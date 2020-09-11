
require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Forms = new Form();


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('panel-component', require('./components/PanelComponent.vue').default);
Vue.component('delete-component', require('./components/DeleteComponent.vue').default);
Vue.component('head-component', require('./components/HeadComponent.vue').default);
Vue.component('body-component', require('./components/BodyComponent.vue').default);
Vue.component('select-component', require('./components/SelectComponent.vue').default);
Vue.component('ipanel-component', require('./components/IPanelComponent.vue').default);
Vue.component('input-component', require('./components/InputComponent.vue').default);


import  {Header} from "./classes/Header";
import  {Form} from "./classes/Forms";
import  {Select} from "./classes/Select";
import  {Input} from "./classes/Input";
import ExampleComponent from "./components/ExampleComponent";
import HeaderComponent from "./components/HeaderComponent";
import PanelComponent from "./components/PanelComponent";
import DeleteComponent from "./components/DeleteComponent";
import HeadComponent from "./components/HeadComponent";
import BodyComponent from "./components/BodyComponent";
import SelectComponent from "./components/SelectComponent";
import IPanelComponent from "./components/IPanelComponent";
import InputComponent from "./components/InputComponent";
import Axios from "axios";


const app = new Vue({
    el: '#app',
    components : {
        ExampleComponent,
        HeaderComponent,
        PanelComponent,
        DeleteComponent,
        HeadComponent,
        BodyComponent,
        SelectComponent,
        IPanelComponent,
        InputComponent
    },
    data:{
       components: [],
       inds: [],
       ns: 0,
       loading: true,
       creating: false,
       updating: false,
    },
    methods:{
        setns(id){
            this.ns = id
        },
        chooseType(type){
             if (type == 'header')
                return new Header()
             else if(Input.getChildren().includes(type))
                return Forms.fset(new Input(), {type: type})
             else if(Select.getChildren().includes(type))
                return Forms.fset(new Select(),{type: type})

        },
        createComponent(type){
             if (this.creating) return
             this.creating = true
             let qt = type == 'header' ? type : 'select'
             let comp =  this.chooseType(type)

             Forms.fset(comp, {index: this.components.length+1, newindex: this.components.length+1})
             Forms.submit('post', `docs/create-${qt}`, {'type': 'radio'})
                  .then((res) => {  comp.dsetData(res); })
                  .catch((err) => { this.components.pop() })

             tout(()=>{
                this.components.push(comp)
             },200)

             tout(()=>{
                 this.creating = false
             },400)

        },
        deleteComponent(id, ind){

            Forms.submit("delete", `docs/delete-component/${id}`, {})
                 .then((res) => { })
                 .catch((err) => { })
               
            tout(function(){
                 app.components = app.components.filter((comp) =>{
                     if (comp.index > ind) comp.index = comp.newindex = comp.index-1
                     return comp.id !== id
                  })
            }, 200)

        },
        processData(data){
            data.map((rel, index) =>{
                  let type=rel['type'];
                  let comp = this.chooseType(type)
                  comp.setData(rel)
                  Forms.fset(comp, {index: index+1, newindex: index+1})
                  this.inds.push(index+1)
                  this.components.push(comp)
            })

        },
        changeType(ind, type, comp){
            if (type.from == type.to) return

            let id = this.components[ind].id
            let fullChange = 1

            comp.saving = true

            if (this.components[ind].children.includes(type.to))
            {
                fullChange = 0
            }

            Forms.submit('patch', `docs/change-quest/${id}`, {type: type.to, change: fullChange})
                 .then((res) =>{ comp.saving = false })
                 .catch((err) => { comp.saving=false; })


            if (fullChange == 0){
              this.components[ind].type = type.to
            }
            else {
                let newObj = Forms.changeObject(this.components[ind], this.chooseType(type.to))

                this.components = this.components.map((comp,index) => {
                    if (index == ind)
                       return newObj
                    return comp
                })
            }

        },
        toggleRequire(id, comp){
            comp.saving = true
            Forms.submit("patch", `docs/change-quest/${id}`, {required: true})
                 .then((res)=>{comp.saving=false})
                 .catch((err)=>{ comp.saving=false; })
        },

        clickImage(ind){
            let id = 'editimage' + ind
            $1(id).click()
        },
        editImage(event, comp){
             let fm = new FormData();
             fm.append('image', event.target.files[0]);

             comp.object.hasImage = false
             let loading = [true]
             comp.imageLoading = loading
             Forms.submit('post', `docs/${comp.object.id}/upload`, fm, loading)
                .then((res) => {
                    Forms.fset(comp.object, {hasImage:true, image: res})
                 })
                .catch((err) => { })
       },

        removeImage(comp){
            Forms.submit("delete", `docs/upload/${comp.object.id}/remove`, {})
                 .then((res) => {  Forms.deleteUpload(comp.object)})
                 .catch((err) => { })
        },

        changeShadow(index){
            this.setns(index)
        },

        activeCheckIcon(index){
            $('.edit-index')[index].className = 'd-inline-block created pointer edit-index'
        },

        clickCheckIcon(comp, index){
            $('.edit-index')[index].className = 'd-none created pointer edit-index'
            let newind = parseInt(comp.newindex)
            let ind    = comp.index

            
            if (newind < 1 || isNaN(newind)) {
                comp.newindex = comp.index
                return
            }

            if (newind > this.components.length) {
                newind = this.components.length
            }
           

            this.sortItems(newind, ind, comp)
        },

        sortItems(newind, ind, comp){
            this.components = this.components.filter(comp => comp.index != ind)
            this.components.insert(newind-1, Forms.fset(comp, {index: newind, newindex: newind}))

            if (newind != ind){
                let k = -1,t=-1
                if (newind < ind){
                    k = 1
                    t = 0
                }


                for (let i=min(newind,ind); i<max(newind,ind); i++){
                     this.components[i + t].index+=k
                     this.components[i + t].newindex+=k
                }  
            }
        },

        update(){
            if (this.updating) return

            this.updating = true
            Forms.update(this)
        }
    },
    created(){
        Event.$on('new-element', (type)=>{
            this.createComponent(type)
        })

        this.$on("delete", (id,ind) =>{
            this.deleteComponent(id,ind)
        })

         let b = dom.body
         cl(b,'ns-loading', this, true)

         axios.get('docs/all').
                then((res) => {
                       this.processData(res.data)
                       cl(b,'', this, false)
                    })
                .catch((err) => {
                    console.log(err.response.data)
                    cl(b,'', this, false)
                })

    }
});
