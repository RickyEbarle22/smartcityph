/* SmartCity PH — Core JS */

(function () {
  'use strict';

  // Navbar scroll state
  const nav = document.querySelector('.navbar');
  if (nav) {
    const onScroll = () => {
      if (window.scrollY > 40) nav.classList.add('scrolled');
      else nav.classList.remove('scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Mobile menu toggle
  const navToggle = document.querySelector('.nav-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', () => {
      const isOpen = mobileMenu.style.display === 'block';
      mobileMenu.style.display = isOpen ? 'none' : 'block';
      navToggle.setAttribute('aria-expanded', String(!isOpen));
    });
  }

  // Flash messages auto-dismiss
  document.querySelectorAll('.flash-dismiss').forEach((el) => {
    setTimeout(() => {
      el.style.transition = 'all 0.4s ease';
      el.style.opacity = '0';
      el.style.transform = 'translateY(-8px)';
      setTimeout(() => el.remove(), 400);
    }, 5000);
  });

  // Counter animation
  const easeOutQuad = (t) => t * (2 - t);
  const animateCount = (el) => {
    const target = parseInt(el.dataset.count || '0', 10);
    if (!Number.isFinite(target) || target <= 0) {
      el.textContent = el.dataset.count || '0';
      return;
    }
    const dur = 1400;
    const start = performance.now();
    const tick = (now) => {
      const t = Math.min(1, (now - start) / dur);
      const v = Math.floor(easeOutQuad(t) * target);
      el.textContent = v.toLocaleString();
      if (t < 1) requestAnimationFrame(tick);
      else el.textContent = target.toLocaleString();
    };
    requestAnimationFrame(tick);
  };

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          animateCount(e.target);
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.4 });
    document.querySelectorAll('[data-count]').forEach((el) => io.observe(el));
  }

  // Typewriter effect
  const typedEl = document.querySelector('[data-typewriter]');
  if (typedEl) {
    const phrases = (typedEl.dataset.typewriter || '').split('|').filter(Boolean);
    let pi = 0, ci = 0, deleting = false;
    const typeSpeed = 60, deleteSpeed = 28, holdMs = 1700;
    const tick = () => {
      const word = phrases[pi % phrases.length];
      if (!deleting) {
        ci++;
        typedEl.textContent = word.slice(0, ci);
        if (ci === word.length) { deleting = true; setTimeout(tick, holdMs); return; }
      } else {
        ci--;
        typedEl.textContent = word.slice(0, ci);
        if (ci === 0) { deleting = false; pi++; }
      }
      setTimeout(tick, deleting ? deleteSpeed : typeSpeed);
    };
    if (phrases.length) tick();
  }

  // Password strength
  const pwd = document.getElementById('password');
  const pwdBar = document.getElementById('pwd-bar-fill');
  const pwdText = document.getElementById('pwd-text');
  if (pwd && pwdBar) {
    pwd.addEventListener('input', () => {
      const v = pwd.value;
      let score = 0;
      if (v.length >= 6) score++;
      if (v.length >= 10) score++;
      if (/[A-Z]/.test(v)) score++;
      if (/[0-9]/.test(v)) score++;
      if (/[^A-Za-z0-9]/.test(v)) score++;
      const widths = ['0%', '20%', '40%', '65%', '85%', '100%'];
      const colors = ['#1A2035', '#EF4444', '#F59E0B', '#FCD116', '#06B6D4', '#22C55E'];
      const labels = ['—', 'Weak', 'Fair', 'Good', 'Strong', 'Excellent'];
      pwdBar.style.width = widths[score];
      pwdBar.style.background = colors[score];
      if (pwdText) pwdText.textContent = labels[score];
    });
  }

  // Confirm dialogs
  document.querySelectorAll('[data-confirm]').forEach((el) => {
    el.addEventListener('click', (e) => {
      if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
  });

  // 3D tilt on hover for .float-card with [data-tilt]
  document.querySelectorAll('[data-tilt]').forEach((card) => {
    const max = 6;
    card.addEventListener('mousemove', (e) => {
      const r = card.getBoundingClientRect();
      const x = (e.clientX - r.left) / r.width - 0.5;
      const y = (e.clientY - r.top) / r.height - 0.5;
      card.style.transform = `translateY(-6px) rotateY(${x * max}deg) rotateX(${-y * max}deg)`;
    });
    card.addEventListener('mouseleave', () => { card.style.transform = ''; });
  });

  // Filter pills active state
  document.querySelectorAll('.pills').forEach((bar) => {
    const url = new URL(window.location.href);
    bar.querySelectorAll('a.pill').forEach((p) => {
      const href = p.getAttribute('href');
      if (!href) return;
      try {
        const u = new URL(href, window.location.origin);
        if (u.search === url.search) p.classList.add('active');
      } catch (_) { /* noop */ }
    });
  });

})();
