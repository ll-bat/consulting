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
    </style>
@endsection

<?php $color = '#009999';
      $delcolor = '#ee5c2d';
?>

@section('content')

    <div class="zim-container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12 ml-5 mr-5" id="main-part">

            @if (Session('message'))
                <p class='alert text-left text-white mb-4' style="background: #009999">
                    {{Session('message')}}
                </p>
            @endif

            @if (Session('error'))
                <p class='alert alert-danger text-white text-left'>
                    {{Session('error')}}
                </p>
            @endif

            <form method='post' action='update' id="form-update">
                @csrf

                <div class='card border-0 partial-shadow p-1' style=''>
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
                                   value="{{$danger->k}}"
                                   style='width:3.5rem;border-bottom:1px solid orange !important;border-radius:0'
                                   name='k'/>
                        </div>
                    </div>
                </div>

                <div class='card border-0 partial-shadow pb-2 '
                     style=''>
                    <div class="card-body text-left p-3">
                        <p class='mt-2 mb-4 font-weight-bolder' style="color: #009999"> აირჩიეთ პროცესი </p>
                        <div class="mt-4">
                            @foreach($procs as $proc)
                                <label class="ns-container mt-3 ml-2 text-secondary"
                                       style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$proc->name}}
                                    <input type="checkbox"
                                           name="process[]"
                                           value="{{ $proc->id }}"
                                           @if(in_array($proc->id, $list)) checked @endif
                                    >
                                    <span class="chbox-checkmark" style=""></span>
                                </label>
                            @endforeach
                        </div>

                        @if ($procs->count() == 0)
                            <p class='text-secondary pl-3'> პროცესები არ არის </p>
                        @endif

                        @error('process')
                        <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                        @enderror
                    </div>

                    <hr style="width:94%;margin-left:3%;"/>

                    <div class='d-flex m-2 mx-3'>
                        <div class=''>
                            <button class='btn my-btn' onclick="updateHandler(this)"> განახლება</button>
                        </div>

                        <div class='ml-2'>
                            <button class='btn my-del-btn' style = 'border-width: 1px !important'
                                    onclick="event.preventDefault();$1('danger-delete').submit(); "> წაშლა
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <form method='post' action='delete' id='danger-delete'>
                @csrf
                @method('delete')
            </form>


            {{--            <div class='card mt-4 text-left ns-font-family  shadow-none rounded-10 ns-border-bottom'--}}
            {{--                 style='border-top:10px solid blue'>--}}
            {{--                <h4 class='p-3'> ყველა შემავალი კონტროლის ზომა </h4>--}}
            {{--                <div class='card-body pl-2 pt-2'>--}}
            {{--                    @foreach ($ycontrol as $ind => $d)--}}
            {{--                        <div class='d-flex my-2'>--}}
            {{--                            <div style='width:85%;'>--}}
            {{--                                <a href='../../control/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'>--}}
            {{--                                    <b>{{$ind + 1}}.</b> {{$d->name}} </a>--}}
            {{--                            </div>--}}
            {{--                            <div style='width:15%'>--}}
            {{--                                <a href='edit/{{$d->id}}/detach'--}}
            {{--                                   class='btn btn-outline-danger text-danger text-sm rounded-pill capitalize px-md-3 px-0 py-1'--}}
            {{--                                   style='font-size:.7em;min-width:70px !important;'> Uncheck </a>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    @endforeach--}}
            {{--                </div>--}}
            {{--            </div>--}}


{{--            <ul class="list-group text-left mt-5 mb-4" style="border-radius:5px;">--}}
{{--                <li class="list-group-item font-weight-bold py-3 pointer"--}}
{{--                    onclick="toggleCollapseHandler(this, 'all-in-controls-panel', '#009999')"--}}
{{--                    style="background-color: #009999;border: 1px solid #009999;color: white;">--}}
{{--                    <i class='fa fa-plus float-left'></i>--}}
{{--                    <span class="pl-4"> ყველა შემავალი კონტროლის ზომა </span>--}}
{{--                </li>--}}
{{--                @foreach($ycontrol as $ind => $d)--}}
{{--                    <li class="list-group-item all-in-controls-panel pl-4"--}}
{{--                        style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);--}}
{{--                            border-left: 1px solid rgba(0,0,0,0.09);--}}
{{--                            border-right: 1px solid rgba(0,0,0,.09);--}}
{{--                        @if ($ind == count($ycontrol)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif--}}
{{--                            ">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-9 col-lg-9 col-xl-10 col-12">--}}
{{--                                <a href='../../control/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'>--}}
{{--                                    <b>{{$ind + 1}}.</b> {{$d->name}} </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3 col-lg-3 col-xl-2 col-2 this-div">--}}
{{--                                <a href='edit/{{$d->id}}/detach'--}}
{{--                                   class='text-sm capitalize px-md-3 px-0 py-1'--}}
{{--                                   style='font-size:.8em;color:indianred '> ამოშლა </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}


{{--            <ul class="list-group text-left mt-0 mb-4" style="border-radius:5px;">--}}
{{--                <li class="list-group-item font-weight-bold py-3 pointer"--}}
{{--                    onclick="toggleCollapseHandler(this, 'controls-panel', '{{$color}}')"--}}
{{--                    style="border: 1px solid {{$color}}; color: {{$color}};">--}}
{{--                    <i class='fa fa-plus float-left'></i>--}}
{{--                    <span class="pl-4"> ყველა სხვა კონტროლის ზომა </span>--}}
{{--                </li>--}}
{{--                @foreach($ncontrol as $ind => $d)--}}
{{--                    <li class="list-group-item pl-4 controls-panel d-none"--}}
{{--                        style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);--}}
{{--                            border-left: 1px solid rgba(0,0,0,0.09);--}}
{{--                            border-right: 1px solid rgba(0,0,0,.09);--}}
{{--                        @if ($ind == count($ycontrol)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif--}}
{{--                            ">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-10 col-12">--}}
{{--                                <a href='../../control/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'>--}}
{{--                                    <b>{{$ind + 1}}.</b> {{$d->name}} </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2 col-2 text-md-center text-left this-div">--}}
{{--                                <a href='edit/{{$d->id}}/attach'--}}
{{--                                   class='text-sm capitalize px-md-3 px-0 py-1'--}}
{{--                                   style='font-size:.8em;color:#009999 '> დამატება </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}

                @include('admin.docs._docs_tables', [
                          'has' => $ycontrol,
                          'nhas' => $ncontrol,
                          'type' => 'control',
                          'color' => $color,
                          'delcolor' => $delcolor,
                          'typeName' => 'კონტროლის ზომა'
                        ])
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

        function updateHandler(elem){

        }

        // window.addEventListener('resize', (e) => {
        //     if (window.innerWidth < 1600) {
        //         $('#main-column').removeClass('col-xl-6').addClass('col-xl-7')
        //     } else {
        //         $('#main-column').removeClass('col-xl-7').addClass('col-xl-6')
        //     }
        // })
        //
        // window.dispatchEvent(new Event('resize'))

    </script>

@endsection
