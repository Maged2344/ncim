<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Privacy Policy Block.
 *
 * @Block(
 *   id = "privacy_block",
 *   admin_label = @Translation("Privacy Policy Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class PrivacyBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new PrivacyBlock instance.
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
    $content = [];
    $privacy_sections = $this->loadPrivacySections();
    
    if ($privacy_sections) {
      $content['sections'] = $this->buildPrivacyContent($privacy_sections);
    }
    
    if (empty($content)) {
      return [
        '#markup' => '<p>' . $this->t('سياسة الخصوصية غير متاحة في الوقت الحالي.') . '</p>',
      ];
    }

    return [
      '#theme' => 'privacy_content',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load privacy policy sections.
   *
   * @return array
   *   Array of privacy policy nodes.
   */
  protected function loadPrivacySections() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load sections in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'privacy_policy')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    $nids = $query->execute();
    
    // If no sections found in current language, try to load any available sections
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'privacy_policy')
        ->condition('status', 1)
        ->condition('field_is_active', 1)
        ->sort('field_display_order', 'ASC')
        ->accessCheck(FALSE);
      
      $nids = $fallback_query->execute();
    }
    
    if (empty($nids)) {
      return [];
    }

    return $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
  }

  /**
   * Build privacy content for template.
   *
   * @param array $sections
   *   Array of privacy policy nodes.
   *
   * @return array
   *   Formatted privacy sections data.
   */
  protected function buildPrivacyContent($sections) {
    $formatted_sections = [];
    
    foreach ($sections as $section) {
      $formatted_sections[] = [
        'title' => $section->getTitle(),
        'content' => $section->get('field_section_content')->value,
        'section_order' => $section->get('field_display_order')->value ?? 0,
      ];
    }
    
    return $formatted_sections;
  }

}
