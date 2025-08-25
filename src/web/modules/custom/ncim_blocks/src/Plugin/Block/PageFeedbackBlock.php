<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\ncim_blocks\Service\FeedbackStatisticsService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "Page Feedback" block.
 *
 * @Block(
 *   id = "page_feedback",
 *   admin_label = @Translation("Page Feedback"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class PageFeedbackBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * The feedback statistics service.
   *
   * @var \Drupal\ncim_blocks\Service\FeedbackStatisticsService
   */
  protected $feedbackStatisticsService;

  /**
   * Constructs a new PageFeedbackBlock instance.
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
   * @param \Drupal\ncim_blocks\Service\FeedbackStatisticsService $feedback_statistics_service
   *   The feedback statistics service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, LanguageManagerInterface $language_manager, FeedbackStatisticsService $feedback_statistics_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->languageManager = $language_manager;
    $this->feedbackStatisticsService = $feedback_statistics_service;
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
      $container->get('ncim_blocks.feedback_statistics')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $feedback_content = $this->loadFeedbackContent();
    
    if (!$feedback_content) {
      return [
        '#markup' => '<p>' . $this->t('Feedback content not found.') . '</p>',
      ];
    }

    // Get feedback statistics
    $feedback_statistics = $this->feedbackStatisticsService->getFeedbackStatistics();

    return [
      '#theme' => 'page_feedback',
      '#content' => $feedback_content,
      '#statistics' => $feedback_statistics,
      '#attached' => [
        'library' => ['ncim_blocks/page_feedback'],
      ],
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load the feedback content.
   */
  protected function loadFeedbackContent() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try: Current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'page_feedback')
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
      ->condition('type', 'page_feedback')
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

}
