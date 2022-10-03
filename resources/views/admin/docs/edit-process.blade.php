@extends('layouts/zim')







@section('header')
    <style>
        .my-btn {
            background: white;
            border: 1px solid #009999;
            color: #009999;
        }

        .my-btn:hover {
            background: #009999 !important;
            color: white;
        }

        .my-del-btn {
            background: white;
            border: 1px solid #ee5c2d !important;
            color: #ee5c2d;
        }

        .my-del-btn:hover {
            background: #ee5c2d !important;
            color: white;
        }

        .my-bg {
            background: #009999;
        }

   </style>
@endsection

<?php $color = '#009999';
      $delcolor = '#ee5c2d';
?>

@section('content')

<div class="text-center m-4" style="width: 96%">
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 ml-5 mr-5" id="main-part">

                @if (Session('message'))
                   <p class='alert my-bg text-left text-white'>
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

                      <div class='card border-0 partial-shadow' style=''>
                             <div class='d-flex'>
                                 <div class='p-3 w-100'>
                                    <div class='form-group mb-4'>
                                          <textarea type='text' class='form-control autoresize'
                                                placeholder='{{ __("დაამატეთ პროცესი") }}'
                                                oninput="$(window).trigger('autoresize')"
                                                name='name'>{{$process->name}}</textarea>
                                    </div>
                                    @error('name')
                                       <p class='text-sm text-danger text-left'> {{$message}} </p>
                                    @enderror

                                     <hr />

                                     <div class='d-md-flex d-block'>
                                         <div class='text-left'>
                                             <button class='btn my-btn border-info'> {{ __("განახლება") }} </button>
                                         </div>

                                         <div class='text-left ml-md-2 ml-0'>
                                             <button class='btn my-del-btn' onclick="event.preventDefault();$1('process-delete').submit(); "> {{ __("წაშლა") }} </button>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                      </div>




                </form>
                <form method='post' action='delete' id='process-delete'>
                                   @csrf
                                   @method('delete')
                </form>


                    @include('admin.docs._docs_tables', [
                                   'has' => $ydanger,
                                   'nhas' => $ndanger,
                                   'color' => $color,
                                   'delcolor' => $delcolor,
                                   'type' => 'danger',
                                   'typeName' => __("საფრთხე")
                    ])

{{--                <div class='card mt-4 text-left shadow-none rounded-10 ns-border-bottom' style='border-top:7px solid rgb(0,0,200)'>--}}
{{--                    <h4 class='p-3 text-lg ns-font-family ns-font-dark'> {{ __("ყველა შემავალი საფრთხე") }} </h4>--}}
{{--                    <div class='card-body pl-2 pt-2'>--}}
{{--                         @foreach ($ydanger as $ind => $d)--}}
{{--                             <div class='d-flex'>--}}
{{--                                    <div style='width:85%;'>--}}
{{--                                         <a href='../../danger/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'> <b>{{$ind + 1}}.</b> {{$d->name}} </a>--}}
{{--                                    </div>--}}
{{--                                    <div style='wdith:15%'>--}}
{{--                                         <a href='edit/{{$d->id}}/detach'--}}
{{--                                            class='btn btn-outline-danger text-danger text-sm rounded-pill capitalize px-md-3 mx-0 py-1'--}}
{{--                                            style='font-size:.7em;min-width:70px !important;'> Uncheck </a>--}}
{{--                                    </div>--}}
{{--                            </div>--}}
{{--                         @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class='card text-left mt-2 pb-3 shadow-none rounded-10 ns-border-bottom' style='border-top:5px solid rgb(200,0,0);'>--}}
{{--                <div class='d-flex'>--}}
{{--                      <h4 class='p-3 text-danger' style='text-shadow:1px 1px 3px lightgrey;'> {{ __("სხვა") }} </h4>--}}
{{--                      <div class='ml-auto pr-4 pt-2'>--}}
{{--                          <button class='btn btn-outline-primary px-3 py-1 rounded-pill capitalize'--}}
{{--                                  onclick="toggleCollapseClick(this, 'other-dangers')"--}}
{{--                          > show </button>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                    <div class='card-body pl-2 pt-2 d-none' id='other-dangers'>--}}
{{--                         @foreach ($ndanger as $ind => $d)--}}
{{--                             <div class='d-flex'>--}}
{{--                                    <div style='width:85%;'>--}}
{{--                                         <a href='../../danger/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'><b>{{$ind + 1}}.</b> {{$d->name}} </a>--}}
{{--                                    </div>--}}
{{--                                    <div style='wdith:15%'>--}}
{{--                                         <a href='edit/{{$d->id}}/attach'  class='btn btn-outline-success text-success text-sm rounded-pill capitalize px-3 py-1 ml-1' style='font-size:.7em;'> Check </a>--}}
{{--                                    </div>--}}
{{--                            </div>--}}
{{--                         @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--           </div>--}}
    </div>
</div>

    <script type="application/javascript">
        function toggleCollapseHandler(obj, clname, bgc) {
            if ($(`.${clname}`).hasClass('d-none')) {
                $(`.${clname}`).removeClass('d-none');
                $(obj).css({'background-color': bgc, 'color': 'white'})
            } else {
                $(`.${clname}`).addClass('d-none')
                $(obj).css({'background-color': 'white', 'color': bgc})
            }
        }
    </script>

@endsection
