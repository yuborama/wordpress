(function ($) {
  'use strict';

  var $list = $('.wp-list-table.posts tbody');
  var $notice = $('<div class="gya-order-status" role="status" aria-live="polite"></div>');

  if (!$list.length || !window.gyaTeamOrder) return;

  $('.wp-list-table').before($notice);

  function setStatus(message, state) {
    $notice.text(message).attr('data-state', state || '');
  }

  function saveOrder() {
    var postIds = $list.children('tr[id^="post-"]').map(function () {
      return this.id.replace('post-', '');
    }).get();

    setStatus('Guardando orden...', 'saving');

    $.post(window.gyaTeamOrder.ajaxUrl, {
      action: 'gya_save_team_order',
      nonce: window.gyaTeamOrder.nonce,
      postIds: postIds
    }).done(function (response) {
      if (response && response.success) {
        setStatus('Orden guardado.', 'success');
        window.setTimeout(function () { setStatus('', ''); }, 1800);
        return;
      }

      setStatus(window.gyaTeamOrder.errorMessage, 'error');
    }).fail(function () {
      setStatus(window.gyaTeamOrder.errorMessage, 'error');
    });
  }

  $list.sortable({
    axis: 'y',
    handle: '.gya-order-handle',
    items: '> tr[id^="post-"]',
    helper: function (event, row) {
      row.children().each(function () {
        $(this).width($(this).width());
      });
      return row;
    },
    placeholder: 'gya-order-placeholder',
    forcePlaceholderSize: true,
    update: saveOrder
  });
})(jQuery);
