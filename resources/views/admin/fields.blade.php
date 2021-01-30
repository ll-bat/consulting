@extends('layouts.zim')

@section('header')
    <style>
        .create-button {
            background: white !important;;
            border: 1px solid transparent !important;
            padding: 12px;
            border-radius: 40px;
            box-shadow: 2px 2px 4px lightgrey;
        }
        .create-button:hover {
            background: #e7e3e3 !important;
        }
        .create-button:focus {
            outline: 0;
        }
    </style>
@endsection

<?php
    $has = false;
    $class = 'alert-danger';
    $message = "";
    if (session()->has('message')) {
        $message = session()->get('message');
        if ($message['success']) {
            $class = 'alert-success';
        }
        $message = $message['message'];
        $has = true;
    }
?>

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-9 col-12">
            @if ($has)
                <p class="alert {{ $class }} text-white"> {{ $message }} </p>
            @endif
            <div class="">
                <div class="text-left">
                    <?php
                    $json = json_encode([
                        'fields' => ['name' => ''],
                        '_nextUrl' => 'fields/create',
                        'title' => 'სფეროს დამატება',
                        'onEnter' => ['name']
                    ])
                    ?>
                    <button class="create-button" id="model-create-button" data-params="{{ $json }}">
                        <i class="nc-icon nc-atom text-primary p-1"></i>
                        <span class="px-2 mb-1 text-primary"> ახალი სფერო </span>
                    </button>
                </div>

                @foreach($fields as $id => $field)
                    <?php
                    $json = json_encode([
                        'fields' => ['name' => $field->name],
                        '_nextUrl' => 'fields/' . $field->id . '/update',
                        'title' => 'სფეროს განახლება',
                    ])
                    ?>
                    <div class="bg-white px-4 py-3 border rounded-10 partial-shadow border-0 mt-3">
                        <div class="d-flex modal-div" style="justify-content: space-between;">
                            <div class="d-flex">
                                <img src="/icons/slack.png" width="40" height="40" />
                                <a href="fields/{{ $field->id }}/docs" class="text-lg mx-4 mt-2"> {{ $field['name'] }} </a>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-primary border-0 px-2 py-1 modal-element" data-params="{{ $json }}">
                                    <i class="fa fa-pencil-alt" style="font-size: .85rem"></i>
                                </button>
                                <button class="btn btn-danger border-0 py-1 modal-element-remove" style="padding: 0 10px;" data-params='{"_nextUrl": "fields/{{ $field->id }}/delete"}'>
                                    <i class="fa fa-trash-alt" style="font-size: .85rem"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    @include('user._partialModal', [
       'title' => 'სფეროს დამატება',
       'form' => 'admin._createField'
    ])

    <script type="application/javascript" src="/js/_modal.js"></script>
@endsection
