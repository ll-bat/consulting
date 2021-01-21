require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form();


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('fbody-component', require('./components/FbodyComponent.vue').default);

import {Form} from "./classes/Form";
import FbodyComponent from "./components/FbodyComponent";


const app = new Vue({
    el: '#app',
    components: {
        FbodyComponent
    },
    data: {
        ploss: [],
        udanger: [],
        psaving: false,
        usaving: false,
        created: true,
        udangerLoading: true,
        plossLoading: true,
        form: null,
    },
    methods: {
        addNewPloss() {
            let data = {k: '3', name: ''}

            this.form.createPloss((id) => {
                data.id = id
            })
            tout(() => {
                this.ploss.push(data)
            }, 200)
        },

        addNewUdanger() {
            let data = {name: ''}

            this.form.createUdanger((id) => {
                data.id = id
            })
            tout(() => {
                this.udanger.push(data)
            }, 200)
        },

        deletePloss(id, type) {
            if (type == 1)
                this.ploss = this.ploss.filter(p => p.id != id)
            else
                this.udanger = this.udanger.filter(p => p.id != id)
        }
    },
    async mounted() {
        for (let a of [{url: 'getPloss', loader: 'plossLoading', data: 'ploss'}, {
            url: 'getUdanger',
            loader: 'udangerLoading',
            data: 'udanger'
        }]) {
            let res = await this.form[a.url]()
            if (res) {
                this[a.data] = res;
            }
            tout(() => {
                this[a.loader] = false
            }, 400)
        }

        tout(() => {
            $('#psaving-panel').removeClass('d-none');
            $('#usaving-panel').removeClass('d-none');
        }, 420)
    },

    created() {
        this.form = new Form();
    }

});
