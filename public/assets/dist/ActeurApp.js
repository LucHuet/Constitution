'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function (window, $, Routing, swal) {
  var ActeurApp = function () {
    function ActeurApp($wrapper) {
      _classCallCheck(this, ActeurApp);

      this.$wrapper = $wrapper;
      this.$wrapper.on('click', '.js-delete-acteur', this.handleActeurDelete.bind(this));

      this.loadActeurs();

      this.$wrapper.on('click', 'tbody tr', this.handleRowClick.bind(this));

      this.$wrapper.on('submit', ActeurApp._selectors.newActeurForm, this.handleNewFormSubmit.bind(this));
    }

    _createClass(ActeurApp, [{
      key: 'loadActeurs',
      value: function loadActeurs() {
        var _this = this;

        $.ajax({
          url: Routing.generate('acteur_partie_list')
        }).then(function (data) {
          var _iteratorNormalCompletion = true;
          var _didIteratorError = false;
          var _iteratorError = undefined;

          try {
            for (var _iterator = data.items[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
              var acteur = _step.value;

              _this._addRow(acteur);
            }
          } catch (err) {
            _didIteratorError = true;
            _iteratorError = err;
          } finally {
            try {
              if (!_iteratorNormalCompletion && _iterator.return) {
                _iterator.return();
              }
            } finally {
              if (_didIteratorError) {
                throw _iteratorError;
              }
            }
          }
        });
      }
    }, {
      key: 'handleActeurDelete',
      value: function handleActeurDelete(e) {
        var _this2 = this;

        e.preventDefault();

        var $link = $(e.currentTarget);
        swal({
          title: 'Supprimer cet Acteur ?',
          html: 'Supprimer ?',
          showCancelButton: true
        }).then(function () {
          _this2._deleteActeur($link);
        }).catch(function (arg) {
          console.log('cancel');
        });
      }
    }, {
      key: '_deleteActeur',
      value: function _deleteActeur($link) {
        $link.addClass('text-danger');
        $link.find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');

        var deleteUrl = $link.data('url');
        var $row = $link.closest('tr');
        $.ajax({
          url: deleteUrl,
          method: 'DELETE'
        }).then(function (data) {
          $row.fadeOut('normal', function () {
            $row.remove();
          });
        }).catch(function (jqXHR) {
          console.log('delete fail');
        });
      }
    }, {
      key: 'handleRowClick',
      value: function handleRowClick() {
        console.log('row click');
      }
    }, {
      key: 'handleNewFormSubmit',
      value: function handleNewFormSubmit(e) {
        var _this3 = this;

        e.preventDefault();
        var $form = $(e.currentTarget);
        var formData = {};
        var _iteratorNormalCompletion2 = true;
        var _didIteratorError2 = false;
        var _iteratorError2 = undefined;

        try {
          for (var _iterator2 = $form.serializeArray()[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
            var fieldData = _step2.value;

            formData[fieldData.name] = fieldData.value;
          }
        } catch (err) {
          _didIteratorError2 = true;
          _iteratorError2 = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion2 && _iterator2.return) {
              _iterator2.return();
            }
          } finally {
            if (_didIteratorError2) {
              throw _iteratorError2;
            }
          }
        }

        this._saveActeur(formData).then(function (data) {
          _this3._clearForm();
          _this3._addRow(data);
        }).catch(function (errorData) {
          _this3._mapErrorsToForm(errorData.responseJSON.errors);
        });
      }
    }, {
      key: '_saveActeur',
      value: function _saveActeur(data) {
        var url = Routing.generate('acteur_partie_newJS');
        return $.ajax({
          url: url,
          method: 'POST',
          data: JSON.stringify(data)
        }).then(function (data, textStatus, jqXHR) {
          return $.ajax({
            url: jqXHR.getResponseHeader('Location')
          });
        });
      }
    }, {
      key: '_mapErrorsToForm',
      value: function _mapErrorsToForm(errorData) {
        // reset things
        var $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
        this._removeFormErrors();

        var _iteratorNormalCompletion3 = true;
        var _didIteratorError3 = false;
        var _iteratorError3 = undefined;

        try {
          for (var _iterator3 = $form.find(':input')[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
            var element = _step3.value;

            var fieldName = $(element).attr('name');
            var $wrapper = $(element).closest('.form-group');
            if (!errorData[fieldName]) {
              //no error
              return;
            }

            var $error = $('<span class="js-field-error help-block"></span>');
            $error.html(errorData[fieldName]);
            $wrapper.append($error);
            $wrapper.addClass('has-error');
          }
        } catch (err) {
          _didIteratorError3 = true;
          _iteratorError3 = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion3 && _iterator3.return) {
              _iterator3.return();
            }
          } finally {
            if (_didIteratorError3) {
              throw _iteratorError3;
            }
          }
        }
      }
    }, {
      key: '_removeFormErrors',
      value: function _removeFormErrors() {
        var $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
        $form.find('.js-field-error').remove();
        $form.find('.form-group').removeClass('has-error');
      }
    }, {
      key: '_clearForm',
      value: function _clearForm() {
        this._removeFormErrors();
        var $form = this.$wrapper.find(ActeurApp._selectors.newActeurForm);
        $form[0].reset();
      }
    }, {
      key: '_addRow',
      value: function _addRow(acteur) {

        var html = rowTemplate(acteur);
        this.$wrapper.find('tbody').append($.parseHTML(html));
      }
    }], [{
      key: '_selectors',
      get: function get() {
        return {
          newActeurForm: '.js-new-acteur-form'
        };
      }
    }]);

    return ActeurApp;
  }();

  var rowTemplate = function rowTemplate(acteur) {
    return '\n        <tr>\n            <td>' + acteur.nom + '</td>\n            <td>' + acteur.nombreIndividus + '</td>\n            <td>\n            </td>\n            <td>\n            </td>\n            <td></td>\n            <td>\n              <a href="#"\n                class="js-delete-acteur"\n                data-url="' + acteur.links._self + '"\n              >\n                <span class="fa fa-trash"></span>\n              </a>\n            </td>\n        </tr>';
  };

  window.ActeurApp = ActeurApp;
})(window, jQuery, Routing, swal);
