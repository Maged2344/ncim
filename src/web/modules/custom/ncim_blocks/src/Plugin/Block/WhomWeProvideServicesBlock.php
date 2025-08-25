<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Whom We Provide Services Block.
 *
 * @Block(
 *   id = "whom_we_provide_services_block",
 *   admin_label = @Translation("Whom We Provide Services Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class WhomWeProvideServicesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new WhomWeProvideServicesBlock instance.
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
    
    // Load whom we provide services sections in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'whom_we_provide_services_section')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('created', 'ASC')
          ->range(0, 2)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no sections in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'whom_we_provide_services_section')
            ->condition('status', 1)
            ->sort('created', 'ASC')
            ->range(0, 2)
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
        '#markup' => '<div class="alert alert-warning">No whom we provide services sections found. Please create whom_we_provide_services_section content type.</div>',
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
      
      // Get the icon image
      $icon = null;
      if ($node->hasField('field_whom_icon') && !$node->get('field_whom_icon')->isEmpty()) {
        $icon = $node->get('field_whom_icon')->entity;
      }

      $sections[] = [
        'title' => $title,
        'description' => $description,
        'cta_text' => $cta_text,
        'cta_url' => $cta_url,
        'icon' => $icon,
      ];
    }

    if (empty($sections)) {
      return [];
    }

    // Build HTML for sections dynamically
    $sections_html = '';
    foreach ($sections as $index => $section) {
      $icon_src = $section['icon'] ? $section['icon']->createFileUrl() : '/themes/custom/ncim_theme/images/icons/default-icon.svg';
      
      // First section has special styling (col-lg-7 col-xl-8)
      $col_classes = ($index === 0) ? 'col-lg-7 col-xl-8' : 'col-lg-5 col-xl-4';
      $card_classes = ($index === 0) ? 'bg-transparent' : 'bg-transparent';
      $icon_wrapper_classes = ($index === 0) ? 'bg-background-success-light' : 'bg-neutral-50';
      $button_classes = ($index === 0) ? 'btn btn-primary' : 'btn btn-default';
      
      $sections_html .= '
      <div class="' . $col_classes . '">
          <div
              id="' . ($index === 0 ? 'individual' : 'gov') . '"
              class="card h-100 ' . $card_classes . ' p-md-4 p-2 border-0 rounded-4"
          >
              <div class="card-body bg-white rounded-4 p-3 p-xl-4' . ($index === 0 ? ' d-flex flex-column' : '') . '">
                  <div class="icon-circle ' . $icon_wrapper_classes . ' mb-5">
                      <img
                          src="' . $icon_src . '"
                          alt="' . $section['title'] . '"
                      >
                  </div>

                  <h4 class="fs-24 fw-700 mb-3">' . $section['title'] . '</h4>
                  <p class="text-secondary-paragraph mb-5">' . $section['description'] . '</p>

                  <div class="' . ($index === 0 ? 'd-flex align-items-end flex-fill' : 'd-flex align-items-end') . '">
                      <a
                          role="button"
                          href="' . $section['cta_url'] . '"
                          class="' . $button_classes . ' d-flex align-items-center gap-3 w-fit' . ($index === 1 ? ' d-block mt-auto' : '') . '"
                      >' . $section['cta_text'] . '
                          <i
                              class="fa fa-arrow-left d-rtl-block"
                              aria-hidden="true"
                          ></i>
                          <i
                              class="fa fa-arrow-right d-ltr-block"
                              aria-hidden="true"
                          ></i>
                      </a>
                  </div>
              </div>
          </div>
      </div>';
    }

    $html = '
    <section id="whom_we_provide_services" class="pb-8">
        <div class="outer-container">
            <h1 class="fs-48 text-default text-center mb-4">' . $this->t('لمن نقدم خدماتنا؟') . '</h1>
            <p class="col-lg-8 fs-18 fw-500 col-xl-6 text-center d-block m-auto text-primary-paragraph mb-7">' . $this->t('دورنا هو التنظيم والتمكين، لا التدخّل ولا التنفيذ. نضمن أن كل زيارة مبرّرة، غير مكرّرة، وتُنفّذ بمعايير موحّدة — نمنح الجهات الأدوات، ونمنح المستفيدين الوضوح.') . '</p>

            <div class="container-fluid">
                <div class="row g-xl-5 g-4">
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
    $cache_tags[] = 'node_list:whom_we_provide_services_section';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h1', 'h4', 'p', 'a', 'img', 'i'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour
      ],
    ];
  }

}
