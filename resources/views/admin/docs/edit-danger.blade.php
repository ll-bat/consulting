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

        .new-btn {
            background: white;
            border: 1px solid #007799 !important;
            color: #007799 !important;
        }

        .new-btn:hover {
            background: #007799 !important;
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

                <div class="text-right">
                    <button class="btn btn-outline-primary new-btn px-3 py-1" id="minimize-btn">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>

                <form method='post' action='update' id="form-update">
                    @csrf

                    <div class='card border-0 partial-shadow p-1' style=''>
                        <div class='d-flex'>
                            <div class='mx-2 mt-2 w-75'>
                                <div class='form-group'>
                                    <textarea type='text'
                                              class='form-control autoresize'
                                              placeholder='{{ __("დაამატეთ საფრთხე") }}'
                                              oninput="$(window).trigger('autoresize')"
                                              name='name'>{{ $danger->name }}
                                    </textarea>
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

                    <div class='card border-0 partial-shadow pb-2' id="choose-process"
                         style=''>
                        <div class="card-body text-left p-3">
                            <p class='mt-2 mb-4 font-weight-bolder' style="color: #009999"> {{ __("აირჩიეთ პროცესი") }} </p>
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
                                <p class='text-secondary pl-3'> {{ __("პროცესები არ არის") }} </p>
                            @endif

                            @error('process')
                            <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                            @enderror
                        </div>

                        <hr style="width:94%;margin-left:3%;"/>

                        <div class='d-flex m-2 mx-3'>
                            <div class=''>
                                <button class='btn my-btn' onclick="updateHandler(this)"> {{ __("განახლება") }}</button>
                            </div>

                            <div class='ml-2'>
                                <button class='btn my-del-btn' style='border-width: 1px !important'
                                        onclick="event.preventDefault();$1('danger-delete').submit(); "> {{ __("წაშლა") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <form method='post' action='delete' id='danger-delete'>
                    @csrf
                    @method('delete')
                </form>

                @include('admin.docs._docs_tables', [
                          'has' => $ycontrol,
                          'nhas' => $ncontrol,
                          'type' => 'control',
                          'color' => $color,
                          'delcolor' => $delcolor,
                          'typeName' => __("კონტროლის ზომა")
                        ])

                    <ul class="list-group text-left mb-4" style="border-radius:5px;">
                        <li class="list-group-item font-weight-bold py-3 pointer"
                            style="background: #2159a2; color: white"
                        >
                            <i class='nc-icon nc-single-02 float-left'></i>
                            <span class="pl-4"> {{ __("მომხმარებელთა მიერ დამატებულები") }}  </span>
                        </li>
                        <li class="list-group-item pl-4 py-4">
                            <a href="control"> 1. {{ __("კონტროლის ზომები") }} ({{ $controlsCount }}) </a>
                        </li>
                        <li class="list-group-item pl-4 py-4">
                            <a href="ploss"> 2. {{ __("პოტენციური ზიანი") }} ({{ $plossCount }}) </a>
                        </li>
                        <li class="list-group-item pl-4 py-4">
                            <a href="udanger"> 3. {{ __("ვინ იმყოფება საფრთხის ქვეშ") }} ({{ $udangerCount }}) </a>
                        </li>
                    </ul>
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

            $(document).ready(() => {
                const el = dom.querySelector('#minimize-btn');
                const fa = el.querySelector('.fa');
                const p = $('#choose-process');
                $(el).on('click', (e) => {
                    if ($(fa).hasClass('maximized')) {
                        fa.className = 'fa fa-minus';
                    } else {
                        fa.className = 'fa fa-plus maximized';
                    }

                    p.toggleClass('d-none');
                });
            })

        </script>

@endsection
