<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Statistics Cards Block.
 *
 * @Block(
 *   id = "statistics_cards_block",
 *   admin_label = @Translation("Statistics Cards Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class StatisticsCardsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new StatisticsCardsBlock instance.
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
    
    // Load statistics ordered by display order in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'statistics')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('field_display_order', 'ASC')
          ->range(0, 4)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no statistics in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'statistics')
            ->condition('status', 1)
            ->sort('field_display_order', 'ASC')
            ->range(0, 4)
            ->accessCheck(FALSE);
      $fallback_nids = $fallback_query->execute();
      
      if (!empty($fallback_nids)) {
        $fallback_nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_nids);
        $nodes = $fallback_nodes;
      } else {
        $nodes = [];
      }
    } else {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    if (empty($nodes)) {
      return [
        '#markup' => '<div class="alert alert-warning">No statistics found. Please create statistics content type.</div>',
      ];
    }
    
    /** @var NodeInterface[] $nodes */
    $statistics_cards = [];
    foreach ($nodes as $node) {
      /** @var NodeInterface $node */
      $title = $node->get('title')->value ?? '';
      $number = $node->get('field_statistic_number')->value ?? '';
      $description = $node->get('field_statistic_description')->value ?? '';
      
      // Get the icon image
      $icon = null;
      if ($node->hasField('field_statistic_icon') && !$node->get('field_statistic_icon')->isEmpty()) {
        $icon = $node->get('field_statistic_icon')->entity;
      }

      $statistics_cards[] = [
        'title' => $title,
        'number' => $number,
        'description' => $description,
        'icon' => $icon,
      ];
    }

    if (empty($statistics_cards)) {
      return [];
    }

    // Build HTML for statistics cards - exactly like in index.html
    $cards_html = '';
    foreach ($statistics_cards as $index => $stat) {
      $icon_src = $stat['icon'] ? $stat['icon']->createFileUrl() : '/themes/custom/ncim_theme/images/icons/default-icon.svg';
      
      // First card has special styling (bg-icon-neutral text-oncolor-primary)
      $card_classes = ($index === 0) ? 'bg-icon-neutral text-oncolor-primary' : '';
      $icon_wrapper_classes = ($index === 0) ? 'bg-neutral-100 bg-opacity-10' : 'bg-neutral-100';
      
      $cards_html .= '
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

    $html = '
    <div class="container-fluid">
        <div class="row mt-xl-8 mt-lg-5 g-4">
            ' . $cards_html . '
        </div>
    </div>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for statistics nodes
    foreach ($nodes as $node) {
      $cache_tags[] = 'node:' . $node->id();
    }
    $cache_tags[] = 'node_list:statistics';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['div', 'h1', 'h4', 'img'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour, but invalidate when content changes
      ],
    ];
  }

}
