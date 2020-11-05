








<template>
    <div class='row'>
         <template v-for = 'service in services'>
              <service :service='service' @delete='deleteService'></service>
         </template>

         <div class="col-lg-5 col-md-8 col-sm-10 col-12 ml-auto mr-auto px-5 pt-5 text-center mb-5"
              @click = 'addService'
              style='border:none !important;'>
              <div class='hoverable py-5'>
                  <i class='fa fa-plus' style='font-size: 10rem;'></i>
              </div>
         </div>
    </div>
</template>

<script>
    export default {

        props :[
            
        ],

        data(){
            return {
               services: [],
               creating: false,
            }
        },

        methods: {
            deleteService(id){
                this.services = this.services.filter(s => s.id !== id)
            },

            addService(){
                if (this.creating) return ;

                this.creating = true;

                let uuid = get_uuid()

                axios['post']('modify/new-service', {
                    id: uuid
                }).then(res => {this.creating=false})
                .catch(err => {
                       alert('error'); console.log(err); this.creating = false
                       this.services = this.services.filter(s => s.id != uuid)
                })

                tout(() => {
                    this.services.push({
                        id: uuid,
                        value: {
                            title: '',
                            description: '',
                            shown : 'false',
                            image: '/icons/no-image.png'
                        }
                    })
                }, 300)
            }
        },

        created(){
            axios['get']('modify/get-services')
               .then(res => {
                   for(let a in res.data){
                       this.services.push({
                           id: a,
                           value: res.data[a]
                       })
                   }

                   console.log(this.services)
               })
               .catch(err => {
                   alert('error')
                   console.log(err)
               })
        }
    }
</script>


<style scoped>

     .hoverable {
         cursor:pointer;
         transition: all .4s ease-in;
     }

     .hoverable:hover{
         border-radius: 25px;
         background-color: rgba(0,0,0,.12) !important;
     }

</style>