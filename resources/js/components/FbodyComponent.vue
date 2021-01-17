








<template>
      <div class='d-flex my-2'>
         <div class='ns-circle' style='width:25px;'></div>

         <textarea type="text"
                   class="form-control docs-input th-bottom h-font ns-font-family autoresize ml-2 w-100"
                   rows = '1'
                   style='line-height:2.6;font-size:.88em; margin-top:-.56rem;'
                   :placeholder= 'placeholder'
                   v-model="input"
         ></textarea>


         <div v-if = 'type == 1' style='width:20%'>
               <div class='mx-2 mt-2 text-left'>
                     <input type='number' class='form-control border-0 w-100'
                            placeholder='K:1'
                            v-model = 'k'
                            @input = 'updateScore()'
                            style='width:3rem;border-bottom:1px solid orange !important;border-radius:0' />
              </div>
         </div>

         <button class='text-center mr-2 bg-white' @click='deleteComp()'
                 style='width:10%;border:none;outline:0;'>
            <i class='nc-icon nc-simple-remove option-remove h-ntest'></i>
         </button>

      </div>
</template>

<script>
    export default {

        props :[
           'data', 'placeholder', 'type', 'url'
        ],

        data(){
           return {
                k: 0,
                debounceInput: '',
                timeout: 0,
           }
       },

       computed: {
           input: {
               get(){
                   return this.debounceInput
               },
               set(val){
                   if (this.timeout) clearTimeout(this.timeout)
                   this.timeout = setTimeout(()=>{
                       this.debounceInput = val
                   }, 500)
               }
            }
       },

       methods: {
           initFirst(obj){
               this.debounceInput = obj.name == 'null' ? '' : obj.name
               this.k = obj.k
           },

           updateScore(){
              if (this.k)
                this.update(this.debounceInput == '' ? 'null': this.debounceInput)
           },

           update(newVal){
                 this.data.name = newVal
                 this.data.k    = this.k

                 this.$emit('saving')
                 Form.send('post', this.url, this.data, this).then(res => this.$emit("saved"))
           },
           deleteComp(){
                 let type = this.type == '1' ? 'ploss' : 'udanger'
                 Form.send('delete', `docs/${type}/${this.data.id}/delete`, null, null)
                 this.$emit('deleted', this.data.id, this.type)
           }
       },

        watch: {
            data: function(newObj, oldObj){
                 this.initFirst(newObj)
            },

            debounceInput: function(newVal, oldVal){
                 if (newVal == oldVal) return

                 this.update(newVal)
            }
        },


        created(){
            tout(()=> {
                $(window).trigger('autoresize')
            }, 200)
            tout(() => {
               this.initFirst(this.data)
            }, 100)
        }
    }
</script>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .option-remove{
        font-size:1.2em;font-weight:bold;color:grey;
    }
    .h-ntest{
        padding:12px;
        border-radius:45%;
        cursor: pointer;
        transition: all .3s;
        opacity:.6;
    }
    .h-ntest:hover{
        background-color:whitesmoke;
        border-radius:50%;
        color:#602b92;
        opacity:1;
    }
    @keyframes  testanim {
       from {opacity: .8; transform: rotate(-90deg); padding:1px; background-color:lightblue; border-radius:50%;}
       to {}
   }
   .testit{
       animation-name:testanim;
       animation-duration: .5s;
   }
</style>
