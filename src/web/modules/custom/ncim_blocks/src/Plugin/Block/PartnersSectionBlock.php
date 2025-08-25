<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Partners Section Block.
 *
 * @Block(
 *   id = "partners_section_block",
 *   admin_label = @Translation("Partners Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class PartnersSectionBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new PartnersSectionBlock instance.
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
    
    // Load partners ordered by display order in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'partners')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('field_display_order', 'ASC')
          ->range(0, 10)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no partners in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'partners')
            ->condition('status', 1)
            ->sort('field_display_order', 'ASC')
            ->range(0, 10)
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
        '#markup' => '<div class="alert alert-warning">No partners found. Please create partners content type.</div>',
      ];
    }
    
    /** @var NodeInterface[] $nodes */
    $partners = [];
    foreach ($nodes as $node) {
      /** @var NodeInterface $node */
      $name = $node->get('title')->value ?? '';
      
      // Get the partner logo
      $logo = null;
      if ($node->hasField('field_partner_logo') && !$node->get('field_partner_logo')->isEmpty()) {
        $logo = $node->get('field_partner_logo')->entity;
      }

      $partners[] = [
        'name' => $name,
        'logo' => $logo,
      ];
    }

    if (empty($partners)) {
      return [];
    }

    // Build HTML for partners section
    $partner_items_html = '';
    foreach ($partners as $partner) {
      $logo_src = $partner['logo'] ? $partner['logo']->createFileUrl() : '/themes/custom/ncim_theme/images/partners/default-partner.png';
      
      $partner_items_html .= '
      <div class="item">
          <img src="' . $logo_src . '" alt="' . $partner['name'] . '">
      </div>';
    }

    $html = '
    <section id="partner" class="py-10">
        <div class="outer-container">
            <div class="d-flex flex-wrap justify-content-between mb-5">
                <div>
                    <h2 class="fs-36 text-default fw-700 mb-4">' . $this->t('شركاؤنا') . '</h2>
                    <p class="fs-18 fw-500">' . $this->t('هنا يمكنك إضافة وصف مختصر حول الغرض من البوابة.') . '</p>
                </div>
                <div>
                    <a class="btn btn-outline-default d-flex align-items-center gap-3" href="/" role="button">' . $this->t('عرض الكل') . '
                        <i class="fa fa-arrow-left d-rtl-block" aria-hidden="true"></i>
                        <i class="fa fa-arrow-right d-ltr-block" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="custom-owl-wrapper position-relative">
                <!-- Custom Left Button -->
                <button class="owl-btn prev-btn">
                    <i class="fa fa-angle-left d-ltr-block" aria-hidden="true"></i>
                    <i class="fa fa-angle-right d-rtl-block" aria-hidden="true"></i>
                </button>

                <!-- Carousel -->
                <div class="owl-carousel partners-carousel">
                    ' . $partner_items_html . '
                </div>

                <!-- Custom Right Button -->
                <button class="owl-btn next-btn">
                    <i class="fa fa-angle-right d-ltr-block" aria-hidden="true"></i>
                    <i class="fa fa-angle-left d-rtl-block" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for partner nodes
    foreach ($nodes as $node) {
      $cache_tags[] = 'node:' . $node->id();
    }
    $cache_tags[] = 'node_list:partners';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h2', 'p', 'a', 'button', 'img', 'i'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour, but invalidate when content changes
      ],
    ];
  }
}
