<?php

namespace Drupal\ncim_blocks\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Provides a Feedback Submission form.
 */
class FeedbackSubmissionForm extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new FeedbackSubmissionForm instance.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'feedback_submission_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get current page info
    $current_url = \Drupal::request()->getRequestUri();
    $current_title = \Drupal::routeMatch()->getRouteName() === 'entity.node.canonical' 
      ? \Drupal::routeMatch()->getParameter('node')->getTitle() 
      : '';

    $form['page_url'] = [
      '#type' => 'hidden',
      '#value' => $current_url,
    ];

    $form['page_title'] = [
      '#type' => 'hidden',
      '#value' => $current_title,
    ];

    $form['feedback_type'] = [
      '#type' => 'hidden',
      '#value' => '',
    ];

    $form['feedback_reasons'] = [
      '#type' => 'hidden',
      '#value' => '',
    ];

    $form['gender'] = [
      '#type' => 'hidden',
      '#value' => '',
    ];

    $form['comment'] = [
      '#type' => 'hidden',
      '#value' => '',
    ];

    $form['user_ip'] = [
      '#type' => 'hidden',
      '#value' => \Drupal::request()->getClientIp(),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Feedback'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    try {
      // Create feedback submission node
      $feedback_submission = $this->entityTypeManager->getStorage('node')->create([
        'type' => 'feedback_submission',
        'title' => 'Feedback from ' . $form_state->getValue('page_url'),
        'field_page_url' => $form_state->getValue('page_url'),
        'field_page_title' => $form_state->getValue('page_title'),
        'field_feedback_type' => $form_state->getValue('feedback_type'),
        'field_feedback_submission_reason' => $form_state->getValue('feedback_reasons'),
        'field_submission_gender' => $form_state->getValue('gender'),
        'field_comment' => $form_state->getValue('comment'),
        'field_user_ip' => $form_state->getValue('user_ip'),
        'field_submission_date' => date('Y-m-d\TH:i:s'),
        'status' => 1,
      ]);

      $feedback_submission->save();

      $this->messenger->addStatus($this->t('Thank you for your feedback!'));
      
      // Redirect back to the same page
      $form_state->setRedirectUrl(Url::fromUri('internal:' . $form_state->getValue('page_url')));
      
    } catch (\Exception $e) {
      $this->messenger->addError($this->t('An error occurred while submitting your feedback. Please try again.'));
      \Drupal::logger('ncim_blocks')->error('Feedback submission error: @error', ['@error' => $e->getMessage()]);
    }
  }

}
