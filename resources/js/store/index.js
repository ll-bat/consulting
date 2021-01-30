import Vue from 'vue';
import Vuex from 'vuex';
import preQuestions from './modules/preQuestions';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        showDocAbout: false
    },
    getters: {},
    actions: {},
    mutations: {},
    modules: {
        preQuestions
    }
})
