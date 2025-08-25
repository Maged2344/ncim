<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a News Section Block.
 *
 * @Block(
 *   id = "news_section_block",
 *   admin_label = @Translation("News Section"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class NewsSectionBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new NewsSectionBlock instance.
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
    
    // Load latest 3 news articles in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'news')
          ->condition('status', 1)
          ->condition('langcode', $language_id)
          ->sort('field_news_date', 'DESC')
          ->range(0, 3)
          ->accessCheck(FALSE);
    $nids = $query->execute();

    // If no news in current language, try to get translations
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery();
      $fallback_query->condition('type', 'news')
            ->condition('status', 1)
            ->sort('field_news_date', 'DESC')
            ->range(0, 3)
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
        '#markup' => '<div class="alert alert-warning">No news articles found. Please create news article content type.</div>',
      ];
    }
    
    /** @var NodeInterface[] $nodes */
    $news_items = [];
    foreach ($nodes as $node) {
      /** @var NodeInterface $node */
      $title = $node->get('title')->value ?? '';
      $summary = $node->get('field_summary')->value ?? '';
      
      // Get the news image
      $image = null;
      if ($node->hasField('field_news_image') && !$node->get('field_news_image')->isEmpty()) {
        $image = $node->get('field_news_image')->entity;
      }

      $news_items[] = [
        'title' => $title,
        'summary' => $summary,
        'image' => $image,
        'url' => $node->toUrl()->toString(),
      ];
    }

    if (empty($news_items)) {
      return [];
    }

    // Build HTML for news section
    $news_cards_html = '';
    foreach ($news_items as $news) {
      $image_src = $news['image'] ? $news['image']->createFileUrl() : 'https://images.unsplash.com/photo-1561154464-82e9adf32764?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60';
      
      $news_cards_html .= '
      <div>
          <div class="card border-0 rounded-4">
              <div class="card-body">
                  <img src="' . $image_src . '" class="card-img-top rounded-3 mb-4 object-fit-cover" height="300" alt="' . $news['title'] . '">
                  <h5 class="fs-18 fw-700 mb-3">' . $news['title'] . '</h5>
                  <p class="fs-16 text-400 mb-4">' . $news['summary'] . '</p>
                  <a class="btn btn-primary d-flex align-items-center gap-3 w-fit" href="' . $news['url'] . '" role="button">' . $this->t('قراءة المزيد') . '</a>
              </div>
          </div>
      </div>';
    }

    $html = '
    <section id="news" class="py-10 bg-neutral-100">
        <div class="outer-container">
            <div class="d-flex flex-wrap justify-content-between mb-5">
                <div>
                    <h2 class="fs-36 text-default fw-700 mb-4">' . $this->t('الأخبار والتحديثات') . '</h2>
                    <p class="fs-18 fw-500">' . $this->t('هنا يمكنك إضافة وصف مختصر حول الغرض من البوابة.') . '</p>
                </div>
                <div>
                    <a class="btn btn-outline-default d-flex align-items-center gap-3" href="/" role="button">' . $this->t('عرض الكل') . '
                        <i class="fa fa-arrow-left d-rtl-block" aria-hidden="true"></i>
                        <i class="fa fa-arrow-right d-ltr-block" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="row row-cols-lg-3 row-cols-md-2 g-4">
                ' . $news_cards_html . '
            </div>
        </div>
    </section>';

    // Build cache tags for all content this block depends on
    $cache_tags = [];
    
    // Add cache tags for news nodes
    foreach ($nodes as $node) {
      $cache_tags[] = 'node:' . $node->id();
    }
    $cache_tags[] = 'node_list:news_article';
    
    // Add cache contexts for user permissions and language
    $cache_contexts = ['user.permissions', 'languages:language_interface'];

    return [
      '#markup' => $html,
      '#allowed_tags' => ['section', 'div', 'h2', 'h5', 'p', 'a', 'img', 'i'],
      '#cache' => [
        'tags' => $cache_tags,
        'contexts' => $cache_contexts,
        'max-age' => 3600, // Cache for 1 hour, but invalidate when content changes
      ],
    ];
  }

}
