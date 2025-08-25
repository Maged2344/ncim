<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "Rules and Regulations" block.
 *
 * @Block(
 *   id = "rules_and_regulations",
 *   admin_label = @Translation("Rules and Regulations"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class RulesAndRegulationsBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * Constructs a new RulesAndRegulationsBlock instance.
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

    // Load the main page content.
    $page_content = $this->loadRegulationDocuments();
    if ($page_content) {
      $content['documents'] = $this->buildDocumentsContent($page_content);
    }

    if (empty($content)) {
        return [
          '#markup' => '<p>' . $this->t('Rules and regulations page content not found.') . '</p>',
        ];
    }

    return [
      '#theme' => 'rules_and_regulations',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load regulation documents.
   */
  protected function loadRegulationDocuments() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'regulation_document')
      ->condition('status', 1)
      ->condition('field_is_active', 1)
      ->condition('langcode', $language_id)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    $nids = $query->execute();
    if (!empty($nids)) {
      return $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    // Fallback: Any language
    $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'regulation_document')
      ->condition('status', 1)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    $fallback_nids = $fallback_query->execute();
    if (!empty($fallback_nids)) {
      return $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_nids);
    }

    return [];
  }

  /**
   * Build the documents content.
   */
  protected function buildDocumentsContent($document_nodes) {
    $documents = [];
    foreach ($document_nodes as $node) {
      $file_size = '';
      $file_url = '';
      
      // Get file size and URL from the document file
      if ($node->hasField('field_document_file') && !$node->get('field_document_file')->isEmpty()) {
        $file = $node->get('field_document_file')->entity;
        if ($file) {
          $size_in_bytes = $file->getSize();
          $file_size = $this->formatFileSize($size_in_bytes);
          $file_url = $file->createFileUrl();
        }
      }
      
      $documents[] = [
        'title' => $node->get('title')->value ?? '',
        'icon' => $this->getImageUrl($node, 'field_document_icon'),
        'file_url' => $file_url,
        'file_size' => $file_size,
        'download_text' => $node->get('field_download_button_text')->value ?? $this->t('تنزيل'),
        'display_order' => $node->get('field_display_order')->value ?? 0,
      ];
    }
    return $documents;
  }

  /**
   * Get image URL from a field.
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

  /**
   * Format file size in human-readable format.
   */
  protected function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
      return number_format($bytes / 1073741824, 1) . ' GB';
    } elseif ($bytes >= 1048576) {
      return number_format($bytes / 1048576, 1) . ' MB';
    } elseif ($bytes >= 1024) {
      return number_format($bytes / 1024, 1) . ' KB';
    } else {
      return $bytes . ' bytes';
    }
  }

}
