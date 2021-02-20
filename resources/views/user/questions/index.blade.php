@extends('layouts/zim')

@section('header')
    <link rel="stylesheet" href="/css/skeleton-loader.css"/>

    <style>
        .border-bottom {
            border-bottom: 1px dotted lightgrey !important;
        }

        .border-bottom:focus {
            border-color: transparent !important;
        }

        .slow-down {
            transition: all .5s ease-out;
        }

        .add-control-border {
            border-bottom: 5px solid white !important;
        }

        .remove-control-border {
            border-bottom: 5px solid orange !important;
        }

        #moveable-control-border {
            transition: all .3s ease;
        }

        .control-border-bottom {
            border-bottom: 5px solid rgba(0, 0, 0, .1) !important;
        }

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

        @keyframes _animateSubmitButton {
            0% {
                margin-top: 7rem;
                transform: rotate(-20deg) rotateX(180deg);
            }
            100% {
                margin-top: 0rem;
            }
        }

        .animate-submit-button {
            animation: _animateSubmitButton .5s ease-out;
        }

        .hoverable-underline {
            width: 0;
            height: .2rem;
            margin-right: 5px;
            transition: all .2s ease-out;
        }

        .hoverable:hover .hoverable-underline {
            width: 100%;
        }

        .m-btn:focus {
            outline: 0;
        }

        .text-orange {
            color: orange;
        }

        .text-purple {
            color: purple;
        }

        .text-blue {
            color: blue;
        }

        .bg-purple {
            background-color: purple;
        }

        .bg-blue {
            background-color: blue;
        }

        .ns-card {
            border-radius: 0 !important;
            border-top: 10px solid blue !important;
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





    <script type="application/javascript">
        function _onFocusHandler(el) {
            $(el).parent().parent().removeClass('remove-control-border').addClass('add-control-border')
        }

        function _onBlurHandler(el) {
            $(el).parent().parent().removeClass('add-control-border').addClass('remove-control-border');
        }
    </script>
@endsection
