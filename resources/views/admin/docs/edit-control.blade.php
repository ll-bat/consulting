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

        .my-color {
            color: #009999;
        }

        .my-bg {
            background: #009999;
        }
    </style>
@endsection

<?php $color = '#009999'; ?>

@section('content')

    <div class="zim-container">
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 ml-5 mr-5" id="main-part">

                @if (Session('message'))
                    <p class='alert my-bg text-left text-white mt-2 mb-3'>
                        {{Session('message')}}
                    </p>
                @endif

                <form method='post' action='update'>
                    @csrf

                    <div class='card border-0 partial-shadow' style=''>
                        <div class='d-flex'>
                            <div class='mx-3 mt-3 w-75'>
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
                            <div class='mx-3 mt-3 text-left'>
                                <input type='text' class='form-control border-0 autoresize'
                                       placeholder='K:1'
                                       name='k'
                                       value="{{$control->k}}"
                                       style='width:4rem;border-bottom:1px solid {{$color}} !important;border-radius:0'
                                       name='k'/>
                            </div>
                        </div>

                        <label class="ns-container text-secondary text-left ml-3 mt-2 mb-3"
                               style='font-size:.95em; color:rgba(0,0,0,.8);'> ამცირებს პოტენციურ ზიანს
                            <input type="checkbox"
                                   name="rploss"
                                   value="1"
                                   @if ($control->hasRPLoss()) checked @endif
                            >
                            <span class="chbox-checkmark"></span>
                        </label>

                        <label class="ns-container text-secondary text-left ml-3 mt-2 mb-3"
                               style='font-size:.95em; color:rgba(0,0,0,.8);'> არსებული კონტროლის ზომის პასუხის დამალვა
                            <input type="checkbox"
                                   name="is_first_option_off"
                                   value="1"
                                   @if ($control->is_first_option_off) checked @endif
                            >
                            <span class="chbox-checkmark"></span>
                        </label>
                    </div>

                    <div class='card text-left border-0 partial-shadow'>
                        <div class='card-body ml-1 pb-4' required>
                            <p class='ml-1 mt-2 mb-4 font-weight-bolder my-color'> აირჩიეთ საფრთხე </p>

                            @foreach($dangers as $danger)
                                <label class="ns-container mt-3 ml-3 text-secondary"
                                       style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$danger->name}}
                                    <input type="checkbox"
                                           name="danger[]"
                                           value="{{ $danger->id }}"
                                           @if(in_array($danger->id, $list)) checked @endif
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

                            <hr style="width: 100%"/>

                            <div class='d-md-flex d-block'>
                                <div class='text-left'>
                                    <button class='btn my-btn'> განახლება</button>
                                </div>

                                <div class='text-left ml-md-2 ml-0'>
                                    <button class='btn my-del-btn'
                                            onclick="event.preventDefault();$1('control-delete').submit(); "> წაშლა
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
                <form method='post' action='rdelete' id='control-delete'>
                    @csrf
                    @method('delete')
                </form>

            </div>
        </div>
    </div>

    <script type="application/javascript">


    </script>

@endsection
