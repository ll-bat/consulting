@extends('layouts/zim')

@section('header')
 <style>

     @keyframes blog-buttons{
         0% {opacity:0; margin-top:20px; transform: rotateX(-130deg);height:0}
         70% {opacity:.5; margin-top:5px;height:70%;}
         90% {opacity:.8; height:90%;}
         100% {opacity: 1;}
     }
     .animate-buttons{
         animation: blog-buttons .31s ease-in;
     }
     .blur{
         /*color: transparent;*/
         /*text-shadow: 0 0 5px #000;*/
         /*opacity: .31;*/
         transition: all .5s;
     }

     .blog-hoverable {
         background-color: lightgrey;
         color: darkcyan;
         transition: all .4s ease-in;
     }

     .blog-hoverable:hover {
         background-color: #ddddbb;
     }
 </style>
@endsection

@section('content')

<div class="container">

 <div class="row">
     @foreach($blogs as $index => $blog)
   <div class="col-md-6 col-lg-6 col-xl-4 col-sm-6 blog-content">

    <div class="card position-relative" style="border-radius: 15px; width:100%;cursor:pointer"
         onclick="$$('blog-url')[{{$index}}].click()">

        <div class="image blog-image" style="min-height:150px;max-height:500px; background-color: rgba(244, 243, 239,1);">
            <img src="{{$blog->path()}}" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;" />
        </div>

        <div class="card-body overflow-hidden mb-3" style="height:5rem;">
            <div class="text-info">
                <a href="{{route('show', $blog->id)}}"
                   class="blog-url d-none"
                ></a>
                    <h5 class="title blog-title">{{$blog->title}}</h5>
            </div>
        </div>

        <a class='position-absolute px-3 py-2 rounded-pill blog-hoverable'
           href='blog/{{$blog->id}}/edit'
           style='left:-10px; top:-10px;'>
            <i class='fa fa-pencil' style='color:darkcyan;'></i>
         </a>


        <div class="card-footer" style="margin-top:0px;">
            <p class="text-{{$blog->isPublic() ? 'success' : 'danger'}} text-sm font-weight-bolder text-left position-absolute" style="margin-top:-20px;">
                <span class="blog-status"> სტატუსი: {{$blog->isPublic() ? 'საჯარო' : 'დამალული'}} </span>
            </p>
        </div>

     </div>
   </div>
  @endforeach
  </div>
    <div class="mt-3" style="margin-left:40%;">
        {{$blogs->links()}}
    </div>
</div>

<script type="application/javascript">

                $(window).resize(()=>{
                    let width = window.innerWidth;
                    // alert(width)
                    if (width < 900){
                        $('.blog-content').removeClass('col-lg-6').addClass('col-lg-4')
                    }
                    else {
                        $('.blog-content').removeClass('col-lg-4').addClass('col-lg-6')
                    }
                })

                $(window).trigger('resize')
            </script>

@endsection
