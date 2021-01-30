<div class=''>
    <div class='card shadow-none rounded-10 pl-4' style="padding-top: 30px !important;" v-if='showControls'>
        <p class='text-lg mb-0'>
            ატვირთეთ საფრთხის ამსახველი ფოტო
            <span class='text-muted text-sm'>(არასავალდებულო)</span>
        </p>

        <div class='card-body pb-5 px-2' style="padding-top: 30px">
            <div class='text-muted' style='margin-bottom:-8px;'>
                <button class='btn btn-outline-info px-5 py-2 bg-white'
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
                         style='max-width:400px;max-height:400px;'/>
                    <a class='btn btn-danger bg-lightgrey text-white mt-3 px-3 py-1 capitalize border-0'
                       @click='clearUpload()'
                    > Remove image </a>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showControlsLoader">
        <div class="controls-skeleton"></div>
        <div class="danger-skeleton my-4"></div>
        <div class="danger-skeleton"></div>
    </div>
</div>
