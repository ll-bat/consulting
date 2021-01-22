@extends('layouts/zim')

@section('header')
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
            background-color: #673ab7 !important;
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
        let $doc = `{!! $data !!}`;
        let $exportId = "{{ $exportId }}"
    </script>
@endsection
@section('content')

    <div class="" id='app' style="width: 100% !important;">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mt-md-0 mt-sm-5 mt-5">

                <div class="text-center" :class="{'d-none': !loading}" style="margin-top:30%;">
                    <div class="spinner-border text-warning"
                         style="width:7rem; height: 7rem;border-width: 1rem;"></div>
                </div>

                @include('user.questions._proccesses')

                <div class="d-none" id="questions-content">
                    @foreach (['dangers', 'danger-image', 'controls', 'add-controls'] as $view)
                        @include('user.questions._'.$view)
                    @endforeach

                    <div v-if='showControls'>
                        @foreach (['udanger-ploss', 'add-udangers', 'add-rpersons', 'add-etimes'] as $view)
                            @include('user.questions._'.$view)
                        @endforeach

                            <div class='mb-4 animate-submit-button'>
                                <button
                                    class='btn btn-primary bg-primary hovered-ns-button border-info capitalize text-sm px-4 py-1'
                                    id='data-submit'
                                    @click='submit()'
                                ><span class="spinner-border spinner-border-sm p-2 mr-2 d-none" id='data-processing'
                                       style='margin-left:-.6rem;'></span>
                                    Submit
                                </button>
                            </div>
                    </div>
                </div>

                <form method='get' action='docs/show-data' id='red_to_fin'>
                    @csrf
                </form>

            </div>
        </div>
    </div>
    <script type="application/javascript">
        function uploadImage(ev, ind) {
            ev.preventDefault()
            $(`#imageupload${ind}`).click()
        }

        function clearUploadedImage(ind) {
            $1(`docimage${ind}`).src = ''
            $1(`imageupload${ind}`).value = ''
        }

        function customize(el) {
            $(el).parent().parent().removeClass('remove-control-border').addClass('add-control-border')
        }
    </script>
@endsection
