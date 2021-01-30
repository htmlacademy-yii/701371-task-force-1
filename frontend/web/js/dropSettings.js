/* jshint esversion: 6 */

$(function () {
  $(document).on('click', '.setting-button__link-delete_file', function () {
    let link = $(this);

    if (link.is('.stop')) {
      return false;
    }

    link.addClass('stop');

    $.ajax({
      url: 'settings/drop',
      type: 'post',
      data: {
        id: link.data('id')
      },

      success: function() {
        link.parent().remove();
      },

      complete: function() {
        link.removeClass('.stop');
      },

      error: function() {}
    })
  });
});
