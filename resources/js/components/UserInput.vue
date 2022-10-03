<template>
    <div class="card test-shadow mt-4">
        <p class="text-center pt-4"> {{ obj.title }} </p>
        <div class="card-body" v-if="this.isInput">
            <p class="px-3 pt-3 ml-2 text-sm"> {{ obj.smTitle }} </p>
            <div class="card-body ml-4 mt-0 pt-0 mb-3">
                <div class="mt-3" v-for="(d, i) in obj.data">
                    <div class="d-flex">
                        <div class="m-2 mt-3 border border-secondary rounded-circle"
                             style="width: 8px; height: 8px"></div>
                        <div class="position-relative w-100">
                                <textarea type="text"
                                          :rows="1"
                                          class="form-control border-0 border-bottom-dotted px-0 py-2 font-size-09-rem"
                                          :placeholder='$i18n.t("დაამატეთ")'
                                          v-model="d.value"
                                          @input="input()"
                                          onclick="$(this).next().addClass('ns-test-underline-mx');$(this).addClass('border-bottom-transparent').removeClass('border-bottom-dotted')"
                                          onblur="$(this).next().removeClass('ns-test-underline-mx');$(this).removeClass('border-bottom-transparent').addClass('border-bottom-dotted')"></textarea>
                            <div class="ns-underline"
                                 style='background-color:#63759b !important; height: 1px !important;'></div>
                        </div>
                        <div @click="remove(i)">
                            <i class="fas fa-times exit-icon rounded-circle p-3 mt-1"></i>
                        </div>
                    </div>
                </div>
                <div v-if="obj.data.length < 2" class="d-flex mx-1 mt-4">
                    <div class="rounded-circle border pt-1" style="width: 15px; height: 15px"></div>
                    <p class="px-2 text-sm text-muted text-hoverable pointer" @click="addNew()"> {{ $i18n.t("დაამატეთ ახალი") }} </p>
                </div>
            </div>
        </div>

        <div v-else-if="isTime" class="ml-2 mb-3">
            <div v-for="(type,i) in obj.types">
                <p class="px-3 pt-3 ml-2 text-sm"> {{ obj.smTitle[i] }} </p>
                <div class="card-body ml-4 mt-0 pt-0 mb-3">
                    <div class="mt-3" v-for="(d, i) in objData[type.ref]">
                        <div class="d-flex">
                            <div class="m-2 mt-3 border border-secondary rounded-circle"
                                 style="width: 8px; height: 8px"></div>
                            <div class="position-relative w-100" v-if="type.inputType === 'text'">
                                <textarea type="text"
                                          :rows="1"
                                          class="form-control border-0 border-bottom-dotted px-0 py-2 font-size-09-rem"
                                          :placeholder='$i18n.t("დაამატეთ")'
                                          v-model="d.value"
                                          @input="input(type.ref)"
                                          onclick="$(this).next().addClass('ns-test-underline-mx');$(this).addClass('border-bottom-transparent').removeClass('border-bottom-dotted')"
                                          onblur="$(this).next().removeClass('ns-test-underline-mx');$(this).removeClass('border-bottom-transparent').addClass('border-bottom-dotted')"></textarea>
                                <div class="ns-underline"
                                     style='background-color:#63759b !important; height: 1px !important;'></div>
                            </div>
                            <div v-else-if="type.inputType === 'date'" class="w-100 p-1">
                                <input type="date" v-model="d.value" @input="input(type.ref)" class="form-control"/>
                            </div>
                            <div @click="remove(i, type.ref)">
                                <i class="fas fa-times exit-icon rounded-circle p-3" style="margin-top: -3px"></i>
                            </div>
                        </div>
                    </div>
                    <div v-if="getLength(type.ref) < 2" class="d-flex mx-1 mt-4">
                        <div class="rounded-circle border pt-1" style="width: 15px; height: 15px"></div>
                        <p class="px-2 text-sm text-muted text-hoverable pointer" @click="addNew(type.ref)"> {{ $i18n.t("დაამატეთ ახალი") }} </p>
                    </div>
                </div>

                <p v-if="i !== obj.types.length -1 && obj.separator" class="text-primary" style="margin-left: 100px"> {{ obj.separator }} </p>

            </div>
        </div>

    </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";

const {mapState, mapActions} = createNamespacedHelpers('questions');
export default {
    name: "UserInput",
    props: {
        params: {
            type: Object
        }
    },

    computed: {
        ...mapState(['data'])
    },

    data() {
        return {
            obj: {
                data: [],
                ref: null,
                types: [],
            },
            objData: {},
            isInput: true,
            isTime: false,
            type: null,
            delayedUpdate: null,
        }
    },
    methods: {
        ...mapActions(['updateStore']),
        addNew(type) {
            if (type) {
                this.objData[type].push({value: ''});
            } else {
                this.obj.data.push({value: ''});
            }
            this.update(type);
        },

        remove(ind, type) {
            if (type) {
                this.objData[type] = this.objData[type].filter((d, i) => i !== ind);
            } else {
                this.obj.data = this.obj.data.filter((d, i) => i !== ind);
            }

            this.update(type);
        },

        input(type) {
            if (this.delayedUpdate) {
                clearTimeout(this.delayedUpdate);
            }
            this.delayedUpdate = setTimeout(() => {
                this.update(type);
            }, 750)
        },

        update(type) {
            this.updateStore(store => {
                if (type) {
                    store.data[this.ref][type] = JSON.parse(JSON.stringify(this.objData[type]));
                } else {
                    store.data[this.ref] = JSON.parse(JSON.stringify(this.obj.data));
                }
            });
        },

        copyObj(data) {
            let el = JSON.parse(JSON.stringify(data));
            if (!this.type) {
                this.obj.data = el;
            } else {
                this.objData = el;
            }
        },

        init(type) {
            for (let {ref} of this.obj.types) {
                if (!this.objData[ref]) {
                    this.objData[ref] = [];
                }
            }

            if (type === 'time') {
                this.isTime = true;
            }

            this.isInput = false;
        },

        getLength(type) {
            return this.objData[type].length;
        }
    },

    watch: {
        'data': function (data) {
            this.copyObj(data[this.ref]);
        },
    },

    mounted() {
        this.obj = JSON.parse(JSON.stringify(this.params));

        if (!this.obj.ref) {
            throw new Error('Wrong data format provided');
        }

        if (this.obj.type) {
            this.type = this.obj.type;
        }

        this.ref = this.obj.ref;
        this.copyObj(this.data[this.ref]);

        if (this.params.types) {
            this.init(this.params.type);
        }
    },
}
</script>

<style scoped>
.size-12 {
    font-size: 1.2rem;
}

.border-bottom-transparent {
    border-bottom: 1px solid transparent !important;
}

.font-size-09-rem {
    font-size: .9rem;
}

.border-bottom-dotted {
    border-bottom: 1px dotted lightgrey !important;
}

.text-hoverable:hover {
    text-decoration: underline;
}

.exit-icon {
    cursor: pointer;
    color: #cbc6c6;
    background-color: transparent;
}

.exit-icon:hover {
    background: #f1eeee;
    color: #798db0;
}

</style>
798db0;
}

</style>
