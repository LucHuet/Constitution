'use strict';

import $ from 'jquery';
import ActeurApp from './Components/ActeurApp';

$(document).ready(function() {
  var $wrapper = $('.js-acteur-table');
  var acteurApp = new ActeurApp($wrapper, $wrapper.data('acteurs'));
});
