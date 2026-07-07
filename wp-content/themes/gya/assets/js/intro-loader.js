(function () {
  var config = window.gyaIntroLoader || {};
  var loader = document.getElementById('page-loader');
  var container = document.getElementById('page-loader-lottie');
  var storageKey = config.storageKey || 'gyaIntroLoaderPlayed';
  var hideTimer;

  function hideLoader() {
    if (!loader) return;

    loader.classList.add('is-hidden');
    document.body.classList.remove('has-page-loader');
    window.clearTimeout(hideTimer);

    window.setTimeout(function () {
      if (loader && loader.parentNode) {
        loader.parentNode.removeChild(loader);
      }
    }, 500);
  }

  if (!loader || !container || !config.animationPath) {
    return;
  }

  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    hideLoader();
    return;
  }

  try {
    if (window.sessionStorage && window.sessionStorage.getItem(storageKey) === 'true') {
      hideLoader();
      return;
    }

    if (window.sessionStorage) {
      window.sessionStorage.setItem(storageKey, 'true');
    }
  } catch (error) {
    // Storage can be unavailable in private browsing; the animation can still run.
  }

  document.body.classList.add('has-page-loader');

  if (!window.lottie || typeof window.lottie.loadAnimation !== 'function') {
    hideLoader();
    return;
  }

  hideTimer = window.setTimeout(hideLoader, 5000);

  var animation = window.lottie.loadAnimation({
    container: container,
    renderer: 'svg',
    loop: false,
    autoplay: true,
    path: config.animationPath
  });

  animation.addEventListener('complete', hideLoader);
  animation.addEventListener('data_failed', hideLoader);
})();
