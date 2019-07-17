
//moment
window.moment = require('moment');

// JQuery
window.$ = window.jQuery = require("jquery");

// Vue JS
window.Vue = require("vue");
Vue.component("selectize", require("./components/Selectize.vue"));

// iziToast
window.iziToast = require("izitoast");

// Axios
window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}

// selectize
require("selectize");

// dhtmlxgantt
require("dhtmlx-gantt");
require("dhtmlx-gantt/codebase/ext/dhtmlxgantt_marker.js");

//bootstrap-multiselect
require("bootstrap-multiselect/dist/js/bootstrap-multiselect.js");

// Bootstrap
require("admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js");

// Datatables
require("admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js");
require("admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js");

// I Check
require("admin-lte/plugins/iCheck/icheck.min.js");

// FastClick
require("admin-lte/bower_components/fastclick/lib/fastclick.js");

// SlimScroll
require("admin-lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js");

// AdminLTE
require("admin-lte/dist/js/adminlte.min.js");

// SparkLine
require("admin-lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js");

// JVector Map
require("admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js");
require("admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js");

// Input Mask
require("admin-lte/plugins/input-mask/jquery.inputmask.js");
require("admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js");
require("admin-lte/plugins/input-mask/jquery.inputmask.extensions.js");

// Chart JS
require("chart.js");

// Select2
// require("admin-lte/bower_components/select2/dist/js/select2.full.min.js");

// Date Picker
// require("admin-lte/bower_components/moment");
require("admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js");
require("admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js");
require("admin-lte/plugins/timepicker/bootstrap-timepicker.min.js");

// Color Picker
require("admin-lte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js");

require("./layout");

//tree-view
require("jstree/dist/jstree.min.js");

//fullcalendar
require("fullcalendar/dist/fullcalendar.min.js");

//date range picker
require("daterangepicker");

// magnific-popup
require("magnific-popup");

