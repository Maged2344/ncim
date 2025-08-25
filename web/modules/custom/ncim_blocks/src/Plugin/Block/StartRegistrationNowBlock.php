<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Start Registration Now Block.
 *
 * @Block(
 *   id = "start_registration_now_block",
 *   admin_label = @Translation("Start Registration Now Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class StartRegistrationNowBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new StartRegistrationNowBlock instance.
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
    
    // Load start registration now section in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'start_registration_now_section')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('created', 'ASC')
          ->range(0, 1)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no section in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'start_registration_now_section')
            ->condition('status', 1)
            ->sort('created', 'ASC')
            ->range(0, 1)
            ->accessCheck(FALSE);
      $fallback_nids = $fallback_query->execute();
      
      if (!empty($fallback_nids)) {
        $fallback_nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_nids);
        $node = reset($fallback_nodes);
      } else {
        $node = null;
      }
    } else {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      $node = reset($nodes);
    }

    if (!$node) {
      return [
        '#markup' => '<div class="alert alert-warning">No start registration now section found. Please create start_registration_now_section content type.</div>',
      ];
    }
    
    /** @var NodeInterface $node */
    // Get the content fields
    $title = $node->get('title')->value ?? $this->t('ابدأ بالتسجيل الآن');
    $description = $node->get('field_description')->value ?? $this->t('هل تمثّل جهة تفتيش وتبحث عن أدوات موحدة لتنظيم أعمالك؟ ابدأ رحلة التأهيل الآن لتفعيل حسابك، والوصول إلى منتجات المركز.');
    $cta_text = $node->get('field_cta_text')->value ?? $this->t('ابدأ بالتسجيل الآن');
    $cta_url = $node->get('field_cta_url')->value ?? '#';

    $html = '
    <section id="start_register" class="bg-primary pt-8 pb-10">
        <div class="outer-container pb-md-8">
            <div class="d-flex justify-content-between gap-3 flex-wrap">
                <div>
                    <h2 class="fs-36 fw-700 text-white mb-4">' . $title . '</h2>
                    <p class="fs-24 fw-400 text-oncolor-secondary">' . $description . '</p>
                </div>

                <div>
                    <a
                        href="' . $cta_url . '"
                        role="button"
                        class="btn btn-default d-flex align-items-center gap-3"
                    >' . $cta_text . '

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

    </section>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for the section node
    $cache_tags[] = 'node:' . $node->id();
    $cache_tags[] = 'node_list:start_registration_now_section';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h2', 'p', 'a', 'i'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour
      ],
    ];
  }
}
