<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

/**
 * Provides an About Page Block.
 *
 * @Block(
 *   id = "about_page_block",
 *   admin_label = @Translation("About Page Content"),
 *   category = @Translation("NCIM Blocks"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node", label = @Translation("Node"))
 *   }
 * )
 */
class AboutPageBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a new AboutPageBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match, LanguageManagerInterface $language_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
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
      $container->get('current_route_match'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    
    // Get the current language.
    $current_language = $this->languageManager->getCurrentLanguage()->getId();
    
    // Load the About page content.
    $about_page = $this->loadAboutPage($current_language);
    
    if (!$about_page) {
      return [
        '#markup' => '<p>' . $this->t('About page content not found.') . '</p>',
      ];
    }

    // Build the content sections.
    $build['#theme'] = 'about_page_content';
    $build['#content'] = $this->buildContentSections($about_page);
    
    return $build;
  }

  /**
   * Load the About page content.
   *
   * @param string $language
   *   The language code.
   *
   * @return \Drupal\node\NodeInterface|null
   *   The About page node or null if not found.
   */
  protected function loadAboutPage($language) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'about_page')
          ->condition('status', 1)
          ->condition('langcode', $language)
          ->accessCheck(FALSE)
          ->range(0, 1);
    
    $nids = $query->execute();
        
    if (!empty($nids)) {
      $nid = reset($nids);
      return $this->entityTypeManager->getStorage('node')->load($nid);
    }
    
    // Fallback: Any language
    $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'about_page')
      ->condition('status', 1)
      ->accessCheck(FALSE)
      ->range(0, 1);

    $fallback_nids = $fallback_query->execute();
    if (!empty($fallback_nids)) {
      $nid = reset($fallback_nids);
      return $this->entityTypeManager->getStorage('node')->load($nid);
    }

    return NULL;
  }

  /**
   * Build the content sections from the About page node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The About page node.
   *
   * @return array
   *   The content sections array.
   */
  protected function buildContentSections($node) {
    $sections = [];
    
    // Foundation Section
    if ($node->hasField('field_foundation_title') && !$node->get('field_foundation_title')->isEmpty()) {
      $sections['foundation'] = [
        'title' => $node->get('field_foundation_title')->value,
        'description' => $node->get('field_foundation_description')->value ?? '',
        'image' => $this->getImageUrl($node, 'field_foundation_image'),
      ];
    }
    
    // Vision & Mission Section
    if ($node->hasField('field_vision_and_mission_title') && !$node->get('field_vision_and_mission_title')->isEmpty()) {
      $sections['vision_mission'] = [
        'title' => $node->get('field_vision_and_mission_title')->value,
        'description' => $node->get('field_vision_and_mission_descrip')->value ?? '',
        'vision' => [
          'title' => $node->get('field_vision_title')->value ?? '',
          'description' => $node->get('field_vision_description')->value ?? '',
        ],
        'mission' => [
          'title' => $node->get('field_mission_title')->value ?? '',
          'description' => $node->get('field_mission_description')->value ?? '',
        ],
      ];
    }
    
    // CEO Message Section
    if ($node->hasField('field_ceo_message_title') && !$node->get('field_ceo_message_title')->isEmpty()) {
      $sections['ceo_message'] = [
        'title' => $node->get('field_ceo_message_title')->value,
        'description' => $node->get('field_ceo_message_description')->value ?? '',
        'message' => $node->get('field_ceo_message')->value ?? '',
        'name' => $node->get('field_ceo_name')->value ?? '',
        'position' => $node->get('field_ceo_position')->value ?? '',
        'image' => $this->getImageUrl($node, 'field_ceo_image'),
      ];
    }
    
    // Strategic Goals Section
    if ($node->hasField('field_goals_title') && !$node->get('field_goals_title')->isEmpty()) {
      $sections['strategic_goals'] = [
        'title' => $node->get('field_goals_title')->value,
        'description' => $node->get('field_goals_description')->value ?? '',
        'goals' => $this->getUnlimitedTextFieldValue($node, 'field_strategic_goals'),
      ];
    }
    
    // Values Section
    if ($node->hasField('field_value_title') && !$node->get('field_value_title')->isEmpty()) {
      $sections['values'] = [
        'title' => $node->get('field_value_title')->value,
        'description' => $node->get('field_value_description')->value ?? '',
        'values_list' => $this->loadCoreValues(),
      ];
    }
    
    // Center Role Section
    if ($node->hasField('field_center_role_title') && !$node->get('field_center_role_title')->isEmpty()) {
      $sections['center_role'] = [
        'title' => $node->get('field_center_role_title')->value,
        'description' => $node->get('field_center_role_description')->value ?? '',
      ];
    }
    
    // Missions Section
    if ($node->hasField('field_missions_title') && !$node->get('field_missions_title')->isEmpty()) {
      $sections['missions'] = [
        'title' => $node->get('field_missions_title')->value,
        'description' => $node->get('field_missions_description')->value ?? '',
        'missions_list' => $this->getUnlimitedTextFieldValue($node, 'field_missions_list'),
      ];
    }
    
    return $sections;
  }

  /**
   * Get image URL from a field.
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

  /**
   * Get value from unlimited text field.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node.
   * @param string $field_name
   *   The field name.
   *
   * @return string
   *   The field value as a string.
   */
  protected function getUnlimitedTextFieldValue($node, $field_name) {
    if ($node->hasField($field_name) && !$node->get($field_name)->isEmpty()) {
      $field = $node->get($field_name);
      $values = [];
      foreach ($field as $item) {
        if (!empty($item->value)) {
          $values[] = $item->value;
        }
      }
      return implode("\n", $values);
    }
    return '';
  }

  /**
   * Load core values from the core_value content type.
   *
   * @return array
   *   Array of core values.
   */
  protected function loadCoreValues() {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'core_value')
          ->condition('status', 1)
          ->accessCheck(FALSE)
          ->sort('field_display_order', 'ASC');
    
    $nids = $query->execute();
    
    if (empty($nids)) {
      return [];
    }
    
    $values = [];
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    
    foreach ($nodes as $node) {
      $values[] = [
        'title' => $node->get('title')->value ?? '',
        'icon' => $this->getImageUrl($node, 'field_value_icon'),
      ];
    }
    
    return $values;
  }

}
