require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form();

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
        fieldId: null,
    },
    methods: {
        addNewPloss() {
            const data = {k: '3', name: ''}

            this.form.createPloss((id) => {
                data.id = id;
            });

            tout(() => {
                this.ploss.push(data)
            }, 200);
        },

        addNewUdanger() {
            const data = {name: ''};

            this.form.createUdanger((id) => {
                data.id = id;
            });

            tout(() => {
                this.udanger.push(data);
            }, 200);
        },

        deletePloss(id, type) {
            if (type == 1) {
                this.ploss = this.ploss.filter(p => p.id !== id)
            }
            else {
                this.udanger = this.udanger.filter(p => p.id !== id)
            }
        },

        async initData() {
            const data = await this.form.getApiData();
            this.ploss = data.ploss;
            this.udanger = data.udanger;

            this.plossLoading = false;
            this.udangerLoading = false;
        },
        findFieldId() {
            const fieldId = $1('field_id').value
            this.fieldId = fieldId;
        }
    },
    mounted() {
        // noinspection JSIgnoredPromiseFromCall
        this.initData();

        tout(() => {
            $('#psaving-panel').removeClass('d-none');
            $('#usaving-panel').removeClass('d-none');
        }, 420)
    },

    created() {
        this.findFieldId()
        this.form = new Form(this.fieldId);
        this.form.setupRedirect();
    }

});
