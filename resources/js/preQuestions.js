
require('./bootstrap');

import PreQuestions from './components/PreQuestions';

import Vue from "vue";

const app = new Vue({
    el: '#app',
    components: {
        PreQuestions
    }
});
