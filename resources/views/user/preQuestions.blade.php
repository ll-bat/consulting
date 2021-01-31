@extends('layouts.zim')


@section('content')
    <div id="app" class="">
        <div class="d-flex justify-content-center align-items-center h-100" id="content-spinner">
            <div class="text-center">
                <div class="spinner spinner-border text-secondary"
                     style="width: 100px; height: 100px; border-width: 1.2rem;margin-top: -100px"></div>
            </div>
        </div>

        <pre-questions _objects = "{{ \Psy\Util\Json::encode($objects) }}"
                       _docs="{{ \Psy\Util\Json::encode($docs) }}"
                       _fields = "{{ \Psy\Util\Json::encode($fields) }}"
        ></pre-questions>
    </div>
    <script>
        $1('app').style.height = window.innerHeight - 200 + 'px';
    </script>
@endsection
