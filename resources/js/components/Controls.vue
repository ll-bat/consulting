<template>
    <div class='bg-white test-shadow rounded-8'>
        <table class='table'>
            <thead>
            <th class='text-center align-middle bg-light' style='font-size: 1.2rem;
                      width:50%;
                      border-top-left-radius: 8px;
                      color: #9999ff;
                      border-right:1px solid #d3d3d3;'>{{ $i18n.t("კონტროლის ზომები") }}
            </th>
            <th class="text-center align-middle" v-for="answer in controlAnswers"
                v-html="answer.text"
                style='font-size: .7rem !important;'>
            </th>
            </thead>
            <tbody>
            <tr v-for='(o,i) in currentControls'>
                <td class='text-center mt-3'
                    style='font-size:.7rem;
                           height:80px;
                           border-right:1px solid lightgrey;
                           background-color: rgba(0,0,0,.0176);'>
                    {{ o.name }}
                </td>

                <td v-for="(v,ind) in controlAnswers" style='width: 19%;' :title='v.label'>
                    <label class="ns-container"
                           v-if="!(ind === 0 && o.is_first_option_off)"
                           @mousedown="update(o.id, ind);">
                        <div class="ns-test" style="left: calc(50% - 25px);">
                            <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin rounded-circle"
                                 :class="{'hovered-checkmark-diff controls-border-color' : controlsMapper[o.id] === ind}">
                                 <span class='text-center' :class="{'checked-circle-diff controls-bg-color': controlsMapper[o.id] === ind}"></span>
                            </div>
                        </div>

                    </label>

                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";

const {mapState, mapActions} = createNamespacedHelpers('questions');

export default {
    name: "Controls",
    computed: {
        ...mapState(['showControls', 'currentControls', 'data'])
    },
    methods: {
        ...mapActions(['updateStore']),

        update(id, i) {
            let fn = (store) => {
                const el = store.data.control.find(e => e.id === id)
                if (!el) {
                    store.data.control.push({id: id, value: i})
                } else {
                    el.value = i
                }
            }

            this.$set(this.controlsMapper, id, i);
            // console.log(this.controlsMapper)

            this.updateStore(fn);
        },

        init() {
            this.controlAnswers = [{
                text: `${this.$i18n.t('არსებული')} <br/><i class="text-muted">(${this.$i18n.t("საწყის ეტაპზე")})</i>`,
                label: this.$i18n.t('მონიშნეთ თუ სახეზეა, იცავთ, იყენებთ, მიღებულია ეს ზომა')
            }, {
                text: `${this.$i18n.t('დამატებითი')} <br/> <i class="text-muted">(${this.$i18n.t("გატარებული ან/და მიმდინარე")})</i>`,
                label: this.$i18n.t('მონიშნეთ თუ სახეზე არ არის, არ გაქვთ მიღებულია ეს ზომა და შემდგომში მიიღებთ ამ ზომას (შეძლებისდაგვარად აუცილებელია)')
            }, {
                text: this.$i18n.t('გასატარებელი პრევენციული ღონისძიება'),
                label: '',
            }, {
                text: this.$i18n.t('არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება'),
                label: ''
            }];
        },

        initMapper() {
            this.controlsMapper = {};
            this.data.control.forEach(control => {
                this.$set(this.controlsMapper, control.id, control.value);
            });
        }
    },
    data() {
        return {
            controlAnswers: [],
            controlsMapper: {}
        }
    },

    watch: {
        'data' : function() {
            this.initMapper();
        }
    },

    mounted() {
        this.init();
        this.initMapper();
        tout(() => {
            console.log(this.currentControls)
        })
    }
}
</script>

<style scoped>

.table thead th {
    border-bottom: 1px solid lightgrey !important;
}

</style>
yle>
