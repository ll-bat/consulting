<template>
    <div id="dangers-part">
        <div class='card test-shadow rounded-8' v-if='showDangers' style="border-left: 8px solid #6957b8;">
            <div class='card-body ml-2 pl-2'>
                <p class='px-2 py-3 pb-0 size-13'> აირჩიეთ საფრთხე </p>
                <div class="px-3 my-0 py-0" v-for="id in Object.keys(completedData)">
                    <p class="text-success">
                        <i class="nc-icon nc-check-2 px-2 mt-1"></i>
                        <span class="p-hover" :class="{'p-hovered' : highlight == id}"
                              @click="chooseCompletedDanger(id)">
                            {{ completedData[id] }}
                        </span>
                        <span class="trash-hover text-sm mx-2" @click="removeDanger(id)">
                            (ამოშლა)
                        </span>
                    </p>
                </div>
                <div class="form-group py-1 px-3" v-if='currentDangers.length > 0'>
                    <div class="mt-2">
                        <div v-for='(d,i) in currentDangers'>
                            <label class="ns-container mb-3 pl-5 pt-1" style="color: #393838;"
                                   @mousedown="chooseDanger(d.id)">{{ d.name }}
                                <div class="ns-test">
                                    <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin rounded-circle"
                                        :class="{'hovered-checkmark-diff': (d.id === dangerId) }">
                                    <span class='text-center'
                                          :class="{'checked-circle-diff': (d.id === dangerId)}"></span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="danger-skeleton" v-if="showDangerLoader"></div>
    </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex/dist/vuex.mjs";

const {mapState, mapActions} = createNamespacedHelpers('questions');

export default {
    name: "Dangers",
    computed: {
        ...mapState(['showDangers', 'showDangerLoader', 'currentDangers', 'dangerId', 'processId', 'info', 'completedDangers', 'toBeWatched', 'isUpdate'])
    },
    methods: {
        ...mapActions(['showDangersM', 'showDangerLoaderM', 'setDanger', 'showControlsLoaderM', 'showControlsM', 'setControls', 'getControls', 'setElement', 'editDanger', 'removeCompletedDanger']),
        chooseDanger(id) {
            this.setDanger(id);

            this.showControlsLoaderM(true);
            this.showControlsM(false);
            this.setControls([]);

            let danger = this.currentDangers.find(d => d.id === id)
            if (!danger) {
                this.showControlsM(false);
                alert('სამწუხაროდ, ამ დოკუმენტში შემავალი ზოგიერთი საფრთხე წაშლილია...');
                this.showControlsLoaderM(false);
                this.showControlsM(false);
                return;
            }

            this.getControls(danger.id);

            const elm = this.info.find(e => e.pid === this.processId && e.did === this.dangerId);
            this.setElement(elm);

            this.showControlsLoaderM(false);
            this.showControlsM(true);
        },

        chooseCompletedDanger(id) {
            this.editDanger(id);
        },

        removeDanger(id) {
            this.removeCompletedDanger(id);
        },

        refreshCompletedDangers() {
            this.completedData = {};
            this.completedData = this.completedDangers[this.processId] || {};
        }
    },
    data() {
        return {
            completedData: {},
            highlight: -1,
        }
    },
    watch: {
        'processId' : function(obj) {
            this.refreshCompletedDangers();
        },
        'dangerId' : function(s) {
            this.highlight = this.dangerId;
        },
    },
    mounted() {
        this.$watch('toBeWatched', (s) => {
            this.refreshCompletedDangers()
        });
    }
}
</script>

<style scoped>
.size-13 {
    font-size: 1.3rem;
}
.text-success {
    color: #149d76 !important;
    font-weight: 500 !important;
}
.p-hovered {
    text-decoration: underline;
}
.p-hover:hover {
    cursor: pointer;
    text-decoration: underline;
}
.trash-hover {
    cursor: pointer;
    color: #883434;
    font-style: italic;
}
.trash-hover:hover {
    text-decoration: underline;
}
</style>
