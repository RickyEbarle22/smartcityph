/* SmartCity PH — GSAP scroll animations */

(function () {
  'use strict';
  if (typeof gsap === 'undefined') return;
  if (typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Hero load animations — these run on page load, no ScrollTrigger needed.
  gsap.from('.hero-content > *', {
    y: 30,
    opacity: 0,
    stagger: 0.12,
    duration: 0.9,
    ease: 'power3.out',
    delay: 0.1,
  });
  gsap.from('.hero-stats .stat', {
    y: 20,
    opacity: 0,
    stagger: 0.08,
    duration: 0.7,
    ease: 'power2.out',
    delay: 0.6,
  });

  if (reduce || typeof ScrollTrigger === 'undefined') return;

  // ScrollTrigger animations: use `immediateRender: false` so elements stay
  // visible by default (CSS state) and only animate when the trigger fires.
  // This prevents cards from staying invisible if ScrollTrigger ever misfires.
  const scrollFade = (target, opts = {}) => {
    gsap.from(target, Object.assign({
      y: 30,
      opacity: 0,
      duration: 0.7,
      ease: 'power3.out',
      immediateRender: false,
    }, opts));
  };

  document.querySelectorAll('.section-header').forEach((el) => {
    scrollFade(el, {
      scrollTrigger: { trigger: el, start: 'top 90%', toggleActions: 'play none none none' },
      duration: 0.8,
    });
  });

  // Category cards
  document.querySelectorAll('.cat-strip').forEach((strip) => {
    scrollFade(strip.children, {
      scrollTrigger: { trigger: strip, start: 'top 90%', toggleActions: 'play none none none' },
      stagger: 0.1,
      y: 28,
      duration: 0.6,
    });
  });

  // Service cards
  document.querySelectorAll('.svc-grid').forEach((grid) => {
    scrollFade(grid.children, {
      scrollTrigger: { trigger: grid, start: 'top 90%', toggleActions: 'play none none none' },
      stagger: 0.08,
    });
  });

  // News cards
  document.querySelectorAll('.news-grid').forEach((grid) => {
    scrollFade(grid.children, {
      scrollTrigger: { trigger: grid, start: 'top 90%', toggleActions: 'play none none none' },
      stagger: 0.08,
    });
  });

  // Steps
  document.querySelectorAll('.steps').forEach((steps) => {
    scrollFade(steps.children, {
      scrollTrigger: { trigger: steps, start: 'top 85%', toggleActions: 'play none none none' },
      stagger: 0.15,
      duration: 0.8,
    });
  });

  // Map scale
  document.querySelectorAll('.map-frame').forEach((el) => {
    gsap.from(el, {
      scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' },
      scale: 0.96,
      opacity: 0,
      duration: 0.9,
      ease: 'power3.out',
      immediateRender: false,
    });
  });

  // Hotline cards
  document.querySelectorAll('.emergency-banner').forEach((banner) => {
    const cards = banner.querySelectorAll('.hotline-card');
    if (cards.length) {
      scrollFade(cards, {
        scrollTrigger: { trigger: banner, start: 'top 85%', toggleActions: 'play none none none' },
        stagger: 0.06,
        y: 24,
        duration: 0.6,
      });
    }
  });

  // Progress bars: explicit fromTo (safe — width animation, not opacity)
  document.querySelectorAll('.progress-bar .fill').forEach((el) => {
    const target = el.dataset.progress || '0';
    gsap.fromTo(el, { width: '0%' }, {
      width: target + '%',
      duration: 1.4,
      ease: 'power3.out',
      immediateRender: false,
      scrollTrigger: { trigger: el, start: 'top 95%', toggleActions: 'play none none none' },
    });
  });

  // Safety net: refresh ScrollTrigger after page assets load to recompute
  // trigger positions (handles fonts/images shifting layout).
  window.addEventListener('load', () => {
    if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
  });

})();
