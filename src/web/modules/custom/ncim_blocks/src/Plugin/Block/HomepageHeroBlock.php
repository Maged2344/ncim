<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Homepage Hero Block.
 *
 * @Block(
 *   id = "homepage_hero_block",
 *   admin_label = @Translation("Homepage Hero Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class HomepageHeroBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new HomepageHeroBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get current language
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // Load the active hero section in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'hero_section')
          ->condition('field_is_active', 1)
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('created', 'DESC')
          ->range(0, 1)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    if (empty($nids)) {
      // Try to find content in any language and get translation
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'hero_section')
            ->condition('field_is_active', 1)
            ->condition('status', 1)
            ->sort('created', 'DESC')
            ->range(0, 1)
            ->accessCheck(FALSE);
      $fallback_nids = $fallback_query->execute();
      
      if (!empty($fallback_nids)) {
        $fallback_node = $this->entityTypeManager->getStorage('node')->load(reset($fallback_nids));
        // Try to get the node in current language
        $node = $fallback_node;
        $nids = [$node->id()];
      }
    }

    if (empty($nids)) {
      return [
        '#markup' => '<div class="alert alert-warning">No active hero section found. Please create a hero section content type.</div>',
        '#cache' => [
          'max-age' => 0, // No cache for this case
        ],
      ];
    }

    $node = $this->entityTypeManager->getStorage('node')->load(reset($nids));
    
    if (!$node) {
      return [];
    }

    /** @var NodeInterface $node */
    // Use translatable default values based on language
    $hero_title = $node->get('title')->value ?? $this->t('معاً نحــو بيئــة رقــابية مـتزنة وشفافة');
    $hero_subtitle = $node->get('field_hero_subtitle')->value ?? $this->t('نُنظم أعمال الرقابة والتفتيش بما يضمن العدالة، ويوحّد الجهود بين الجهات والمنشآت. نعمل على بناء منظومة رقابية أكثر كفاءة ووضوحًا.');
    $cta_text = $node->get('field_cta_text')->value ?? $this->t('إستكشف المزيد ');
    
    // Get CTA URL safely - default to # if field is empty or invalid
    $cta_url = '#';
    try {
      if ($node->hasField('field_cta_url') && !$node->get('field_cta_url')->isEmpty()) {
        $field_item = $node->get('field_cta_url')->first();
        if ($field_item) {
          $cta_url = $field_item->getValue()['uri'] ?? '#';
        }
      }
    }
    catch (\Exception $e) {
      // If there's any error getting the URL, fall back to default
      $cta_url = '#';
    }

    // Load statistics in current language
    $statistics_query = $this->entityTypeManager->getStorage('node')->getQuery();
    $statistics_query->condition('type', 'statistics')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('field_display_order', 'ASC')
          ->range(0, 4)
          ->accessCheck(FALSE);
    $statistics_nids = $statistics_query->execute();

    // If no statistics in current language, try to get translations
    if (empty($statistics_nids)) {
      $fallback_stats_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_stats_query->condition('type', 'statistics')
            ->condition('status', 1)
            ->sort('field_display_order', 'ASC')
            ->range(0, 4)
            ->accessCheck(FALSE);
      $fallback_stats_nids = $fallback_stats_query->execute();
      
        if (!empty($fallback_stats_nids)) {
          $fallback_stats_nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_stats_nids);
          $statistics_nodes = $fallback_stats_nodes;
        } else {
          $statistics_nodes = [];
        }
    } else {
      $statistics_nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($statistics_nids);
    }
    
    /** @var NodeInterface[] $statistics_nodes */
    $statistics_cards = [];
    foreach ($statistics_nodes as $stat_node) {
      /** @var NodeInterface $stat_node */
      $title = $stat_node->get('title')->value ?? '';
      $number = $stat_node->get('field_statistic_number')->value ?? '';
      $description = $stat_node->get('field_statistic_description')->value ?? '';
      
      // Get the icon image
      $icon = null;
      if ($stat_node->hasField('field_statistic_icon') && !$stat_node->get('field_statistic_icon')->isEmpty()) {
        $icon = $stat_node->get('field_statistic_icon')->entity;
      }

      $statistics_cards[] = [
        'title' => $title,
        'number' => $number,
        'description' => $description,
        'icon' => $icon,
      ];
    }

    $statistics_cards_html = '';
    foreach ($statistics_cards as $index => $stat) {
      $icon_src = $stat['icon'] ? $stat['icon']->createFileUrl() : '/themes/custom/ncim_theme/images/icons/default-icon.svg';
      
      // First card has special styling (bg-icon-neutral text-oncolor-primary)
      $card_classes = ($index === 0) ? 'bg-icon-neutral text-oncolor-primary' : '';
      $icon_wrapper_classes = ($index === 0) ? 'bg-neutral-100 bg-opacity-10' : 'bg-neutral-100';
      
      $statistics_cards_html .= '
      <div class="' . ($index === 0 ? 'col-lg-12 col-xl-4' : 'col-xl col-md-4') . '">
          <div class="card h-100 border-0 rounded-4 p-lg-4 ' . $card_classes . '">
              <div class="card-body d-flex flex-column">
                  <h4 class="card-title mb-5">' . $stat['title'] . '</h4>
                  <div class="d-flex justify-content-between gap-3 flex-wrap flex-fill align-items-end">
                      <div>
                          <div class="px-3 py-1 w-fit rounded-2 fw-600 bg-white text-default">' . $stat['description'] . '</div>
                          <h1 class="fw-600">' . $stat['number'] . '</h1>
                      </div>
                      <div class="icon-wrapper ' . $icon_wrapper_classes . '">
                          <img src="' . $icon_src . '" alt="' . $stat['title'] . '">
                      </div>
                  </div>
              </div>
          </div>
      </div>';
    }

    // Return simple HTML like other blocks
    $html = '
    <header class="home-header d-lg-flex align-items-lg-center py-5">
        <div class="outer-container py-5">
            <h1 class="fs-56 fw-700 text-center mt-md-5 mb-4">' . $hero_title . '</h1>
            <h3 class="fs-md-20 fs-18 col-lg-10 col-xl-5 fw-500 m-auto text-center mb-5">' . $hero_subtitle . '</h3>

            <a href="' . $cta_url . '" role="button" class="btn btn-primary d-block m-auto d-flex align-items-center gap-3 fw-500 w-fit">
                ' . $cta_text . '
                <i class="fa fa-arrow-left d-rtl-block" aria-hidden="true"></i>
                <i class="fa fa-arrow-right d-ltr-block" aria-hidden="true"></i>
            </a>

            <br>

            <div class="container-fluid">
                <div class="row mt-xl-8 mt-lg-5 g-4">
                    ' . $statistics_cards_html . '
                </div>
            </div>
        </div>
    </header>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for the hero section node
    if ($node) {
      $cache_tags[] = 'node:' . $node->id();
      $cache_tags[] = 'node_list:hero_section';
    }
    
    // Add cache tags for statistics nodes
    foreach ($statistics_nodes as $stat_node) {
      $cache_tags[] = 'node:' . $stat_node->id();
    }
    $cache_tags[] = 'node_list:statistics';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['header', 'div', 'h1', 'h3', 'h4', 'a', 'i', 'img', 'p'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour, but invalidate when content changes
      ],
    ];
  }


}
