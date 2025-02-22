const mix = require('laravel-mix');
const path = require('path');
const lodash = require("lodash");
const folder = {
    src: "resources/", // source files
    dist: "/", // build files
    dist_assets: "assets/" //build assets files
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

var third_party_assets = {
    css_js: [
        {"name": "jquery", "assets": ["./node_modules/jquery/dist/jquery.min.js"]},
        {"name": "bootstrap", "assets": ["./node_modules/bootstrap/dist/js/bootstrap.bundle.js"]},
        {"name": "metismenu", "assets": ["./node_modules/metismenu/dist/metisMenu.js"]},
        {"name": "simplebar", "assets": ["./node_modules/simplebar/dist/simplebar.js"]},
        {"name": "node-waves", "assets": ["./node_modules/node-waves/dist/waves.js"]},
        {"name": "select2", "assets": ["./node_modules/select2/dist/js/select2.min.js", "./node_modules/select2/dist/css/select2.min.css"]},
        {"name": "chart-js", "assets": ["./node_modules/chart.js/dist/Chart.bundle.min.js"]},
        {"name": "apexcharts", "assets": ["./node_modules/apexcharts/dist/apexcharts.min.js"]},
        {
            "name": "datatables", "assets": ["./node_modules/datatables.net/js/jquery.dataTables.min.js",
                "./node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js",
                "./node_modules/datatables.net-responsive/js/dataTables.responsive.min.js",
                "./node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js",
                "./node_modules/datatables.net-buttons/js/dataTables.buttons.min.js",
                "./node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.html5.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.flash.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.print.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.colVis.min.js",
                "./node_modules/datatables.net-keytable/js/dataTables.keyTable.min.js",
                "./node_modules/datatables.net-select/js/dataTables.select.min.js",
                "./node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css",
                "./node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css",
                "./node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css",
                "./node_modules/datatables.net-select-bs4/css/select.bootstrap4.css"]
        },
        {"name": "pdfmake", "assets": ["./node_modules/pdfmake/build/pdfmake.min.js", "./node_modules/pdfmake/build/vfs_fonts.js"]},
        {"name": "jszip", "assets": ["./node_modules/jszip/dist/jszip.min.js"]},
        {"name": "curiosityx", "assets": ["./node_modules/@curiosityx/bootstrap-session-timeout/index.js"]},
        {"name": "bootstrap-datepicker", "assets": ["./node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js","./node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"]},
        {"name": "datepicker", "assets": ["./node_modules/@chenfengyuan/datepicker/dist/datepicker.min.js","./node_modules/@chenfengyuan/datepicker/dist/datepicker.min.css"]},
        {"name": "bootstrap-timepicker", "assets": ["./node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css","./node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"]},
        {"name": "tui-calendar", "assets": ["./node_modules/tui-calendar/dist/tui-calendar.min.js", "./node_modules/tui-calendar/dist/tui-calendar.min.css"]},
        {"name": "tui-chart", "assets": ["./node_modules/tui-chart/dist/tui-chart-all.min.js", "./node_modules/tui-chart/dist/maps/usa.js", "./node_modules/tui-chart/dist/tui-chart.min.css"]},
        {"name": "tui-code-snippet", "assets": ["./node_modules/tui-code-snippet/dist/tui-code-snippet.min.js"]},
        {"name": "tui-date-picker", "assets": ["./node_modules/tui-date-picker/dist/tui-date-picker.min.js", "./node_modules/tui-date-picker/dist/tui-date-picker.min.css"]},
        {"name": "tui-dom", "assets": ["./node_modules/tui-dom/dist/tui-dom.min.js"]},
        {"name": "tui-time-picker", "assets": ["./node_modules/tui-time-picker/dist/tui-time-picker.min.js", "./node_modules/tui-time-picker/dist/tui-time-picker.min.css"]},
        {"name": "chance", "assets": ["./node_modules/chance/dist/chance.min.js"]},
        {"name": "gmaps", "assets": ["./node_modules/gmaps/gmaps.min.js"]},
        {"name": "leaflet", "assets": ["./node_modules/leaflet/dist/leaflet.js", "./node_modules/leaflet/dist/leaflet.css"]},
        {"name": "bootstrap-filestyle2", "assets": ["./node_modules/bootstrap-filestyle2/src/bootstrap-filestyle.min.js"]},
        {"name": "bs-custom-file-input", "assets": ["./node_modules/bs-custom-file-input/dist/bs-custom-file-input.min.js"]},
        {"name": "cropperjs", "assets": ["./node_modules/cropperjs/dist/cropper.min.js", "./node_modules/cropperjs/dist/cropper.min.css"]},
        {"name": "echarts", "assets": ["./node_modules/echarts/dist/echarts.min.js"]},
        {"name": "owl.carousel", "assets": ["./node_modules/owl.carousel/dist/owl.carousel.min.js", "./node_modules/owl.carousel/dist/assets/owl.carousel.min.css","./node_modules/owl.carousel/dist/assets/owl.theme.default.min.css"]},
        {"name": "toastr", "assets": ["./node_modules/toastr/build/toastr.min.js", "./node_modules/toastr/build/toastr.min.css"]},
        {"name": "twitter-bootstrap-wizard", "assets": ["./node_modules/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js","./node_modules/twitter-bootstrap-wizard/prettify.js","./node_modules/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.css"]},
        {"name": "rwd-table", "assets": ["./node_modules/admin-resources/rwd-table/rwd-table.min.js", "./node_modules/admin-resources/rwd-table/rwd-table.min.css"]},
        {"name": "bootstrap-editable", "assets": ["./node_modules/bootstrap-editable/js/index.js", "./node_modules/bootstrap-editable/css/bootstrap-editable.css"]},
        {
            "name": "jquery-vectormap", "assets": ["./node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-au-mill-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-il-chicago-mill-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-in-mill-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-uk-mill-en.js",
                "./node_modules/admin-resources/jquery.vectormap/maps/jquery-jvectormap-ca-lcc-en.js",
                "./node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"]
        },
        { "name": "ion-rangeslider", "assets": ["./node_modules/ion-rangeslider/js/ion.rangeSlider.min.js", "./node_modules/ion-rangeslider/css/ion.rangeSlider.min.css"] },
        {"name": "sweetalert2", "assets": ["./node_modules/sweetalert2/dist/sweetalert2.min.js", "./node_modules/sweetalert2/dist/sweetalert2.min.css"]},
        {"name": "jquery-sparkline", "assets": ["./node_modules/jquery-sparkline/jquery.sparkline.min.js"]},
        {"name": "jquery-knob", "assets": ["./node_modules/jquery-knob/dist/jquery.knob.min.js"]},
        {"name": "moment", "assets": ["./node_modules/moment/min/moment.min.js"]},
        {
            "name": "flot-charts", "assets": ["./node_modules/flot-charts/jquery.flot.js",
                "./node_modules/flot-charts/jquery.flot.time.js",
                "./node_modules/flot-charts/jquery.flot.resize.js",
                "./node_modules/flot-charts/jquery.flot.pie.js",
                "./node_modules/flot-charts/jquery.flot.selection.js",
                "./node_modules/flot-charts/jquery.flot.stack.js",
                "./node_modules/flot-charts/jquery.flot.crosshair.js",
                "./node_modules/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js",
                "./node_modules/flot-orderbars/js/jquery.flot.orderBars.js"]
        },
        {"name": "magnific-popup", "assets": ["./node_modules/magnific-popup/dist/jquery.magnific-popup.min.js", "./node_modules/magnific-popup/dist/magnific-popup.css"]},
        {"name": "parsleyjs", "assets": ["./node_modules/parsleyjs/dist/parsley.min.js"]},
        {"name": "bootstrap-touchspin", "assets": ["./node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js", "./node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css"] },
        {"name": "bootstrap-maxlength", "assets": ["./node_modules/bootstrap-maxlength/bootstrap-maxlength.min.js"]},
        {"name": "bootstrap-colorpicker", "assets": ["./node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js", "./node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css"]},
        {"name": "bootstrap-rating", "assets": ["./node_modules/bootstrap-rating/bootstrap-rating.min.js", "./node_modules/bootstrap-rating/bootstrap-rating.css"]},
        {"name": "summernote", "assets": ["./node_modules/summernote/dist/summernote-bs4.min.js", "./node_modules/summernote/dist/summernote-bs4.css"]},
        {"name": "dropzone", "assets": ["./node_modules/dropzone/dist/min/dropzone.min.js", "./node_modules/dropzone/dist/min/dropzone.min.css"]},
        {"name": "dragula", "assets": ["./node_modules/dragula/dist/dragula.min.js", "./node_modules/dragula/dist/dragula.min.css"]},
        {"name": "jquery-countdown", "assets": ["./node_modules/jquery-countdown/dist/jquery.countdown.min.js"]},
        {"name": "jquery.easing", "assets": ["./node_modules/jquery.easing/jquery.easing.min.js"]},
        {"name": "jquery-repeater", "assets": ["./node_modules/jquery.repeater/jquery.repeater.min.js"]},
        {"name": "inputmask", "assets": ["./node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js"]}
    ]
};

//copying third party assets
lodash(third_party_assets).forEach(function (assets, type) {
    if (type == "css_js") {
        lodash(assets).forEach(function (plugin) {
            var name = plugin['name'],
                assetlist = plugin['assets'],
                css = [],
                js = [];
            lodash(assetlist).forEach(function (asset) {
                var ass = asset.split(',');
                for (let i = 0; i < ass.length; ++i) {
                    if(ass[i].substr(ass[i].length - 3)  == ".js") {
                        js.push(ass[i]);
                    } else {
                        css.push(ass[i]);
                    }
                };
            });
            if(js.length > 0){
                mix.combine(js, folder.dist_assets + "/libs/" + name + "/" + name + ".min.js");
            }
            if(css.length > 0){
                mix.combine(css, folder.dist_assets + "/libs/" + name + "/" + name + ".min.css");
            }
        });
    }
});

mix.copyDirectory("./node_modules/tinymce", folder.dist_assets + "/libs/tinymce");
    mix.copyDirectory("./node_modules/leaflet/dist/images", folder.dist_assets + "/libs/leaflet/images");
    mix.copyDirectory("./node_modules/bootstrap-editable/img", folder.dist_assets + "/libs/img");
    mix.copyDirectory("./node_modules/summernote/dist/font", folder.dist_assets + "/libs/summernote/font");

    // copy all fonts
    var out = folder.dist_assets + "fonts";
    mix.copyDirectory(folder.src + "fonts", out);

    // copy all images 
    var out = folder.dist_assets + "images";
    mix.copyDirectory(folder.src + "images", out);

    // mix.sass('resources/scss/bootstrap.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/bootstrap.css");
    // mix.sass('resources/scss/bootstrap-dark.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/bootstrap-dark.css");
    // mix.sass('resources/scss/icons.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/icons.css");
    // mix.sass('resources/scss/app-rtl.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/app-rtl.css");
    // mix.sass('resources/scss/app.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/app.css");
    // mix.sass('resources/scss/app-dark.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/app-dark.css");

    mix.combine('resources/js/front-end/app.js', folder.dist_assets + "js/front-end/app.min.js");
    mix.combine('resources/js/front-end/custom.js', folder.dist_assets + "js/front-end/custom.min.js");

    mix.setPublicPath('/');
mix.js('resources/js/app.js', 'js').vue({
        extractStyles: true,
        globalStyles: false
    })
    // .postCss('resources/sass/app.scss', 'public/css', [
    //     //
    // ])
    .sass('resources/sass/app.scss', 'css')
    .sass('resources/sass/app-dark.scss', 'css')
    .sass('resources/sass/app-rtl.scss', 'css')
    .options({
        processCssUrls: false
    })
    .webpackConfig({
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.runtime.esm.js',
                '@': path.resolve('resources/js'),
                'ziggy': path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
            },
        },
    })
    .babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import'],
    })
    .version()
    .sourceMaps();
// mix.js('resources/js/canvas-ui/app.js', 'public/js/canvas-ui.js').sass(
//     'resources/sass/canvas-ui.scss',
//     'public/css/canvas-ui.css'
// );
