<template>
    <div>
        <div class='card test-shadow rounded-8' v-if='showDangers' style="border-left: 8px solid #6957b8;">
            <div class='card-body ml-2 pl-2'>
                <p class='px-2 py-3 pb-0 size-13'> აირჩიეთ საფრთხე </p>
                <div class="form-group py-1 px-3" v-if='currentDangers.length > 0'>
                    <div class="mt-2">
                        <div v-for='(d,i) in currentDangers'>
                            <label class="ns-container mb-3 pl-5 pt-1" style="color: #393838;"
                                   @mousedown="chooseDanger(d.id)">{{ d.name }}
                                <div class="ns-test">
                                    <div
                                        class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin rounded-circle"
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
        ...mapState(['showDangers', 'showDangerLoader', 'currentDangers', 'dangerId', 'processId', 'info'])
    },
    methods: {
        ...mapActions(['showDangersM', 'showDangerLoaderM', 'setDanger', 'showControlsLoaderM', 'showControlsM', 'setControls', 'getControls', 'setElement']),
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
        }
    },
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>

<style scoped>
.size-13 {
    font-size: 1.3rem;
}
</style>
