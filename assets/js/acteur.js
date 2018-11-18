import $ from 'jquery';
import 'bootstrap-sass';
import ActeurApp from './Components/ActeurApp';

global.$ = $;

$(document).ready(function() {
  var $wrapper = $('.js-acteur-table');
  var acteurApp = new ActeurApp($wrapper, $wrapper.data('acteurs'));
});
