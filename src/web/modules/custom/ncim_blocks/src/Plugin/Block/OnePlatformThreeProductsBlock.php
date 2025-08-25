<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a One Platform Three Products Block.
 *
 * @Block(
 *   id = "one_platform_three_products_block",
 *   admin_label = @Translation("One Platform Three Products Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class OnePlatformThreeProductsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new OnePlatformThreeProductsBlock instance.
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
    
    // Load one platform three products sections in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'one_platform_three_products_sec')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('created', 'ASC')
          ->range(0, 4)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no sections in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'one_platform_three_products_sec')
            ->condition('status', 1)
            ->sort('created', 'ASC')
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
        '#markup' => '<div class="alert alert-warning">No one platform three products sections found. Please create one_platform_three_products_sec content type.</div>',
      ];
    }
    
    /** @var NodeInterface[] $nodes */
    $sections = [];
    foreach ($nodes as $node) {
      /** @var NodeInterface $node */
      $title = $node->get('title')->value ?? '';
      $description = $node->get('field_description')->value ?? '';
      $cta_text = $node->get('field_cta_text')->value ?? '';
      $cta_url = $node->get('field_cta_url')->value ?? '#';
      
      // Get the background image
      $background_image = null;
      if ($node->hasField('field_three_p_bg') && !$node->get('field_three_p_bg')->isEmpty()) {
        $background_image = $node->get('field_three_p_bg')->entity;
      }

      $sections[] = [
        'title' => $title,
        'description' => $description,
        'cta_text' => $cta_text,
        'cta_url' => $cta_url,
        'background_image' => $background_image,
      ];
    }

    if (empty($sections)) {
      return [];
    }

    // Build HTML for sections dynamically based on index
    $sections_html = '';
    foreach ($sections as $index => $section) {
      $background_src = $section['background_image'] ? $section['background_image']->createFileUrl() : '/themes/custom/ncim_theme/images/default-bg.jpg';
      
      // Different styling based on index (0, 1, 2, 3)
      switch ($index) {
        case 0: // First item - col-lg-5, bg-info-50
          $col_classes = 'col-lg-5';
          $card_classes = 'border-0 bg-info-50 rounded-4';
          $image_src = '/themes/custom/ncim_theme/images/training.png';
          $image_alt = 'training';
          break;
          
        case 1: // Second item - col-lg-7, bg-neutral-100
          $col_classes = 'col-lg-7';
          $card_classes = 'border-0 bg-neutral-100 rounded-4';
          $image_src = '/themes/custom/ncim_theme/images/services.png';
          $image_alt = 'training';
          break;
          
        case 2: // Third item - col-lg-7, bg-primary-50
          $col_classes = 'col-lg-7';
          $card_classes = 'border-0 bg-primary-50 rounded-4';
          $image_src = '/themes/custom/ncim_theme/images/qr.png';
          $image_alt = 'qr-code';
          break;
          
        case 3: // Fourth item - col-lg-5, bg-neutral-800
          $col_classes = 'col-lg-5';
          $card_classes = 'border-0 bg-neutral-800 rounded-4 overflow-hidden';
          $image_src = '';
          $image_alt = '';
          break;
          
        default:
          $col_classes = 'col-lg-6';
          $card_classes = 'border-0 bg-light rounded-4';
          $image_src = '/themes/custom/ncim_theme/images/default.png';
          $image_alt = 'default';
      }
      
      // Build the card HTML based on index
      if ($index === 0) {
        // First card - Training card
        $sections_html .= '
        <div class="' . $col_classes . '">
            <div class="card h-100 ' . $card_classes . '">
                <div class="card-body px-lg-5 pt-lg-5">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                        <h3 class="fs-30 fw-700">' . $section['title'] . '</h3>
                        <div>
                            <a
                                class="btn p-1"
                                href="' . $section['cta_url'] . '"
                                role="button"
                            >
                                <img
                                    src="/themes/custom/ncim_theme/images/icons/redirect.svg"
                                    alt="redirect"
                                >
                            </a>
                        </div>
                    </div>
                    <p class="fw-400 text-default fs-18">' . $section['description'] . '</p>
                </div>
                <img
                    src="' . $image_src . '"
                    alt="' . $image_alt . '"
                    class="rounded-bottom-4"
                >
            </div>
        </div>';
      } elseif ($index === 1) {
        // Second card - Services card
        $sections_html .= '
        <div class="' . $col_classes . '">
            <div class="card h-100 ' . $card_classes . '">
                <div class="card-body px-lg-5 pt-lg-5">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                        <h3 class="fs-30 fw-700">' . $section['title'] . '</h3>
                        <div>
                            <a
                                class="btn p-1"
                                href="' . $section['cta_url'] . '"
                                role="button"
                            >
                                <img
                                    src="/themes/custom/ncim_theme/images/icons/redirect.svg"
                                    alt="redirect"
                                >
                            </a>
                        </div>
                    </div>
                    <p class="fw-400 text-default fs-18">' . $section['description'] . '</p>
                    <img
                        src="' . $image_src . '"
                        alt="' . $image_alt . '"
                        class="rounded-bottom-4 img-fluid"
                    >
                </div>
            </div>
        </div>';
      } elseif ($index === 2) {
        // Third card - Watch card
        $sections_html .= '
        <div class="' . $col_classes . '">
            <div
                class="card h-100 ' . $card_classes . '"
                id="watch"
            >
                <div class="card-body p-lg-5 d-flex flex-column">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                        <h3 class="fs-30 fw-700">' . $section['title'] . '</h3>
                        <div>
                            <a
                                class="btn p-1"
                                href="' . $section['cta_url'] . '"
                                role="button"
                            >
                                <img
                                    src="/themes/custom/ncim_theme/images/icons/redirect.svg"
                                    alt="redirect"
                                >
                            </a>
                        </div>
                    </div>
                    <p class="fw-400 text-default fs-18 col-md-7 col-lg-8 mb-5">' . $section['description'] . '</p>
                    <div class="d-flex align-items-center flex-fill">
                        <img
                            src="' . $image_src . '"
                            alt="' . $image_alt . '"
                            width="100"
                            class="my-5"
                        >
                    </div>
                </div>
            </div>
        </div>';
      } elseif ($index === 3) {
        // Fourth card - Services overview card
        $sections_html .= '
        <div class="' . $col_classes . '">
            <div
                class="card h-100 ' . $card_classes . ' overflow-hidden"
                id="services"
            >
                <div
                    class="card-body p-lg-5 text-white d-flex flex-column"
                >
                    <p class="fs-20 fw-400">' . $section['description'] . '</p>
                    <div class="d-flex align-items-end flex-fill">
                        <a
                            class="btn btn-primary d-flex gap-3 align-items-center w-fit"
                            href="' . $section['cta_url'] . '"
                            role="button"
                        >' . $section['cta_text'] . '
                            <i class="fa fa-arrow-left d-rtl-block" aria-hidden="true"></i>
                            <i class="fa fa-arrow-right d-ltr-block" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
      }
    }

    $html = '
    <section id="platform" class="py-10">
        <div class="outer-container">
            <h1 class="fs-48 text-default text-center fw-700 mb-4">' . $this->t('منصة واحدة، بثلاثة منتجات متكاملة') . '</h1>
            <p class="col-lg-10 col-xl-8 fs-18 text-center m-auto mb-8">' . $this->t('يقدّم المركز ثلاث واجهات رقمية رئيسية، تتيح تنفيذ المهام، وتقديم الخدمات، وتحليل البيانات. جميعها متاحة بعد تسجيل الدخول.') . '</p>

            <div class="container-fluid">
                <div class="row g-4">
                    ' . $sections_html . '
                </div>
            </div>
        </div>
    </section>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for section nodes
    foreach ($nodes as $node) {
      $cache_tags[] = 'node:' . $node->id();
    }
    $cache_tags[] = 'node_list:one_platform_three_products_sec';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h1', 'h3', 'p', 'a', 'img', 'i'],
      '#cache' => [
        'tags' => $cache_tags,
        'max-age' => 3600, // Cache for 1 hour
        'contexts' => $cache_contexts,
      ],
    ];
  }

}
