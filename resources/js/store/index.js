import Vue from 'vue'
import Vuex from 'vuex'
import questions from './modules/questions';

Vue.use(Vuex)

const debug = true;

export default new Vuex.Store({
    namespaced: true,
    modules: {
        questions
    },
    strict: debug
})
