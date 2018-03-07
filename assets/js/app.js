require('../css/app.scss');

// import 'bootstrap';
import 'bootstrap-material-design';
// var Popper = require('popper.js');

const routes = require('../../web/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);


// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var theFunction = require('./function');

$(document).ready(function() { $('body').bootstrapMaterialDesign(); });