<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Support Services Block.
 *
 * @Block(
 *   id = "support_block",
 *   admin_label = @Translation("Support Services Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class SupportBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SupportBlock instance.
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
    $support_services = $this->loadSupportServices();
    
    if ($support_services) {
      $content['services'] = $this->buildSupportContent($support_services);
    }
    
    if (empty($content)) {
      return [
        '#markup' => '<p>' . $this->t('خدمات المساعدة والدعم غير متاحة في الوقت الحالي.') . '</p>',
      ];
    }

    return [
      '#theme' => 'support_content',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load support services.
   *
   * @return array
   *   Array of support service nodes.
   */
  protected function loadSupportServices() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load services in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'support_service')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->accessCheck(FALSE);

    $nids = $query->execute();
    
    // If no services found in current language, try to load any available services
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'support_service')
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
   * Build support content for template.
   *
   * @param array $services
   *   Array of support service nodes.
   *
   * @return array
   *   Formatted support services data.
   */
  protected function buildSupportContent($services) {
    $formatted_services = [];
    
    foreach ($services as $service) {
      $icon_url = '';
      if ($service->hasField('field_icon') && !$service->get('field_icon')->isEmpty()) {
        $file = $service->get('field_icon')->entity;
        if ($file) {
          $icon_url = $file->createFileUrl();
        }
      }
      
      $formatted_services[] = [
        'title' => $service->getTitle(),
        'description' => $service->get('field_description')->value,
        'icon_url' => $icon_url,
        'action_url' => $service->get('field_action_url')->uri,
        'display_order' => $service->get('field_display_order')->value ?? 0,
      ];
    }
    
    return $formatted_services;
  }

}
