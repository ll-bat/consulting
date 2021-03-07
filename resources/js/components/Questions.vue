<template>
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mt-md-0 mt-sm-5 mt-5" style="min-width: 900px">
            <processes></processes>

            <div class="d-none" id="questions-content">
                <dangers></dangers>
                <div v-if="showControls">
                    <danger-image></danger-image>
                    <ploss-udanger></ploss-udanger>
                    <controls></controls>
                    <add-controls></add-controls>
                    <user-input :params="rpersons"></user-input>
                    <user-input :params="etimes"></user-input>

                    <button class='btn btn-primary rounded bg-primary hovered-ns-button border-0 text-sm' id='data-submit'
                            style="padding: 6px 16px"
                            @click='submit()'>
                        <span class="spinner-border spinner-border-sm text-sm pr-1 d-none" id='data-processing'
                            style="margin-left: -.5rem !important;">
                        </span>
                        დასრულება
                    </button>

                    <button v-if="!isUpdate" class='btn btn-primary rounded border-0 text-sm'
                            @click='next()'>
                        შემდეგი
                    </button>
                    <button v-else class="btn btn-danger rounded border-0 text-sm"
                            @click="updateDanger()">
                        განახლება
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";
const {mapState, mapActions} = createNamespacedHelpers('questions');

import Processes from "./Processes";
import Dangers from "./Dangers";
import DangerImage from "./DangerImage";
import Controls from "./Controls";
import PlossUdanger from "./PlossUdanger";
import AddControls from './AddControls';
import UserInput from "./UserInput";
import httpService from "../services/httpService";

