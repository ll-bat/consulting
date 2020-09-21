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

                @if (Session('error'))
                   <p class='alert alert-danger text-left text-white'> 
                         {{Session('error')}} 
                   </p>
                @endif
                 
                <form method='post' action='update'>
                   @csrf

                      <div class='card shadow-none' style='border-left:5px solid grey'>
                             <div class='d-flex'>
                                 <div class='mx-2 mt-2 w-100'>
                                    <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize' 
                                                placeholder='დაამატეთ პროცესი' 
                                                oninput="$(window).trigger('autoresize')"
                                                name='name'>{{$process->name}}</textarea>
                                    </div>
                                    @error('name')
                                       <p class='text-sm text-danger text-left'> {{$message}} </p>
                                    @enderror
                                 </div>
                             </div>
                      </div> 
      
              
      
                      <div class='d-md-flex d-block'>
                         <div class='text-left'>
                              <button class='btn btn-primary border-info'> Update </button>    
                         </div>
     
                         <div class='text-left ml-md-2 ml-0'>
                              <button class='btn btn-outline-danger' onclick="event.preventDefault();$1('process-delete').submit(); "> Delete </button>    
                         </div>
                    </div>
                </form>
                <form method='post' action='delete' id='process-delete'>
                                   @csrf 
                                   @method('delete')
                </form>

                <div class='card mt-4 text-left shadow-none rounded-10 ns-border-bottom' style='border-top:7px solid rgb(0,0,200)'>
                    <h4 class='p-3 text-lg ns-font-family ns-font-dark'> ყველა შემავალი საფრთხე </h4>
                    <div class='card-body pl-2 pt-2'>
                         @foreach ($ydanger as $ind => $d)
                             <div class='d-flex'>
                                    <div style='width:85%;'>
                                         <a href='../../danger/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'> <b>{{$ind + 1}}.</b> {{$d->name}} </a>
                                    </div>
                                    <div style='wdith:15%'>
                                         <a href='edit/{{$d->id}}/detach'  
                                            class='btn btn-outline-danger text-danger text-sm rounded-pill capitalize px-md-3 mx-0 py-1' 
                                            style='font-size:.7em;min-width:70px !important;'> Uncheck </a>
                                    </div>
                            </div>
                         @endforeach
                    </div>
                </div>

                <div class='card text-left mt-2 pb-3 shadow-none rounded-10 ns-border-bottom' style='border-top:5px solid rgb(200,0,0);'>
                    <h4 class='p-3 text-danger'> სხვა </h4>   
                    <div class='card-body pl-2 pt-2'>
                         @foreach ($ndanger as $ind => $d)
                             <div class='d-flex'>
                                    <div style='width:85%;'>
                                         <a href='../../danger/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'><b>{{$ind + 1}}.</b> {{$d->name}} </a>
                                    </div>
                                    <div style='wdith:15%'>
                                         <a href='edit/{{$d->id}}/attach'  class='btn btn-outline-success text-success text-sm rounded-pill capitalize px-3 py-1 ml-1' style='font-size:.7em;'> Check </a>
                                    </div>
                            </div>
                         @endforeach
                    </div>
                </div>

           </div>
    </div>
</div>

<script type="application/javascript">
      

</script>

@endsection