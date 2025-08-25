function updateDateTime() {
  const now = new Date();
  const date = now.toLocaleDateString("ar-EG", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
  const time = now.toLocaleTimeString("ar-EG", {
    hour: "numeric",
    minute: "2-digit",
  });
  document.getElementById("date-time").textContent = date;
  document.getElementById("time").textContent = time;
}

function fetchWeather() {
  // Only get weather condition in Arabic
  fetch("https://wttr.in/?format=%C&lang=ar")
    .then((res) => res.text())
    .then((condition) => {
      document.getElementById("weather-status").textContent = condition;

      // Pick icon based on condition
      if (condition.includes("غائم")) {
        document.getElementById("weather-icon").src =
          "https://openweathermap.org/img/wn/03d.png";
      } else if (condition.includes("مشمس")) {
        document.getElementById("weather-icon").src =
          "https://openweathermap.org/img/wn/01d.png";
      } else if (condition.includes("أمطار")) {
        document.getElementById("weather-icon").src =
          "https://openweathermap.org/img/wn/09d.png";
      } else {
        document.getElementById("weather-icon").src =
          "https://openweathermap.org/img/wn/50d.png";
      }
    })
    .catch((err) => console.error(err));
}

function getCity() {
  fetch("https://ipapi.co/json/")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("location").textContent = data.city;
    });
}

function initWeatherWidget() {
  fetchWeather();
  updateDateTime();
  setInterval(updateDateTime, 60000);
}

function updateYear() {
  const currentYear = new Date().getFullYear();
  const yearTags = document.getElementsByClassName("year");

  for (let i = 0; i < yearTags.length; i++) {
    yearTags[i].textContent = currentYear;
  }
}

// Search and Filter JavaScript
document.addEventListener("DOMContentLoaded", () => {
  initWeatherWidget();
  getCity();
  updateDateTime();
  updateYear();
});

