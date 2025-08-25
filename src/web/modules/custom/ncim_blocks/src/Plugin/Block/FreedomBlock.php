<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Freedom of Information Block.
 *
 * @Block(
 *   id = "freedom_block",
 *   admin_label = @Translation("Freedom of Information Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class FreedomBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new FreedomBlock instance.
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
    $freedom_sections = $this->loadFreedomSections();
    
    if ($freedom_sections) {
      $content['sections'] = $this->buildFreedomContent($freedom_sections);
    }
    
    if (empty($content)) {
      return [
        '#markup' => '<p>' . $this->t('معلومات حرية الحصول على المعلومات غير متاحة في الوقت الحالي.') . '</p>',
      ];
    }

    return [
      '#theme' => 'freedom_content',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load freedom of information sections.
   *
   * @return array
   *   Array of freedom of information nodes.
   */
  protected function loadFreedomSections() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load sections in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'freedom_of_information')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    $nids = $query->execute();
    
    // If no sections found in current language, try to load any available sections
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'freedom_of_information')
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
   * Build freedom content for template.
   *
   * @param array $sections
   *   Array of freedom of information nodes.
   *
   * @return array
   *   Formatted freedom sections data.
   */
  protected function buildFreedomContent($sections) {
    $formatted_sections = [];
    
    foreach ($sections as $section) {
      $formatted_sections[] = [
        'title' => $section->getTitle(),
        'content' => $section->get('field_section_content')->value,
        'display_order' => $section->get('field_display_order')->value ?? 0,
      ];
    }
    
    return $formatted_sections;
  }

}
