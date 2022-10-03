@extends('layouts/zim')







@section('header')
    <style>

    </style>
@endsection



@section('content')

    <div class="zim-container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mr-4 ml-5 mr-5 mt-md-0 mt-sm-5 mt-5" id="main-part">
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
                                                    placeholder='{{ __("დაამატეთ") }}'
                                                    oninput="$(window).trigger('autoresize')"
                                                    name='name'>{{$udanger->name}}</textarea>
                                </div>
                                @error('name')
                                <p class='text-sm text-danger text-left'> {{$message}} </p>
                                @enderror

                                <div class='d-md-flex d-block'>
                                    <div class='text-left'>
                                        <button class='btn btn-outline-primary' style="border-width: 1px !important;"> {{ __("დამატება") }}</button>
                                    </div>

                                    <div class='text-left ml-md-2 ml-0'>
                                        <button class='btn btn-outline-danger'
                                                style="border-width: 1px !important;"
                                                data-confirm="{{ __('ნამდვილად გსურთ წაშლა ?') }}"
                                                onclick="event.preventDefault();$1('control-delete').submit(); ">
                                            {{ __("წაშლა") }}
                                        </button>
                                    </div>
                                </div>
                            </div>
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