// FAQ Search and Sort Functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('faqSearchInput');
  const sortBtn = document.getElementById('filterBtn');
  const sortDropdown = document.getElementById('filterDropdown');
  const sortOptions = document.querySelectorAll('.filter-category');
  const faqItems = document.querySelectorAll('.faq-item');
  
  let currentSort = 'newest';
  let searchTerm = '';

  // Toggle sort dropdown
  if (sortBtn) {
    sortBtn.addEventListener('click', function() {
      sortDropdown.classList.toggle('d-none');
    });
  }

  // Handle sorting options
  if (sortOptions.length > 0) {
    sortOptions.forEach(btn => {
      btn.addEventListener('click', function() {
        const sortType = this.dataset.category;
        currentSort = sortType;
        
        // Update active sort button
        sortOptions.forEach(b => b.classList.remove('btn-primary'));
        sortOptions.forEach(b => b.classList.add('btn-outline-primary'));
        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary');
        
        // Hide sort dropdown
        sortDropdown.classList.add('d-none');
        
        // Apply search and sort
        applySearchAndSort();
      });
    });
  }

  // Handle search input
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      searchTerm = this.value.toLowerCase().trim();
      applySearchAndSort();
    });
  }

  // Apply search and sort
  function applySearchAndSort() {
    const visibleItems = [];
    
    // First, filter items based on search
    faqItems.forEach(item => {
      const question = item.dataset.question || '';
      const answer = item.dataset.answer || '';
      const keywords = item.dataset.keywords || '';
      const category = item.dataset.category || '';
      
      // Check if item matches search term
      const matchesSearch = !searchTerm || 
        question.includes(searchTerm) || 
        answer.includes(searchTerm) || 
        keywords.includes(searchTerm);
      
      if (matchesSearch) {
        item.style.display = 'block';
        item.classList.remove('d-none');
        visibleItems.push(item);
      } else {
        item.style.display = 'none';
        item.classList.add('d-none');
      }
    });
    
    // Then sort visible items
    if (visibleItems.length > 0) {
      // Hide no results message if it exists
      hideNoResultsMessage();
      sortFAQItems(visibleItems, currentSort);
    } else {
      // Show "no results" message if no items match search
      showNoResultsMessage();
    }
    
    // Update tab content visibility
    updateTabVisibility();
  }

  // Sort FAQ items based on sort type
  function sortFAQItems(items, sortType) {
    const accordionContainers = document.querySelectorAll('.accordion');
    
    accordionContainers.forEach(container => {
      const containerItems = Array.from(container.querySelectorAll('.faq-item:not(.d-none)'));
      
      if (containerItems.length > 0) {
        // Sort items based on sort type
        containerItems.sort((a, b) => {
          switch (sortType) {
            case 'newest':
              // Sort by creation date (newest first) - using ID as proxy for date
              return parseInt(b.dataset.id || 0) - parseInt(a.dataset.id || 0);
              
            case 'oldest':
              // Sort by creation date (oldest first) - using ID as proxy for date
              return parseInt(a.dataset.id || 0) - parseInt(b.dataset.id || 0);
              
            case 'alphabetical':
              // Sort alphabetically by question
              const questionA = a.dataset.question || '';
              const questionB = b.dataset.question || '';
              return questionA.localeCompare(questionB, 'ar');
              
            case 'reverse-alphabetical':
              // Sort reverse alphabetically by question
              const questionARev = a.dataset.question || '';
              const questionBRev = b.dataset.question || '';
              return questionBRev.localeCompare(questionARev, 'ar');
              
            case 'category':
              // Sort by category name
              const categoryA = a.dataset.category || '';
              const categoryB = b.dataset.category || '';
              return categoryA.localeCompare(categoryB, 'ar');
              
            default:
              return 0;
          }
        });
        
        // Reorder items in the DOM
        containerItems.forEach(item => {
          container.appendChild(item);
        });
      }
    });
    
    // After sorting, update tab visibility to ensure proper display
    setTimeout(() => {
      updateTabVisibility();
    }, 0);
  }
  
  // Ensure active tab is visible and properly configured
  function ensureActiveTabVisibility() {
    // Let Bootstrap handle tab visibility - we only manage tab buttons
    // This function is now minimal to avoid conflicts
  }

  // Show no results message
  function showNoResultsMessage() {
    // Remove any existing no results message
    const existingMessage = document.querySelector('.no-results-message');
    if (existingMessage) {
      existingMessage.remove();
    }
    
    // Create and show no results message
    const noResultsDiv = document.createElement('div');
    noResultsDiv.className = 'no-results-message text-center py-5';
    noResultsDiv.innerHTML = `
      <div class="alert alert-info">
        <h5>${searchTerm ? 'لا توجد نتائج للبحث' : 'لا توجد أسئلة متاحة'}</h5>
        <p>${searchTerm ? `لم يتم العثور على نتائج لـ "${searchTerm}"` : 'يرجى المحاولة مرة أخرى لاحقاً'}</p>
      </div>
    `;
    
    // Insert the message after the search form
    const searchForm = document.getElementById('faqSearchForm');
    if (searchForm) {
      searchForm.parentNode.insertBefore(noResultsDiv, searchForm.nextSibling);
    }
  }

  // Hide no results message
  function hideNoResultsMessage() {
    const existingMessage = document.querySelector('.no-results-message');
    if (existingMessage) {
      existingMessage.remove();
    }
  }

  // Update tab content visibility
  function updateTabVisibility() {
    const tabPanes = document.querySelectorAll('.tab-pane');
    let hasVisibleTabs = false;
    
    tabPanes.forEach(pane => {
      const visibleItems = pane.querySelectorAll('.faq-item:not(.d-none)');
      const tabId = pane.id;
      const tabButton = document.querySelector(`[data-bs-target="#${tabId}"]`);
      
      if (visibleItems.length === 0) {
        // Hide tab button if no visible items
        if (tabButton) {
          tabButton.style.display = 'none';
        }
      } else {
        // Show tab button if there are visible items
        hasVisibleTabs = true;
        if (tabButton) {
          tabButton.style.display = 'block';
        }
      }
    });
    
    // If no tabs are visible, show a message
    if (!hasVisibleTabs) {
      showNoResultsMessage();
    }
  }
  
  // Reset search and sort when switching tabs
  function resetSearchAndSort() {
    // Clear search input
    if (searchInput) {
      searchInput.value = '';
      searchTerm = '';
    }
    
    // Reset sort to default
    currentSort = 'newest';
    
    // Reset sort button states
    sortOptions.forEach(btn => {
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-outline-primary');
    });
    
    // Reset first sort option to active
    if (sortOptions.length > 0) {
      sortOptions[0].classList.remove('btn-outline-primary');
      sortOptions[0].classList.add('btn-primary');
    }
    
    // Reset all FAQ items to visible
    faqItems.forEach(item => {
      item.style.display = 'block';
      item.classList.remove('d-none');
    });
    
    // Hide no results message
    hideNoResultsMessage();
  }

  // Voice search button (placeholder for future implementation)
  const voiceSearchBtn = document.getElementById('voiceSearchBtn');
  if (voiceSearchBtn) {
    voiceSearchBtn.addEventListener('click', function() {
      alert('ميزة البحث الصوتي ستكون متاحة قريباً');
    });
  }

  // Handle tab switching to reset FAQ item visibility
  const tabButtons = document.querySelectorAll('.nav-link');
  tabButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Reset search, sort, and visibility when switching tabs
      setTimeout(() => {
        resetSearchAndSort();
      }, 100); // Small delay to ensure tab switch completes
    });
  });
  
  // Close sort dropdown when clicking outside
  document.addEventListener('click', function(event) {
    if (sortBtn && sortDropdown && !sortBtn.contains(event.target) && !sortDropdown.contains(event.target)) {
      sortDropdown.classList.add('d-none');
    }
  });
});

//# sourceMappingURL=main.js.map
