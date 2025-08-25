<?php

namespace Drupal\ncim_blocks\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Service for calculating feedback statistics.
 */
class FeedbackStatisticsService {
  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new FeedbackStatisticsService instance.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Get feedback statistics.
   *
   * @return array
   *   Array containing total submissions and positive percentage.
   */
  public function getFeedbackStatistics() {
    try {
      // Get total feedback submissions
      $total_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'feedback_submission')
        ->condition('status', 1)
        ->accessCheck(FALSE);

      $total_nids = $total_query->execute();
      $total_submissions = count($total_nids);

      // Get positive feedback submissions
      $positive_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'feedback_submission')
        ->condition('status', 1)
        ->condition('field_feedback_type', 'positive')
        ->accessCheck(FALSE);

      $positive_nids = $positive_query->execute();
      $positive_submissions = count($positive_nids);

      // Calculate percentage
      $positive_percentage = $total_submissions > 0 ? round(($positive_submissions / $total_submissions) * 100) : 0;

      return [
        'total_submissions' => $total_submissions,
        'positive_submissions' => $positive_submissions,
        'positive_percentage' => $positive_percentage,
      ];

    } catch (\Exception $e) {
      \Drupal::logger('ncim_blocks')->error('Error calculating feedback statistics: @error', ['@error' => $e->getMessage()]);
      
      return [
        'total_submissions' => 0,
        'positive_submissions' => 0,
        'positive_percentage' => 0,
      ];
    }
  }

  /**
   * Get formatted statistics text.
   *
   * @return string
   *   Formatted statistics text in Arabic.
   */
  public function getFormattedStatisticsText() {
    $stats = $this->getFeedbackStatistics();
    
    if ($stats['total_submissions'] === 0) {
      return $this->t('لا توجد تعليقات بعد');
    }

    $percentage = $stats['positive_percentage'];
    $total = $stats['total_submissions'];
    
    return $this->t('@percentage% من المستخدمين قالوا نعم من @total تعليقًا', [
      '@percentage' => $percentage,
      '@total' => $total,
    ]);
  }

}
