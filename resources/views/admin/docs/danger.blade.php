@extends('layouts/zim')

@section('header')
    <style>


        .this-icon {
            transition: all .4 ease-in;
        }

        .this-icon:hover {
            font-weight: bolder;
        }

        .my-btn {
            border: 1px solid #4a81ee !important;
            background: white;
            color: #3366cc;
        }

        .my-btn:hover {
            background: #4a81ee !important;
            color: white;
        }

        .my-color {
            color: #4a81ee
        }

        .my-bg {
            background: #4a81ee;
        }

        .my-border {
            border: 1px solid #4a81ee;
        }

    </style>
@endsection

<?php $color = "#4a81ee" ?>

@section('content')

    <div class="zim-container">
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12 ml-5 mr-5" id="main-part">
                @if (Session('message'))
                    <p class='alert text-left text-white mt-3 mb-4 my-bg'>
                        {{Session('message')}}
                    </p>
                @endif

                @if (Session('error'))
                    <p class='alert alert-danger text-left text-white'>
                        {{Session('error')}}
                    </p>
                @endif


                <div
                    class='card card-user mt-3 mb-0 text-left shadow-none my-border'
                    style=''>
                    <div class='card-title mb-1 mt-3 pointer' id='add-new-danger'
                         onclick="toggleCollapse(this, 'new-danger')">
                        <i class='fa fa-plus float-left ml-3 mt-1'></i>
                        <p class='pl-5 font-weight-bold my-color'> დაამატეთ ახალი საფრთხე </p>
                    </div>
                </div>


                {{--                    #7733ff    --}}

                <form method='post' action='new-danger' class='d-none' id='new-danger'>
                    @csrf

                    <div class='card border-0 partial-shadow' style=''>
                        <div class='d-flex'>
                            <div class='mx-3 my-3 w-75'>
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
                            <div class='mx-2 mt-3 w-25 text-left' style="max-width: 5rem;">
                                <input type='text' class='form-control border-0'
                                       placeholder='K:1'
                                       name='k'
                                       value="{{old('k')}}"
                                       style='border-bottom:1px solid {{$color}} !important;border-radius:0'
                                       name='k'/>
                            </div>
                        </div>
                    </div>

                    <div class='card pb-2 border-0 partial-shadow'
                         style=''>
                        <div class="card-body px-4 pt-4 mb-0 pb-0 text-left">
                            <p class='mt-2 mb-4 font-weight-bolder my-color' style=''> აირჩიეთ პროცესი  </p>
                            @foreach($procs as $proc)
                                <label class="ns-container mt-3 ml-2 text-secondary"
                                       style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$proc->name}}
                                    <input type="checkbox"
                                           name="process[]"
                                           value="{{ $proc->id }}"
                                           @if(is_array(old('process')) && in_array($proc->id, old('process'))) checked @endif
                                    >
                                    <span class="chbox-checkmark"></span>
                                </label>
                            @endforeach

                            @if ($procs->count() == 0)
                                <p class='text-secondary font-weight-bolder ml-3'> პროცესები არ არის </p>
                            @endif

                            @error('process')
                            <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                            @enderror

                            <hr style="width: 100%"/>

                            <div class='text-left mt-3 mb-1'>
                                <button class='btn my-btn border-0'> შექმნა</button>
                            </div>
                        </div>

                    </div>
                </form>


                <ul class="list-group text-left my-3" style="border-radius:5px;">
                    <li class="list-group-item font-weight-bold py-3 pointer" onclick="toggleCollapse(this, null, '{{$color}}')"
                        style="border: 1px solid {{$color}};color: {{$color}};">
                        <i class='fa fa-plus float-left'></i>
                        <span class="pl-4"> ყველა  საფრთხე </span>
                    </li>
                    @foreach($dangers as $ind => $danger)
                        <li class="list-group-item pl-4 dangers-panel d-none"
                            style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);
                                border-left: 1px solid rgba(0,0,0,0.09);
                                border-right: 1px solid rgba(0,0,0,.09);
                            @if ($ind == count($dangers)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif
                                ">
                            <div class="row">
                                <div class="col-md-10 col-12">
                                    {{$danger->name}}
                                </div>
                                <div class="col-md-2 col-2 text-md-center text-left this-div">
                                    <a class='btn this-color my-color' href='danger/{{$danger->id}}/edit'
                                       style='background-color:transparent !important;'>
                                        შეცვლა
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @if ($danger->count() == 0)
                        <div class='d-none controls-panel pb-1'>
                            <p class='text-secondary'> თქვენ არ გაქვთ კონტროლის ზომები </p>
                        </div>
                    @endif
                </ul>


{{--                <div class='card card-user mt-3 text-left shadow-none my-border'--}}
{{--                     style=''>--}}
{{--                    <div class='card-title mb-1 mt-3 pointer' onclick='toggleCollapse()'>--}}
{{--                        <i class='fa fa-plus float-left ml-3 mt-1 my-color'></i>--}}
{{--                        <p class='pl-5 font-weight-bold' style='color:#7733ff'> ყველა საფრთხე </p>--}}
{{--                    </div>--}}

{{--                    <div class='pl-4' style=''>--}}
{{--                        @foreach($dangers as $ind => $danger)--}}
{{--                            <div class="d-none dangers-panel-1 pb-1" style="">--}}
{{--                                <div class="row" style="width: 100%;">--}}
{{--                                    <div class="col-md-8 col-12" style="">--}}
{{--                                        <p class="@if(Session('created') && $ind == $dangers->count()-1) text-black font-weight-bolder @else text-muted @endif"> {{$ind + 1}}--}}
{{--                                            . {{$danger->name}} </p>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-2 col-2 this-div text-center text-md-right">--}}
{{--                                        <a class='btn this-color' href='danger/{{$danger->id}}/copy'--}}
{{--                                           style='margin-top:-.1rem;background-color:transparent !important;color:blue'>--}}
{{--                                            copy--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-2 col-2 this-div">--}}
{{--                                        <a class='btn this-color' href='danger/{{$danger->id}}/edit'--}}
{{--                                           style='margin-top:-.1rem;background-color:transparent !important;color:blue'>--}}
{{--                                            edit--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                        @if ($dangers->count() == 0)--}}
{{--                            <div class='d-none dangers-panel pb-1'>--}}
{{--                                <p class='text-secondary'> თქვენ ჯერ არ გაქვთ საფრთხეები </p>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}


                <div class='text-left my-4'>
                    <form method='post' action='../docs/import/danger' enctype="multipart/form-data">
                        @csrf
                        <input type='file' class='d-none' id='import_excel' name='danger'
                               onchange='this.parentNode.submit()'/>
                        <button class='btn text-white border-0 py-1 px-3 my-bg'
                                onclick="$1('import_excel').click(); event.preventDefault()"><i class='fa fa-plus'></i>
                            საფრთხეები(ექსელი)
                        </button>
                    </form>
                    @if ($errors->has('danger'))
                        <p class='text-danger text-sm'> გთხოვთ, ატვირთოთ ექსელის დოკუმენტი </p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script type="application/javascript">
        function toggleCollapse(obj, id, color) {
            if (id) {
                obj.parentNode.remove()
                remove($1(id), 'd-none')
                return
            }

            if ($('.dangers-panel').hasClass('d-none')){
                $('.dangers-panel').removeClass('d-none')
                $(obj).css({'color': 'white', 'background-color': color})
            }
            else
            {
                $('.dangers-panel').addClass('d-none')
                $(obj).css({'background-color' : 'white', 'color': color})
            }
        }

        @if ($errors->count() > 0)
        toggleCollapse($1('add-new-danger'), 'new-danger')
        @endif

    </script>

@endsection
