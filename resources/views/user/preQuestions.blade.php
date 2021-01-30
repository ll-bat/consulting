@extends('layouts.zim')


@section('content')
    <div id="app">
        <pre-questions _objects = "{{ \Psy\Util\Json::encode($objects) }}"
                       _docs="{{ \Psy\Util\Json::encode($docs) }}"
                       _fields = "{{ \Psy\Util\Json::encode($fields) }}"
        ></pre-questions>
    </div>
@endsection
