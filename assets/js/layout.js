'use strict';

const $ = require('jquery');
require('bootstrap-sass');

require('../css/main.scss');

require('babel-polyfill');

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
