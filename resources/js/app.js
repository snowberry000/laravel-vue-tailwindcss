/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

//import "vuetify/dist/vuetify.min.css"; // Ensure you are using css-loader
//import "material-design-icons-iconfont/dist/material-design-icons.css";

//import Vue from "vue";
//import store from "./contributors/store/index.js";
//import router from "./contributors/Router";

import vuetify from "./plugins/Vuetify.js";

//import Vuetify from "vuetify/lib";

//Vue.use(Vuetify);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import App from "./components/Layout.vue";

const app = new Vue({
    vuetify,
    el: "#app",
    render: h => h(App)
});
