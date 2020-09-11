
require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form1();


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('fbody-component', require('./components/FbodyComponent.vue').default);

import  {Form1} from "./classes/Form1";
import FbodyComponent from "./components/FbodyComponent";
import Axios from "axios";


const app = new Vue({
    el: '#app',
    components : {
       FbodyComponent
    },
    data:{
       ploss: [], 
       udanger: [],
       psaving: false,
       usaving: false,
       created: true
    },
    methods:{
       addNewPloss(){
             let data = {k:'3', name:''}

             Form.createPloss((id) => {
                data.id = id
             })
             tout(() => {
                this.ploss.push(data)
             }, 200)
       },

       addNewUdanger(){
           let data = {name: ''}

           Form.createUdanger((id) => {
              data.id = id
            })
           tout(() => {
              this.udanger.push(data)
           }, 200)
       },

       deletePloss(id,type){
            if (type == 1)
              this.ploss =  this.ploss.filter(p => p.id != id)
            else 
              this.udanger =  this.udanger.filter(p => p.id != id)
       }
    },
    created() {
        Form.getPloss(this)
        Form.getUdanger(this)
    },


});
