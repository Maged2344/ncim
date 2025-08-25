<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Pager\PagerManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "News List" block.
 *
 * @Block(
 *   id = "news_list",
 *   admin_label = @Translation("News List"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class NewsListBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The pager manager.
   *
   * @var \Drupal\Core\Pager\PagerManagerInterface
   */
  protected $pagerManager;

  /**
   * Constructs a new NewsListBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Pager\PagerManagerInterface $pager_manager
   *   The pager manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, LanguageManagerInterface $language_manager, PagerManagerInterface $pager_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->languageManager = $language_manager;
    $this->pagerManager = $pager_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('language_manager'),
      $container->get('pager.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get current page from URL parameter
    $page = \Drupal::request()->query->get('page', 0);
    
    // Load news nodes with pagination
    $news_nodes = $this->loadNewsNodes($page);
    
    // Get total count for pager
    $total_count = $this->getTotalNewsCount();

    return [
      '#theme' => 'news_list',
      '#news_items' => $news_nodes,
      '#total_count' => $total_count,
      '#current_page' => $page,
      '#attached' => [
        'library' => ['ncim_blocks/news_list'],
      ],
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load news nodes with pagination.
   *
   * @param int $page
   *   The current page number.
   *
   * @return array
   *   Array of news nodes.
   */
  protected function loadNewsNodes($page) {
    try {
      $current_language = $this->languageManager->getCurrentLanguage();
      $language_id = $current_language->getId();

      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'news')
        ->condition('status', 1)
        ->condition('langcode', $language_id)
        ->sort('created', 'DESC')
        ->range($page * 6, 6)
        ->accessCheck(FALSE);

      $nids = $query->execute();

      if (!empty($nids)) {
        $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
        return $this->formatNewsNodes($nodes);
      }

      // Fallback to any language if current language not found
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'news')
        ->condition('status', 1)
        ->sort('created', 'DESC')
        ->range($page * 6, 6)
        ->accessCheck(FALSE);

      $fallback_nids = $fallback_query->execute();

      if (!empty($fallback_nids)) {
        $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_nids);
        return $this->formatNewsNodes($nodes);
      }

      return [];

    } catch (\Exception $e) {
      \Drupal::logger('ncim_blocks')->error('Error loading news nodes: @error', ['@error' => $e->getMessage()]);
      return [];
    }
  }

  /**
   * Get total count of news nodes.
   *
   * @return int
   *   Total count of news nodes.
   */
  protected function getTotalNewsCount() {
    try {
      $current_language = $this->languageManager->getCurrentLanguage();
      $language_id = $current_language->getId();

      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'news')
        ->condition('status', 1)
        ->condition('langcode', $language_id)
        ->count()
        ->accessCheck(FALSE);

      $count = $query->execute();

      if ($count > 0) {
        return $count;
      }

      // Fallback to any language count
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'news')
        ->condition('status', 1)
        ->count()
        ->accessCheck(FALSE);

      return $fallback_query->execute();

    } catch (\Exception $e) {
      \Drupal::logger('ncim_blocks')->error('Error getting news count: @error', ['@error' => $e->getMessage()]);
      return 0;
    }
  }

  /**
   * Format news nodes for template.
   *
   * @param array $nodes
   *   Array of news nodes.
   *
   * @return array
   *   Formatted array of news data.
   */
  protected function formatNewsNodes($nodes) {
    $formatted_news = [];

    foreach ($nodes as $node) {
      $formatted_news[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
        'summary' => $node->hasField('field_news_summary') ? $node->get('field_news_summary')->value : '',
        'image' => $this->getImageUrl($node, 'field_news_image'),
        'url' => $node->toUrl()->toString(),
        'created' => $node->getCreatedTime(),
      ];
    }

    return $formatted_news;
  }

  /**
   * Get image URL from node field.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node.
   * @param string $field_name
   *   The field name.
   *
   * @return string|null
   *   The image URL or null.
   */
  protected function getImageUrl($node, $field_name) {
    if ($node->hasField($field_name) && !$node->get($field_name)->isEmpty()) {
      $image = $node->get($field_name)->entity;
      if ($image) {
        return $image->createFileUrl();
      }
    }
    return NULL;
  }

}
