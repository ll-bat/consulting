@extends('layouts/zim')







@section('header')
    <style>

   </style>
@endsection



@section('content')

<div class="zim-container mb-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mr-4 ml-5 mr-5" id='app'>
               <div class='card rounded-10 shadow-none pb-3' style='border-left:5px solid orange'>
                      <h5 class='text-left p-4' style='color:orange; text-shadow:1px 1px .5px blue'> აირჩიეთ პროცესი </h5>
                      <div v-for='p in process' class='text-left pl-2'>
                           <div class='card-body ml-2 pl-1 pb-1'>
                               <label class="ns-container mt-1" @click='choose(p.id)'  style='font-size:.95em; color:rgba(0,0,0,.8);'>@{{p.name}}
                                   <input type="radio" name='same'>
                                   <span class="checkmark" style='border-radius:50%'></span>
                              </label>
                           </div>
                      </div>
                </div>

                <div class='card rounded-10 shadow-none pb-3' style='border-left:5px solid blue'>
                      <h5 class='text-left p-4' style='color:blue; text-shadow:1px 1px .5px lightblue'> შემავალი საფრთხე </h5>
                      <div v-for='o in odan' class='text-left pl-2'>
                           <div class='card-body ml-2 pl-1 pt-0 pb-0'>
                               <div class='d-flex'>
                                    <div style='width:85%'>
                                          <label class="ns-container mt-1" @click='chooseOcon(o.id)'  style='font-size:.95em; color:rgba(0,0,0,.8);'>@{{o.name}}
                                              <input type="radio" name='heresame' class='to-be-checked'>
                                              <span class="checkmark" style='border-radius:50%'></span>
                                         </label>
                                    </div>
                                    <div style='width:15%'>
                                          <a :href='linkToDanger(o.id)' class='btn btn-outline-primary rounded-pill text-primary px-3 py-1' style='font-size:.8em;'>Edit</a>
                                    </div>
                              </div>
                           </div>
                      </div>
                </div>

                <div class='card rounded-10 shadow-none pb-3' style='border-left:5px solid #00b36b' >
                      <h5 class='text-left p-4' style='color:#00b36b; text-shadow:1px 1px .5px #00ff99'> შემავალი კონტროლის ზომები </h5>
                      <div v-for='o in ocon' class='text-left pl-2'>
                           <div class='card-body ml-2 pl-1 pb-1'>
                                <div class='d-flex'>
                                      <div style='width:85%'>
                                            <i class="fa fa-check text-success float-left ml-0 pl-1 pt-1 pr-2"></i>
                                            <p style='font-size:.95em; color:rgba(0,0,0,.8);'> @{{o.name}} </p>
                                      </div>
                                      <div style='width:15%'>
                                            <a :href='linkToControl(o.id)'  class='btn btn-outline-success rounded-pill text-success px-3 py-1' style='font-size:.8em;'>Edit</a>
                                     </div>
                               </div>
                           </div>
                      </div>
                </div>

        </div>

    </div>
</div>

<script type="application/javascript">
      function toggleCollapse(){
         $('.controls-panel').removeClass('d-none').addClass('d-flex')
      }

</script>

@endsection
