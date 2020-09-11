@extends('layouts/zim')





<?php
   $categories = \App\Category::all();
   $badges = ['primary', 'secondary', 'success', 'danger', 'warning', 'info' , 'light', 'dark'];
   $bcolor = ['blue', 'grey', 'green', 'red', 'orangered', 'blue', 'black', 'black'];
?>
@section('header')

    <style>
      .hiddenCategory{
          display: none;
      }
      .hidden{
          display: none;
      }
      .active{
          display: block;
      }
      @keyframes fade-down {
          from {margin-top:-30px;opacity: .1; color:white}
          to {margin-top:-10px; opacity: 1}
      }
      .fadeDown{
          animation-name: fade-down;
          animation-timing-function: inherit;
          animation-duration: .5s;
      }
    </style>
@endsection

@section('content')
   <div class="row">
       <div class="col-md-4">
           <div class="container">
               <div class="create-category hidden m-1 my-3">
                   <form method="post" action="category/create">
                       @csrf
                       <input class="form-control rounded-0 text-danger new-category"
                              placeholder="name"
                              name = 'name'
                              style="background-color: transparent;
                              border:none;
                              border-bottom:2px solid orangered;
                              font-family: 'Comic Sans MS'; font-size:1em;color:orange"
                              required
                       />
                       <button class="btn btn-outline-danger rounded-pill mb-4"
                               style="font-size:.9em;font-family: 'Comic Sans MS'"
                       >Create</button>
                   </form>
               </div>
               @foreach($categories as  $index=>$category)
                  <div class="p-1" style="display: flex;">
                     <a class="mr-4 text-info h-info"
                        style="cursor:pointer;"
                        onclick="categoryEdit({{$index}})"
                     >Edit</a>
                     <div class="category-content">
                        @include('admin.blog._category-edit', compact('badges'))
                     </div>
                     <div class="category-rename hiddenCategory">
                         @include('admin.blog._category-rename', ['category' => $category, 'bcolor' => $bcolor])
                     </div>
                  </div>
                   <br />
               @endforeach
           </div>
       </div>
       <div class="col-md-7 offset-1">
           <div class="container">
               <hr />
               <div class="header text-muted">
                   <div id="errors">
                   @if ($errors->any())
                       <div class="text-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                                   <li style="font-family: 'Comic Sans MS'; text-shadow:0px 0px 1px green">{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @elseif (old('general-category'))
                        <div class="text-danger">
                            <li style="font-family: 'Comic Sans MS'; text-shadow:0px 0px 1px green">{{ old('general-category') }}</li>
                        </div>
                   @else
                       @if (old('message'))
                           <p class="text-success"
                            style="font-family: 'Comic Sans MS'; text-shadow:0px 0px 1px green"
                           >* {{old('message')}}</p>
                       @else
                          <p>Errors will appear here</p>
                       @endif
                   @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

    @section('script')
        <script>
            function categoryEdit(ind){
                let div = $1(`categoryEdit${ind}`);
                if (div.className === 'active categoryEdit fadeDown')
                    div.className = 'hidden categoryEdit'
                else
                   div.className = 'active categoryEdit fadeDown'
            }
            function toggleRename(ind){

                if ($$('category-rename')[ind].className === 'category-rename') {
                    $$('category-content')[ind].className += 'category-content'
                    $$('category-rename')[ind].className += ' hiddenCategory'
                    categoryEdit(ind)
                }
                else {
                    $$('category-content')[ind].className += ' hiddenCategory'
                    $$('category-rename')[ind].className = 'category-rename'
                }
            }
            function createCategory(){
                $$('create-category')[0].className = 'create-category active'
            }
            function deleteCategory(ind){
                $$('category-delete')[ind].submit()
            }
        </script>
    @endsection
@endsection
