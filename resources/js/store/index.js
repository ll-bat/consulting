import Vue from 'vue'
import Vuex from 'vuex'
import preQuestions from './modules/preQuestions';

Vue.use(Vuex)

const debug = true;

export default new Vuex.Store({
    namespaced: true,
    modules: {
        preQuestions
    },
    strict: debug
})
