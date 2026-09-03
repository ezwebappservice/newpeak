/**
 * Peak Potential – Main JavaScript
 * Modular, CMS-ready interactions
 */

(function () {
  'use strict';

  /* --------------------------------------------------------------------------
     DOM Ready
     -------------------------------------------------------------------------- */
  document.addEventListener('DOMContentLoaded', init);

  function init() {
    setCurrentYear();
    initHeaderHeight();
    initStickyHeader();
    initMobileNav();
    initMegaMenu();
    initHeroSlider();
    initSmoothScroll();
    initScrollReveal();
    initLazyLoad();
    initCounters();
    initTestimonialSlider();
    initBackToTop();
    initServerFormValidation();
    initServerFormErrorsOnLoad();
    initFormMessageScroll();
    initContactForm();
    initNewsletterForm();
    initActiveNavOnScroll();
  }

  /* --------------------------------------------------------------------------
     Dynamic header height (accurate scroll offset on all devices)
     -------------------------------------------------------------------------- */
  function initHeaderHeight() {
    const header = document.getElementById('siteHeader');
    if (!header) return;

    const update = () => {
      document.documentElement.style.setProperty('--header-height', header.offsetHeight + 'px');
    };

    update();
    window.addEventListener('resize', update, { passive: true });
    window.addEventListener('orientationchange', () => setTimeout(update, 150));

    const collapse = document.getElementById('mainNav');
    if (collapse) {
      ['show.bs.collapse', 'hidden.bs.collapse'].forEach((evt) => {
        collapse.addEventListener(evt, () => setTimeout(update, 320));
      });
    }
  }

  function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  function supportsSmoothScroll() {
    return 'scrollBehavior' in document.documentElement.style;
  }

  /* --------------------------------------------------------------------------
     Footer year
     -------------------------------------------------------------------------- */
  function setCurrentYear() {
    const el = document.getElementById('currentYear');
    if (el) el.textContent = new Date().getFullYear();
  }

  /* --------------------------------------------------------------------------
     Sticky header on scroll
     -------------------------------------------------------------------------- */
  function initStickyHeader() {
    const header = document.getElementById('siteHeader');
    if (!header) return;

    const onScroll = () => {
      header.classList.toggle('scrolled', window.scrollY > 60);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* --------------------------------------------------------------------------
     Mobile navigation
     -------------------------------------------------------------------------- */
  function initMobileNav() {
    const header = document.getElementById('siteHeader');
    const collapse = document.getElementById('mainNav');
    const toggler = document.querySelector('.mobile-menu-toggle');

    if (!header || !collapse) return;

    let scrollPosition = 0;

    collapse.addEventListener('show.bs.collapse', () => {
      header.classList.add('menu-open');
      document.body.classList.add('nav-open');
      if (window.innerWidth < 992) {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        document.body.style.position = 'fixed';
        document.body.style.top = '-' + scrollPosition + 'px';
        document.body.style.left = '0';
        document.body.style.right = '0';
        document.body.style.width = '100%';
      }
    });

    collapse.addEventListener('hidden.bs.collapse', () => {
      header.classList.remove('menu-open');
      document.body.classList.remove('nav-open');
      if (document.body.style.position === 'fixed') {
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.width = '';
        window.scrollTo(0, scrollPosition);
      }
    });

    // Close menu when a leaf link is tapped (not parent toggles)
    collapse.querySelectorAll('.main-menu a[href]').forEach((link) => {
      link.addEventListener('click', () => {
        if (window.innerWidth >= 992) return;
        if (!collapse.classList.contains('show')) return;
        const li = link.closest('.menu-item');
        if (li?.classList.contains('menu-item-has-children')) {
          const href = link.getAttribute('href');
          if (!href || href === '#') return;
        }
        if (typeof bootstrap !== 'undefined') {
          bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        }
      });
    });

    // Reset on desktop resize
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 992) {
        if (collapse.classList.contains('show') && typeof bootstrap !== 'undefined') {
          bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        }
        if (document.body.style.position === 'fixed') {
          document.body.style.position = '';
          document.body.style.top = '';
          document.body.style.left = '';
          document.body.style.right = '';
          document.body.style.width = '';
          document.body.classList.remove('nav-open');
          header.classList.remove('menu-open');
        }
      }
    });

    // Sync aria-expanded on toggler for hamburger animation
    if (toggler) {
      collapse.addEventListener('shown.bs.collapse', () => {
        toggler.setAttribute('aria-expanded', 'true');
        toggler.setAttribute('aria-label', 'Close menu');
      });
      collapse.addEventListener('hidden.bs.collapse', () => {
        toggler.setAttribute('aria-expanded', 'false');
        toggler.setAttribute('aria-label', 'Open menu');
      });
    }
  }

  /* --------------------------------------------------------------------------
     Multi-level mega menu (desktop hover + mobile accordion)
     -------------------------------------------------------------------------- */
  function initMegaMenu() {
    const menu = document.getElementById('mainMenu');
    if (!menu) return;

    const isMobile = () => window.innerWidth < 992;
    const closeTimers = new WeakMap();

    menu.querySelectorAll('.menu-item-has-children').forEach((li) => {
      li.addEventListener('mouseenter', () => {
        if (isMobile()) return;
        const timer = closeTimers.get(li);
        if (timer) clearTimeout(timer);
        li.classList.add('is-hover');
      });

      li.addEventListener('mouseleave', () => {
        if (isMobile()) return;
        const timer = setTimeout(() => {
          li.classList.remove('is-hover');
          closeTimers.delete(li);
        }, 120);
        closeTimers.set(li, timer);
      });
    });

    menu.querySelectorAll('.submenu-toggle').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!isMobile()) return;

        const li = btn.closest('.menu-item-has-children');
        if (!li) return;

        const willOpen = !li.classList.contains('is-open');

        const parentUl = li.parentElement;
        if (parentUl) {
          parentUl.querySelectorAll(':scope > .menu-item-has-children.is-open').forEach((openLi) => {
            if (openLi !== li) {
              openLi.classList.remove('is-open');
              const openBtn = openLi.querySelector(':scope > .menu-parent-wrap .submenu-toggle');
              openBtn?.setAttribute('aria-expanded', 'false');
            }
          });
        }

        li.classList.toggle('is-open', willOpen);
        btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      });
    });

    menu.querySelectorAll('.menu-item-has-children > .menu-parent-wrap .menu-parent').forEach((link) => {
      link.addEventListener('click', (e) => {
        if (!isMobile()) return;
        const href = link.getAttribute('href');
        if (href && href !== '#') return;
        e.preventDefault();
        const btn = link.parentElement?.querySelector('.submenu-toggle');
        btn?.click();
      });
    });

    menu.querySelectorAll('.sub-menu .menu-item-has-children > .menu-parent-wrap .menu-parent').forEach((link) => {
      link.addEventListener('click', (e) => {
        if (!isMobile()) return;
        const href = link.getAttribute('href');
        if (href && href !== '#') return;
        e.preventDefault();
        link.parentElement?.querySelector('.submenu-toggle')?.click();
      });
    });

    window.addEventListener('resize', () => {
      if (!isMobile()) {
        menu.querySelectorAll('.menu-item-has-children.is-open, .menu-item-has-children.is-hover').forEach((li) => {
          li.classList.remove('is-open', 'is-hover');
        });
        menu.querySelectorAll('.submenu-toggle').forEach((btn) => {
          btn.setAttribute('aria-expanded', 'false');
        });
      }
    });

    menu.querySelectorAll('.menu-item-has-children > .menu-parent[href="#"], .sub-menu .menu-item-has-children > .menu-parent-wrap .menu-parent[href="#"], .sub-menu .menu-item-has-children > a.menu-parent[href="#"]').forEach((link) => {
      link.addEventListener('click', (e) => {
        if (!isMobile()) e.preventDefault();
      });
      link.addEventListener('mousedown', (e) => {
        if (!isMobile()) e.preventDefault();
      });
    });
  }

  /* --------------------------------------------------------------------------
     Hero image slider
     -------------------------------------------------------------------------- */
  function initHeroSlider() {
    const slider = document.getElementById('heroSlider');
    const dotsContainer = document.getElementById('heroSliderDots');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    if (slides.length < 2) return;

    let current = 0;
    let autoplayTimer;

    slides.forEach((_, i) => {
      if (!dotsContainer) return;
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.setAttribute('aria-label', `Show hero slide ${i + 1}`);
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => {
        goTo(i);
        startAutoplay();
      });
      dotsContainer.appendChild(dot);
    });

    const dots = dotsContainer?.querySelectorAll('button') || [];

    function goTo(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
      dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
    }

    function next() {
      goTo(current + 1);
    }

    function startAutoplay() {
      clearInterval(autoplayTimer);
      autoplayTimer = setInterval(next, 6000);
    }

    slider.addEventListener('mouseenter', () => clearInterval(autoplayTimer));
    slider.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
  }

  /* --------------------------------------------------------------------------
     Smooth scroll for anchor links
     -------------------------------------------------------------------------- */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const target = document.querySelector(targetId);
        if (!target) return;

        e.preventDefault();
        const headerOffset = document.getElementById('siteHeader')?.offsetHeight || 80;
        const top = target.getBoundingClientRect().top + window.scrollY - headerOffset;

        const scrollBehavior =
          prefersReducedMotion() || !supportsSmoothScroll() ? 'auto' : 'smooth';
        window.scrollTo({ top, behavior: scrollBehavior });

        // Close mobile menu
        const navCollapse = document.getElementById('mainNav');
        if (navCollapse?.classList.contains('show') && typeof bootstrap !== 'undefined') {
          bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
        }
      });
    });
  }

  /* --------------------------------------------------------------------------
     Scroll reveal animations (Intersection Observer)
     -------------------------------------------------------------------------- */
  function initScrollReveal() {
    const reveals = document.querySelectorAll('[data-reveal]');
    if (!reveals.length) return;

    if (!('IntersectionObserver' in window)) {
      reveals.forEach((el) => el.classList.add('revealed'));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;

          const el = entry.target;
          const delay = parseInt(el.dataset.revealDelay || '0', 10);

          setTimeout(() => el.classList.add('revealed'), delay);
          observer.unobserve(el);
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    reveals.forEach((el) => observer.observe(el));
  }

  /* --------------------------------------------------------------------------
     Lazy load images
     -------------------------------------------------------------------------- */
  function initLazyLoad() {
    const lazyImages = document.querySelectorAll('img.lazy');

    if ('loading' in HTMLImageElement.prototype) {
      lazyImages.forEach((img) => {
        if (img.complete) img.classList.add('loaded');
        else img.addEventListener('load', () => img.classList.add('loaded'));
      });
      return;
    }

    const imageObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const img = entry.target;
        if (img.dataset.src) img.src = img.dataset.src;
        img.classList.add('loaded');
        imageObserver.unobserve(img);
      });
    });

    lazyImages.forEach((img) => imageObserver.observe(img));
  }

  /* --------------------------------------------------------------------------
     Animated counters
     -------------------------------------------------------------------------- */
  function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    const animateCounter = (el) => {
      const target = parseInt(el.dataset.counter, 10);
      const duration = 2000;
      const start = performance.now();

      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(eased * target);
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = target;
      };

      requestAnimationFrame(step);
    };

    if (!('IntersectionObserver' in window)) {
      counters.forEach((el) => {
        el.textContent = el.dataset.counter;
      });
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        });
      },
      { threshold: 0.5 }
    );

    counters.forEach((c) => observer.observe(c));
  }

  /* --------------------------------------------------------------------------
     Testimonial slider
     -------------------------------------------------------------------------- */
  function initTestimonialSlider() {
    const track = document.getElementById('testimonialTrack');
    const prevBtn = document.getElementById('testimonialPrev');
    const nextBtn = document.getElementById('testimonialNext');
    const dotsContainer = document.getElementById('testimonialDots');

    if (!track || !prevBtn || !nextBtn) return;

    const slides = track.querySelectorAll('.testimonial-card');
    let current = 0;
    let autoplayTimer;

    // Build dots
    if (dotsContainer) {
      slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goTo(i));
        dotsContainer.appendChild(dot);
      });
    }

    const dots = dotsContainer?.querySelectorAll('button') || [];

    function goTo(index) {
      current = (index + slides.length) % slides.length;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function next() {
      goTo(current + 1);
    }

    function prev() {
      goTo(current - 1);
    }

    function startAutoplay() {
      stopAutoplay();
      autoplayTimer = setInterval(next, 6000);
    }

    function stopAutoplay() {
      clearInterval(autoplayTimer);
    }

    prevBtn.addEventListener('click', () => {
      prev();
      startAutoplay();
    });

    nextBtn.addEventListener('click', () => {
      next();
      startAutoplay();
    });

    track.parentElement?.addEventListener('mouseenter', stopAutoplay);
    track.parentElement?.addEventListener('mouseleave', startAutoplay);

    // Touch swipe
    let touchStartX = 0;
    track.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
      const diff = touchStartX - e.changedTouches[0].screenX;
      if (Math.abs(diff) > 50) diff > 0 ? next() : prev();
      startAutoplay();
    }, { passive: true });

    startAutoplay();
  }

  /* --------------------------------------------------------------------------
     Back to top button
     -------------------------------------------------------------------------- */
  function initBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;

    window.addEventListener(
      'scroll',
      () => btn.classList.toggle('visible', window.scrollY > 500),
      { passive: true }
    );

    btn.addEventListener('click', () => {
      const scrollBehavior =
        prefersReducedMotion() || !supportsSmoothScroll() ? 'auto' : 'smooth';
      window.scrollTo({ top: 0, behavior: scrollBehavior });
    });
  }

  /* --------------------------------------------------------------------------
     Active nav link on scroll
     -------------------------------------------------------------------------- */
  function initActiveNavOnScroll() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');

    if (!sections.length || !navLinks.length) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const id = entry.target.getAttribute('id');
          navLinks.forEach((link) => {
            link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
          });
        });
      },
      { rootMargin: '-40% 0px -55% 0px', threshold: 0 }
    );

    sections.forEach((s) => observer.observe(s));
  }

  /* --------------------------------------------------------------------------
     Server-side forms – Bootstrap validation UI
     -------------------------------------------------------------------------- */
  function initServerFormValidation() {
    document.querySelectorAll('form[data-server-form]').forEach((form) => {
      form.classList.add('needs-validation');
      form.setAttribute('novalidate', 'novalidate');

      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();

          const firstInvalid = form.querySelector(':invalid');
          if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        }

        form.classList.add('was-validated');
      });

      form.querySelectorAll('.form-control, .form-select, textarea').forEach((input) => {
        ['input', 'blur'].forEach((evt) => {
          input.addEventListener(evt, () => {
            if (!form.classList.contains('was-validated')) {
              return;
            }

            if (input.checkValidity()) {
              input.classList.remove('is-invalid');
              input.classList.add('is-valid');
            } else {
              input.classList.add('is-invalid');
              input.classList.remove('is-valid');
            }
          });
        });
      });
    });
  }

  function initServerFormErrorsOnLoad() {
    document.querySelectorAll('.srl-form-messages[data-has-errors]').forEach((box) => {
      const form = box.parentElement?.querySelector('form[data-server-form]');
      if (!form) {
        return;
      }

      form.classList.add('was-validated');

      form.querySelectorAll('input, select, textarea').forEach((field) => {
        if (field.type === 'hidden' || field.closest('.srl-form-antispam-hp')) {
          return;
        }

        if (!field.checkValidity()) {
          field.classList.add('is-invalid');
          field.classList.remove('is-valid');
        }
      });
    });
  }

  function initFormMessageScroll() {
    const errorBox = document.querySelector('.srl-form-messages[data-has-errors]');
    if (errorBox) {
      errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    const successBox = document.querySelector('.srl-form-messages');
    if (successBox) {
      successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    if (window.location.hash) {
      const target = document.querySelector(window.location.hash);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }
  }

  /* --------------------------------------------------------------------------
     Contact form (static placeholder)
     -------------------------------------------------------------------------- */
  function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    if (form.hasAttribute('data-server-form')) return;

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }
      // Placeholder for future PHP/API integration
      const btn = form.querySelector('[type="submit"]');
      const originalText = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Sending...';

      setTimeout(() => {
        btn.textContent = 'Message Sent!';
        btn.classList.replace('btn-primary', 'btn-success');
        form.reset();
        form.classList.remove('was-validated');

        setTimeout(() => {
          btn.disabled = false;
          btn.textContent = originalText;
          btn.classList.replace('btn-success', 'btn-primary');
        }, 3000);
      }, 1200);
    });
  }

  /* --------------------------------------------------------------------------
     Newsletter form (static placeholder)
     -------------------------------------------------------------------------- */
  function initNewsletterForm() {
    const form = document.getElementById('newsletterForm');
    if (!form) return;

    if (form.hasAttribute('data-server-form')) return;

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const input = form.querySelector('input[type="email"]');
      const btn = form.querySelector('button');
      if (!input?.value) return;

      btn.innerHTML = '<i class="bi bi-check-lg"></i>';
      input.value = '';
      setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-send"></i>';
      }, 2500);
    });
  }
})();
