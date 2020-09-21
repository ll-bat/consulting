@extends('layouts/zim')







@section('header')
    <style>

   </style>
@endsection



@section('content')

<div class="container text-center position-absolute my-5">
        <div class="row justify-content-center">
            
        <div class='position-absolute ml-3 ml-md-0 mb-3' style='left:0;'>
               <div class='position-md-absolute position-sm-relative position-relative' style='z-index:1;left:0;margin-top:-.5rem;'>
                     <a class='btn btn-outline-secondary' href="/user/docs">
                         Back 
                     </a>
                </div>
           </div> 

            <div class="col-lg-7 col-md-10 col-sm-12 col-12 mr-4 ml-5 mr-5 mt-md-0 mt-sm-5 mt-5">
                
                @if (Session('message'))
                   <p class='alert alert-success text-left text-white'> 
                         {{Session('message')}} 
                   </p>
                @endif

                  <div class='card card-user mt-3 text-left rounded-10 shadow-none left-colored-border top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid #003366'>
                     <div class='card-title mb-2 mt-3 pointer' onclick="toggleCollapse(this,'add-new-control')">
                          <i class='fa fa-plus float-left ml-3 mt-1'></i>
                          <p class='pl-5 font-weight-bold'> ახალი კონტროლის ზომა </p>
                     </div>
                  </div>

                  <form method='post' action='new-control' class='d-none' id='add-new-control'>
                     @csrf

                      <div class='card shadow-none' style='border-left:5px solid #003366'>
                             <div class='d-flex'>
                                 <div class='mx-2 mt-2 w-75'>
                                    <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize' 
                                                placeholder='დაამატეთ კონტროლის ზომა' 
                                                oninput="$(window).trigger('autoresize')"
                                                name='name'>{{old('name')}}</textarea>
                                    </div>
                                    @error('name')
                                       <p class='text-sm text-danger text-left'> {{$message}} </p>
                                    @enderror
                                 </div>
                                 <div class='mx-2 mt-2 text-left'>
                                       <input type='text' class='form-control border-0 autoresize' 
                                              placeholder='K:1'
                                              name='k'
                                              value = "{{old('k')}}"
                                              style='width:3rem;border-bottom:1px solid orange !important;border-radius:0' name='k' />
                                 </div>
                             </div>

                             <label class="ns-container text-secondary text-left ml-2" style='font-size:.95em; color:rgba(0,0,0,.8);'> ამცირებს პოტენციურ ზიანს
                                <input type="checkbox"
                                       name="rploss"
                                       value="1"
                                       @if (old('rploss') == '1') checked @endif
                                >
                                <span class="chbox-checkmark"></span>
                           </label>
                      </div> 
      
                      <div class='card text-left rounded-10 top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid #003366'>   
                           <div class='card-body ml-2 pl-1 pb-4' required>
                                <p class='ml-1 mt-2 mb-4 text-primary font-weight-bolder'> აირჩიეთ საფრთხე </p>
          
                                @foreach($dangers as $danger)
                                <label class="ns-container mt-3 text-secondary" style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$danger->name}}
                                     <input type="checkbox"
                                            name="danger[]"
                                            value="{{ $danger->id }}"
                                            @if(is_array(old('danger')) && in_array($danger->id, old('danger'))) checked @endif
                                     >
                                     <span class="chbox-checkmark"></span>
                                </label>
                                @endforeach

                                @if ($dangers->count() == 0)
                                   <p class='text-secondary font-weight-bolder ml-3'> საფრთხეები არ არის </p>
                                @endif

                                @error('danger')
                                     <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                                @enderror
                            </div>
                      </div>
      
                      <div class='text-left'>
                               <button class='btn btn-primary border-0'> create </button>    
                      </div>

                </form>

                <div class='card card-user mt-3 text-left rounded-10 shadow-none left-colored-border top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid #003366'>
                     <div class='card-title mb-2 mt-3 pointer' onclick='toggleCollapse()'>
                          <i class='fa fa-plus float-left ml-3 mt-1'></i>
                          <p class='pl-5 font-weight-bold'> ყველა კონტროლის ზომა </p>
                     </div>
                     
                     <div class='pl-4' style=''>
                           @foreach($controls as $ind => $control)
                           <div class='d-none controls-panel pb-1'>
                                  <div style='width:85%'>
                                       <p class="@if(Session('created') && $ind == $control->count()-1) font-weight-bolder @else text-muted @endif"> {{$ind + 1}}. {{$control->name}} </p>
                                  </div>
                                  <div class='d-flex' style='width:15%'>
                                                                           
                                       <div class='w-100 h-100 this-div'>
                                            <div class='position-absolute this-button' style='width:.2rem;height:2rem;background-color:#003366'></div>
                                            <a class='btn this-color' href='control/{{$control->id}}/edit'
                                                    style='margin-top:-.1rem;background-color:transparent !important;color:blue'> edit 
                                            </a>
                                       </div>
                                  </div>
                             </div>
                           @endforeach

                           @if ($controls->count() == 0)
                               <div class='d-none controls-panel pb-1'>
                                   <p class='text-secondary'> თქვენ არ გაქვთ კონტროლის ზომები </p>
                                </div>                     
                           @endif
                         </div>
                  </div>

           </div>
    </div>
</div>

<script type="application/javascript">
      function toggleCollapse(obj, id){
         if (obj){
             obj.parentNode.remove()
             remove($1(id), 'd-none')
             return
         }

         if ($('.controls-panel').hasClass('d-none'))
           $('.controls-panel').removeClass('d-none').addClass('d-flex')
         else  $('.controls-panel').removeClass('d-flex').addClass('d-none')
      }

      @if (Session('created')) toggleCollapse() @endif

</script>

@endsection