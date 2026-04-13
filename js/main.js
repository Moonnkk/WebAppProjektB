/* ============================================================
   SunShine Tours - Main JavaScript
   Theme toggle, mobile menu, sparkle effects, general logic
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  // --- Theme Toggle (Dark/Light Mode) ---
  const themeToggle = document.getElementById('themeToggle');
  const html = document.documentElement;
  const themeIcon = themeToggle ? themeToggle.querySelector('.theme-icon') : null;

  // Load saved theme or default to light
  const savedTheme = localStorage.getItem('sunshine-theme') || 'light';
  html.setAttribute('data-theme', savedTheme);
  updateThemeIcon(savedTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      const current = html.getAttribute('data-theme');
      const next = current === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', next);
      localStorage.setItem('sunshine-theme', next);
      updateThemeIcon(next);
      // Add a fun wobble
      this.style.transform = 'scale(1.2) rotate(20deg)';
      setTimeout(() => { this.style.transform = ''; }, 300);
    });
  }

  function updateThemeIcon(theme) {
    if (themeIcon) {
      themeIcon.innerHTML = theme === 'light' ? '&#127769;' : '&#9728;&#65039;';
    }
  }

  // --- Mobile Menu Toggle ---
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navMenu = document.getElementById('navMenu');

  if (mobileMenuBtn && navMenu) {
    mobileMenuBtn.addEventListener('click', function () {
      navMenu.classList.toggle('active');
      this.innerHTML = navMenu.classList.contains('active') ? '&#10005;' : '&#9776;';
    });

    // Close menu when clicking a link
    navMenu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navMenu.classList.remove('active');
        mobileMenuBtn.innerHTML = '&#9776;';
      });
    });
  }

  // --- Random Sparkle Effect on Click ---
  document.addEventListener('click', function (e) {
    createSparkle(e.clientX, e.clientY);
  });

  function createSparkle(x, y) {
    var sparkle = document.createElement('div');
    sparkle.innerHTML = '\u2726';
    sparkle.style.cssText =
      'position:fixed;pointer-events:none;z-index:99999;font-size:' +
      (Math.random() * 20 + 10) + 'px;color:' +
      ['#FFD700', '#FF8C00', '#00FF41', '#FF4500', '#7FFF00'][Math.floor(Math.random() * 5)] +
      ';left:' + x + 'px;top:' + y +
      'px;transition:all 0.8s ease-out;opacity:1;transform:scale(1);';
    document.body.appendChild(sparkle);

    requestAnimationFrame(function () {
      sparkle.style.opacity = '0';
      sparkle.style.transform = 'scale(0) translateY(-50px) rotate(' + (Math.random() * 360) + 'deg)';
    });

    setTimeout(function () {
      sparkle.remove();
    }, 800);
  }

  // --- Randomly rotate some elements for extra jank ---
  document.querySelectorAll('.card, .review-card, .team-card').forEach(function (el, i) {
    var rotation = (Math.random() - 0.5) * 2;
    el.style.transform = 'rotate(' + rotation + 'deg)';
  });

});
