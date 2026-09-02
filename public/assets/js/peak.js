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
    '.hero .row',
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
    return;
  }

  const revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      entry.target.classList.toggle('is-visible', entry.isIntersecting);
    });
  }, { threshold: 0.16 });

  revealItems.forEach(function (item) {
    revealObserver.observe(item);
  });
})();
