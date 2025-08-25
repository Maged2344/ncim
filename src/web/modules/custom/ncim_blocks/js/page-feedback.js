/**
 * Page Feedback Form Handler
 * Handles the feedback form submission and interaction
 * Maintains exact HTML structure and behavior from about.html
 */
(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.pageFeedback = {
    attach: function (context, settings) {
      // Initialize feedback form
      this.initFeedbackForm(context);
    },

    initFeedbackForm: function (context) {
      const $context = $(context);
      const $positiveBtn = $context.find('#positiveFeedbackBtn');
      const $negativeBtn = $context.find('#negativeFeedbackBtn');
      const $closeBtn = $context.find('#closeFeedbackBtn');
      const $feedbackCollapse = $context.find('#feedback');
      const $form = $context.find('#feedbackForm');
      const $submitBtn = $context.find('button[type="submit"]');

      let feedbackType = '';
      let selectedReasons = [];
      let selectedGender = '';
      let userComment = '';

      // Handle positive feedback
      $positiveBtn.on('click', function() {
        feedbackType = 'positive';
        selectedReasons = [];
        selectedGender = '';
        userComment = '';
        
        // Show success message
        $positiveBtn.text('شكراً لك!').prop('disabled', true);
        $negativeBtn.hide();
        
        // Submit positive feedback
        submitFeedback();
      });

      // Handle negative feedback
      $negativeBtn.on('click', function() {
        feedbackType = 'negative';
        $feedbackCollapse.collapse('show');
        $negativeBtn.hide();
        $closeBtn.removeClass('d-none');
      });

      // Handle close button
      $closeBtn.on('click', function() {
        $feedbackCollapse.collapse('hide');
        $negativeBtn.show();
        $closeBtn.addClass('d-none');
        feedbackType = '';
      });

      // Handle reason checkboxes
      $context.find('.reason-checkbox').on('change', function() {
        const value = $(this).val();
        if ($(this).is(':checked')) {
          selectedReasons.push(value);
          // Clear the feedback reasons error when a reason is selected
          const $feedbackErrorDiv = $context.find('.invalid-feedback').first();
          $feedbackErrorDiv.removeClass('d-block');
        } else {
          selectedReasons = selectedReasons.filter(reason => reason !== value);
        }
      });

      // Handle gender selection
      $context.find('input[name="gender"]').on('change', function() {
        selectedGender = $(this).val();
        console.log('Gender selected:', selectedGender);
        
        // Clear the gender error when gender is selected
        const $errorDivs = $context.find('.invalid-feedback');
        const $genderErrorDiv = $errorDivs.eq(1); // Second invalid-feedback div
        $genderErrorDiv.removeClass('d-block');
      });

      // Handle comment input
      $context.find('#comment').on('input', function() {
        userComment = $(this).val();
      });

      // Handle form submission
      $form.on('submit', function(e) {
        e.preventDefault();
        handleFormSubmission();
      });

      // Handle submit button click (backup method)
      $context.on('click', 'button[type="submit"]', function(e) {
        e.preventDefault();
        handleFormSubmission();
      });

      // Function to handle form submission logic
      function handleFormSubmission() {
        console.log('=== FORM SUBMISSION ATTEMPT ===');
        console.log('feedbackType:', feedbackType);
        console.log('selectedReasons:', selectedReasons);
        console.log('selectedGender:', selectedGender);
        
        if (feedbackType === 'negative') {
          // Validate negative feedback
          if (selectedReasons.length === 0) {
            console.log('Validation failed: No reasons selected');
            showFeedbackReasonsError(Drupal.t('الرجاء تحديد سبب واحد على الأقل'));
            return;
          }
          
          if (!selectedGender) {
            console.log('Validation failed: No gender selected');
            showGenderError(Drupal.t('الرجاء تحديد تقييم'));
            return;
          }
        }
        
        console.log('Validation passed, submitting feedback...');
        // Submit feedback
        submitFeedback();
      }

      // Function to submit feedback
      function submitFeedback() {
        // Create form data
        const formData = new FormData();
        formData.append('feedback_type', feedbackType);
        formData.append('feedback_reasons', selectedReasons.join(', '));
        formData.append('gender', selectedGender);
        formData.append('comment', userComment);
        formData.append('page_url', window.location.pathname);
        formData.append('page_title', document.title);
        
        // Submit via AJAX to Drupal form
        $.ajax({
          url: Drupal.url('feedback/submit'),
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            if (response.success) {
              showSuccessMessage(Drupal.t('شكراً لك على ملاحظاتك!'));
              resetForm();
            } else {
              showErrorMessage(Drupal.t('حدث خطأ أثناء إرسال الملاحظات. يرجى المحاولة مرة أخرى.'));
            }
          },
          error: function() {
            showErrorMessage(Drupal.t('حدث خطأ أثناء إرسال الملاحظات. يرجى المحاولة مرة أخرى.'));
          }
        });
      }

      // Function to show feedback reasons validation error
      function showFeedbackReasonsError(message) {
        console.log('Showing feedback reasons error:', message);
        
        // Find the specific error div for feedback reasons
        const $errorDiv = $context.find('.invalid-feedback').first();
        
        if ($errorDiv.length > 0) {
          $errorDiv.text(message).addClass('d-block');
          console.log('Feedback reasons error div updated and shown');
        } else {
          console.log('No feedback reasons error div found');
        }
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
          $errorDiv.removeClass('d-block');
        }, 5000);
      }

      // Function to show gender validation error
      function showGenderError(message) {
        console.log('Showing gender error:', message);
        
        // Find the specific error div for gender (second invalid-feedback div)
        const $errorDivs = $context.find('.invalid-feedback');
        const $genderErrorDiv = $errorDivs.eq(1); // Second invalid-feedback div
        
        if ($genderErrorDiv.length > 0) {
          $genderErrorDiv.text(message).addClass('d-block');
          console.log('Gender error div updated and shown');
        } else {
          console.log('No gender error div found');
        }
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
          $genderErrorDiv.removeClass('d-block');
        }, 5000);
      }

      // Function to show success message
      function showSuccessMessage(message) {
        const $successDiv = $('<div class="alert alert-success mt-3">' + message + '</div>');
        $form.after($successDiv);
        
        setTimeout(function() {
          $successDiv.fadeOut();
        }, 5000);
      }

      // Function to show error message
      function showErrorMessage(message) {
        const $errorDiv = $('<div class="alert alert-danger mt-3">' + message + '</div>');
        $form.after($errorDiv);
        
        setTimeout(function() {
          $errorDiv.fadeOut();
        }, 5000);
      }

      // Function to reset form
      function resetForm() {
        $feedbackCollapse.collapse('hide');
        $positiveBtn.text('نعم').prop('disabled', false);
        $negativeBtn.show();
        $closeBtn.addClass('d-none');
        $form[0].reset();
        feedbackType = '';
        selectedReasons = [];
        selectedGender = '';
        userComment = '';
      }
    }
  };

})(jQuery, Drupal);
