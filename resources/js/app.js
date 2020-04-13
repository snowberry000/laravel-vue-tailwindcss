import Vue from "vue";
import VueMeta from "vue-meta";
import PortalVue from "portal-vue";
import { InertiaApp } from "@inertiajs/inertia-vue";
import VTooltip from "v-tooltip";
window.moment = require("moment");
Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route, moment: window.moment } });
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueMeta);
Vue.use(VTooltip);

import Axios from "axios";
Vue.prototype.$http = Axios;

// const token = localStorage.getItem("token");
// if (token) {
//     Vue.prototype.$http.defaults.headers.common["Authorization"] =
//         "Bearer " + token;
// }
Vue.prototype.$http.defaults.headers.common["X-Requested-With"] =
    "XMLHttpRequest";
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    Vue.prototype.$http.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}

let app = document.getElementById("app");

new Vue({
    metaInfo: {
        titleTemplate: title => (title ? `${title} - YAYIMAGES` : "YAYIMAGES")
    },
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name =>
                    import(`@/Pages/${name}`).then(module => module.default)
            }
        })
}).$mount(app);
