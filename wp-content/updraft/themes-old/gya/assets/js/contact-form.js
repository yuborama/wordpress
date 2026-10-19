(function () {
  var form = document.getElementById('gya-contact-form');

  if (!form || !window.gyaContactForm) return;

  var message = document.getElementById('gya-contact-message');
  var submit = form.querySelector('.contact-submit');

  function setMessage(text, type) {
    if (!message) return;

    message.textContent = text || '';
    message.classList.toggle('is-success', type === 'success');
    message.classList.toggle('is-error', type === 'error');
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = new FormData(form);
    formData.append('action', 'gya_contact_form');

    if (submit) {
      submit.disabled = true;
    }

    setMessage('Enviando...', '');

    fetch(window.gyaContactForm.ajaxUrl, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin'
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (result) {
        if (!result || !result.success) {
          setMessage(result && result.data && result.data.message ? result.data.message : 'No se pudo enviar el formulario.', 'error');
          return;
        }

        form.reset();

        setMessage(result.data && result.data.message ? result.data.message : 'Tu solicitud fue enviada correctamente.', 'success');
      })
      .catch(function () {
        setMessage('Ocurrió un error. Intenta nuevamente.', 'error');
      })
      .finally(function () {
        if (submit) {
          submit.disabled = false;
        }
      });
  });
})();
