(function () {
  var heroSection = document.querySelector('.hero-section');
  if (!heroSection) return;

  var slides = heroSection.querySelectorAll('[data-hero-slide]');
  var copies = heroSection.querySelectorAll('[data-hero-copy]');
  var prevButton = heroSection.querySelector('.hero-prev');
  var nextButton = heroSection.querySelector('.hero-next');
  var activeIndex = 0;
  var slideCount = Math.max(slides.length, copies.length);
  var intervalMs = 6500;
  var timerId;

  function setActiveSlide(index) {
    if (slideCount <= 0) return;

    activeIndex = (index + slideCount) % slideCount;

    slides.forEach(function (slide, i) {
      slide.classList.toggle('is-active', i === activeIndex);
    });

    copies.forEach(function (copy, i) {
      copy.classList.toggle('is-active', i === activeIndex);
    });
  }

  function startAutoplay() {
    if (timerId) clearInterval(timerId);
    timerId = setInterval(function () {
      setActiveSlide(activeIndex + 1);
    }, intervalMs);
  }

  if (slideCount > 1) {
    if (prevButton) {
      prevButton.addEventListener('click', function () {
        setActiveSlide(activeIndex - 1);
        startAutoplay();
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        setActiveSlide(activeIndex + 1);
        startAutoplay();
      });
    }

    startAutoplay();
  } else {
    if (prevButton) prevButton.hidden = true;
    if (nextButton) nextButton.hidden = true;
  }
})();

(function () {
  var toggle = document.querySelector('.mobile-menu-toggle');
  var panel = document.querySelector('.mobile-menu-panel');
  var closeButton = document.querySelector('.mobile-menu-close');

  if (!toggle || !panel || !closeButton) return;

  function setMenuOpen(isOpen) {
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    panel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    panel.classList.toggle('is-open', isOpen);
    document.body.classList.toggle('mobile-menu-open', isOpen);
  }

  toggle.addEventListener('click', function () {
    setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });

  closeButton.addEventListener('click', function () {
    setMenuOpen(false);
  });

  panel.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      setMenuOpen(false);
    });
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      setMenuOpen(false);
    }
  });
})();
