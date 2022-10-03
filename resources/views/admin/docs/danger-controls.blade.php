
@extends('layouts.zim')

@section('header')
    <style>
        .btn-outline-orange {
            border-color: orange !important;
            color: orange !important;
        }

        .btn-outline-orange:hover {
            background: orange !important;
            color: white !important;
        }

        .btn-outline-danger {
            color: #b84848 !important;
        }

        .btn-outline-success {
            color: #36c436 !important;
        }
    </style>
@endsection
@section('content')
<div class="zim-container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12 ml-5 mr-5" id="main-part">

            @if (Session('message'))<p class='alert text-left text-white mb-4' style="background: #2159a2">
                {{Session('message')}}
            </p>
            @endif

            @if (Session('error'))<p class='alert alert-danger text-white text-left'>{{Session('error')}}</p>  @endif

            <div class='card text-left border-0 partial-shadow p-3'>
                <p>
                    <span class="font-weight-bold" style="color: #2159a2"> {{ __("დაემატა საფრთხეს") }} <img src="/icons/right-arrow1.png" class="ml-2" width="15" />  </span>
                    <span class="ml-2"> {{ $danger }} </span>
                </p>
            </div>

            <ul class="list-group text-left mb-4" style="border-radius:5px;">
                <li class="list-group-item font-weight-bold py-3 pointer"
                    style="background: #2159a2; color: white">
                    <i class='nc-icon nc-atom float-left mt-1'></i>
                    <span class="pl-4"> {{ $title }}  </span>
                </li>
                @foreach($data as $ind => $d)
                <li class="list-group-item pl-4">
                    <p class="text-sm text-muted m-0 p-0">
                        by {{ $d['username'] }}
                        @if ($d['is_ignored'])
                            <b class="text-orange ml-3">
                                {{ __("იგნორირებულია") }} !
                            </b>
                        @endif
                    </p>
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-lg-8 mt-3">
                            <span> {{ $ind + 1 }}. {{ $d['name'] }} </span>
                        </div>
                        <div class="col-sm-12 col-lg-4 mt-md-2 mt-lg-0 text-lg-center">
                            <a class="btn btn-outline-success"
                               href="added/{{ $d['id'] }}/approve"
                               style="border-width: 1px !important;">
                                <i class="fa fa-check text-sm"></i>
                            </a>
                            @if (!$d['is_ignored'])
                                <a class="btn btn-outline-orange"
                                   href="added/{{ $d['id'] }}/ignore"
                                   style="border-width: 1px !important;">
                                    <i class="fa fa-exclamation px-1 text-sm"></i>
                                </a>
                            @endif
                            <a class="btn btn-outline-danger"
                               href="added/{{ $d['id'] }}/remove"
                               style="border-width: 1px !important;">
                                <i class="fa fa-times text-sm"></i>
                            </a>
                        </div>
                    </div>
                </li>
                @endforeach
                @if (count($data) == 0)
                    <li class="list-group-item pl-4">
                        <p> {{ __("მონაცემები არ არის") }} </p>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</div>

@endsection
