<template>
    <div class="pb-0 mt-3" id="ploss-udangers-part">
        <div v-for='c in combined'>
            <div class="card rounded mb-0" :class="c.class" :style="c.style">
                <div class="card-body ml-3 mt-2 mb-2">
                    <p class="mb-4 text-lg"> {{ c.text }}</p>
                    <div v-for="(d,i) in c.data">
                        <label class="ns-container mt-3 pl-5 pt-1" @mousedown="update(d.id, c.type)"
                               style="font-size:.95em; color:rgba(0,0,0,.8);">{{ d.name }}
                            <div class="ns-test">
                                <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin clickable"
                                     :class="{'hovered-checkmark-bg hovered-checkmark-diff-cyan' : dataMapper[c.type][d.id] === 1 }">
                                    <span class="checked-diff"></span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <user-input :params="c.userInput"></user-input>
        </div>
    </div>

</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";
import UserInput from "./UserInput";

const {mapState, mapActions} = createNamespacedHelpers('questions');

export default {
    name: "PlossUdanger",
    components: {UserInput},
    computed: {
        ...mapState(['ploss', 'udanger', 'data'])
    },
    methods: {
        ...mapActions(['updateStore']),
        update(id, type) {
            let value = 1;
            const fn = (store) => {
                let el = store.data[type].find(p => p.id === id);
                if (!el) {
                    store.data[type].push({value: 1, id: id});
                } else {
                    el.value = (el.value + 1) % 2;
                    value = el.value;
                }
            }
            this.updateStore(fn);

            this.$set(this.dataMapper[type], id, value);
        },

        initMapper() {
            this.dataMapper = {
                ploss: {},
                udanger: {},
            };

            ['ploss', 'udanger'].forEach(t => {
                this.data[t].forEach(p => {
                    this.$set(this.dataMapper[t], p.id, p.value);
                })
            })
        },

        init() {
            this.combined = [{
                class: 'mb-4 rounded-8 test-shadow',
                style: 'border-radius:0;border-bottom:0;',
                text: this.$i18n.t('აირჩიეთ პოტენციური ზიანი'),
                data: this.ploss,
                type: 'ploss',
                userInput: {
                    title: this.$i18n.t('პოტენციური ზიანის დამატება'),
                    smTitle: this.$i18n.t('საჭიროების შემთხვევაში დაამატეთ პოტენციური ზიანი'),
                    data: [],
                    ref: 'newPloss'
                }
            }, {
                class: 'pb-0 mb-4 rounded-8 test-shadow',
                style: 'border-radius:0;padding-bottom:0 !important; ',
                text: this.$i18n.t('ვინ იმყოფება საფრთხის ქვეშ'),
                data: this.udanger,
                type: 'udanger',
                userInput: {
                    title: this.$i18n.t('საფრთხის-ქვეშ მყოფი პირის დამატება'),
                    smTitle: this.$i18n.t('საჭიროების შემთხვევაში დაამატეთ ვინ იმყოფება საფრთხის ქვეშ'),
                    data: [],
                    ref: 'newUdangers'
                }
            }];
        }
    },
    data() {
        return {
            helpers: {},
            combined: null,
            dataMapper: {
                ploss: {},
                udanger: {}
            }
        }
    },
    watch: {
        'data': function (data) {
           this.initMapper();
        },
    },

    mounted() {
        this.init();
        this.initMapper();
    }
}
</script>

<style scoped>

</style>
