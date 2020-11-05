@extends('layouts/zim')

<?php
   $categories = \App\Category::all();
?>

@section('header')
    <style>


        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 27px;
            float:right;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input.default:checked + .slider {
            background-color: #444;
        }
        input.primary:checked + .slider {
            background-color: #2196F3;
        }
        input.success:checked + .slider {
            background-color: #8bc34a;
        }
        input.info:checked + .slider {
            background-color: #3de0f5;
        }
        input.warning:checked + .slider {
            background-color: #FFC107;
        }
        input.danger:checked + .slider {
            background-color: #f44336;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
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

           <button class="btn btn-danger position-absolute" style="border-radius: 20px; top:10px;"> წაშლა </button>
     </form> 
@endsection