<template>






    <div class="form-group">
           <textarea type="text"
                     rows='1'
                     class="form-control docs-input tk-bottom font-weight-bold ns-font-family autoresize"
                     placeholder="Add title"
                     v-model = "input"
                     onfocus = "this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"

           ></textarea>
     </div>
</template>

<script>
    export default {
       props: [
          'object'
       ],
       data(){
           return {
                debounceInput: '',
                timeout: 0,
           }
       },
       created(){
           this.initFirst()
       },
       methods: {
           initFirst(){
               this.testvar = this.object.title
               this.debounceInput = this.object.title
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
               if (newVal == this.testvar)
               {
                   this.testvar = '     .'
                   return
               }

               this.$emit('saving')

               Forms.submit('post','docs/save-quest', {title: newVal, id: this.object.id}).then((res) => {
                   this.$emit('saved')
                   this.object.title = newVal
               }).catch((err) => {
                   alert('error')
                   this.$emit('saved')
                   console.log(err)
               })
           }
        }

    }
</script>
