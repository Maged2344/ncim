<?php

namespace Drupal\ncim_blocks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for handling feedback submissions.
 */
class FeedbackController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new FeedbackController instance.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Handles feedback submission via AJAX.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON response indicating success or failure.
   */
  public function submit(Request $request) {
    try {
        // Get form data
        $feedback_type = $request->request->get('feedback_type');
        $feedback_reasons = $request->request->get('feedback_reasons');
        $gender = $request->request->get('gender');
        $comment = $request->request->get('comment');
        $page_url = $request->request->get('page_url');
        $page_title = $request->request->get('page_title');

        // Validate required fields for negative feedback
        if ($feedback_type === 'negative') {
            if (empty($feedback_reasons)) {
                return new JsonResponse(['success' => false, 'message' => $this->t('Feedback reasons are required for negative feedback.')]);
            }
            if (empty($gender)) {
                return new JsonResponse(['success' => false, 'message' => $this->t('Gender selection is required for negative feedback.')]);
            }
        }

        // Create feedback submission node
        $feedback_submission = $this->entityTypeManager->getStorage('node')->create([
            'type' => 'feedback_submission',
            'title' => 'Feedback from ' . $page_url,
            'field_page_url' => $page_url,
            'field_page_title' => $page_title,
            'field_feedback_type' => $feedback_type,
            'field_feedback_submission_reason' => $feedback_reasons,
            'field_submission_gender' => $gender,
            'field_comment' => $comment,
            'field_user_ip' => $request->getClientIp(),
            'field_submission_date' => date('Y-m-d\TH:i:s'),
            'status' => 1,
        ]);

        $feedback_submission->save();

        // Log the submission
        $this->getLogger('ncim_blocks')->info('Feedback submitted: @type from @page', [
            '@type' => $feedback_type,
            '@page' => $page_url,
        ]);

        return new JsonResponse([
            'success' => true,
            'message' => $this->t('Feedback submitted successfully.'),
            'submission_id' => $feedback_submission->id(),
        ]);

    } catch (\Exception $e) {
        // Log the error
        $this->getLogger('ncim_blocks')->error('Feedback submission error: @error', [
          '@error' => $e->getMessage(),
        ]);

        return new JsonResponse([
            'success' => false,
            'message' => $this->t('An error occurred while submitting feedback. Please try again.'),
        ], 500);
    }
  }

}
