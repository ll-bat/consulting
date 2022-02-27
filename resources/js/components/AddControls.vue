<template>
    <div>
        <div class="card test-shadow mt-4">
            <p class="text-center pt-4"> კონტროლის ზომის დამატება </p>
            <div class="card-body" :class="{'mb-3' : ct.type === 'second'}" v-for="ct in controlTypes">
                <p :class="ct.class"> {{ ct.text }} </p>
                <div class="card-body ml-4 mt-0 pt-0">
                    <div class="mt-3" v-for="(control, i) in userControls[ct.type]">
                        <div class="d-flex">
                            <div class="m-2 mt-3 border border-secondary rounded-circle"
                                 style="width: 8px; height: 8px"></div>
                            <div class="position-relative w-100">
                                <textarea type="text"
                                          :rows="1"
                                          class="form-control border-0 border-bottom-dotted px-0 py-2 font-size-09-rem"
                                          placeholder='დაამატეთ'
                                          v-model="control.value"
                                          @input="input(ct.type)"
                                          onclick="$(this).next().addClass('ns-test-underline-mx');$(this).addClass('border-bottom-transparent').removeClass('border-bottom-dotted')"
                                          onblur="$(this).next().removeClass('ns-test-underline-mx');$(this).removeClass('border-bottom-transparent').addClass('border-bottom-dotted')"></textarea>
                                <div class="ns-underline"
                                     style='background-color:#63759b !important; height: 1px !important;'></div>
                            </div>
                            <div @click="removeControl(i, ct.type)">
                                <i class="fas fa-times exit-icon rounded-circle p-3 mt-1"></i>
                            </div>
                        </div>
                    </div>
                    <div v-if="userControls[ct.type].length < 2" class="d-flex mx-2 mt-3">
                        <div class="rounded-circle border pt-1" style="width: 15px; height: 15px"></div>
                        <p class="px-2 text-sm text-muted text-hoverable pointer" @click="addNewControl(ct.type)">
                            დაამატეთ ახალი </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";

const {mapState, mapActions} = createNamespacedHelpers('questions');

export default {
    name: "add-controls",
    computed: {
        ...mapState(['showControls', 'data']),
    },
    methods: {
        ...mapActions(['updateStore']),
        updateInput(idx, ev) {
            this.updateStore((store) => {
                store.data.newControls[idx].value = ev.target.value;
            })
        },

        addNewControl(type) {
            this.userControls[type].push({value: ''});
            this.updateUserControls(type);
        },

        removeControl(ind, type) {
            this.userControls[type].splice(ind, 1);
            this.updateUserControls(type);
        },

        input(type) {
            if (this.delayedUpdate) {
                clearInterval(this.delayedUpdate);
            }

            this.delayedUpdate = setTimeout(() => {
                this.updateUserControls(type);
            }, 750)
        },

        updateUserControls(type) {
            this.updateStore(store => {
                store.data.newControls[type] = JSON.parse(JSON.stringify(this.userControls[type]));
            });
        },

        copyNewControls(controls) {
            const data = JSON.parse(JSON.stringify(controls));
            this.userControls.first = data.first || [];
            this.userControls.second = data.second || [];
        }
    },
    data() {
        return {
            userControls: {
                first: [],
                second: []
            },
            controlTypes: [],
            delayedUpdate: null,
        }
    },
    watch: {
        'data': function (data) {
            this.copyNewControls(data.newControls);
        },
        'data.newControls': function (controls) {
            this.copyNewControls(controls);
        }
    },

    mounted() {
        this.controlTypes = [
            {
                class: "px-3 pt-3 ml-2 text-sm",
                text: "1. საჭიროების შემთხვევაში დაამატეთ ფაქტობრივი, გატარებული კონტროლის ზომა",
                type: 'first'
            },
            {
                class: "px-3 pt-0 mb-3 ml-2 text-sm",
                text: "2. საჭიროების შემთხვევაში მიუთითეთ გასატარებელი ღონისძიება კონტროლის ზომა",
                type: 'second'
            }
        ];

        if (this.data.newControls) {
            this.copyNewControls(this.data.newControls);
        }
    }
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
