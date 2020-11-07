


<div class='' style='background-color:red;border-right:1px solid red;box-shadow:2px 2px 4px grey !important'>
     <div class='card shadow-none anim-half-width anim-margin' v-if='canShowOcon' style='border-bottom-right-radius:100px;border-top-left-radius:25px;'>
         <p class='ns-font-family ns-dark-color text-lg pl-4 pt-4 mb-0'> ატვირთეთ საფრთხის ამსახველი ფოტო <span class='text-muted text-sm'>(არასავალდებულო)</span> </p>

         <div class='card-body p-4'>
            <div class='text-muted' style='margin-bottom:-8px;'>
                  <button class='btn btn-outline-info rounded-pill bg-white  capiptalize' onclick='uploadImage(event,0)'>
                       <i class='fa fa-upload'></i> Upload
                  </button>
                  <input type='file'
                         id='imageupload0'
                         style='display:none'
                         accept="image/x-png,image/jpg,image/jpeg"
                         @change="uploadImage()"
                          />

                  <div class='uploaded_image'>
                     <img :src='data.image' class='mt-2 d-block' id='docimage0' style='max-width:400px;max-height:400px;'  />
                     <a class='btn btn-danger rounded-pill bg-lightgrey text-white px-3 py-1 capitalize border-0'
                        @click = 'clearUpload()'
                     > clear </a>
                  </div>
            </div>
       </div>
    </div>
</div>