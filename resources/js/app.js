require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from "vue";
window.Vue = Vue;

import route from './ziggy';
import { Ziggy } from './ziggy';
import { BootstrapVue } from "bootstrap-vue";
import vClickOutside from "v-click-outside";
import VueMask from "v-mask";
import VueSweetalert2 from "vue-sweetalert2";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/pt';
import Multiselect from "vue-multiselect";
import VueCurrencyFilter from 'vue-currency-filter';

import vueFilePond from 'vue-filepond';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';

import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';

import CKEditor from '@ckeditor/ckeditor5-vue';
import Layouts from "./mixins/layouts.mixin";
import i18n from "./i18n";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageCrop
);

Vue.prototype.$isDev = process.env.MIX_APP_ENV !== "production";
Vue.config.devtools = Vue.prototype.$isDev;
Vue.config.debug = Vue.prototype.$isDev;
Vue.config.silent = !Vue.prototype.$isDev;

Vue.mixin({ methods: { route: window.route } });
// Vue.mixin({
//     methods: {
//         route: (name, params, absolute) => ziggy(name, params, absolute, Ziggy)
//     }
// });

Vue.use(plugin)
Vue.use(BootstrapVue);
Vue.use(vClickOutside);
Vue.use(DatePicker);
Vue.component('multiselect', Multiselect);
Vue.use(CKEditor);
Vue.use(VueMask);
// Vue.use(Vuelidate);
Vue.use(VueSweetalert2);
Vue.use(VueCurrencyFilter,
{
    symbol : 'AOA',
    thousandsSeparator: '.',
    fractionCount: 2,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
})

const el = document.getElementById('app')

new Vue({
  mixins: [
      Layouts,
      // {
      //   route: (name, params, absolute) => ziggy(name, params, absolute, Ziggy)
      // },
    ],
  i18n,  
  render: h => h(App, {
    // mixins: [
    //     Layouts,
    //     {
    //         route: (name, params, absolute) => ziggy(name, params, absolute, Ziggy)
    //     }
    // ],  
    props: {
      initialPage: JSON.parse(el.dataset.page),
    //   resolveComponent: name => require(`./Pages/${name}`).default,
    resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(el)
