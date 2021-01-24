
require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();

import PreQuestions from './components/PreQuestions';

const app = new Vue({
    el: '#app',
    components: {
        PreQuestions
    },
    data: {}
});
