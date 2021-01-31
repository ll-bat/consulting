@extends('layouts.zim')


@section('content')
    <div id="app" class="">
        <pre-questions _objects = "{{ \Psy\Util\Json::encode($objects) }}"
                       _docs="{{ \Psy\Util\Json::encode($docs) }}"
                       _fields = "{{ \Psy\Util\Json::encode($fields) }}"
        ></pre-questions>
    </div>
    <script>
        $1('app').style.height = window.innerHeight - 200 + 'px';
    </script>
@endsection
