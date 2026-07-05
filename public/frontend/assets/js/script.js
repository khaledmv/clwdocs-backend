/* ==========================================================================
   clw-backend — interactivity (vanilla JS, no dependencies)
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  initThemeToggle();
  initMobileNav();
  initStepTabs();
  initCopyButtons();
  initScrollFadeIn();
  initFooterYear();
});

/* ---- Dark / light mode toggle ------------------------------------------ */
/* Toggles a class on <body>. No localStorage, per spec — resets on reload. */
function initThemeToggle() {
  const toggleBtn = document.getElementById('themeToggle');
  if (!toggleBtn) return;

  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
  });
}

/* ---- Mobile hamburger / off-canvas nav --------------------------------- */
function initMobileNav() {
  const hamburger = document.getElementById('hamburgerBtn');
  const nav = document.getElementById('mainNav');
  const backdrop = document.getElementById('navBackdrop');
  if (!hamburger || !nav || !backdrop) return;

  const closeNav = () => {
    hamburger.classList.remove('is-active');
    nav.classList.remove('is-open');
    backdrop.classList.remove('is-visible');
    hamburger.setAttribute('aria-expanded', 'false');
  };

  const openNav = () => {
    hamburger.classList.add('is-active');
    nav.classList.add('is-open');
    backdrop.classList.add('is-visible');
    hamburger.setAttribute('aria-expanded', 'true');
  };

  hamburger.addEventListener('click', () => {
    const isOpen = nav.classList.contains('is-open');
    isOpen ? closeNav() : openNav();
  });

  backdrop.addEventListener('click', closeNav);

  // Close the nav whenever a link inside it is clicked (mobile UX).
  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeNav);
  });

  // Close on Escape for keyboard users.
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeNav();
  });
}

/* ---- Quick start step tabs --------------------------------------------- */
function initStepTabs() {
  const stepButtons = document.querySelectorAll('.step-item');
  const stepPanels = document.querySelectorAll('.step-panel');
  if (!stepButtons.length || !stepPanels.length) return;

  stepButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const targetStep = button.getAttribute('data-step');

      stepButtons.forEach((btn) => {
        btn.classList.remove('is-active');
        btn.setAttribute('aria-selected', 'false');
      });
      button.classList.add('is-active');
      button.setAttribute('aria-selected', 'true');

      stepPanels.forEach((panel) => {
        panel.classList.toggle('is-active', panel.id === `step-panel-${targetStep}`);
      });
    });
  });
}

/* ---- Copy-to-clipboard buttons ------------------------------------------ */
function initCopyButtons() {
  const copyButtons = document.querySelectorAll('.copy-btn');
  if (!copyButtons.length) return;

  copyButtons.forEach((button) => {
    const targetId = button.getAttribute('data-copy-target');
    const codeEl = document.getElementById(targetId);
    if (!codeEl) return;

    const label = button.querySelector('span');

    button.addEventListener('click', async () => {
      const text = codeEl.innerText;

      try {
        await navigator.clipboard.writeText(text);
      } catch (err) {
        // Clipboard API unavailable (e.g. insecure context) — fail silently.
        return;
      }

      button.classList.add('is-copied');
      const originalLabel = label ? label.textContent : '';
      if (label) label.textContent = 'Copied!';

      setTimeout(() => {
        button.classList.remove('is-copied');
        if (label) label.textContent = originalLabel;
      }, 1800);
    });
  });
}

/* ---- Scroll fade-in reveal (IntersectionObserver) ----------------------- */
function initScrollFadeIn() {
  const fadeEls = document.querySelectorAll('.fade-in');
  if (!fadeEls.length) return;

  if (!('IntersectionObserver' in window)) {
    fadeEls.forEach((el) => el.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
  );

  fadeEls.forEach((el) => observer.observe(el));
}

/* ---- Footer copyright year ----------------------------------------------*/
function initFooterYear() {
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
}
