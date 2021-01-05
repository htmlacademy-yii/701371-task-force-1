/* jshint esversion: 6 */

$(function () {
  $(document).on('click', '.setting-button__link-delete_file', function () {
    let link = $(this);
    $.ajax({
      url: 'settings/drop',
      type: 'post',
      data: {
        id: link.data('id')
      },

      success: function() {
        link.parent().remove();
      },

      error: function() {}
    })
  });
});
