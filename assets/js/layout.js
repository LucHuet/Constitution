'use strict';

import $ from 'jquery';
import 'font-awesome/css/font-awesome.css';
import '../css/main.scss';
import 'whatwg-fetch';
import 'promise-polyfill/src/polyfill';

//import 'core-js/library/es6/promise';

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
