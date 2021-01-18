@extends('layouts/zim')

@section('header')
    <style>
        tr td {
            text-align: center !important;
            height: 20px;
        }


        thead tr td {
            font-size: .7rem;
            border: 1px solid lightgrey;
            background-color: rgb(222, 234, 246);
        }

        .smaller {
            font-size: .6rem;
        }

        .small {
            font-size: .8rem;
        }

        .small1 {
            font-size: .7rem;
        }

        table tr td {
            border: 1px solid lightgrey;
        }

        .bg-purple {
            background-color: transparent;
        }

        .bg-dlight {
            background-color: #D9D9D9;
            border: 1px solid lightgrey !important;
        }

        .bg-primary {
            background-color: #0070C0 !important;
            border: 1px solid lightgrey !important;
            color: white !important;
        }

        .bg-warning {
            background-color: #FFFF00 !important;
            border: 1px solid lightgrey !important;
        }

        .hoverable-image {
            margin: auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            min-width: 5rem;
            position: absolute;
            width: 5rem;
            min-height: 5rem;
            height: 5rem;
            transition: all .41s ease-in;
            z-index: 1;
        }

        .hoverable-image:hover {
            position: absolute;
            left: -10rem;
            right: -10rem;
            top: -5rem;
            bottom: -5rem;
            min-width: 20rem;
            min-height: 20rem;
            border-radius: 10px;
            z-index: 99;
        }

        .hover-grey {
            transition: all .5s ease-in;
        }

        .hover-grey:hover {
            background-color: rgba(0, 0, 0, .1) !important;
        }

        .border {
            border-width: .15rem !important;
        }

        .border-success {
            border-width: .15rem !important;
            border-color: lightseagreen !important;
        }

    </style>
@endsection

@section('content')



    <div class='container-fluid mt-5' id='table-data'>
        <h5 class="mb-5"> დოკუმენტის
            <a  href="{{ $docId }}/edit"
                class="text-info">
                რედაქტირება
                <span class="fas fa-pencil-alt mx-1"></span>
            </a>
        </h5>

    @include('user/docs/_table', compact('countAll', 'object'))
    <!-- <div class='form-group'>
               <button class='btn btn-primary' onclick='exportData()'> Export </button>
           </div> -->

        <div class='d-block position-relative' style='margin-top:5rem;'>
            <span class='mt-4 mr-3'> შეინახეთ დოკუმენტი როგორც: </span>

            <div class='d-block mt-3 m-4'>
                <div class='d-flex'>
                    <div class='bg-white border rounded-10 p-2 pointer hover-grey' onclick="select(this,'pdf')"
                         style=''>
                        <img src='/icons/pdf.png' width='60'/>
                    </div>
                    <div class='bg-white border rounded-10 p-2 ml-4 pointer hover-grey' onclick="select(this,'excel')"
                         style=''>
                        <img src='/icons/excel.png' width='60'/>
                    </div>
                </div>
                <button class='btn btn-primary border-0 capitalize px-4 py-1 mt-4'
                        onclick='exportData(event)'>Export
                </button>
            </div>
        </div>
    </div>

    <a href='{{ $docId }}/export' class='d-none' id='export'></a>

    @include('user.docs._modal')
    <script>
        st(dom.body, 'bg: rgba(32, 113, 99, .04')

        let selected = '';

        function select(obj, type) {
            if (!$(obj).hasClass('border-success')) {
                $('.border-success').removeClass('border-success')
                $(obj).addClass('border-success')
                selected = type
            }
        }

        function exportData(event) {
            let pdf = selected == 'pdf'
            let excel = selected == 'excel'

            if (!(pdf | excel)) {
                $1('forms-modal').click()
                return
            }

            if (pdf) {
                $1('export').href = "{{$docId}}/export?pdf=1"
                $1('export').click()
            } else if (excel) {
                $1('export').href = "{{$docId}}/export?excel=1"
                $1('export').click()
            }
        }

        @if (count($errors) > 0)
        $1('forms-modal').click()
        @endif

    </script>
@endsection
