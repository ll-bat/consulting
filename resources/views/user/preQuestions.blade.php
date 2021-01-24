@extends('layouts.zim')


@section('content')
    <div id="app">
        <pre-questions _objects = "{{ \Psy\Util\Json::encode($objects) }}" _docs="{{ \Psy\Util\Json::encode($docs) }}" ></pre-questions>
    </div>
@endsection
