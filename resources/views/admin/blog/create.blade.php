@extends('layouts/zim')





<?php
   $categories = \App\Category::all();
?>


@section('content')
    <form method="post" action="./create" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group" style="clear:both;">
                            <h5 form="title">{{ __("სათაური") }}</h5>
                            <input type="text" class="form-control"
                                   style="font-size: 1em;"
                                   placeholder="Add title"
                                   name="title"
                                   value="{{old('title')}}"
                            />
                            @error("title")
                            <p class="text text-danger text-sm">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h5 for="Category" class="pr-3">{{ __("კატეგორია") }}</h5>
                            <select class="form-control" name="category_id">
                                @foreach($categories as $category)
                                    <option
                                        class="p-5 text-muted" style="font-family: 'Comic Sans MS'"
                                        value="{{$category->id}}"
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <h5 form="excerpt">{{ __("ნაწყვეტი") }}</h5>
                    <input type="text"
                           class="form-control" style="font-size:1em;"
                           placeholder="Enter excerpt"
                           name="excerpt"
                           value="{{old('excerpt')}}"
                    />
                    @error("excerpt")
                    <p class="text text-danger text-sm">
                        {{$message}}
                    </p>
                    @enderror
                </div>

                <div class="form-group">
                    <h5 for="excerpt">{{ __("ტექსტი") }}</h5>
                    <textarea
                        class="form-control"
                        id = "article-editor"
                        style=""
                        placeholder="Here goes body..."
                        rows="6"
                        name="body"
                    >{{old('body')}}</textarea>

                    @error("body")
                    <p class="text text-danger text-sm">
                        {{$message}}
                    </p>
                    @enderror
                </div>

                <input type="file" value="Upload"
                       name="image"
                /><br/>

                @error("image")
                <p class="text text-danger text-sm">
                    {{$message}}
                </p>
                @enderror

                <button class="btn btn-info mt-5" style="border-radius: 20px;">{{ __("შექმნა") }}</button>

            </div>
        </div>
    </form>
    <script type="application/javascript">
        CKEDITOR.replace( 'article-editor');
    </script>
@endsection
