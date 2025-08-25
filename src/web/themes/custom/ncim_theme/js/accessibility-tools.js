/**
 * Accessibility Tools JavaScript
 * Handles functionality for footer accessibility tools
 */

jQuery(document).ready(function ($) {
  // Handle accessibility tool clicks
  $(document).find('.accessibility-tool').on('click', function (e) {
    e.preventDefault();

    const action = $(this).data('action');
    const toolTitle = $(this).attr('title');

    console.log('Accessibility tool clicked:', action, toolTitle);

    switch (action) {
      case 'toggle-visibility':
        toggleElementVisibility();
        break;
      case 'zoom-in':
        increaseZoom();
        break;
      case 'zoom-out':
        decreaseZoom();
        break;
      case 'text-to-speech':
        startTextToSpeech();
        break;
      case 'high-contrast':
        toggleHighContrast();
        break;
      case 'font-size-increase':
        increaseFontSize();
        break;
      case 'font-size-decrease':
        decreaseFontSize();
        break;
      default:
        console.log('Unknown accessibility tool action:', action);
    }
  });

  // Initialize accessibility tools
  initializeAccessibilityTools();
});

/**
 * Initialize accessibility tools
 */
function initializeAccessibilityTools() {
  // Load saved preferences
  loadAccessibilityPreferences();

  // Apply current settings
  applyAccessibilitySettings();
}

/**
 * Toggle element visibility
 */
function toggleElementVisibility() {
  const body = $('body');
  const isHidden = body.hasClass('accessibility-hidden');

  if (isHidden) {
    body.removeClass('accessibility-hidden');
    localStorage.setItem('accessibility-hidden', 'false');
    showNotification('تم إظهار العناصر', 'success');
  } else {
    body.addClass('accessibility-hidden');
    localStorage.setItem('accessibility-hidden', 'true');
    showNotification('تم إخفاء العناصر', 'info');
  }
}

/**
 * Increase page zoom
 */
function increaseZoom() {
  const currentZoom = parseFloat(localStorage.getItem('accessibility-zoom') || 100);
  const newZoom = Math.min(currentZoom + 25, 200);

  $('body').css('zoom', newZoom + '%');
  localStorage.setItem('accessibility-zoom', newZoom);

  showNotification(`تم تكبير الصفحة إلى ${newZoom}%`, 'success');
}

/**
 * Decrease page zoom
 */
function decreaseZoom() {
  const currentZoom = parseFloat(localStorage.getItem('accessibility-zoom') || 100);
  const newZoom = Math.max(currentZoom - 25, 50);

  $('body').css('zoom', newZoom + '%');
  localStorage.setItem('accessibility-zoom', newZoom);

  showNotification(`تم تصغير الصفحة إلى ${newZoom}%`, 'success');
}

/**
 * Start text to speech
 */
function startTextToSpeech() {
  if ('speechSynthesis' in window) {
    const text = $('body').text().substring(0, 1000); // Limit text length
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'ar-SA'; // Arabic language
    utterance.rate = 0.8; // Slower speed for better understanding

    speechSynthesis.speak(utterance);
    showNotification('جاري قراءة النص', 'info');
  } else {
    showNotification('متصفحك لا يدعم تحويل النص إلى كلام', 'error');
  }
}

/**
 * Toggle high contrast mode
 */
function toggleHighContrast() {
  const body = $('body');
  const isHighContrast = body.hasClass('accessibility-high-contrast');

  if (isHighContrast) {
    body.removeClass('accessibility-high-contrast');
    localStorage.setItem('accessibility-high-contrast', 'false');
    showNotification('تم إيقاف الوضع عالي التباين', 'info');
  } else {
    body.addClass('accessibility-high-contrast');
    localStorage.setItem('accessibility-high-contrast', 'true');
    showNotification('تم تفعيل الوضع عالي التباين', 'success');
  }
}

/**
 * Increase font size
 */
function increaseFontSize() {
  const currentSize = parseFloat(localStorage.getItem('accessibility-font-size') || 16);
  const newSize = Math.min(currentSize + 2, 24);

  $('body').css('font-size', newSize + 'px');
  localStorage.setItem('accessibility-font-size', newSize);

  showNotification(`تم زيادة حجم الخط إلى ${newSize}px`, 'success');
}

/**
 * Decrease font size
 */
function decreaseFontSize() {
  const currentSize = parseFloat(localStorage.getItem('accessibility-font-size') || 16);
  const newSize = Math.max(currentSize - 2, 12);

  $('body').css('font-size', newSize + 'px');
  localStorage.setItem('accessibility-font-size', newSize);

  showNotification(`تم تقليل حجم الخط إلى ${newSize}px`, 'success');
}

/**
 * Load accessibility preferences from localStorage
 */
function loadAccessibilityPreferences() {
  // Load zoom
  const zoom = localStorage.getItem('accessibility-zoom');
  if (zoom) {
    $('body').css('zoom', zoom + '%');
  }

  // Load font size
  const fontSize = localStorage.getItem('accessibility-font-size');
  if (fontSize) {
    $('body').css('font-size', fontSize + 'px');
  }

  // Load hidden state
  const isHidden = localStorage.getItem('accessibility-hidden');
  if (isHidden === 'true') {
    $('body').addClass('accessibility-hidden');
  }

  // Load high contrast
  const isHighContrast = localStorage.getItem('accessibility-high-contrast');
  if (isHighContrast === 'true') {
    $('body').addClass('accessibility-high-contrast');
  }
}

/**
 * Apply accessibility settings
 */
function applyAccessibilitySettings() {
  // Apply any additional accessibility settings here
}

/**
 * Show notification message
 */
function showNotification(message, type = 'info') {
  // Create notification element
  const notification = $(`
      <div class="accessibility-notification accessibility-notification-${type}">
        <span>${message}</span>
        <button class="accessibility-notification-close">&times;</button>
      </div>
    `);

  // Add to page
  $('body').append(notification);

  // Auto-remove after 3 seconds
  setTimeout(function () {
    notification.fadeOut(300, function () {
      $(this).remove();
    });
  }, 3000);

  // Close button functionality
  notification.find('.accessibility-notification-close').on('click', function () {
    notification.fadeOut(300, function () {
      $(this).remove();
    });
  });
}
