@extends('layouts/app')

<?php
  $route = Request::route()->getName();
?>

@section('css')
    <link rel="stylesheet" href="css/style.css" />

    <style>
       .services-hoverable{
           height: 400px;
           overflow:hidden;
       }

       .serices-hoverable:hover{
           overflow: visible;
           height:auto !important;
           min-height:400px !important;
           max-height:800px !important;
       }
    </style>
@endsection

@section('content')
    <main>
           @include('_header', ['page' => 'services'])
            <div class="categories-area section-padding30">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Section Tittle -->
                            <div style="
                                {{$modifies->getStyleFor('services', 'between-image-and-title')}};
                                line-height:2rem;
                                margin-top: -100px;
                                margin-bottom: 100px;
                                "
                            >
                                {{$modifies->getTextFor('services', 'between-image-and-title') }}

                            </div>

                            <!-- Section Tittle -->
                            <div class="section-tittle mb-70">
                                <span>Services</span>
                                <h2>{{ __("ჩვენი სერვისები") }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($modifies->services->getServices() as $id => $obj)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-cat text-center services-hoverable mb-50">
                                <div class="cat-icon">
                                    <img src="{{$obj['image']}}" height='70' class='mb-5' />
                                </div>
                                <div class="cat-cap" style='max-height:200px !important;overflow:hidden !important;'>
                                    <h5><a href=""> {{$obj['title']}} </a></h5>
                                    <p class='mb-5'> {{$obj['description']}} ... </p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
    </main>
@endsection