export default {
    name: "Questions",
    props: {
        data: {
            type: String,
        }
    },

    components: {
        Processes, Dangers, DangerImage, Controls, PlossUdanger, AddControls, UserInput
    },
    computed: {
        ...mapState(['showControls', 'info', 'fm', 'processes', 'loading', 'completedDangers', 'processId', 'dangerId', 'isUpdate', 'sendData']),
    },
    data() {
        return {
            rpersons : {},
            etimes : {},
        }
    },
    watch: {
        'loading' : (s) => {
            $('#loaders').remove();
        }
    },

    methods: {
        ...mapActions(['updateStore', 'completeDanger', 'updateCompletedDanger', 'initOldDoc']),
        next() {
            const flag = this.validateCurrentDanger();
            if (flag) {
                this.completeDanger();
            }
        },

        updateDanger() {
            const flag = this.validateCurrentDanger();
            if (flag) {
                this.updateCompletedDanger();
            }
        },

        getDangerData() {
            return this.$store.state.questions.data;
        },

        validateCurrentDanger() {
            /**
             * At least one control should be checked or added.
             * At least one ploss/udanger should be checked or added
             * At least one rperson/etime should be added.
             */

            const data = this.getDangerData();

            function validateString(p) {
                return p.value.length > 0;
            }

            /**
             * Validate controls
             */
            let ok = !!data.control.find(c => c.value < 2)
            if (!ok) {
                ok = !!data.newControls.first.find(validateString);
            }
            if (!ok) {
                ok = !!data.newControls.second.find(validateString);
            }

            if (!ok) {
                alert('აუცილებელია მონიშნოთ ან დაამატოთ, მინიმუმ 1 არსებითი ან დამატებითი კონტროლის ზომა.')
                return false;
            }

            /**
             * Validate ploss
             */
            ok = !!data.ploss.find(p => p.value === 1);
            if (!ok) {
                ok = !!data.newPloss.find(validateString);
            }
            if (!ok) {
                alert('აუცილებელია მონიშნოთ ან დაამატოთ, მინიმუმ 1 პოტენციური ზიანი.')
                return false;
            }

            /**
             * Validate udanger
             */
            ok = !!data.udanger.find(p => p.value === 1);
            if (!ok) {
                ok = !!data.newUdangers.find(validateString);
            }
            if (!ok) {
                alert('აუცილებელია მონიშნოთ ან დაამატოთ, მინიმუმ 1 "ვინ იმყოფება საფრთხის ქვეშ".')
                return false;
            }

            /**
             * Validate rpersons
             */
            ok = !!data.rpersons.find(validateString);
            if (!ok) {
                alert('გთხოვთ დაამატოთ პასუხისმგებელი პირი.')
                return false;
            }

            /**
             * Validate etimes
             */
            ok = !!data.etimes.normal.find(validateString)
            if (!ok) {
                ok = !!data.etimes.time.find(validateString);
            }
            if (!ok) {
                alert('გთხოვთ, მიუთითოთ შესრულების ვადა.');
                return false;
            }

            return true;
        },

        wantsToCompletePage() {
            const data = this.getDangerData();

            let ok = !!data.control.find(c => c.value < 2)
            if (!ok) {
                ok = !!data.newControls.first.find(p => p.value.length > 1);
            }
            if (!ok) {
                ok = !!data.newControls.second.find(p => p.value.length > 1);
            }

            if (!ok) {
                return false;
            }

            return true;
        },

        async submit() {

            let lastPage = null;

            if (this.wantsToCompletePage()) {
                if (!this.validateCurrentDanger()) {
                    return false;
                } else {
                    if (!this.isUpdate) {
                        lastPage = {pid: this.processId, did: this.dangerId, data: this.getDangerData()};
                    } else {
                        this.updateStore((state) => {
                            const elm = state.sendData.find(el => el.pid === this.processId && el.did === this.dangerId);
                            elm.data = state.data;
                        })
                    }
                }
            }

            const start = () => {
                $('#data-submit').addClass('disabled');
                $('#data-processing').removeClass('d-none');
            }

            const end = () => {
                $('#data-submit').removeClass('disabled');
                $('#data-processing').addClass('d-none');
            }


            start();


            const formData = new FormData();
            let data = JSON.parse(JSON.stringify(this.sendData));

            if (lastPage) {
                data.push(lastPage);
            }

            data = data.map(d => {
                d.data.image = ''

                if (this.fm.has(d.data.imageName)) {
                    formData.append(d.data.imageName, this.fm.get(d.data.imageName));
                }

                return d;
            });

            if (!data.length) {
                alert('გთხოვთ, შეავსოთ მონაცემები')
                end();
                return;
            }

            formData.append('data', JSON.stringify(data));

            const res = await httpService.post('docs/submit', formData).catch(err => {
                alert("დაფიქსირდა შეცდომა. გთხოვთ, სცადოთ თავიდან.");
                console.log(err);
            });

            if (res) {
                window.location = res;
            }

            end();
        },

        prepareOldDoc() {
            const data = JSON.parse(this.data);
            this.initOldDoc(data);
        },

        init() {
            this.rpersons = {
                title: 'პასუხისმგებელი პირი',
                smTitle: '1. გთხოვთ დაამატოთ პასუხისმგებელი პირი',
                data: [],
                ref: 'rpersons'
            };

            this.etimes = {
                title: 'შესრულების ვადა',
                smTitle: [
                    '1. გთხოვთ, აირჩიოთ თარიღი',
                    '2. ან შეიყვანოთ დღეების რაოდენობა სიტყვიერად, მაგალითად: რეგულარულად, ყოველკვირეულად ან სხვა'
                ],
                data: {},
                ref: 'etimes',
                type: 'time',
                types: [{
                    ref: 'time',
                    inputType: 'date'
                }, {
                    ref: 'normal',
                    inputType: 'text'
                }],
            }

            if (this.data) {
                this.prepareOldDoc();
            }
        }
    },

    created() {
        this.init();
    },

    mounted() {
        $('#questions-content').removeClass('d-none');
        console.log(this.$store.state.questions.data);
    }
}
</script>

<style scoped>
.spinner-loader {
    width: 7rem;
    height: 7rem;
    border-width: 1rem;
}
</style>
