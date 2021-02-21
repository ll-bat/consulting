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
        ...mapState(['showControls', 'info', 'fm', 'processes', 'loading', 'completedDangers', 'processId', 'dangerId', 'isUpdate', 'sendData'])
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
        ...mapActions(['updateStore', 'completeDanger', 'updateCompletedDanger']),
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

        validateCurrentDanger() {
            return true;
        },

        async submit() {

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

            data = data.map(d => {
                d.data.image = ''

                if (this.fm.has(d.data.imageName)) {
                    if (d.data.control.length) {
                        formData.append(d.data.imageName, this.fm.get(d.data.imageName));
                    }
                }

                return d;
            });

            if (!data.length) {
                alert('გთხოვთ, შეავსოთ მონაცემები')
                end();
                return;
            }

            this.testify();

            formData.append('data', JSON.stringify(data));

            const res = await httpService.post('docs/submit', formData).catch(err => {
                alert("დაფიქსირდა შეცდომა. გთხოვთ, სცადოთ თავიდან.");
                console.log(err);
            });

            if (res) {
                // console.log(data);
                window.location = res;
            }

            end();
        },

        testify() {

        },

        prepareOldDoc() {
            const data = JSON.parse(this.data);
            this.updateStore(state => {
                state.newDoc = false;
                state.info = data;
            });

            tout(() => {
                console.log("You are updating old document");
                console.log(data);
            })
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
