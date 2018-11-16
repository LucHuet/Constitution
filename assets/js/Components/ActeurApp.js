'use strict';

import $ from 'jquery';
import swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.css';
import Routing from './Routing';

class ActeurApp {

  constructor ($wrapper, initialActeurs){
    this.$wrapper = $wrapper;
    this.$wrapper.on(
      'click',
      '.js-delete-acteur',
      this.handleActeurDelete.bind(this)
    );

    for(let acteur of initialActeurs){
      this._addRow(acteur);
    }

    this.$wrapper.on(
      'click',
      'tbody tr',
      this.handleRowClick.bind(this)
    );

    this.$wrapper.on(
      'submit',
      ActeurApp._selectors.newActeurForm,
      this.handleNewFormSubmit.bind(this)
    );
  }

  static get _selectors() {
    return{
      newActeurForm: '.js-new-acteur-form'
    };
  }

  handleActeurDelete(e) {
    e.preventDefault();

    const $link = $(e.currentTarget);
    swal({
      title: 'Supprimer cet Acteur ?',
      html: 'Supprimer ?',
      showCancelButton: true,
    }).then((result) =>{
      if(result.value) {
        this._deleteActeur($link);
      }
    }).catch( (arg) => {
          console.log('cancel');
    });
  }

  _deleteActeur($link){
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
  }

  handleRowClick() {
    console.log('row click');
  }

  handleNewFormSubmit(e) {
    e.preventDefault();
    const $form = $(e.currentTarget);
    const formData = {};
    for(let fieldData of $form.serializeArray()){
      formData[fieldData.name] = fieldData.value;
    }
    this._saveActeur(formData)
    .then((data) =>{
      this._clearForm();
      this._addRow(data);
    }).catch((errorData) =>{
      this._mapErrorsToForm(errorData.responseJSON.errors);
    });
  }

  _saveActeur(data) {
    const url = Routing.generate('acteur_partie_newJS');
    return $.ajax({
        url,
        method: 'POST',
        data: JSON.stringify(data),
      }).then((data, textStatus, jqXHR) =>{
          return $.ajax({
            url: jqXHR.getResponseHeader('Location')
          });
      });
  }

  _mapErrorsToForm(errorData){
    // reset things
    const $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
    this._removeFormErrors();

    for(let element of $form.find(':input')){
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
    }
  }

  _removeFormErrors(){
    const $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
    $form.find('.js-field-error').remove();
    $form.find('.form-group').removeClass('has-error');
  }

  _clearForm(){
    this._removeFormErrors();
    const $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
    $form[0].reset();
  }

  _addRow(acteur){

    const html = rowTemplate(acteur);
    this.$wrapper.find('tbody')
      .append($.parseHTML(html));
  }

}

const rowTemplate = (acteur) => `
      <tr>
          <td>${ acteur.nom }</td>
          <td>${ acteur.nombreIndividus }</td>
          <td>
          </td>
          <td>
          </td>
          <td></td>
          <td>
            <a href="#"
              class="js-delete-acteur"
              data-url="${ acteur.links._self }"
            >
              <span class="fa fa-trash"></span>
            </a>
          </td>
      </tr>`;

export default ActeurApp;
