@extends('layouts/app')





<?php

    $route = back()->getTargetUrl();

?>

@section('content')
    <section class="blog_area mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-lg-0 mt-0">
                    <div class="blog_left_sidebar">
                        <article class="blog_item offset-1">
                            <a href="{{  $route }}" class="mb-2 btn btn-outline-info text-primary" style='background-color:transparent !important;'>
                                Back
                            </a>
                            <div class="blog_area mt-5">
                                <h1>{{$blog->title}}</h1>
                                <p class="pt-2 text-muted" style="font-size:1.1em;">
                                    <i class="fas fa-user lightgrey pr-1"></i>
                                    By <span class="text-info">Mister {{$blog->user->username}}</span>
                                </p>
                                <hr />
                                <p class="text-dark" style="font-size:1.1em;">
                                    Posted on {{$blog->postDate()}}
                                </p>
                                <hr />
                            </div>
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="{{$blog->path()}}" alt="" />
                            </div>
                            <hr />
                            <div class="blog_details">
                                   {!! $blog->body !!}
                                <div class="blog-info-link">
                                    <div class="mt-5" style="margin-left:-17px;">
                                        <div class="" style="margin-left:0;">
                                            <div class="main mt-3 all-comments pl-0">
                                                <u class="ml-3 text-muted" style="font-size: .8em; font-family: 'Comic Sans MS;">All comments:</u>
                                                <hr class="ml-3">
                                                @foreach($blog->comments as $comment)
                                                    @include('_comment')
                                                @endforeach

                                            </div>

                                            @auth
                                                @include('_write-comment', ['index' => 0])
                                            @endauth
                                            @guest()
                                                @if (count($blog->comments) == 0)
                                                    <div class="p-3">
                                                        <p class="text-center font-weight-bolder text-secondary">No comments to show here</p>
                                                    </div>
                                                @endif
                                            @endguest
                                            <br /> <br /> <br /> <br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="pb-5">

    </div>
@endsection

@section('script')
     @include('_comment-fns')
@endsection