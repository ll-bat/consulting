import httpService from "./services/httpService";

require('./bootstrap');


window.Vue = require('vue');
import i18n from "./i18n";

window.Event = new Vue();
window.Form = new Form()

import {Form} from "./classes/Form";

import Questions from "./components/Questions";
import store from './store'

const app = new Vue({
    el: '#app',
    i18n,
    components: {
        Questions
    },
    store,
    data: {
    },
    methods: {
    },
    created() {
    },
});
