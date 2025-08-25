<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a How The Center Works Block.
 *
 * @Block(
 *   id = "how_the_center_works_block",
 *   admin_label = @Translation("How The Center Works Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class HowTheCenterWorksBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new HowTheCenterWorksBlock instance.
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
    $query->condition('type', 'how_the_center_works')
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
      $fallback_query->condition('type', 'how_the_center_works')
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

    $node = $this->entityTypeManager->getStorage('node')->load(reset($nids));
    
    if (!$node) {
      return [];
    }

    /** @var NodeInterface $node */
    // Use translatable default values based on language
    $title = $node->get('title')->value ?? $this->t('كيف يعمل المركز؟');
    $description = $node->get('field_description')->value ?? $this->t('يشرف المركز على تنظيم وحوكمة أعمال التفتيش في أكثر من ٢٠ قطاعًا حيويًا، من خلال توحيد الإجراءات، وتقديم أدوات رقمية معيارية، وتمكين الجهات بالتكامل والربط. يهدف عمله إلى تقليل التكرار، ورفع جودة التنفيذ، وضمان التزام متوازن بين جميع الأطراف.');
    $cta_text = $node->get('field_cta_text')->value ?? $this->t('إستكشف المزيد ');
    $cta_url = $node->get('field_cta_url')->value ?? '#';


    $html = '
    <section id="how_it_works" class="pt-8 position-relative">
        <div class="py-3 bg-primary">
            <div class="outer-container z-3">
                <div class="d-flex justify-content-between gap-3 flex-wrap ">
                    <h1 class="fs-56 text-white mb-4">
                        ' . $title . '
                    </h1>

                    <div class="d-none d-sm-block">
                        <button
                            type="button"
                            class="btn btn-default d-flex gap-3 align-items-center"
                        >' . $cta_text . ' <i
                                class="fa fa-arrow-left d-rtl-block"
                                aria-hidden="true"
                            ></i>
                            <i
                                class="fa fa-arrow-right d-ltr-block"
                                aria-hidden="true"
                            ></i></button>
                    </div>
                </div>
                <p class="col-lg-8 fs-18 text-white m-0">' . $description . '</p>



                <a
                    href="' . $cta_url . '"
                    role="button"
                    class="btn btn-default d-flex gap-3 align-items-center mt-4 d-block d-sm-none"
                >' . $cta_text . ' <i
                        class="fa fa-arrow-left d-rtl-block"
                        aria-hidden="true"
                    ></i>
                    <i
                        class="fa fa-arrow-right d-ltr-block"
                        aria-hidden="true"
                    ></i></a>
            </div>
        </div>
        <img
            src="/themes/custom/ncim_theme/images/bgs/Shape_Animation.png"
            class="img-fluid shape"
        >
    </section>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h1', 'p', 'button', 'a', 'i', 'img'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour
      ],
    ];
  }

}
