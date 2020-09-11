@extends('layouts/zim')










@section('header')
    <style>
       

       .this-icon {
           transition: all .4 ease-in;
        }
        .this-icon:hover {
           font-weight:bolder;
        }
   </style>
@endsection



@section('content')

<div class="container text-center position-absolute">
        <div class="row justify-content-center">
           <div class='position-absolute ml-3 ml-md-0 mb-3' style='left:0;'>
               <div class='position-md-absolute position-sm-relative position-relative' style='z-index:1;left:0;margin-top:-.5rem;'>
                     <a class='btn btn-outline-secondary' href="/user/docs">
                         Back 
                     </a>
                </div>
           </div> 
            <div class="col-lg-7 col-md-10 col-sm-12 col-12 ml-5 mr-5 mt-md-0 mt-sm-5 mt-5">

           

                @if (Session('message'))
                   <p class='alert alert-success text-left text-white'> 
                         {{Session('message')}} 
                   </p>
                @endif

                <div class='card card-user mt-3 text-left rounded-10 shadow-none left-colored-border top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid #7733ff'>
                     <div class='card-title mb-2 mt-3 pointer' onclick='toggleCollapse()'>
                          <i class='fa fa-plus float-left ml-3 mt-1'></i>
                          <p class='pl-5 font-weight-bold' style='color:#7733ff'> ყველა საფრთხე </p>
                     </div>
                     
                     <div class='pl-4' style=''>
                           @foreach($dangers as $ind => $danger)
                           <div class='d-none dangers-panel pb-1'>
                                  <div style='width:80%'>
                                       <p class="text-muted @if(Session('created') && $ind == $dangers->count()-1) font-weight-bolder @endif"> {{$ind + 1}}. {{$danger->name}} </p>
                                  </div>
                                  <div class='d-flex' style='width:20%'>

                                      <a href='danger/{{$danger->id}}/copy' class='px-2 py-1 pointer'>
                                          <i class='fa fa-clone this-icon' style='color:#7733ff'></i>
                                       </a>
                                       <div class='w-100 h-100 this-div'>
                                            <a class='btn this-color' href='danger/{{$danger->id}}/edit'
                                                    style='margin-top:-.1rem;background-color:transparent !important;color:blue'> edit 
                                            </a>
                                       </div>
                                  </div>
                             </div>
                           @endforeach
                         </div>

                </div>

                   <form method='post' action='new-danger'>
                    @csrf
                
                    <div class='card' style='border-left:5px solid #7733ff !important;'>
                       <div class='d-flex'>
                           <div class='mx-2 mt-2 w-75'>
                              <div class='form-group'>
                                    <textarea type='text' 
                                           class='form-control autoresize' 
                                           placeholder='დაამატეთ საფრთხე'
                                           oninput="$(window).trigger('autoresize')" 
                                           name='name'>{{ old('name')}}</textarea>  
                              </div>
                              @error('name')
                                 <p class='text-sm text-danger text-left'> {{$message}} </p>
                              @enderror
                           </div>
                           <div class='mx-2 mt-2 text-left'>
                                 <input type='text' class='form-control border-0' 
                                        placeholder='K:1'
                                        name='k'
                                        value = "{{old('k')}}"
                                        style='width:3rem;border-bottom:1px solid orange !important;border-radius:0' name='k' />
                           </div>
                       </div>
                    </div>  
                 
                    <div class='card pb-2 rounded-10 ns-border-bottom top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid #7733ff !important;'>
                        <div class="card-body text-left">
                            <p class='mt-2 mb-4 font-weight-bolder' style='color:#7733ff'> აირჩიეთ პროცესი (<span class='text-muted'>მინ: 1</span>) </p>
                            @foreach($procs as $proc)
                            <label class="ns-container mt-3 text-secondary" style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$proc->name}}
                                <input type="checkbox"
                                       name="process[]"
                                       value="{{ $proc->id }}"
                                       @if(is_array(old('process')) && in_array($proc->id, old('process'))) checked @endif
                                >
                                <span class="chbox-checkmark"></span>
                           </label>
                            @endforeach

                            @error('process')
                               <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class='text-left'>
                         <button class='btn btn-primary border-0'> create </button>    
                    </div>
                </form>
        </div>
    </div>
</div>

<script type="application/javascript">
      function toggleCollapse(){
         if ($('.dangers-panel').hasClass('d-none'))
            $('.dangers-panel').removeClass('d-none').addClass('d-flex')
         else  $('.dangers-panel').removeClass('d-flex').addClass('d-none')
      }

      @if (Session('message'))
         toggleCollapse()
      @endif

</script>

@endsection