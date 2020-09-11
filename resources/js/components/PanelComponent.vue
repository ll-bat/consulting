<template>
     <div class="card rounded-10 text-center" style="width: 100%">
        <div class="d-flex d-md-block">
            <div class='my-2'>
                <button title="Add new Question"
                        class='bg-white'
                        style="cursor:pointer;border:none;outline:none;"
                        @click='newQuestion()'>
                    <i class="fa fa-plus text-secondary h-dif"></i>
                </button>
            </div>
            <div class='my-2'>
                <button title="Add new title and description"
                        class='bg-white'
                        style="cursor:pointer;border:none;outline:0;"
                        @click='newHeader()'>
                    <i class="nc-icon nc-caps-small text-secondary h-dif"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {

            }
        },
        methods: {
           newQuestion(){
              Event.$emit('new-element', 'radio')
           },
           newHeader(){
              Event.$emit('new-element', 'header')
           }
        }
    }
</script>
<style>
  .h-dif{
     padding:12px;
     transition: all .4s ease-in-out;
  }
  .h-dif:hover{
     background-color:rgba(211, 211, 211, 0.377);
     border-radius: 45%;
  }
</style>
