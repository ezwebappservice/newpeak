(function () {
  const navContent = document.getElementById('navContent');
  const toggleBtn = document.getElementById('navToggleBtn');

  if (navContent && toggleBtn) {
    navContent.addEventListener('show.bs.collapse', function () {
      toggleBtn.classList.add('open');
    });
    navContent.addEventListener('hide.bs.collapse', function () {
      toggleBtn.classList.remove('open');
    });
  }

  window.openDiscoveryForm = function (event) {
    if (event) {
      event.preventDefault();
    }
    window.location.href = document.querySelector('.btn.btn-book')?.getAttribute('href') || '/customer-enquiry-form';
  };

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const revealTargets = [
    'section h2',
    '.loop-card',
    '.framework-step',
    '.skill-item',
    '.transformation-card',
    '.before-after-card',
    '.journey-step',
    '.discovery-offer',
    '.footer-grid > *',
    '.parent-program-card',
    '.school-program-card',
    '.story-values article'
  ];

  const revealItems = [...new Set(
    revealTargets.flatMap(function (selector) {
      return [...document.querySelectorAll(selector)];
    })
  )].filter(function (item) {
    return item.getClientRects().length;
  });

  revealItems.forEach(function (item, index) {
    item.classList.add('reveal-on-scroll', 'reveal-left');
    item.style.setProperty('--reveal-delay', ((index % 6) * 110) + 'ms');
  });

  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach(function (item) {
      item.classList.add('is-visible');
    });
  } else {
    const revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        entry.target.classList.toggle('is-visible', entry.isIntersecting);
      });
    }, { threshold: 0.16 });

    revealItems.forEach(function (item) {
      revealObserver.observe(item);
    });
  }

  document.querySelectorAll('.video-facade[data-youtube]').forEach(function (button) {
    button.addEventListener('click', function () {
      var videoId = button.getAttribute('data-youtube');
      if (!videoId) {
        return;
      }

      var iframe = document.createElement('iframe');
      iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(videoId) + '?autoplay=1&rel=0';
      iframe.title = button.getAttribute('aria-label') || 'Video';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      iframe.setAttribute('allowfullscreen', '');
      iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
      button.replaceWith(iframe);
    });
  });
})();
