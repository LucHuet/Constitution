'use strict';

(function(window, $) {
  window.ActeurApp =  function($wrapper){
    this.$wrapper = $wrapper;
    this.$wrapper.on(
      'click',
      '.js-delete-acteur',
      this.handleActeurDelete.bind(this)
    );

    this.$wrapper.on(
      'click',
      'tbody tr',
      this.handleRowClick.bind(this)
    );

    this.$wrapper.on(
      'submit',
      '.js-new-acteur-form',
      this.handleNewFormSubmit.bind(this)
    );
  };

  $.extend(window.ActeurApp.prototype, {
    handleActeurDelete: function(e) {
      e.preventDefault();

      var $link = $(e.currentTarget);

      $link.addClass('text-danger');
      $link.find('.fa')
        .removeClass('fa-trash')
        .addClass('fa-spinner')
        .addClass('fa-spin');

      var deleteUrl = $link.data('url');
      var $row = $link.closest('tr');
      $.ajax({
        url: deleteUrl,
        method: 'DELETE',
        success: function() {
          $row.fadeOut('normal', function(){
            $row.remove();
          });
        }
      })
    },

    handleRowClick: function() {
      console.log('row click');
    },

    handleNewFormSubmit: function(e) {
      e.preventDefault();
      var $form = $(e.currentTarget);
      var $tbody = this.$wrapper.find('tbody');
      $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        data: $form.serialize(),
        success: function(data) {
          $tbody.append(data);
          $('#ajoutActeurModal').modal('hide');
        },
        error: function(jqXHR){
          $form.closest('.js-new-acteur-form-wrapper')
            .html(jqXHR.responseText);
        }
      });
    }
  });
})(window, jQuery);
