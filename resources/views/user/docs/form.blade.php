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

        .bg-lightgrey {
            background: #EAECEB !important;
        }

    </style>
@endsection

@section('content')
    <div class='container-fluid mt-5' id='table-data'>
        <h5 class="mb-4 bg-white p-3 " style="border: 1px solid lightgrey">
            დოკუმენტის სახელი:
            <a href="" class="text-info" id="doc-rename-a">
                &nbsp; {{ $filename }}
                <i class="fa fa-pencil-alt text-info"></i>
            </a>
        </h5>
        <h5 class="mb-5 bg-white p-3" style="border: 1px solid lightgrey"> დოკუმენტის
            <a href="{{ $docId }}/edit"
               class="text-info"> რედაქტირება
                <span class="fas fa-pencil-alt mx-1"></span>
            </a>
        </h5>

        @include('user.docs.doc-header', compact('docAbout'))
        @include('user/docs/_table', compact('countAll', 'object'))

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

    <button type="button" id="modal-button" class="btn btn-primary d-none" data-toggle="modal"
            data-target="#form-modal"></button>
    <div class="modal" id="form-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"> დოკუმენტის შეცვლა </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body mx-2 my-1">
                    <div class="form-group">
                        <label class="text-muted">სახელი:</label>
                        <input class="form-control p-3"
                               id="modal-input"
                               placeholder="შეიყვანეთ სახელი"/>

                        <div class="valid-feedback">
                            <p> ოპერაცია წარმატებით დასრულდა </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-muted">ობიექტი:</label>
                        <select class="form-control" id="modal-doc-object-id">
                            <option value disabled> აირჩიეთ ობიექტი</option>
                            @foreach($objects as $o)
                                <option value="{{ $o['id'] }}"> {{ $o['name'] }} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            <p> სამწუხაროდ შეცდომა დაფიქსირდა, სცადეთ თავიდან </p>
                        </div>
                        <div class="valid-feedback">
                            <p> ოპერაცია წარმატებით დასრულდა </p>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger border-0" data-dismiss="modal">დახურვა</button>
                    <button type="button" class="btn btn-primary border-0" id="modal-submit-button">
                        <span class="spinner-border spinner-border-sm d-none" id="modal-submit-spinner"></span>
                        <span class="py-2 px-1"> შენახვა </span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <a href='{{ $docId }}/export' class='d-none' id='export'></a>

    @include('user.docs._modal')
    <script>

        $('#form-modal #modal-input').on('keydown', e => {
            if (e.key === 'Enter') {
                $('#modal-submit-button').click();
            }
        })

        $('#doc-rename-a').on('click', e => {
            e.preventDefault();
            $('#modal-input').val("{{ $filename }}").removeClass('is-invalid');
            $('#modal-doc-object-id').val("{{ $objectId }}").removeClass('is-invalid')
            $('#modal-button').click();
        })

        $('#modal-submit-button').on('click', async e => {
            const el = $('#modal-input');
            const select = $('#modal-doc-object-id');
            if (el.val().length < 1 || !select.val()) {
                alert('გთხოვთ, შეიყვანოთ ტექსტი');
                return;
            }
            const url = `/user/doc/{{ $docId }}/update`;
            const data = {
                filename: el.val(),
                objectId: select.val()
            };

            $('#modal-submit-button').addClass('disabled');
            $('#modal-submit-spinner').removeClass('d-none');

            const res = await $.post(url, data).catch(err => {
                select.addClass('is-invalid');
                $('#modal-submit-button').removeClass('disabled');
                $('#modal-submit-spinner').addClass('d-none');
            })

            if (res) {
                select.removeClass('is-invalid').addClass('is-valid');
                el.removeClass('is-invalid').addClass('is-valid');
                tout(() => {
                    window.location = '';
                }, 400);
            }
        })

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
