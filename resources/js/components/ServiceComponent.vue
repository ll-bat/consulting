








<template>
   <div class="col-lg-5 col-md-8 col-sm-10 col-12 border px-5 pt-5 ml-auto mr-auto text-center mb-5"
        style='border-color: rgba(0,0,0,.2) !important'
   >
         <div class="single-cat text-center mb-50">
           <div class="cat-icon position-relative">
               <!-- <i class='fa fa-plus mb-5' style='font-size: 5rem;color:#eb566c;'></i> -->
               <img :src='data.image' onload="this.style.opacity='1'"
                    class='mb-4'
                    style='opacity:.3; transition: all .3s ease-in;height:80px; max-height:80px;min-height:80px;max-width:170px' />
               <div class='position-absolute' style='top:0; right:0;'>
                  <button class='box-image-button' onclick='$(this).next().click()'>
                     <i class='fa fa-pencil text-primary'></i>
                  </button>
                  <input type='file' class='d-none'  @change='loadImage($event)' />
               </div>

               <div class='position-absolute' style='top:0; left:0;'>
                   <button class='box-image-button' @click="deleteService($event)">
                        <i class='fa fa-trash text-danger box-trash'></i>
                   </button>
               </div>

            </div>

            <div class="cat-cap">
               <textarea type='text' class='form-control p-2 autoresize' rows='1'
                         style='border-color: rgba(0,0,0,.18) !important'
                         v-model='data.title'
                         :placeholder='$i18n.t("სათაური")'></textarea>

               <textarea type='text' class='form-control p-2 mt-4 autoresize'
                         style='border-color: rgba(0,0,0,.18) !important'
                         v-model='data.description'
                         :placeholder='$i18n.t("აღწერა")'> </textarea>
           </div>

        </div>

        <div class='spinner text-primary spinner-border position-absolute d-none'
            style='bottom:10px;  right:10px; width:20px; height:20px;'></div>

        <label class="ns-container mt-3 p-0 text-secondary"
               style='font-size:.95em; color:rgba(0,0,0,.8);'> {{ $i18n.t("გამოჩნდეს მთავარ გვერდზე") }}
             <input type="checkbox" v-model = 'data.shown' />
             <span class="chbox-checkmark mt-1"></span>
        </label>

        <button class='box-save-button my-4 px-3 py-1'
                @click='saveHandler()'
                style=''>

               <div class='d-flex'>
                     <span class="spinner-border spinner-border-sm mt-1 mr-1" :class="{'d-none': !saving}"></span>
                     <span> {{ $i18n.t("განახლება") }} </span>
              </div>

        </button>

    </div>
</template>

<script>
    export default {

        props :[
            'service'
        ],

        data(){
            return {
                id: null,
                data: null,
                saving: false,
                postData: null
            }
        },

        watch: {
            service: function(newObj, oldObj){
                this.init(newObj)
            }
        },

        methods: {
            init(service){
                this.id = service.id
                this.data = service.value
                this.data.shown = ['false', false].includes(this.data.shown) ? false : true
                this.postData = new FormData()
                this.postData.append('id', this.id)
            },

            loadImage(ev){
                let el = ev.target.parentNode.parentNode.children[0];
                el.style.opacity = '.3'

                el.parentNode.parentNode.parentNode.children[1].classList.remove('d-none')

                imageLoad(ev, null,  (data) => {
                      el.src = data
                      el.parentNode.parentNode.parentNode.children[1].classList.add('d-none')

                      if (this.postData.has('image')) this.postData.delete('image')
                      this.postData.append('image', ev.target.files[0])
                })
             },
            deleteService(ev){
                this.$emit('delete', this.id)

                axios['post']('modify/delete-service', {
                    id: this.id
                })
                .then(res => {

                })
                .catch(err => {
                    alert("An error has occured")
                    console.log(err)
                })
            },
            saveHandler(){
                this.saving = true;

                for (let a of ['title', 'description', 'shown']){
                    if (this.postData.has(a)) this.postData.delete(a)
                    this.postData.append(a, this.data[a])
                }

                if (this.postData.has('image-name')) this.postData.delete('image-name')
                    this.postData.append('image-name', this.data['image'])

                axios['post']('modify/services', this.postData)
                    .then(res => {
                        this.data['image'] = res.data
                        this.saving = false
                        if (this.postData.has('image')) this.postData.delete('image')
                    })
                    .catch(err => {
                        alert(this.$i18n.t('სამწუხაროდ შეცდომა დაფიქსირდა, გთხოვთ სცადოთ თავიდან'))
                        console.log(err)
                        this.saving = false
                        if (this.postData.has('image')) this.postData.delete('image')
                    })
            }
        },

        created(){
            this.init(this.service)

            tout(() => {
               $(window).trigger('autoresize')
            }, 200)
        }
    }
</script>
  }
    }
</script>
