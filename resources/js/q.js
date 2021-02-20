import httpService from "./services/httpService";

require('./bootstrap');


window.Vue = require('vue');
window.Event = new Vue();
window.Form = new Form()

import {Form} from "./classes/Form";
// import {Data} from "./classes/Data";
// import {chboxId, checkedId, checkControl, toggleControl, toggleInput, checkPloss, togglePloss, checkUdanger, toggleUdanger, chainedAnim, removeLoader, setControlAnswers, combine } from "./helpers/fns";
// import fetcher from "./classes/Fetcher";

import Questions from "./components/Questions";
import store from './store'

const app = new Vue({
    el: '#app',
    components: {
        Questions
    },
    store,
    data: {
        // loading: true,
        // newDoc: true,
        // processes: [],
        // dangers: [],
        // controls: [],
        // ploss: [],
        // udanger: [],
        // info: [],
        // processId: -1,
        // dangerId: -1,
        // elm: null,
        // data: [],
        // controlAnswers: [],
        // fm: new FormData(),
        // dangerSelect: [],
        // currentDangers: [],
        // currentControls: [],
        // showDangers: false,
        // showControls: false,
        // showDangerLoader: false,
        // showControlsLoader: false,
        // helpers: {},
        // exportId: null,
        // focuses: false
    },
    methods: {
        // async chooseProcess(id) {
        //     return await this.filterDangers(id);
        // },
        //
        // async chooseDanger(id) {
        //     return await this.filterControls(id);
        // },
        //
        // filterDangers(selectedValue) {
        //     return new Promise(async res => {
        //         this.showDangerLoader = true;
        //         this.showDangers = false;
        //         this.showControls = false;
        //
        //         this.currentDangers = [];
        //         this.dangerId = -1;
        //         // Event.$emit('setDefaultValue')
        //
        //         let id = selectedValue;
        //         const process = this.processes.find(p => p.id === id);
        //         if (!process) {
        //             alert('სამწუხაროდ, ამ დოკუმენტში შემავალი ზოგიერთი პროცესი წაშლილია...');
        //             this.showDangerLoader = false;
        //             this.showDangers = false;
        //             res();
        //             return;
        //         }
        //
        //         this.processId = id
        //         this.currentDangers = await fetcher.getDangers(process.id);
        //
        //         this.showDangerLoader = false;
        //         this.showDangers = true;
        //         res();
        //     })
        // },
        //
        // async filterControls(selectedValue) {
        //     return new Promise(async res => {
        //         this.showControlsLoader = true;
        //         this.showControls = false;
        //         this.currentControls = [];
        //
        //         let id = selectedValue
        //         let danger = this.currentDangers.find(d => d.id === id)
        //         if (!danger) {
        //             this.showControls = false;
        //             alert('სამწუხაროდ, ამ დოკუმენტში შემავალი ზოგიერთი საფრთხე წაშლილია...');
        //             this.showControlsLoader = false;
        //             this.showControls = false;
        //             res();
        //             return;
        //         }
        //
        //         this.dangerId = id
        //         this.currentControls = await fetcher.getControls(id);
        //
        //         this.elm = this.info.find(e => e.pid === this.processId && e.did === this.dangerId)
        //         if (!this.elm) {
        //             this.data = new Data()
        //             this.elm = {pid: this.processId, did: this.dangerId, data: this.data}
        //             this.info.push(this.elm)
        //         } else {
        //             this.data = this.elm.data
        //         }
        //
        //         this.showControlsLoader = false;
        //         this.showControls = true;
        //         chainedAnim('sizeable-control', this.currentControls.length, 0);
        //         res();
        //     })
        // },
        //
        // vueImageLoad(ev) {
        //     imageLoad(ev, null, (val) => {
        //         this.data.image = val
        //         this.data.hasImage = true
        //
        //         this.fm.append(`image_${this.processId}_${this.dangerId}`, ev.target.files[0])
        //         this.data.imageName = `image_${this.processId}_${this.dangerId}`
        //     })
        // },
        //
        // clearUpload() {
        //     $1('danger-image-id').src = '';
        //     $1('danger-image-input').value = '';
        //     this.data.image = ''
        //     this.data.hasImage = false
        //     this.fm.delete(this.data.imageName)
        //     this.data.imageName = ''
        //     this.data.oldImage = false;
        // },
        //
        // addInArray(type) {
        //     this.data[type].push({value: ''})
        // },
        //
        // removeFromArray(type, i) {
        //     this.data[type] = this.data[type].filter((d, ix) => ix != i)
        // },
        //
        // async submit() {
        //     this.info = this.info.filter(d => {
        //         let ys = false
        //
        //         d.data.image = ''
        //         d.data.control.forEach(c => {
        //             if (c.value != -1) {
        //                 ys = true
        //                 return
        //             }
        //         })
        //         if (!ys) {
        //             this.fm.delete(d.data.imageName)
        //         }
        //
        //         return ys
        //     });
        //
        //     if (this.info.length === 0) {
        //         alert('Please, fill up the form')
        //         window.location = ''
        //         return
        //     }
        //
        //     this.testify();
        //
        //     this.fm.append('data', JSON.stringify(this.info));
        //
        //     $('#data-processing').removeClass('d-none')
        //     $('#data-submit').addClass('disabled')
        //
        //     let res = await httpService.post('docs/submit', this.fm).catch(err => {
        //         alert("დაფიქსირდა შეცდომა. გთხოვთ, სცადოთ თავიდან.");
        //         $('#data-processing').addClass('d-none')
        //         $('#data-submit').removeClass('disabled')
        //     });
        //
        //     if (res) {
        //         window.location = res;
        //     }
        // },
        //
        // testify() {
        //
        // },
        //
        // async init() {
        //     let data = await httpService.get('api/all-data');
        //     for (let a in data) {
        //         this[a] = data[a];
        //     }
        //
        //     this.setHelpers();
        //     this.helpers.combine();
        //     this.helpers.setControlAnswers();
        //
        //     if (!this.newDoc) {
        //         const {pid, did} = this.info[0];
        //         await this.filterDangers(pid);
        //         await this.filterControls(did);
        //         tout(async () => {
        //             Event.$emit('selectProcess', pid);
        //             Event.$emit('selectDanger', did);
        //         }, 250)
        //     }
        //
        //     this.helpers.removeLoader();
        // },
        //
        // setHelpers() {
        //   this.helpers = {
        //       chboxId,
        //       checkedId,
        //       checkControl: (...params) => {
        //           return checkControl.call(this, ...params)
        //       },
        //       toggleControl: (...params) => {
        //           return toggleControl.call(this, ...params);
        //       },
        //       toggleInput: (...params) => {
        //           return toggleInput.call(this, ...params);
        //       },
        //       checkPloss: (...params) => {
        //           return checkPloss.call(this, ...params);
        //       },
        //       togglePloss: (...params) => {
        //           return togglePloss.call(this, ...params);
        //       },
        //       checkUdanger: (...params) => {
        //           return checkUdanger.call(this, ...params);
        //       },
        //       toggleUdanger: (...params) => {
        //           return toggleUdanger.call(this, ...params);
        //       },
        //       chainedAnim: (...params) => {
        //           return chainedAnim.call(this, ...params);
        //       },
        //       removeLoader: (...params) => {
        //           return removeLoader.call(this, ...params);
        //       },
        //       setControlAnswers: (...params) => {
        //           return setControlAnswers.call(this, ...params);
        //       },
        //       combine: (...params) => {
        //           return combine.call(this, ...params);
        //       }
        //   }
        // },
        //
        // copyObj() {
        //     this.info = JSON.parse(JSON.stringify(this.$doc));
        //     this.newDoc = false;
        //     // console.log(this.info);
        // }
    },

    created() {
        // tout(() => {
        //     $('#questions-content').removeClass('d-none');
        // });
        //
        // if ($doc) {
        //     this.$doc = JSON.parse($doc);
        //     console.log(this.$doc);
        //     this.copyObj();
        // } else {
        //     this.$doc = false;
        // }
        //
        // this.form = new Form();
        // this.init();
    },
});
