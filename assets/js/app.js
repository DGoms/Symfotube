require('../css/app.scss');

// loads the jquery package from node_modules
var $ = require('jquery');

require('bootstrap-sass');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var greet = require('./function');