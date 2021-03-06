window._ = require("lodash");
window.Popper = require('popper.js').default;

import VModal from "vue-js-modal";
import Vuelidate from 'vuelidate'
import VueSelect from "vue-select";
import VueInternalization from "vue-i18n";

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

 try {
 	window.$ = window.jQuery = require("jquery");
 	require('bootstrap');

 } catch (e) {}
// require('select2');
/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

 window.Vue = require("vue");
 require('vue2-animate/dist/vue2-animate.min.css')
 import VueFeather from "vue-feather";
 Vue.component(VueFeather.name, VueFeather);
 Vue.use(VueInternalization);
 Vue.use(Vuelidate);

// Vue.config.lang = 'en';

// Object.keys(Locales).forEach(function (lang) {
//     Vue.locale(lang, Locales[lang])
// });

Vue.use(VModal);
Vue.component("v-select", VueSelect);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

 window.axios = require("axios");

 window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

 let token = document.head.querySelector('meta[name="csrf-token"]');

 if (token) {
 	window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
 	window.axios.defaults.headers.common["Authorization"] = 'Bearer ' + token;
 } else {
 	console.error(
 		"CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
 		);
 }
 window.events = new Vue();

 window.flash = function(message, level = "success") {
 	window.events.$emit("flash", { message, level });
 };

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
