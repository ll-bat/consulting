import httpService from "./services/httpService";

require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form1();

Vue.component('select-component', require('./components/SelectComponent').default);
import SelectComponent from "./components/SelectComponent";
import {Form1} from "./classes/Form1";
import {Data} from "./classes/Data";
import {chboxId, checkedId, checkControl, toggleControl, toggleInput, checkPloss, togglePloss, checkUdanger, toggleUdanger, chainedAnim } from "./helpers/fns";
import fetcher from "./classes/Fetcher";

const app = new Vue({
    el: '#app',
    components: {
        SelectComponent
    },
    data: {
        loading: true,
        processes: [],
        dangers: [],
        controls: [],
        ploss: [],
        udanger: [],
        info: [],
        processId: -1,
        dangerId: -1,
        elm: null,
        data: [],
        controlAnswers: [],
        fm: new FormData(),
        dangerSelect: [],
        currentDangers: [],
        currentControls: [],
        showDangers: false,
        showControls: false,
        helpers: {}
    },
    methods: {
        async filterDangers(selectedValue) {
            this.currentDangers = [];
            Event.$emit('setDefaultValue')

            let id = selectedValue;
            const process = this.processes.find(p => p.id === id);
            if (!process) return

            const dangerIds = await fetcher.getDangers(process.id);

            this.processId = id
            this.currentDangers = this.dangers.filter(d => dangerIds.includes(d.id))
                .map(d => {
                    return { name: d.name, value: d.id }
                });

            this.dangerSelect = JSON.parse(JSON.stringify(this.currentDangers));

            this.showDangers = true;
            this.showControls = false;
        },

        async filterControls(selectedValue) {
            this.currentControls = [];

            let id = selectedValue
            let danger = this.currentDangers.find(d => d.value === id)
            if (!danger) {
                this.showControls = false;
                return;
            }

            this.dangerId = id
            const controlIds = await fetcher.getControls(id);
            this.currentControls = this.controls.filter(c => controlIds.includes(c.id));

            this.elm = this.info.find(e => e.pid === this.processId && e.did === this.dangerId)
            if (!this.elm) {
                this.data = new Data()
                this.elm = {pid: this.processId, did: this.dangerId, data: this.data}
                this.info.push(this.elm)
            } else {
                this.data = this.elm.data
            }

            this.showControls = true;
            chainedAnim('sizeable-control', this.currentControls.length, 0)
        },

        uploadImage() {
            let ev = event
            imageLoad(event, 'docimage0', (val) => {
                this.data.image = val
                this.data.hasImage = true

                this.fm.append(`image_${this.processId}_${this.dangerId}`, ev.target.files[0])
                this.data.imageName = `image_${this.processId}_${this.dangerId}`
            })
        },

        clearUpload() {
            clearUploadedImage(0)
            this.data.image = ''
            this.data.hasImage = false
            this.fm.delete(this.data.imageName)
            this.data.imageName = ''
        },

        addInArray(type) {
            this.data[type].push({value: ''})
        },

        removeFromArray(type, i) {
            this.data[type] = this.data[type].filter((d, ix) => ix != i)
        },

        submit() {
            this.info = this.info.filter(d => {
                let ys = false

                d.data.image = ''
                d.data.control.forEach(c => {
                    if (c.value != -1) {
                        ys = true
                        return
                    }
                })
                if (!ys) {
                    this.fm.delete(d.data.imageName)
                }

                return ys
            })

            if (this.info.length === 0) {
                alert('Please, fill up the form')
                window.location = ''
                return
            }

            $('#data-processing').removeClass('d-none')
            $('#data-submit').addClass('disabled')
            Form.submit('docs/submit', this.info, this.fm)
        },

        async init() {
            let data = await httpService.get('api/all-data');
            for (let a in data) {
                this[a] = data[a];
            }

            this.removeLoader();
            this.setControlAnswers();
            this.setHelpers();
        },

        setHelpers() {
          this.helpers = {
              chboxId,
              checkedId,
              checkControl: (...params) => {
                  return checkControl.call(this, ...params)
              },
              toggleControl: (...params) => {
                  return toggleControl.call(this, ...params);
              },
              toggleInput: (...params) => {
                  return toggleInput.call(this, ...params);
              },
              checkPloss: (...params) => {
                  return checkPloss.call(this, ...params);
              },
              togglePloss: (...params) => {
                  return togglePloss.call(this, ...params);
              },
              checkUdanger: (...params) => {
                  return checkUdanger.call(this, ...params);
              },
              toggleUdanger: (...params) => {
                  return toggleUdanger.call(this, ...params);
              },
              chainedAnim: (...params) => {
                  return chainedAnim.call(this, ...params);
              }
          }
        },

        removeLoader() {
            this.loading = false;
            $('#show_data').removeClass('d-none');
            tout(() => $('#edit-process').css({'border-top': '10px solid #673ab7'}), 500)
        },

        setControlAnswers() {
            this.controlAnswers.push({
                text: 'არსებული',
                label: 'მონიშნეთ თუ სახეზეა, იცავთ, იყენებთ, მიღებულია ეს ზომა'
            });
            this.controlAnswers.push({
                text: 'დამატებითი',
                label: 'მონიშნეთ თუ სახეზე არ არის, არ გაქვთ მიღებულია ეს ზომა და შემდგომში მიიღებთ ამ ზომას (შეძლებისდაგვარად აუცილებელია)'
            })
            this.controlAnswers.push({text: 'არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება', label: ''});
        },

        combine() {
            this.combined = []
            this.combined.push({
                class: '',
                style: 'border-radius:0;border-bottom:5px solid lightgrey',
                text: 'აირჩიეთ პოტენციური ზიანი',
                data: this.ploss,
                update: this.helpers.togglePloss,
                check: this.helpers.checkPloss,
                type: 'ploss'
            })
            this.combined.push({
                class: 'pb-0',
                style: 'border-radius:0;padding-bottom:0 !important',
                text: 'ვინ იმყოფება საფრთხის ქვეშ',
                data: this.udanger,
                update: this.helpers.toggleUdanger,
                check: this.helpers.checkUdanger,
                type: 'udanger'
            })
        },
    },

    computed: {
        allProcess: function () {
            return this.processes.map(p => {
                return {name: p.name, value: p.id}
            })
        },
    },

    watch: {
        ploss: function (newdata, olddata) {
            this.combine()
        },
    },

    created() {
        this.init();
    },
});
