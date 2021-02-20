@extends('layouts/zim')

@section('header')
    <style>

        .mybtn {
            background: transparent;
            border: none;
            outline: 0;
            color: lightgrey;
            transition: .3s ease-in;
        }

        .mybtn:hover {
            color: green;
        }

        .remove:hover {
            color: darkred;
        }

        .mybtn:active {
            color: grey;
        }

        .mybtn:link, .mybtn:focus {
            outline: 0;
        }

        @keyframes _animSpinner {
            0% {
                opacity: .2;
            }
            100% {
                opacity: 1;
            }

        }

        .anim-spinner {
            animation: _animSpinner .51s;
        }

        @keyframes _animText {
            25% {
                opacity: 1;
                transform: translateY(-7px);
            }
            100% {
                opacity: 0;
                transform: translateY(50px) scaleX(.5);
                margin-left: 2px
            }
        }

        .anim-text {
            animation: _animText 1s;
        }

        @keyframes _animateScale {
            from {
                transform: scaleX(0) scaleY(0);
                opacity: 0;
            }
            to {

            }
        }

        .animate-scale {
            animation: _animateScale .2s ease-out;
        }

        .animate-scale-fast {
            animation: _animateScale .1s ease-out;
        }

        @keyframes _fallDown {
            from {
                transform: scaleY(0) rotateY(180deg);
                opacity: 0
            }
        }

        .animate-fall-dawn {
            animation: _fallDown .4s ease-in;
        }

        .animate-fall-dawn-fast {
            animation: _fallDown .2s ease-in;
        }

        @keyframes _isMoving {
            from {
                transform: translateY(20px) rotateX(-60deg) scaleX(0.6)
            }
        }

        .is-moving {
            opacity: 0;
        }

        .move {
            animation: _isMoving .15s ease-out;
            opacity: 1 !important;
        }
    </style>
@endsection

@section('toolbar')

@endsection

@section('content')

    <div class="zim-container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 col-sm-12 col-12">
                @if (Session('message'))
                    <p class='alert alert-success text-left text-white'>
                        {{Session('message')}}
                    </p>
                @endif

                @if (Session('error'))
                    <p class='alert alert-danger text-left text-white'>
                        {{Session('error')}}
                    </p>
                @endif
            </div>

            <div class="col-lg-7 col-md-10 col-sm-12 col-12">
                <div class='card rounded-10 border-0 pb-3 animate-scale'>
                    <div class='card-body text-left px-4' style='font-size:1.2em;'>
                        <h5 class='text-center py-3 px-2'>
                            დაემატა საფრთხეებს
                        </h5>

                        @foreach ($dangers as $ind => $d)
                            <div class='mt-2 mb-4 mr-2 ml-4'>
                                <a href='danger/{{$d->danger_id}}/edit'>
                                    <h5 class='text-lightblack text-dark text-lowercase py-2 px-0'> {{$ind + 1}}. {{$d->dangers->name}}(*) </h5>
                                </a>
                            </div>
                        @endforeach

                        @if (count($dangers) == 0)
                            <div class='mt-2 mb-4 mr-2 ml-4'>
                                <h5 class='text-lightblack text-dark text-lowercase py-2 px-0'> მონაცემები არ არის </h5>
                            </div>
                        @endif

                        {{ $dangers->links() }}

                    </div>
                </div>
            </div>

            @endsection
        </div>
    </div>
