@extends('layouts/zim')

@section('header')
    <style>
    .border-bottom {
           border-bottom: 1px dotted lightgrey !important;
     }

    .border-bottom:focus {
        border-color: transparent !important;
    }

    .slow-down {
        transition: all .5s ease-out;
    }

    .add-control-border {
        border-bottom: 5px solid white !important;
    }

    .remove-control-border {
        border-bottom: 5px solid orange !important;
    }

    #moveable-control-border {
        transition: all .3s ease;
    }

    .control-border-bottom {
        border-bottom:5px solid rgba(0,0,0,.1) !important;
    }

    .hovered-ns-button {
        background-color:#673ab7 !important;
    }

    @keyframes _animateProcess {
        0% {margin-top: -3rem;transform:rotate(10deg);width:40%;opacity:.3}
        60% {opacity:.5;}
        100% {margin-top: 0rem;width:100%;}
    }

    .animate-process {
        animation: _animateProcess .5s ease-out;
    }

    #edit-process {
        border-top:3px solid rgba(0,0,0,.2);
        transition: all .2s ease-out;
    }
    /* 673ab7 */

    @keyframes _animateSubmitButton{
        0% {margin-top: 7rem;transform: rotate(-20deg) rotateX(180deg);}
        100 {margin-top:0rem;}
    }
    .animate-submit-button {
       animation: _animateSubmitButton .5s ease-out;
    }

    .hoverable-underline {
        width:0;
        height:.2rem;
        margin-right:5px;
        transition: all .2s ease-out;
    }

    .hoverable:hover .hoverable-underline {
        width:100%;
    }

    .m-btn:focus {
        outline: 0;
    }

    .text-orange {
        color:orange;
    }

    .text-purple {
        color:purple;
    }

    .text-blue {
        color: blue;
    }

    .bg-purple {
        background-color: purple;
    }

    .bg-blue {
        background-color: blue;
    }

    .ns-card {
        border-radius: 0 !important;
        border-top: 10px solid blue !important;
    }


   </style>
@endsection



@section('content')


