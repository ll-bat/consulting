@extends('layouts/zim')

@section('header')
    <link rel="stylesheet" href="/css/skeleton-loader.css"/>

    <style>
        .hovered-ns-button {
            background: darkcyan !important;
        }

        @keyframes _animateProcess {
            0% {
                margin-top: -3rem;
                transform: rotate(10deg);
                width: 40%;
                opacity: .3
            }
            60% {
                opacity: .5;
            }
            100% {
                margin-top: 0rem;
                width: 100%;
            }
        }

        .animate-process {
            animation: _animateProcess .5s ease-out;
        }

        #edit-process {
            border-top: 3px solid rgba(0, 0, 0, .2);
            transition: all .2s ease-out;
        }

        /* 673ab7 */

        .text-orange {
            color: orange;
        }


    </style>
@endsection

@section('script')
    <script>
        $(dom.body).css({backgroundColor: '#f3eff6'})
    </script>
@endsection
@section('content')


    <div class="" id='app' style="width: 100% !important;">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mt-md-0 mt-sm-5 mt-5" style="min-width: 900px">
                <div id="loaders">
                    <div class="danger-skeleton"></div>
                    <div class="danger-skeleton my-3"></div>
                    <div class="controls-skeleton"></div>
                    <div class="danger-skeleton my-3"></div>
                </div>
            </div>
        </div>
        <questions :data="`{{ $data }}`"></questions>
    </div>
@endsection
