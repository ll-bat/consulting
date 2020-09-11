<template>





   <div>
        <textarea  type="text"
                   class="form-control docs-input th-bottom h-font ns-font-family autoresize"
                   :class="{'bg-white' : isWhite}"
                   rows = '1'
                   style='line-height:2.6;font-size:.88em;'
                   :placeholder= 'placeholder'
                   onfocus = "this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
                   onfocusout = "this.style.height = 'auto'"
                   v-model="input"
         ></textarea>
    </div>

</template>

<script>
    export default {
       props: [
          'object',
          'placeholder',
          'isWhite'
       ],
       data(){
           return {
                debounceInput: '',
                timeout: 0,
           }
       },
       created(){
           this.initFirst()
           setTimeout(()=> {
                    $(window).trigger("autoresize")
                }, 200)
       },
       methods:{
           initFirst(){
               this.testvar = this.object.value
               this.debounceInput = this.object.value
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
       watch: {
           object: function(newObj, oldObj){
                 this.initFirst()
           },
           debounceInput: function(newVal, oldVal){
               if (newVal == this.testvar){
                   this.testvar = '    .'
                   return
               }

               this.$emit('saving')

               Forms.submit('post','docs/save-rels', {value: newVal, id: this.object.id}).then((res) => {
                    this.$emit('saved')
                    this.object.value = newVal
               }).catch((err) => {
                    alert('error')
                    this.$emit('saved')
                    console.log(err)
               })
           }
        }

    }
</script>
<style>
  .h-font{
      font-family: 'Roboto', sans-serif;
      color: rgba(0,0,0,85);
  }

  .h-border{
      border:1px solid transparent;
      transition: all .1s;
  }
  .h-border:hover{
      border-bottom:1px solid lightgrey;
  }

</style>
