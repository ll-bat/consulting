<template>
    <div class=''>
        <div class='card test-shadow rounded-8 pl-4' style="padding-top: 30px !important;border-left: 8px solid #6957b8;">
            <p class='text-lg mb-0'>
                {{ $i18n.t("ატვირთეთ საფრთხის ამსახველი ფოტო") }}
                <span class='text-muted text-sm'>({{ $i18n.t("არასავალდებულო") }})</span>
            </p>

            <div class='card-body pb-5 px-2' style="padding-top: 30px">
                <div class='text-muted' style='margin-bottom:-8px;'>
                    <button class='btn transparent-hover-nice border-nice color-nice px-5 py-2 bg-white'
                            id="image-upload-button"
                            onclick="$1('danger-image-input').click()"
                            v-if="!data.image && !data.oldImage"
                            style="border-width: 1px !important;">
                        <i class='fa fa-upload'></i>
                        Upload
                    </button>
                    <input type='file'
                           id='danger-image-input'
                           class="d-none"
                           @change="vueImageLoad"
                           accept="image/x-png,image/jpg,image/jpeg"/>

                    <div class='uploaded_image' v-if="data.image || data.oldImage">
                        <img :src='data.image || data.oldImage' class='mt-2 d-block' id='danger-image-id'
                             style='max-width:400px;'/>
                        <a class='btn btn-danger bg-lightgrey text-white mt-3 px-3 py-1 capitalize border-0'
                           @click='clearUpload()'
                        > Remove image </a>
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
    name: "DangerImage",
    computed:{
        ...mapState(['showControls', 'showControlsLoader', 'data', 'dangerId', 'processId', 'fm'])
    },
    methods:{
        ...mapActions(['setDangerImage', 'removeDangerImage']),
        async vueImageLoad(ev) {
            const data = {};
            await imageLoad(ev, null, (val) => {
                data.image = val;
                data.hasImage = true;
                data.imageName = `image_${this.processId}_${this.dangerId}`
                data.fm = {
                    value: ev.target.files[0],
                };
            });
            this.setDangerImage(data);
        },

        clearUpload() {
            $1('danger-image-id').src = '';
            $1('danger-image-input').value = '';
            this.removeDangerImage();
        },
    },
    data() {
        return {

        }
    }
}
</script>

<style scoped>

</style>

</style>
