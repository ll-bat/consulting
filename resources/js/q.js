import httpService from "./services/httpService";

require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form()

Vue.component('select-component', require('./components/SelectComponent').default);
import SelectComponent from "./components/SelectComponent";
import {Form} from "./classes/Form";
import {Data} from "./classes/Data";
import {chboxId, checkedId, checkControl, toggleControl, toggleInput, checkPloss, togglePloss, checkUdanger, toggleUdanger, chainedAnim, removeLoader, setControlAnswers, combine } from "./helpers/fns";
import fetcher from "./classes/Fetcher";

const app = new Vue({
    el: '#app',
    components: {
        SelectComponent
    },
    data: {
        loading: true,
        newDoc: true,
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
        helpers: {},
        exportId: null
    },
    methods: {
        filterDangers(selectedValue) {
            return new Promise(async res => {
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
                res();
            })
        },

        async filterControls(selectedValue) {
            return new Promise(async res => {
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
                chainedAnim('sizeable-control', this.currentControls.length, 0);
                res();
            })
        },

        vueImageLoad(ev) {
            imageLoad(ev, null, (val) => {
                this.data.image = val
                this.data.hasImage = true

                this.fm.append(`image_${this.processId}_${this.dangerId}`, ev.target.files[0])
                this.data.imageName = `image_${this.processId}_${this.dangerId}`
            })
        },

        clearUpload() {
            $1('danger-image-id').src = '';
            $1('danger-image-input').value = '';
            this.data.image = ''
            this.data.hasImage = false
            this.fm.delete(this.data.imageName)
            this.data.imageName = ''
            this.data.oldImage = false;
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

            // console.log(this.info);
            // return;

            if (this.info.length === 0) {
                alert('Please, fill up the form')
                window.location = ''
                return
            }

            this.testify();

            $('#data-processing').removeClass('d-none')
            $('#data-submit').addClass('disabled')
            this.form.submit('docs/submit', this.info, this.fm)
        },

        testify() {

        },

        async init() {
            let data = await httpService.get('api/all-data');
            for (let a in data) {
                this[a] = data[a];
            }

            this.setHelpers();
            this.helpers.combine();
            this.helpers.setControlAnswers();

            if (!this.newDoc) {
                const {pid, did} = this.info[0];
                await this.filterDangers(pid);
                await this.filterControls(did);
                tout(async () => {
                    Event.$emit('selectProcess', pid);
                    Event.$emit('selectDanger', did);
                }, 250)
            }

            this.helpers.removeLoader();
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
              },
              removeLoader: (...params) => {
                  return removeLoader.call(this, ...params);
              },
              setControlAnswers: (...params) => {
                  return setControlAnswers.call(this, ...params);
              },
              combine: (...params) => {
                  return combine.call(this, ...params);
              }
          }
        },

        copyObj() {
            this.info = JSON.parse(JSON.stringify(this.$doc));
            this.exportId = $exportId;
            this.newDoc = false;
            console.log(this.info);
        }
    },

    computed: {
        allProcess: function () {
            return this.processes.map(p => {
                return {name: p.name, value: p.id}
            })
        },
    },

    created() {
        tout(() => {
            $('#questions-content').removeClass('d-none');
        });

        if ($doc) {
            this.$doc = JSON.parse($doc);
            this.copyObj();
        } else {
            this.$doc = false;
        }

        this.form = new Form();
        this.init();
    },
});
