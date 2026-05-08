/* SmartCity PH — GSAP scroll animations */

(function () {
  'use strict';
  if (typeof gsap === 'undefined') return;
  if (typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Hero load animations
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

  // Section headers
  document.querySelectorAll('.section-header').forEach((el) => {
    gsap.from(el, {
      scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' },
      y: 30,
      opacity: 0,
      duration: 0.8,
      ease: 'power3.out',
    });
  });

  // Category cards
  gsap.from('.cat-strip .cat-card', {
    scrollTrigger: { trigger: '.cat-strip', start: 'top 85%', toggleActions: 'play none none none' },
    y: 28,
    opacity: 0,
    stagger: 0.1,
    duration: 0.6,
    ease: 'power2.out',
  });

  // Service cards
  document.querySelectorAll('.svc-grid').forEach((grid) => {
    gsap.from(grid.children, {
      scrollTrigger: { trigger: grid, start: 'top 85%', toggleActions: 'play none none none' },
      y: 30,
      opacity: 0,
      stagger: 0.1,
      duration: 0.7,
      ease: 'power3.out',
    });
  });

  // News cards
  document.querySelectorAll('.news-grid').forEach((grid) => {
    gsap.from(grid.children, {
      scrollTrigger: { trigger: grid, start: 'top 85%', toggleActions: 'play none none none' },
      y: 30,
      opacity: 0,
      stagger: 0.1,
      duration: 0.7,
      ease: 'power3.out',
    });
  });

  // Steps sequential reveal
  gsap.from('.steps .step-card', {
    scrollTrigger: { trigger: '.steps', start: 'top 80%', toggleActions: 'play none none none' },
    y: 30,
    opacity: 0,
    stagger: 0.18,
    duration: 0.8,
    ease: 'power3.out',
  });

  // Map scale
  document.querySelectorAll('.map-frame').forEach((el) => {
    gsap.from(el, {
      scrollTrigger: { trigger: el, start: 'top 80%', toggleActions: 'play none none none' },
      scale: 0.96,
      opacity: 0,
      duration: 0.9,
      ease: 'power3.out',
    });
  });

  // Hotline cards
  gsap.from('.hotline-card', {
    scrollTrigger: { trigger: '.emergency-banner', start: 'top 80%', toggleActions: 'play none none none' },
    y: 24,
    opacity: 0,
    stagger: 0.08,
    duration: 0.6,
    ease: 'power2.out',
  });

  // Project / progress bars fill
  document.querySelectorAll('.progress-bar .fill').forEach((el) => {
    const target = el.dataset.progress || '0';
    gsap.fromTo(el, { width: '0%' }, {
      width: target + '%',
      duration: 1.4,
      ease: 'power3.out',
      scrollTrigger: { trigger: el, start: 'top 90%', toggleActions: 'play none none none' },
    });
  });

})();
