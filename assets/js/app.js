require('../css/app.scss');

// loads the jquery package from node_modules
var $ = require('jquery');
import 'bootstrap';

const routes = require('../../web/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

// //
// require('bootstrap-sass');
//
// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
// });

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var theFunction = require('./function');