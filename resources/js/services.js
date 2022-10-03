require('./bootstrap');


window.Vue = require('vue');
import i18n from "./i18n";

window.Event = new Vue();


Vue.component('services', require('./components/ServicesComponent.vue').default);
Vue.component('service', require('./components/ServiceComponent.vue').default);

import ServicesComponent from "./components/ServicesComponent";
import ServiceComponent from "./components/ServiceComponent";
import Axios from "axios";

const app = new Vue({
    el: '#app',
    i18n,
    components: {
        ServicesComponent,
        ServiceComponent
    },
    data: {},
    methods: {},
    created() {
    },
});
