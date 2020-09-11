@extends('layouts/zim')






@section('header')
   <style>
       .mydocs-border{
           border-bottom: .1rem solid lightseagreen;
           width:0;
           transition: all .2s ease-in;
       }
       .mydocs-item:hover .mydocs-border{
           width:100%;
       }
       .mydocs-item:hover .mydocs-text {
           text-shadow: .4rem .4rem .4rem lightgrey;
       }
   </style>
@endsection
@section('content')


    <div class="container-fluid">
        @foreach($docs as $index=>$doc)
            <div class="card shadow-none">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-12">
                            <a href="doc/{{$doc->id}}" style="text-decoration: none !important;">
                                <div class="mydocs-item pointer d-flex">
                                    <div>
                                        <img src="/icons/pdf.png" style="width:3rem;"/>
                                    </div>
                                    <div class="mt-2">
                                        <span
                                            class="pl-2 mydocs-text text-primary font-weight-bolder" style="">{{ $doc->filename }}</span>
                                        <div class="mydocs-border mt-2 ml-2"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-4 col-10">
                            <div class="d-flex mt-2 mt-sm-0">
                                <div class="mr-1">
                                    <a href="doc/{{$doc->id}}/download" class="btn btn-outline-success rounded-pill text-sm">Download</a>
                                </div>
                                <div class="">
                                    <button class="btn btn-outline-danger rounded-pill text-sm" onclick="$1('doc-delete{{$index}}').submit()">
                                        Delete
                                    </button>

                                    <form method="post" action="doc/{{$doc->id}}/delete"  class="d-none" id="doc-delete{{$index}}">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
