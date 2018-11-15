const $ = require('jquery');
const ActeurApp = require('./Components/ActeurApp');

$(document).ready(function() {
  var $wrapper = $('.js-acteur-table');

  var acteurApp = new ActeurApp($wrapper);
});
