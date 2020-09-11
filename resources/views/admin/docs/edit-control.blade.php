@extends('layouts/zim')







@section('header')
    <style>
        
   </style>
@endsection



@section('content')

<div class="container text-center position-absolute">
        <div class="row justify-content-center">
            
        <div class='position-absolute ml-3 ml-md-0 mb-3' style='left:0;'>
               <div class='position-md-absolute position-sm-relative position-relative' style='z-index:1;left:0;margin-top:-.5rem;'>
                     <a class='btn btn-outline-secondary' href="/user/docs/new-control">
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
                 
                <form method='post' action='update'>
                   @csrf

                      <div class='card shadow-none' style='border-left:5px solid #003366'>
                             <div class='d-flex'>
                                 <div class='mx-2 mt-2 w-75'>
                                    <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize' 
                                                placeholder='დაამატეთ კონტროლის ზომა' 
                                                oninput="$(window).trigger('autoresize')"
                                                name='name'>{{$control->name}}</textarea>
                                    </div>
                                    @error('name')
                                       <p class='text-sm text-danger text-left'> {{$message}} </p>
                                    @enderror
                                 </div>
                                 <div class='mx-2 mt-2 text-left'>
                                       <input type='text' class='form-control border-0 autoresize' 
                                              placeholder='K:1'
                                              name='k'
                                              value = "{{$control->k}}"
                                              style='width:3rem;border-bottom:1px solid orange !important;border-radius:0' name='k' />
                                 </div>
                             </div>

                             <label class="ns-container text-secondary text-left ml-2" style='font-size:.95em; color:rgba(0,0,0,.8);'> ამცირებს პოტენციურ ზიანს
                                <input type="checkbox"
                                       name="rploss"
                                       value="1"
                                       @if ($control->hasRPLoss()) checked @endif
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
                                            @if(in_array($danger->id, $list)) checked @endif
                                     >
                                     <span class="chbox-checkmark"></span>
                                </label>
                                @endforeach

                                @error('danger')
                                     <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                                @enderror
                            </div>
                      </div>
      
                      <div class='d-md-flex d-block'>
                         <div class='text-left'>
                              <button class='btn btn-primary border-info'> Update </button>    
                         </div>
     
                         <div class='text-left ml-md-2 ml-0'>
                              <button class='btn btn-outline-danger' onclick="event.preventDefault();$1('control-delete').submit(); "> Delete </button>    
                         </div>
                    </div>
                </form>
                <form method='post' action='delete' id='control-delete'>
                                   @csrf 
                                   @method('delete')
                </form>

           </div>
    </div>
</div>

<script type="application/javascript">
      

</script>

@endsection