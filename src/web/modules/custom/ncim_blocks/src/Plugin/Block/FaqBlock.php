<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a FAQ Block.
 *
 * @Block(
 *   id = "faq_block",
 *   admin_label = @Translation("FAQ Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class FaqBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * Constructs a new FaqBlock instance.
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
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, LanguageManagerInterface $language_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->languageManager = $language_manager;
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
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = [];
    
    // Load FAQ items
    $faq_items = $this->loadFaqItems();
    if ($faq_items) {
      $content['faq_items'] = $this->buildFaqContent($faq_items);
      
      // Load categories for tabs dynamically based on FAQ items
      $categories = $this->getCategories($content['faq_items']);
      if ($categories) {
        $content['categories'] = $categories;
      }
    }
    
    if (empty($content)) {
      return [
        '#markup' => '<p>' . $this->t('الأسئلة الشائعة غير متاحة في الوقت الحالي.') . '</p>',
      ];
    }

    return [
      '#theme' => 'faq_content',
      '#content' => $content,
      '#attached' => [
        'library' => ['core/drupal.ajax'],
      ],
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load FAQ items with language fallback.
   *
   * @return array
   *   Array of FAQ items.
   */
  protected function loadFaqItems() {
    $current_language = $this->languageManager->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load FAQs in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'faq_item')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->sort('created', 'ASC')
      ->accessCheck(FALSE);
    $nids = $query->execute();
    
    // If no FAQs found in current language, try to load any available FAQs
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'faq_item')
        ->condition('status', 1)
        ->condition('field_is_active', 1)
        ->sort('field_display_order', 'ASC')
        ->sort('created', 'ASC')
        ->accessCheck(FALSE);
      $nids = $fallback_query->execute();
    }
    
    if (empty($nids)) {
      return [];
    }
    
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    return $nodes;
  }

  /**
   * Load FAQ categories with language fallback.
   *
   * @return array
   *   Array of FAQ categories.
   */
  protected function loadFaqCategories() {
    $current_language = $this->languageManager->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load categories in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'faq_category')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->sort('title', 'ASC')
      ->accessCheck(FALSE);
    $nids = $query->execute();
    
    // If no categories found in current language, try to load any available categories
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'faq_category')
        ->condition('status', 1)
        ->condition('field_is_active', 1)
        ->sort('field_display_order', 'ASC')
        ->sort('title', 'ASC')
        ->accessCheck(FALSE);
      $nids = $fallback_query->execute();
    }
    
    if (empty($nids)) {
      return [];
    }
    
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    return $nodes;
  }

  /**
   * Build FAQ content for template.
   *
   * @param array $faq_nodes
   *   Array of FAQ node objects.
   *
   * @return array
   *   Formatted FAQ content.
   */
  protected function buildFaqContent($faq_nodes) {
    $formatted_items = [];
    
    foreach ($faq_nodes as $node) {
      $category_reference = $node->get('field_category')->entity;
      $category_key = '';
      $category_name = '';
      
      if ($category_reference) {
        $category_key = $category_reference->id();
        $category_name = $category_reference->getTitle();
      }
      
      $formatted_items[] = [
        'id' => $node->id(),
        'question' => $node->getTitle(),
        'answer' => $node->get('field_answer')->value,
        'category' => $category_key,
        'category_name' => $category_name,
        'display_order' => $node->get('field_display_order')->value ?? 0,
        'search_keywords' => $node->get('field_search_keywords')->value ?? '',
      ];
    }
    
    return $formatted_items;
  }

  /**
   * Get category statistics for display.
   *
   * @param array $faq_items
   *   Array of FAQ items.
   *
   * @return array
   *   Array of category statistics.
   */
  protected function getCategoryStats($faq_items) {
    $stats = [];
    
    if (!empty($faq_items)) {
      foreach ($faq_items as $item) {
        $category = $item['category'] ?? 'all';
        if (!isset($stats[$category])) {
          $stats[$category] = 0;
        }
        $stats[$category]++;
      }
    }
    
    return $stats;
  }

  /**
   * Get available categories for tabs dynamically.
   *
   * @param array $faq_items
   *   Array of FAQ items to extract categories from.
   *
   * @return array
   *   Array of categories with their display names.
   */
  protected function getCategories($faq_items = []) {
    // Always include "all" category
    $categories = ['all' => $this->t('الكل')];
    
    // Load categories from content type
    $category_nodes = $this->loadFaqCategories();
    
         if (!empty($category_nodes)) {
       foreach ($category_nodes as $category_node) {
         $category_key = $category_node->id();
         $category_name = $category_node->getTitle();
         $categories[$category_key] = $category_name;
       }
    } else {
      // Fallback: Extract unique categories from FAQ items if no category nodes exist
      if (!empty($faq_items)) {
        $unique_categories = [];
        foreach ($faq_items as $item) {
          if (!empty($item['category']) && $item['category'] !== 'all') {
            $unique_categories[$item['category']] = $item['category_name'] ?? $item['category'];
          }
        }
        
        // Add categories that exist in the FAQ items
        foreach ($unique_categories as $category_key => $category_name) {
          $categories[$category_key] = $category_name;
        }
      }
    }
    
    return $categories;
  }

}
