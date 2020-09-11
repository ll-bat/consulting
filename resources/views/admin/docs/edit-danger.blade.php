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
                     <a class='btn btn-outline-secondary' href="/user/docs/new-danger">
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

                @if (Session('error'))
                   <p class='alert alert-danger text-white text-left'> 
                         {{Session('error')}} 
                   </p>
                @endif

         <form method='post' action='update'>
                    @csrf
                
                    <div class='card' style='border-left:5px solid rgba(255,100,0,1);'>
                       <div class='d-flex'>
                           <div class='mx-2 mt-2 w-75'>
                              <div class='form-group'>
                                    <textarea type='text' 
                                           class='form-control autoresize' 
                                           placeholder='დაამატეთ საფრთხე'
                                           oninput="$(window).trigger('autoresize')" 
                                           name='name'>{{ $danger->name }}</textarea> 
                                </div>
                              @error('name')
                                 <p class='text-sm text-danger text-left'> {{$message}} </p>
                              @enderror
                           </div>
                           <div class='mx-2 mt-2 text-left'>
                                 <input type='text' class='form-control border-0' 
                                        placeholder='K:1'
                                        name='k'
                                        value = "{{$danger->k}}"
                                        style='width:3.5rem;border-bottom:1px solid orange !important;border-radius:0' name='k' />
                           </div>
                       </div>
                    </div>  
                 
                    <div class='card pb-2 rounded-10 shadow-none top-left-radius-0 bottom-left-radius-0' style='border-left:5px solid rgba(255,100,0,1);'>
                        <div class="card-body text-left">
                            <p class='mt-2 mb-4 text-primary font-weight-bolder'> აირჩიეთ პროცესი (<span class='text-muted'>მინ: 1</span>) </p>
                            @foreach($procs as $proc)
                            <label class="ns-container mt-3 text-secondary" style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$proc->name}}
                                <input type="checkbox"
                                       name="process[]"
                                       value="{{ $proc->id }}"
                                       @if(in_array($proc->id, $list)) checked @endif
                                >
                                <span class="chbox-checkmark"></span>
                           </label>
                            @endforeach

                            @error('process')
                               <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class='d-md-flex d-block'>
                         <div class='text-left'>
                              <button class='btn btn-primary border-info'> Update </button>    
                         </div>
     
                         <div class='text-left ml-md-2 ml-0'>
                              <button class='btn btn-outline-danger' onclick="event.preventDefault();$1('danger-delete').submit(); "> Delete </button>    
                         </div>
                    </div>
                </form>
                <form method='post' action='delete' id='danger-delete'>
                                    @csrf 
                                    @method('delete')
                </form>

                <div class='card mt-4 text-left ns-font-family  shadow-none rounded-10 ns-border-bottom' style='border-top:10px solid blue'>
                    <h4 class='p-3'> ყველა შემავალი კონტროლის ზომა </h4>
                    <div class='card-body pl-2 pt-2'>
                         @foreach ($ycontrol as $ind => $d)
                             <div class='d-flex'>
                                    <div style='width:85%;'>
                                         <a href='../../control/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'> <b>{{$ind + 1}}.</b> {{$d->name}} </a>
                                    </div>
                                    <div style='width:15%'>
                                         <a href='edit/{{$d->id}}/detach'  class='btn btn-outline-danger text-danger text-sm rounded-pill capitalize px-3 py-1' style='font-size:.7em;'> Uncheck </a>
                                    </div>
                            </div>
                         @endforeach
                    </div>
                </div>

                <div class='card text-left mt-2 pb-3 shadow-none rounded-10 ns-border-bottom' style='border-top:10px solid rgb(250,0,0);'>
                    <h4 class='p-3 text-danger' style='text-shadow:1px 1px 3px lightgrey;'> სხვა </h4>   
                    <div class='card-body pl-2 pt-2'>
                         @foreach ($ncontrol as $ind => $d)
                             <div class='d-flex'>
                                    <div style='width:85%;'>
                                         <a href='../../control/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'><b>{{$ind + 1}}.</b> {{$d->name}} </a>
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