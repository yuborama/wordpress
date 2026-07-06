(function () {
  var heroSection = document.querySelector('.hero-section');
  if (!heroSection) return;

  var slides = heroSection.querySelectorAll('[data-hero-slide]');
  var copies = heroSection.querySelectorAll('[data-hero-copy]');
  var prevButton = heroSection.querySelector('.hero-prev');
  var nextButton = heroSection.querySelector('.hero-next');
  var activeIndex = 0;
  var intervalMs = 6500;
  var timerId;

  function setActiveSlide(index) {
    activeIndex = (index + slides.length) % slides.length;

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

  if (slides.length > 1) {
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
  }
})();
