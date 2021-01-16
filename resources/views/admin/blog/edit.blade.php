@extends('layouts/zim')

<?php
   $categories = \App\Category::all();
?>

@section('header')
    <link rel="stylesheet" href="/css/switch.css" />
@endsection




@section('content')
    <form method="post" action="./edit" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
           <div class="container">
               <div class="row">
                   <div class="col-md-8">
                       <div class="form-group" style="clear:both;">
                           <h5 form="title">სათაური</h5>
                           <input type="text" class="form-control"
                                  style="font-size: 1em;"
                                  placeholder="Add title"
                                  name="title"
                                  value="{{$blog->title}}"
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
                           <h5 for="Category" class="pr-3">კატეგორია</h5>
                           <select class="form-control" name="category_id">
                               @foreach($categories as $category)
                                   <option
                                       class="p-5 text-muted" style="font-family: 'Comic Sans MS'"
                                       value="{{$category->id}}"
                                       @if ($category->id == $blog->category_id) selected @endif
                                   >{{$category->name}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
               </div>

            <div class="form-group">
                <h5 form="excerpt">ნაწყვეტი</h5>
                <input type="text"
                       class="form-control" style="font-size:1em;"
                       placeholder="Enter excerpt"
                       name="excerpt"
                       value="{{$blog->excerpt}}"
                />
                @error("excerpt")
                <p class="text text-danger text-sm">
                    {{$message}}
                </p>
                @enderror
            </div>

            <div class="form-group">
                <h5 for="excerpt">ტექსტი</h5>
                <textarea
                    class="form-control"
                    id="article-editor"
                    style=""
                    placeholder="Here goes body..."
                    rows="6"
                    name="body"
                >{{$blog->body}}</textarea>

                @error("body")
                <p class="text text-danger text-sm">
                    {{$message}}
                </p>
                @enderror
            </div>

            <div class="">
              <div class="float-left">
                 <input type="file" value="Upload"
                        name="image"
                 /><br/>

                 @error("image")
                   <p class="text text-danger text-sm">
                     {{$message}}
                   </p>
                 @enderror
              </div>


                <div class="float-right">
                    <div class="container text-right">
                        <span class="text-muted m-2" style="font-family: 'Comic Sans MS'">საჯარო: </span>
                        <label class="switch">
                            <input type="checkbox" class="primary"
                                   @if ($blog->isPublic()) checked @endif
                                   onchange="togglePublish()">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <button class="btn btn-info mt-5" style="border-radius: 20px;">განახლება</button>

          </div>
       </div>
    </form>
    <script type="application/javascript">
        function togglePublish(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             $.ajax({
                  url: 'toggle',
                  type: 'get',
                  data:
                     '_token={{csrf_token()}}',
                  success: function (res) {

                  },
                  error: function (request, status, error) {
                      alert(request.responseText);
                  }
             })
        }
        CKEDITOR.replace( 'article-editor');
    </script>

@endsection

@section('toolbar')
     <form method='post' action='delete'>
           @csrf
           @method('delete')

           <button class="btn btn-danger position-absolute" onclick="return confirm('ნამდვილად გსურთ ამ ბლოგის წაშლა ?')" style="border-radius: 20px; top:10px;"> წაშლა </button>
     </form>
@endsection
