<?php
/**
 * @var boolean $readonly
 */

if (!isset($readonly)) {
    $readonly = false;
}
?>

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
            padding: 3px;
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
            transition: all .11s ease-in;
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

        .bg-lightgrey {
            background: #EAECEB !important;
        }

    </style>
@endsection

@section('content')
    <div class='container-fluid mt-2' id='table-data'>
        <h5 class="mb-4 bg-white p-3 " style="border: 1px solid lightgrey">
            დოკუმენტის სახელი:
            @if (!$readonly)
            <a href="" class="text-info" id="doc-rename-a">
                &nbsp; {{ $filename }}
                <i class="far fa-pencil-alt text-info"></i>
            </a>
            @else
            <span class="text-primary"> {{ $filename }} </span>
            @endif
        </h5>

        @if (!$readonly)
        <h5 class="mb-5 bg-white p-3" style="border: 1px solid lightgrey"> დოკუმენტის
            <a href="{{ $docId }}/edit"
               class="text-info"> რედაქტირება
                <span class="fas fa-pencil-alt mx-1"></span>
            </a>
        </h5>
        @endif

        @include('user.docs.doc-header', compact('docAbout'))
        @include('user/docs/_table', compact('countAll', 'object'))

        <div class="card rounded-8 shadow-none mt-5" style="width: 400px;border: 1px solid lightgrey">
            <div class="card-title pt-4" style="font-size: 1.2rem">
                <div class="d-flex justify-content-center">
                    <i class="nc-icon nc-cloud-download-93 font-weight-bold text-primary mx-3 mt-2"></i>
                    <p class="mt-1 text-primary">
                        გადმოწერეთ როგორც
                    </p>
                </div>
            </div>
            <div class="card-body pb-5">
                <div class='d-flex justify-content-center'>
                    <div class='bg-white border rounded-10 p-2 pointer hover-grey download-file' data-url="{{ route('user.export.download', ['export' => $docId]) }}?pdf=1">
                        <img src='/icons/pdf.png' width='60' alt="pdf"/>
                    </div>
                    <div class='bg-white border rounded-10 p-2 ml-4 pointer hover-grey download-file' data-url="{{ route('user.export.download', ['export' => $docId]) }}?excel=1">
                        <img src='/icons/excel.png' width='60' alt="excel"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!$readonly)
        @include('user.docs._doc-modal', compact('objects', 'filename', 'objectId'))
    @endif

    <script>
        $('.download-file').each((ind, elm) => {
            $(elm).on('click', async e => {
                window.location = $(elm).attr('data-url');
            })
        })

        st(dom.body, 'bg: rgba(32, 113, 99, .04')

        @if (count($errors) > 0)
        $1('forms-modal').click()
        @endif

    </script>
@endsection
