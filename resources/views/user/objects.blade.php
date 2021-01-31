@extends('layouts/zim')






@section('header')
    <style>
        .bg-darkblue {
            background: rgba(0,0,200, .5);
        }
    </style>
@endsection

@section('toolbar')
    <?php use App\Objects;
    $json = json_encode([
        'fields' => ['name' => ''],
        '_nextUrl' => 'objects/create',
        'title' => 'ობიექტის დამატება',
        'onEnter' => ['name']
    ]); ?>
    <button class="btn btn-outline-primary font-weight-bold border-0 m-0 px-3 py-1"
            id="model-create-button"
            data-params="{{ $json }}"
            style="margin-bottom: 4px !important;color:rgba(0,0,200, .5)">
        <i class="fa fa-plus pl-0 pr-2"></i>
        ობიექტის დამატება
    </button>
@endsection

<?php
$has = false;
$class = 'alert-danger';
$message = "";
if (session()->has('message')) {
    $message = session()->get('message');
    if ($message['success']) {
        $class = 'bg-darkblue';
    }
    $message = $message['message'];
    $has = true;
}
?>

@section('content')

    @if ($has)
        <p class="alert {{ $class }} text-white"> {{ $message }} </p>
    @endif

    @foreach($objects as $id => $object)
        <?php /** @var $object Objects */
        $json = json_encode([
            'fields' => ['name' => $object['name']],
            '_nextUrl' => 'objects/' . $object['id'] . '/update',
            'title' => 'ობიექტის განახლება',
        ]) ?>

        <div class="bg-white px-4 py-3 border rounded-10 partial-shadow border-0 mt-3">
            <div class="d-flex modal-div " style="justify-content: space-between;">
                <div class="d-flex">
                    <img src="/icons/3d.png" width="40" height="40"/>
                    <a href="objects/{{ $object['id'] }}" class="text-lg mx-4 mt-2"> {{ $object['name'] }} </a>
                </div>
                <div class="d-flex">
                    <span class="mr-4 mt-3"> <b>{{ count($object['docs']) }} </b> doc(s) </span>
                    <button class="btn btn-primary border-0 px-2 py-1 modal-element" data-params="{{ $json }}">
                        <i class="fa fa-pencil-alt" style="font-size: .85rem"></i>
                    </button>
                    <button class="btn btn-danger border-0 py-1 modal-element-remove" style="padding: 0 10px;" data-params='{"_nextUrl": "objects/{{ $object['id'] }}/delete"}'>
                        <i class="fa fa-trash-alt" style="font-size: .85rem"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    @if (count($objects) < 1)
        <p class="alert text-white" style="background-color:rgba(0,0,200, .5)"> თქვენ არ გაქვთ ობიექტები </p>
    @endif

    @include('user._partialModal', [
           'title' => '',
           'form' => 'user._createObject'
    ])

    <script type="application/javascript" src="/js/_modal.js"></script>

@endsection


