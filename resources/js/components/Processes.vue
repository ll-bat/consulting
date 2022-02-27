<template>
    <div class='text-left' id='show_data'>
        <div class='card test-shadow rounded-8 modified-animation' id='edit-process'
             style='border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-top: 8px solid rgb(105, 87, 184)'>
            <div class='card-body ml-2 pl-2'>
                <p class='size-13 py-2 px-2'> აირჩიეთ პროცესი </p>
                <div class="px-4 my-0 py-0" v-for="process in getCompletedProcesses">
                    <p class="text-success" @mousedown="chooseProcess(process.id)">
                        <i class="nc-icon nc-check-2 px-2 mt-1"></i>
                        <span class="p-hover" :class="{'p-hovered' : highlight === process.id}">
                            {{ process.name }}
                        </span>
                    </p>
                </div>

                <div class="form-group">
                    <div class="mt-4">
                        <div v-for='(p,i) in getNotCompletedProcesses'>
                            <label class="ns-container black-75 m-4 pl-5 pt-1" @mousedown="chooseProcess(p.id)">
                                {{ p.name }}
                                <div class="ns-test">
                                    <div
                                        class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin rounded-circle"
                                        :class="{'hovered-checkmark-diff': (p.id === processId) }">
                                        <span class='text-center'
                                              :class="{'checked-circle-diff': (p.id === processId)}"></span>
                                    </div>
                                </div>
                            </label>
                        </div>
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
    name: "Processes",
    computed: {
        ...mapState(['processes', 'showDangerLoader', 'showDangers', 'showControls', 'currentDangers', 'dangerId', 'processId']),
        ...mapState({
            completedProcessIdMapper: state => state.completedDangers,
        }),
        getCompletedProcesses() {
            const completedProcesses = []
            for (const process of this.processes) {
                if (this.completedProcessIdMapper[process.id] !== undefined && Object.keys(this.completedProcessIdMapper[process.id]).length > 0) {
                    completedProcesses.push({id: process.id, name: process.name});
                }
            }
            return completedProcesses
        },
        getNotCompletedProcesses() {
          const completedProcesses = this.getCompletedProcesses;
          const notCompletedProcesses = [];
          for (const process of this.processes) {
              if (completedProcesses.find(item => item.id === process.id) === undefined) {
                  notCompletedProcesses.push({id: process.id, name: process.name});
              }
          }
          return notCompletedProcesses;
        }
    },
    methods: {
        ...mapActions(['getProcesses', 'getDangers', 'showDangersM', 'showControlsM', 'showDangerLoaderM', 'setDanger', 'setProcess']),
        async chooseProcess(id) {
            this.highlight = id;
            this.setProcess(id);

            this.showDangerLoaderM(true);
            this.showDangersM(false);
            this.showControlsM(false);

            this.setDanger(-1);
            const process = this.processes.find(p => p.id === id);
            if (!process) {
                alert('სამწუხაროდ, ამ დოკუმენტში შემავალი ზოგიერთი პროცესი წაშლილია...');
                this.showDangerLoaderM(false);
                this.showDangersM(false);
                return;
            }

            await this.getDangers(id);

            this.showDangerLoaderM(false);
            this.showDangersM(true);

            Event.$emit('scrollTo', 'dangers-part');
        },
    },
    data() {
        return {
            highlight: -1,
        }
    },
    mounted() {
        this.getProcesses();
    }
}
</script>

<style scoped>
.size-13 {
    font-size: 1.3rem;
}
.p-hovered {
    text-decoration: underline;
}
.p-hover:hover {
    cursor: pointer;
    text-decoration: underline;
}
</style>
