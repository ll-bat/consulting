
require('./bootstrap');

window.Vue = require('vue')
import i18n from "./i18n";

window.Event = new Vue();

import store from './store'

import PreQuestions from './components/PreQuestions';

const app = new Vue({
    el: '#app',
    i18n,
    components: {
        PreQuestions
    },
    store
});
