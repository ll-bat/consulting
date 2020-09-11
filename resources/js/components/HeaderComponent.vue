


<template>
 <div class="card text-left rounded-10" @click='emitClickEvent()'
      :class="{'shadow-none leftBorder': nselected, 'colorLeftBorder': !nselected}"
      style='border-left-width:5px;'
      >
    <div class="row">
         <div class="col-md-9 col-sm-10 col-10">
              <div class="ml-3 mt-2">
                  <head-component
                      :object='object'
                      @saving='showSpinner()'
                      @saved='hideSpinner()'
                  ></head-component>
              </div>
         </div>
         <div class="col-md-3 col-sm-2 col-2">
             <div class="my-2 mt-3 text-right mr-3 pr-2">
                <delete-component  @delete="$parent.$emit('delete', object.id, object.index)"></delete-component>
             </div>
         </div>
    </div>

    <div class='row'>
            <div class='col-10'>
                 <div class='form-group ml-3' style='margin-top:-2%'>
                      <div v-for='value in object.values'>
                          <body-component
                            :object='value' isWhite='true'
                            placeholder='Add description'
                            @saving='showSpinner()'
                            @saved='hideSpinner()'></body-component>
                      </div>
                 </div>
            </div>
            <div class='col-2'>
                 <div class="my-2 mt-3 text-right mr-3 p-2 " :class="{'invisible': !saving}">
                      <div class="spinner-border text-info" style="height:20px;width:20px;"></div>
                 </div>
            </div>
     </div>

     <div class="float-left ml-3">
         <div class="d-flex">
             <p class="text-primary font-weight-bolder text-sm pl-1">N: </p>
             <input type="text"
                    class="form-control ns-index-border text-primary font-weight-bolder ml-1"
                    style="width:45px;margin-top:-.47rem"
                    @click="$parent.activeCheckIcon(index)"
                    v-model='object.newindex' />
             <div class="d-none edit-index created pointer" @click="clickCheckIcon()">
                 <i class="fa fa-check position-absolute text-success edit-index-bg rounded-pill p-2"
                    style="margin-top: -.16rem; margin-left:-.3rem;"
                 ></i>
             </div>
         </div>
     </div>

 </div>
</template>

<script>
    export default {
        name: "HeaderComponent",
        props: [
            'object','nselected','index'
        ],
        data(){
            return {
                ys: false,
                saving: false,
            }
        },
        computed: {

        },

        methods: {
            emitClickEvent(){
                this.$emit('choose')
            },
            showSpinner(){
                this.saving = true
            },
            hideSpinner(){
                this.saving = false
            },
            clickCheckIcon(){
                this.$parent.clickCheckIcon(this.object, this.index)
            }
        },
        created() {
               setTimeout(()=> {
                    $(window).trigger("autoresize")
                }, 200)
        }
    }
</script>

<style scoped>
    .colorLeftBorder{
        border-left:5px solid blue;
    }
    .leftBorder{
        border-left-color: rgba(218, 216, 216, .5);
    }
</style>
