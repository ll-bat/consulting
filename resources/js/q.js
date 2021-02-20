import httpService from "./services/httpService";

require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form()

import {Form} from "./classes/Form";

import Questions from "./components/Questions";
import store from './store'

const app = new Vue({
    el: '#app',
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