<div class="container text-center position-absolute" id='app'>
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 col-sm-12 col-12 mr-4 ml-5 mr-5 mt-md-0 mt-sm-5 mt-5" style=''>

            <div :class="{'d-none': !loading}" style="margin-top:30%;">
                 <div class="spinner-border text-warning"
                      style="width:7rem; height: 7rem;border-width: 1rem;"></div>
             </div>

             <!-- #673ab7 -->
            <div class='text-left d-none' id='show_data'>
                <div class='card rounded-10 shadow-none animate-process' id='edit-process' style=''>
                    <div class='card-body ml-2 pl-2'>
                        <p class= 'ns-font-family ns-dark-color py-2 px-2' style='font-size:1.3rem;'> აირჩიეთ პროცესი </p>
                        <div class="form-group" style='width:50%;'>
                           <label for="sel1">Select list:</label>
                           <select class="form-control py-2 px-2" @change="choose()" id="sel1" style='line-height:2rem;'>
                               <option class="p-5" selected disabled style='font-size:1.1rem !important'>ყველა პროცესი</option>
                                  <option class='p-5' v-for='p in process' style='font-size:1.1rem !important;font-weight:400;' :value='p.id'
                                  > @{{p.name}}
                                  </option>
                           </select>
                      </div>
                 </div>
             </div>

             <div class='anim-half-width anim-margin' style='background-color:#673ab7;border-radius:10px;border-right:1px solid #673ab7;box-shadow:2px 2px 4px grey !important'>
                 <div class='card rounded-10 shadow-none anim-half-width anim-margin' v-if='canShow == true'
                      style='border-radius:10px;!important;border-top-right-radius:100px;border-bottom-left-radius:25px;'>
                     <div class='card-body ml-2 pl-2'>
                          <p class= 'ns-font-family ns-dark-color p-3 pb-0' style='font-size:1.3rem;'> აირჩიეთ საფრთხე </p>
                          <div class="form-group p-3" style='width:55%;' v-if='odan.length > 0'>
                               <label for="sel1">Select list:</label>
                               <select class="form-control py-2 px-2" @change="chooseOcon()" id="sel2" style='line-height:2rem;'>
                                   <option class="p-5" selected disabled style='font-size:1.1rem !important'>ყველა საფრთხე</option>
                                      <option class='p-5' v-for='d in odan' style='font-size:1.1rem !important;font-weight:400;' :value='d.id'
                                      > @{{d.name}}
                                      </option>
                               </select>
                          </div>
                          <!-- <div class='d-flex' v-else >
                             <img src='/icons/frown.png' width='40' />
                             <p class='pl-2 mt-2 text-secondary text-sm'> სამწუხაროდ, არჩეული პროცესი არ მოიცავს არცერთ საფრთხეს :)) </p>
                          </div> -->
                     </div>
                 </div>
             </div>

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
             <!-- <div class="card rounded-10 top-left-radius-0 bottom-right-radius-0 ns-font-family my-4 p-2 anim-half-width anim-margin"
                style='border-top:7px solid #673ab7;border-top-right-radius:20px' v-if='canShowOcon'>

                  <div class="card-title pl-4 pt-2">
                         <p class="d-inline" style='font-size:1.3rem;'> აირჩიეთ კონტროლის ზომები </p>
                  </div>
              </div> -->

              <div v-if='canShowOcon' style='padding:0; background-color:white; box-shadow:2px 2px 4px lightgrey, -2px -2px 4px lightgrey;border:1px solid lightgrey'>
                      <div class="card rounded-10 ns-font-family ns-dark-color mb-0 p-2 shadow-none sizeable-control"
                           style='border-left:1px solid lightgrey; border-radius:0'
                           v-for='(o,i) in ocon'
                           :class="{'control-border-bottom' : i != ocon.length - 1}"
                           >

                          <div class="card-body ml-2 pl-1">
                                <div class='ml-3'>
                                    <h4 class='pt-1 pl-0 text-lg' v-if='i == 0'>
                                        გთხოვთ, აირჩიოთ შესაბამისი პასუხი თითოეული კონტროლის ზომის შემთხვევაში
                                    </h4>
                                    <p class='mt-3'> @{{o.name}} </p>
                                    <div v-for = '(v,ind) in controlAnswers'>
                                          <label class="ns-container" :class="v.class" @mousedown="toggleControl(o.id,ind, 'checked-circle');">
                                              <span class='text-dark font-weight-bolder' style='font-size:1em' >@{{v.text}} </span>
                                              <span clasas='text-muted text-sm'>@{{v.label}} </span>
                                              <!-- <input type="checkbox" class='control-to-be-checked' :checked='checkControl(o.id,0)'/> -->
                                              <div class="mod-chbox-checkmark" :class="{'hovered-checkmark': checkControl(o.id,ind)}" :id="chboxId(o.id, ind, 'control')" style='border-radius:50%'>
                                                   <span class='' :class="{'checked-circle': checkControl(o.id,ind)}" :id="checkedId(o.id, ind, 'control')"></span>
                                              </div>
                                          </label>
                                    </div>
                                </div>
                          </div>
                      </div>
                    </div>

                    <div v-if='ocon.length > 0'>
                      <div class="card rounded-10 ns-font-family ns-dark-color mt-4 mb-0 p-2 shadow-none border-0 remove-control-border"
                           v-for='(c,idx) in data.newControls'
                           style='border-radius:0 !important;box-shadow:2px 2px 4px lightgrey, -2px -2px 4px lightgrey !important;'>
                           <div class='d-flex'>
                               <div style='width:85%'>
                                   <p class='p-4 pb-0 mb-0 text-secondary'
                                      style='font-size:1.2rem;'>დაამატეთ კონტროლის ზომა
                                      (<span class='text-muted text-sm'>არასავალდებულო<span>) </p>
                                </div>
                               <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                                   <button v-if='idx == data.newControls.length-1' class='text-orange bg-white px-2 py-1 m-btn' @click="addInArray('newControls')"
                                           style='border:0 !important;'
                                    ><i class='fa fa-plus pr-2'></i>ახალი
                                    </button>

                                    <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('newControls', idx)"
                                           style='border:0 !important;'
                                    ><i class='fa fa-remove pr-2'></i>წაშლა
                                    </button>

                                    <div class='hoverable-underline' :class="{'bg-danger' : idx != data.newControls.length -1, 'bg-warning': idx == data.newControls.length -1}"></div>
                                </div>
                            </div>

                           <div class='card-body ns-input-container pl-4 pb-4'>
                                   <textarea type="text"
                                             rows='1'
                                             class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                                             placeholder='Your answer here'
                                             v-model='c.value'
                                             onclick="$(this).next().addClass('ns-test-underline');customize(this)"
                                             onblur ="$(this).next().removeClass('ns-test-underline');uncustomize(this)"
                                             ></textarea>
                                   <div class="ns-underline" style='background-color:orange !important'></div>
                             </div>
                      </div>
                    </div>


                    <div v-if='canShowOcon'>

                        <div class='pb-0 border mt-3' style='box-shadow:2px 2px 4px lightgrey, -2px -2px 4px lightgrey'>
                            <div v-for = 'c in combined'>
                                  <div class='card ns-font-family ns-dark-color shadow-none mb-0' :class='c.class' :style='c.style'>
                                       <div class="card-body ml-3 mt-2 mb-2">
                                            <p class='mb-5 text-lg'> @{{c.text}} </p>
                                            <div v-for = '(d,i) in c.data'>
                                                <label class="ns-container mt-3" @mousedown='c.update(i,0)' style='font-size:.95em; color:rgba(0,0,0,.8);'>@{{d.name}}
                                                    <div class="mod-chbox-checkmark" :class="{'hovered-checkmark' : c.check(i, d.id)}" :id='chboxId(d.id,0, c.type)'>
                                                        <span :class="{'checked' : c.check(i, d.id)}" :id='checkedId(d.id,0,c.type)'></span>
                                                    </div>
                                                    <span class='hover-chbox'></span>
                                               </label>
                                            </div>
                                       </div>
                                  </div>
                             </div>
                        </div>

                        <div>
                           <div class="card rounded-10 ns-font-family ns-dark-color my-4 p-2 ns-card partial-shadow"
                                style='border-top:10px solid purple !important;'
                                v-for = '(u,idx) in data.newUdangers'
                                >
                                <div class='d-flex'>
                                   <div style='width:85%'>
                                       <p class='p-4 pb-0 mb-0 text-secondary'
                                          style='font-size:1.2rem;'> ვინ იმყოფება საფრთხის ქვეშ
                                          (<span class='text-muted text-sm'>არასავალდებულო<span>) </p>
                                    </div>
                                   <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                                       <button v-if='idx == data.newUdangers.length-1' class='bg-white px-2 py-1 m-btn text-purple' @click="addInArray('newUdangers')"
                                               style='border:0 !important;'
                                        ><i class='fa fa-plus pr-2'></i>ახალი
                                        </button>

                                        <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('newUdangers',idx)"
                                               style='border:0 !important;'
                                        ><i class='fa fa-remove pr-2'></i>წაშლა
                                        </button>

                                        <div class='hoverable-underline' :class="{'bg-danger' : idx != data.newUdangers.length -1, 'bg-purple': idx == data.newUdangers.length -1}"></div>
                                    </div>
                                </div>

                                <div class='ns-input-container pl-4 pb-4'>
                                        <textarea type="text"
                                                  rows='1'
                                                  class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                                                  placeholder='დაამატეთ'
                                                  v-model = 'u.value'
                                                  onclick="$(this).next().addClass('ns-test-underline')"
                                                  onblur ="$(this).next().removeClass('ns-test-underline')"
                                                  ></textarea>
                                        <div class="ns-underline" style='background-color:purple !important'></div>
                                 </div>
                             </div>
                        </div>

                        <div v-for = '(p,idx) in data.rpersons'>
                         <div class="card rounded-10 ns-font-family ns-dark-color ns-card partial-shadow my-4 p-2" style=''>
                               <!-- <p class='p-4 pb-0 mb-0 text-secondary' style='font-size:1.2rem;'>დაამატეთ პასუხისმგებელი პირი  </p> -->
                               
                               <div class='d-flex'>
                                   <div style='width:85%'>
                                       <p class='p-4 pb-0 mb-0 text-secondary'
                                          style='font-size:1.2rem;'> დაამატეთ პასუხისმგებელი პირი </p>
                                    </div>
                                   <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                                       <button v-if='idx == data.rpersons.length-1' class='bg-white px-2 py-1 m-btn text-blue' @click="addInArray('rpersons')"
                                               style='border:0 !important;'
                                        ><i class='fa fa-plus pr-2'></i>ახალი
                                        </button>

                                        <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('rpersons',idx)"
                                               style='border:0 !important;'
                                        ><i class='fa fa-remove pr-2'></i>წაშლა
                                        </button>

                                        <div class='hoverable-underline' :class="{'bg-danger' : idx != data.rpersons.length -1, 'bg-blue': idx == data.rpersons.length -1}"></div>
                                    </div>
                                </div>
                               
                               <div class='card-body ns-input-container pl-4 pb-4'>
                                       <textarea type="text"
                                                 rows='1'
                                                 class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                                                 placeholder='Your answer here'
                                                 v-model='p.value'
                                                 onclick="$(this).next().addClass('ns-test-underline')"
                                                 onblur ="$(this).next().removeClass('ns-test-underline')"
                                                 ></textarea>
                                       <div class="ns-underline" id='test-underline'></div>
                                 </div>
                         </div>
                        </div>

                        <div v-for = '(e,idx) in data.etimes'>
                         <div class="card rounded-10 ns-font-family ns-dark-color ns-card partial-shadow my-4 p-2" style=''>
                                 <!-- <p class='p-4 pb-0 mb-0 ns-font-family text-lg'> მიუთითეთ შესრულების ვადა </p> -->
                                
                                 <div class='d-flex'>
                                   <div style='width:85%'>
                                       <p class='p-4 pb-0 mb-0 text-secondary'
                                          style='font-size:1.2rem;'> დაამატეთ შესრულების ვადა </p>
                                    </div>
                                   <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                                       <button v-if='idx == data.etimes.length-1' class='bg-white px-2 py-1 m-btn text-blue' @click="addInArray('etimes')"
                                               style='border:0 !important;'
                                        ><i class='fa fa-plus pr-2'></i>ახალი
                                        </button>

                                        <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('etimes',idx)"
                                               style='border:0 !important;'
                                        ><i class='fa fa-remove pr-2'></i>წაშლა
                                        </button>

                                        <div class='hoverable-underline' :class="{'bg-danger' : idx != data.etimes.length -1, 'bg-blue': idx == data.etimes.length -1}"></div>
                                    </div>
                                </div>
                                
                                
                                 <div class='card-body ns-input-container pl-4 pb-4'>
                                       <div class='input-group date' id='datetimepicker1'>
                                           <input type='date' v-model='e.value' class="form-control w-50" />
                                       </div>
                                 </div>
                         </div>
                        </div>
                   </div>

                <div class='mb-4 animate-submit-button'>
                      <button class='btn btn-primary bg-primary hovered-ns-button border-info capitalize text-sm px-4 py-1' id='data-submit'
                             @click='submit()'
                      ><span class="spinner-border spinner-border-sm p-2 mr-2 d-none" id='data-processing' style='margin-left:-.6rem;'></span>
                        Submit
                     </button>
                </div>

                <form method='get' action='docs/show-data'  id='red_to_fin'>
                     @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

        function uploadImage(ev, ind){
             ev.preventDefault()
             $(`#imageupload${ind}`).click()
        }

        function clearUploadedImage(ind){
             $1(`docimage${ind}`).src = ''
             $1(`imageupload${ind}`).value = ''
        }

        function customize(el){
            $(el).parent().parent().removeClass('remove-control-border').addClass('add-control-border')
        }

        function uncustomize(el){
            $(el).parent().parent().removeClass('add-control-border').addClass('remove-control-border')
        }


</script>

@endsection
