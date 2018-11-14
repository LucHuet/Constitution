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
      $.ajax({
        url:Routing.generate('acteur_partie_list'),
      }).then((data) => {
        $.each(data.items, (key, acteur) =>{
            this._addRow(acteur);
        });
      });
    },

    handleActeurDelete: function(e) {
      e.preventDefault();

      const $link = $(e.currentTarget);
      swal({
        title: 'Supprimer cet Acteur ?',
        html: 'Supprimer ?',
        showCancelButton: true,
      }).then(() =>{
            this._deleteActeur($link);
      }).catch( (arg) => {
            console.log('cancel');
      });
    },

    _deleteActeur:function($link){
      $link.addClass('text-danger');
      $link.find('.fa')
        .removeClass('fa-trash')
        .addClass('fa-spinner')
        .addClass('fa-spin');

      const deleteUrl = $link.data('url');
      const $row = $link.closest('tr');
      $.ajax({
        url: deleteUrl,
        method: 'DELETE',
      }).then((data) =>{
        $row.fadeOut('normal', () =>{
          $row.remove();
        });
      }).catch((jqXHR) =>{
        console.log('delete fail')
      });
    },

    handleRowClick: function() {
      console.log('row click');
    },

    handleNewFormSubmit: function(e) {
      e.preventDefault();
      const $form = $(e.currentTarget);
      const formData = {};
      $.each($form.serializeArray(), (key, fieldData)=>{
        formData[fieldData.name] = fieldData.value;
      });
      this._saveActeur(formData)
      .then((data) =>{
        this._clearForm();
        this._addRow(data);
      }).catch((errorData) =>{
        this._mapErrorsToForm(errorData.responseJSON.errors);
      });
    },

    _saveActeur: function(data) {
      return $.ajax({
          url: Routing.generate('acteur_partie_newJS'),
          method: 'POST',
          data: JSON.stringify(data),
        }).then((data, textStatus, jqXHR) =>{
            return $.ajax({
              url: jqXHR.getResponseHeader('Location')
            });
        });
    },

    _mapErrorsToForm: function(errorData){
      // reset things
      const $form = this.$wrapper.find(this._selectors.newActeurForm);
      this._removeFormErrors();

      $form.find(':input').each((index, element) =>{
        const fieldName = $(element).attr('name');
        const $wrapper = $(element).closest('.form-group');
        if(!errorData[fieldName])
        {
          //no error
          return;
        }

        const $error = $('<span class="js-field-error help-block"></span>');
        $error.html(errorData[fieldName]);
        $wrapper.append($error);
        $wrapper.addClass('has-error');
      });
    },

    _removeFormErrors: function(){
      const $form = this.$wrapper.find(this._selectors.newActeurForm);
      $form.find('.js-field-error').remove();
      $form.find('.form-group').removeClass('has-error');
    },

    _clearForm: function(){
      this._removeFormErrors();
      const $form = this.$wrapper.find(this._selectors.newActeurForm);
      $form[0].reset();
    },

    _addRow: function(acteur){
      const tplText = $('#js-acteur-row-template').html();
      const tpl = _.template(tplText);

      const html = tpl(acteur);
      this.$wrapper.find('tbody')
        .append($.parseHTML(html));
    }

  });
})(window, jQuery, Routing, swal);
