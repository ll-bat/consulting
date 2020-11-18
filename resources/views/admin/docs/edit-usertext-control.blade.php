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
                    <div class='card border-0 rounded-0 partial-shadow'>
                        <div class='d-flex'>
                            <div class='mx-3 mt-3 w-75'>
                                <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize'
                                                    placeholder='კონტროლის ზომა'
                                                    oninput="$(window).trigger('autoresize')"
                                                    name='name'>{{$model->name}}</textarea>
                                </div>
                                @error('name')
                                <p class='text-sm text-danger text-left'> {{$message}} </p>
                                @enderror
                            </div>
                            <div class='mx-2 mt-3 text-left'>
                                <input type='text' class='form-control border-0 autoresize w-100'
                                       placeholder='K:1'
                                       name='k'
                                       value="{{$model->k}}"
                                       style='max-width: 80px;border-bottom:1px solid orange !important;border-radius:0'
                                       name='k'/>
                            </div>
                        </div>

                        <label class="ns-container text-secondary text-left m-3"
                               style='font-size:.95em; color:rgba(0,0,0,.8);'> ამცირებს პოტენციურ ზიანს
                            <input type="checkbox"
                                   name="rploss"
                                   value="0"
                            >
                            <span class="chbox-checkmark"></span>
                        </label>
                    </div>

                    <div class='card border-0 rounded-0 partial-shadow text-left'>
                        <div class='card-body ml-2 pb-4'>
                            <p class='mt-2 mb-4 text-primary font-weight-bolder'> აირჩიეთ საფრთხე </p>

                            @foreach($dangers as $danger)
                                <label class="ns-container mt-3 text-secondary ml-2"
                                       style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$danger->name}}
                                    <input type="checkbox"
                                           name="danger[]"
                                           value="{{ $danger->id }}"
                                           @if ($model->danger_id == $danger->id) checked @endif
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

                            <hr />

                            <div class='d-md-flex d-block'>
                                <div class='text-left'>
                                    <button class='btn btn-outline-primary' style="border-width: 1px !important;"> დამატება</button>
                                </div>
                                <div class='text-left ml-md-2 ml-0'>
                                    <button class='btn btn-outline-danger'
                                            style="border-width: 1px !important;"
                                            onclick="event.preventDefault();$1('control-delete').submit(); ">
                                        წაშლა
                                    </button>
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
