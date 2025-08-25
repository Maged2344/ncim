<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an "Owners and Individuals Page Content" block.
 *
 * @Block(
 *   id = "owners_individuals_content",
 *   admin_label = @Translation("Owners and Individuals Page Content"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class OwnersIndividualsBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * Constructs a new OwnersIndividualsBlock instance.
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
    $page_content = $this->loadOwnersIndividualsPage();
    if ($page_content) {
      $content['page'] = $this->buildPageContent($page_content);
    }

    // Load beneficiary types.
    $beneficiaries = $this->loadBeneficiaryTypes();
    if ($beneficiaries) {
      $content['beneficiaries'] = $this->buildBeneficiariesContent($beneficiaries);
    }

    if (empty($content)) {
        return [
          '#markup' => '<p>' . $this->t('Owners and individuals page content not found.') . '</p>',
        ];
    }

    return [
      '#theme' => 'owners_individuals_content',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load the owners and individuals page content.
   */
  protected function loadOwnersIndividualsPage() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'owners_and_individuals_page')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->range(0, 1)
      ->accessCheck(FALSE);

    $nids = $query->execute();
    if (!empty($nids)) {
      $nid = reset($nids);
      return $this->entityTypeManager->getStorage('node')->load($nid);
    }

    // Fallback: Any language
    $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'owners_and_individuals_page')
      ->condition('status', 1)
      ->range(0, 1)
      ->accessCheck(FALSE);

    $fallback_nids = $fallback_query->execute();
    if (!empty($fallback_nids)) {
      $nid = reset($fallback_nids);
      return $this->entityTypeManager->getStorage('node')->load($nid);
    }

    return NULL;
  }

  /**
   * Load beneficiary types.
   */
  protected function loadBeneficiaryTypes() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // Query for beneficiary types that should appear in owners and individuals block
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'beneficiary_type')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    // If the display location field exists, filter by it
    if ($this->fieldExists('node', 'beneficiary_type', 'field_display_location')) {
      $query->condition('field_display_location', ['owners_and_individuals', 'both'], 'IN');
    }

    $nids = $query->execute();
    if (!empty($nids)) {
      return $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    // Fallback: Any language
    $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'beneficiary_type')
      ->condition('status', 1)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    if ($this->fieldExists('node', 'beneficiary_type', 'field_display_location')) {
      $fallback_query->condition('field_display_location', ['owners_and_individuals', 'both'], 'IN');
    }

    $fallback_nids = $fallback_query->execute();
    if (!empty($fallback_nids)) {
      return $this->entityTypeManager->getStorage('node')->loadMultiple($fallback_nids);
    }

    return [];
  }

  /**
   * Build the main page content.
   */
  protected function buildPageContent($node) {
    return [
      'how_we_serve' => [
        'title' => $node->get('field_how_we_serve')->value ?? '',
        'description' => $node->get('field_how_we_serve_description')->value ?? '',
      ],
      'beneficiaries' => [
        'title' => $node->get('field_who_are_the_beneficiaries')->value ?? '',
        'description' => $node->get('field_who_beneficiaries_desc')->value ?? '',
      ],
      'services' => [
        'title' => $node->get('field_available_services_title')->value ?? '',
        'description' => $node->get('field_available_services_descrip')->value ?? '',
        'button_text' => $node->get('field_services_button_text')->value ?? '',
        'button_url' => $node->get('field_services_button_url')->first()?->getUrl()->toString() ?? '',
      ],
      'pipeline_cards' => [
        'card_1' => [
          'title' => $node->get('field_pipeline_card_1_title')->value ?? '',
        ],
        'card_2' => [
          'title' => $node->get('field_pipeline_card_2_title')->value ?? '',
          'description' => $node->get('field_pipeline_card_2_descriptio')->value ?? '',
          'icon' => $this->getImageUrl($node, 'field_pipeline_card_2_icon'),
        ],
        'card_3' => [
          'title' => $node->get('field_pipeline_card_3_title')->value ?? '',
        ],
        'card_4' => [
          'title' => $node->get('field_pipeline_card_4_title')->value ?? '',
        ],
        'card_5' => [
          'title' => $node->get('field_pipeline_card_5_title')->value ?? '',
        ],
      ],
    ];
  }

  /**
   * Build the beneficiaries content.
   */
  protected function buildBeneficiariesContent($beneficiary_nodes) {
    $beneficiaries = [];
    foreach ($beneficiary_nodes as $node) {
      $beneficiaries[] = [
        'title' => $node->get('title')->value ?? '',
        'description' => $node->get('field_description')->value ?? '',
        'icon' => $this->getImageUrl($node, 'field_beneficiary_icon'),
      ];
    }
    return $beneficiaries;
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
   * Check if a field exists on a content type.
   */
  protected function fieldExists($entity_type, $bundle, $field_name) {
    try {
      $field_config = $this->entityTypeManager->getStorage('field_config')->load($entity_type . '.' . $bundle . '.' . $field_name);
      return $field_config !== NULL;
    }
    catch (\Exception $e) {
      return FALSE;
    }
  }

}
