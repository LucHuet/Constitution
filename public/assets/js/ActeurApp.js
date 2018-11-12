'use strict';

(function(window, $, Routing, swal) {
  window.ActeurApp =  function($wrapper){
    this.$wrapper = $wrapper;
    this.$wrapper.on(
      'click',
      '.js-delete-acteur',
      this.handleActeurDelete.bind(this)
    );

    this.loadActeurs();

    this.$wrapper.on(
      'click',
      'tbody tr',
      this.handleRowClick.bind(this)
    );

    this.$wrapper.on(
      'submit',
      this._selectors.newActeurForm,
      this.handleNewFormSubmit.bind(this)
    );
  };

  $.extend(window.ActeurApp.prototype, {

    _selectors: {
      newActeurForm: '.js-new-acteur-form'
    },

    loadActeurs: function(){
      var self = this;
      $.ajax({
        url:Routing.generate('acteur_partie_list'),
      }).then(function(data){
        $.each(data.items, function(key, acteur){
            self._addRow(acteur);
        });
      });
    },

    handleActeurDelete: function(e) {
      e.preventDefault();

      var $link = $(e.currentTarget);
      var self = this;
      swal({
        title: 'Supprimer cet Acteur ?',
        html: 'Supprimer ?',
        showCancelButton: true,
      }).then(function(){
            self._deleteActeur($link);
      }).catch(function (arg) {
            console.log('cancel');
          }
      });
    },

    _deleteActeur:function($link){
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
      }).then(function(data){
        $row.fadeOut('normal', function(){
          $row.remove();
        });
      }).catch(function(jqXHR){
        console.log('delete fail')
      });
    },

    handleRowClick: function() {
      console.log('row click');
    },

    handleNewFormSubmit: function(e) {
      e.preventDefault();
      var $form = $(e.currentTarget);
      var formData = {};
      $.each($form.serializeArray(), function(key, fieldData){
        formData[fieldData.name] = fieldData.value;
      });
      var self = this;
      this._saveActeur(formData)
      .then(function(data){
        self._clearForm();
        self._addRow(data);
      }).catch(function(errorData){
        self._mapErrorsToForm(errorData.errors);
      });
    },

    _saveActeur: function(data) {
      return $.ajax({
          url: Routing.generate('acteur_partie_newJS'),
          method: 'POST',
          data: JSON.stringify(data),
        }).then(function(data, textStatus, jqXHR){
            return $.ajax({
              url: jqXHR.getResponseHeader('Location')
            });
        });
    },

    _mapErrorsToForm: function(errorData){
      // reset things
      var $form = this.$wrapper.find(this._selectors.newActeurForm);
      this._removeFormErrors();

      $form.find(':input').each(function(){
        var fieldName = $(this).attr('name');
        var $wrapper = $(this).closest('.form-group');
        if(!errorData[fieldName])
        {
          //no error
          return;
        }

        var $error = $('<span class="js-field-error help-block"></span>');
        $error.html(errorData[fieldName]);
        $wrapper.append($error);
        $wrapper.addClass('has-error');
      });
    },

    _removeFormErrors: function(){
      var $form = this.$wrapper.find(this._selectors.newActeurForm);
      $form.find('.js-field-error').remove();
      $form.find('.form-group').removeClass('has-error');
    },

    _clearForm: function(){
      this._removeFormErrors();
      var $form = this.$wrapper.find(this._selectors.newActeurForm);
      $form[0].reset();
    },

    _addRow: function(acteur){
      var tplText = $('#js-acteur-row-template').html();
      var tpl = _.template(tplText);

      var html = tpl(acteur);
      this.$wrapper.find('tbody')
        .append($.parseHTML(html));
    }

  });
})(window, jQuery, Routing, swal);
