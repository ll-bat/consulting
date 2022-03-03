
require('./bootstrap');

window.Vue = require('vue')
window.Event = new Vue();

import store from './store'

import PreQuestions from './components/PreQuestions';

import Vue from "vue";

const app = new Vue({
    el: '#app',
    components: {
        PreQuestions
    },
    store
});
