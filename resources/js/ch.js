
require('./bootstrap');


window.Vue = require('vue');
import i18n from "./i18n";

window.Event = new Vue();
window.Form = new Form();


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



import  {Form} from "./classes/Form";
import Axios from "axios";



const app = new Vue({
    el: '#app',
    i18n,
    components : {
        SelectComponent
    },
    data:{
       process: [],
       danger:  [],
       control: [],
       odan   : [],
       ocon   : [],
       message: 'success'
    },
    methods:{
       choose(id){
           this.ocon = []
           this.odan = this.danger.filter(d => false)

           let el = this.process.find(p => p.id == id)

           this.odan = this.danger.filter(d => {
               return el.data.includes(d.id)
           })

           $('.to-be-checked').prop('checked', false)
       },

       chooseOcon(id){
           let el = this.danger.find(d => d.id == id)

           this.ocon = this.control.filter(c => {
               return el.data.includes(c.id)
           })

        //    console.log(this.ocon)
       },

       linkToDanger: function(id){
            return `./danger/${id}/edit`
       },

       linkToControl: function(id){
            return `./control/${id}/edit`
       }
    },

    computed : {

    },

    created() {
        Form.getData('all-data', this)
    },



});
