@extends('layouts/app')


<?php
   $route = Request::route()->getName();
   $catid = request('categoryId') ?? -1;
?>



@section('css')
    <link rel="stylesheet" href="css/style.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .page-item {
            margin: 5px !important;;
        }

        .hover-comment {
            transition: all .3s ease-in;
        }
        .hover-comment:hover {
             color: #423e47 !important;
        }

        .comment-image {
            transition: all .4s ease-in;
        }
        .hoverable:hover .comment-image {
            transform: rotate(-30deg);
        }

    </style>
@endsection


@section('content')


    @include('_header', ['page' => 'blogs'])

    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                   @foreach($blogs as $index => $blog)
                    <div class="blog_left_sidebar">
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="{{$blog->path()}}" alt="">
                                <a href="#" class="blog_item_date">
                                    <h3>{{$blog->getDay()}}</h3>
                                    <p>{{$blog->getMonth()}}</p>
                                </a>
                            </div>

                            <div class="blog_details">
                                <a class="d-inline-block" href="blog/{{$blog->id}}">
                                    <h2>{{$blog->title}}</h2>
                                </a>
                                <div style=''>
                                   <p style='position:relative;'>
                                     {{ $blog->excerpt }}
                                   </p>
                                 </div>
                                <div class="blog-info-link mt-0">
                                    <p class="cursor text-secondary hover-comment" onclick="showComments({{$index}})"><i class="fa fa-comments" style="font-size:.9em;"></i>
                                         <span id='comments-count{{$index}}'> {{count($blog->comments)}} </span> comments
                                    </p>
                                    <div class="comm" style="margin-top:-10px;">
                                      <div class="comments" style="display:none;">
                                          <div class="main mt-3 all-comments">
                                              @foreach($blog->getLastThree() as $comment)
                                                  @include('_comment')
                                              @endforeach
                                          </div>

                                          @auth
                                              @include('_write-comment', compact('index'))
                                          @endauth
                                          @guest()
                                              @if (count($blog->comments) == 0)

                                                  <div class="p-3">

                                                      <p class="text-center font-weight-bolder text-secondary">No comments to show here</p>

                                                  </div>

                                              @endif
                                          @endguest
                                     </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                   @endforeach

                    @if (count($blogs) == 0)
                       <h4 class="text-center">
                           There are no blogs
                       </h4>
                    @endif

                    <div class="" style="margin-left:calc(50% - 100px)">
                        {{ $blogs->links() }}
                    </div>

                </div>

                <div class="col-lg-4 pb-5">
                    <div class="content offset-xl-4 this-color ns-font-family pointer offset-1">
                        <ul class="list-style:none">
                           <a href="blog"> <h5> Category </h5> </a>
                            @foreach($categories as $category)
                              <hr />
                              <a href="?categoryId={{$category->id}}" class="this-color" style="color:#1b4962">
                                  <li class="pt-0 @if ($category->id == $catid) th-color-s @else th-color @endif">
                                      {{$category->name}}({{$category->getCount()}})
                                  </li>
                              </a>
                           @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <br /> <br /> <br />
    <br /> <br /> <br />
@endsection


@section('script')
     @include('_comment-fns')
@endsection