
require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form1();

Vue.component('select-component', require('./components/SelectComponent').default);
import SelectComponent from "./components/SelectComponent";
import  {Form1} from "./classes/Form1";
import  {Data} from "./classes/Data";
import Axios from "axios";

const app = new Vue({
    el: '#app',
    components : {
       SelectComponent
    },
    data:{
       loading: true,
       process: [],
       danger:  [],
       control: [],
       odan   : [],
       ocon   : [],
       ploss  : [],
       udanger: [],
       canShow:false,
       canShowOcon:false,
       info   : [],
       processId : -1,
       dangerId  : -1,
       elm       : null,
       data      : [],
       controlAnswers : [],
       fm        : new FormData(),
       var       : 0,
       dangerSelect: [],
    },
    methods:{

        chboxId(d, i, n){
            return `chboxId${d}_${n}_${i}`
        },

        checkedId(d,i, n){
            return `checkedId${d}_${n}_${i}`
        },
        choose(selectedValue){
            this.ocon = []
            this.canShowOcon = false

            let id = selectedValue
            let el = this.process.find(p => p.id == id)

            // console.log($1('danger-id'))
            Event.$emit('setDefaultValue')
            if (!el) return

            this.processId = id

            this.odan = this.danger.filter(d => {
                return el.data.includes(d.id)
            }).map(d => {
                return {name: d.name, value: d.id}
            })

            this.dangerSelect = JSON.parse(JSON.stringify(this.odan));

            if (!this.canShow) this.canShow = true
        },

        chooseOcon(selectedValue){
            this.clearAll()

            let id = selectedValue
            let el = this.danger.find(d => d.id === id)
            if (!el) {
                this.ocon = []
                this.canShowOcon = false;
                return;
            }
            this.dangerId = id

            this.elm = this.info.find(e => e.pid === this.processId && e.did === this.dangerId)
            if (!this.elm){
                 this.data = new Data()
                 this.elm = {pid: this.processId, did: this.dangerId, data: this.data}
                 this.info.push(this.elm)
            }
            else  this.data = this.elm.data

            // console.log(this.data)

            this.ocon = []
            tout(() => {
                this.ocon = this.control.filter(c => {
                    return el.data.includes(c.id)
                })
            },100)

            if (!this.canShowOcon) this.canShowOcon = true

            this.chainedAnim('sizeable-control', this.ocon.length, 0)
        },

        clearAll(){
            let s = $$('control-to-be-checked')
            for(let i=0; i<s.length; i++)
              s[i].checked = false

        },

        uploadImage(){
            let ev = event
            imageLoad(event,'docimage0', (val) => {
                this.data.image = val
                this.data.hasImage = true

                this.fm.append(`image_${this.processId}_${this.dangerId}`, ev.target.files[0])
                this.data.imageName = `image_${this.processId}_${this.dangerId}`
            })
        },

        clearUpload(){
            clearUploadedImage(0)
            this.data.image = ''
            this.data.hasImage = false
            this.fm.delete(this.data.imageName)
            this.data.imageName = ''
        },

        addInArray(type){
            this.data[type].push({value: ''})
        },

        removeFromArray(type,i){
            this.data[type] = this.data[type].filter((d,ix) => ix != i)
        },


        checkControl(id,i){
            let el = this.data.control.find(e => e.id == id)

            if (!el) {
                this.data.control.push({id: id, value: -1})
                return false
            }
            else return el.value == i
        },

        toggleControl(id, i, cls){
            let el = this.data.control.find(e => e.id == id)
            // el.values[i] = (el.values[i] + 1) % 2
            el.value = i

            this.toggleInput(id,i, 'control', cls)
        },

        toggleInput(id, i, type, cls){
            let sym = `${id}_${type}_${i}`

            if (!cls) cls = 'checked'

            if (!$(`#chboxId${sym}`).hasClass('hovered-checkmark')){
                $(`#chboxId${sym}`).addClass('hovered-checkmark')
                $(`#checkedId${sym}`).addClass(cls)
            }
            else {
                if (cls == 'checked-circle') return
                $(`#chboxId${sym}`).removeClass('hovered-checkmark')
                $(`#checkedId${sym}`).removeClass(cls)
            }
        },

        checkPloss(i,id){
            let el = this.data.ploss.find(e => e.ind == i)

            if (!el){
                el = {ind: i, value: 0, id: id}
                this.data.ploss.push(el)
            }

            return el.value == 1
        },

        togglePloss(i, p){
            let el = this.data.ploss[i]

            tout(()=>{
               el.value = (el.value + 1) % 2
            },20)

            this.toggleInput(el.id, 0, 'ploss')
        },

        checkUdanger(i,id){
            let el = this.data.udanger.find(e => e.ind == i)

            if (!el){
                el = {ind: i, value: 0, id: id}
                this.data.udanger.push(el)
            }

            return el.value & 1
        },

        toggleUdanger(i, p){
            let el = this.data.udanger[i]

            tout(()=>{
               el.value = (el.value + 1) % 2
            },20)

            this.toggleInput(el.id, 0, 'udanger')
        },


        chainedAnim(cname, len, c){
            if (c >= len) return

            let tme=200
            for (let i=0; i<len; i++){
                let newt = tme + 500
                tout(()=> {
                    $(`.${cname}`).addClass('animated-border-left anim-half-width anim-margin')
                },tme)
                tme = newt
            }
        },

        combine(){
            this.combined = []
            this.combined.push({
                class: '',
                style: 'border-radius:0;border-bottom:5px solid lightgrey',
                text: 'აირჩიეთ პოტენციური ზიანი',
                data: this.ploss,
                update: this.togglePloss,
                check: this.checkPloss,
                type: 'ploss'
            })
            this.combined.push({
                class: 'pb-0',
                style: 'border-radius:0;padding-bottom:0 !important',
                text: 'ვინ იმყოფება საფრთხის ქვეშ',
                data: this.udanger,
                update: this.toggleUdanger,
                check: this.checkUdanger,
                type: 'udanger'
            })
        },

        submit(){
            this.info = this.info.filter(d => {
                let ys = false
                d.data.image = ''
                // d.data.teststr = "echo {$ind}"
                // d.did += 240
                d.data.control.forEach(c => {
                    if (c.value != -1){
                        ys = true
                        return
                    }
                })
                if (!ys) {this.fm.delete(d.data.imageName)}

                return ys
            })

            if (this.info.length == 0) {
                alert('Please, fill up the form')
                window.location = ''
                return
            }

            // console.log(this.info)
            $('#data-processing').removeClass('d-none')
            $('#data-submit').addClass('disabled')
            Form.submit('docs/submit', this.info, this.fm)
        },

        setProcess(){
            tout(() => {
                $1('sel1').value = 'ყველა პროცესი'
            }, 50)
        },

        getAllDanger(){
            return this.odan.map(d => {
                return {name: d.name, value: d.id}
            })
        },

        async init() {
            let data = await Form.getData('docs/all-data')
            this.process = data[0];
            this.danger = data[1];
            this.control = data[2];

            data = await Form.getOtherData('docs/other-data');
            this.ploss = data[0];
            this.udanger = data[1];

            this.removeLoader();
            this.setControlAnswers();
        },

        removeLoader() {
            this.loading = false;
            $('#show_data').removeClass('d-none');
            tout(() => $('#edit-process').css({'border-top':'10px solid #673ab7'}), 500)
        },

        setControlAnswers() {
            this.controlAnswers.push({text: 'არსებული', label: 'მონიშნეთ თუ სახეზეა, იცავთ, იყენებთ, მიღებულია ეს ზომა'});
            this.controlAnswers.push({text: 'დამატებითი', label: 'მონიშნეთ თუ სახეზე არ არის, არ გაქვთ მიღებულია ეს ზომა და შემდგომში მიიღებთ ამ ზომას (შეძლებისდაგვარად აუცილებელია)'})
            this.controlAnswers.push({text: 'არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება', label: ''});
        }
    },

    computed : {
        allProcess: function(){
            return this.process.map(p => {
                return {name: p.name, value: p.id}
            })
        },
    },

    watch : {
         ploss: function(newdata,olddata){
              this.combine()
         },
    },

    created() {
       this.init();
    },
});
