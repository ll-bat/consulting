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
                     <a class='btn btn-outline-secondary' href="/user/docs/added-by-users">
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

                      <div class='card border-0 partial-shadow' style=''>
                             <div class='d-flex'>
                                 <div class='mx-2 mt-2 w-100'>
                                    <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize' 
                                                placeholder='დაამატეთ' 
                                                oninput="$(window).trigger('autoresize')"
                                                name='name'>{{$udanger->name}}</textarea>
                                    </div>
                                    @error('name')
                                       <p class='text-sm text-danger text-left'> {{$message}} </p>
                                    @enderror
                                 </div>
                             </div>
                      </div>

                      <div class='d-md-flex d-block'>
                         <div class='text-left'>
                              <button class='btn btn-primary border-info'> დამატება </button>    
                         </div>
     
                         <div class='text-left ml-md-2 ml-0'>
                              <button class='btn btn-outline-danger' 
                                      onclick="event.preventDefault();$1('control-delete').submit(); "> 
                              წაშლა </button>    
                         </div>
                    </div>
                </form>
                <form method='post' action='delete' id='control-delete'>
                                   @csrf 

                </form>

           </div>
    </div>
</div>

<script type="application/javascript">
      

</script>

@endsection