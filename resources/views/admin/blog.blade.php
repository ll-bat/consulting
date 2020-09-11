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
 </style>
@endsection

@section('content')

<div class="container">
 <div class="row">
     @foreach($blogs as $index => $blog)
   <div class="col-md-6 col-lg-6 col-xl-4 col-sm-6 blog-content">
    <div class="card"
         style="border-radius: 15px; width:100%;cursor:pointer"
         onclick="$$('blog-url')[{{$index}}].click()"
         onmouseover="showBlogButtons({{$index}})"
         onmouseout ="hideBlogButtons({{$index}})">
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
{{--            <div class="description" style="font-size:.9em;overflow:hidden;max-height:200px;">--}}
{{--               <p class="text-left text-muted" style="font-size:1em">--}}
{{--                   {!! $blog->body !!}  ...--}}
{{--                </p>--}}
{{--            </div>--}}
        </div>
        <div class="card-footer" style="margin-top:0px;">
            <p class="text-{{$blog->isPublic() ? 'success' : 'danger'}} text-sm font-weight-bolder text-left position-absolute" style="margin-top:-20px;">
                <span class="blog-status"> status: {{$blog->isPublic() ? 'public' : 'hidden'}} </span>
            </p>
            <div class="button-container blog-buttons" style="margin-top:-40px;">
               <div class="invisible blog-invisible position-absolute" style="left:50%;">
                   <div class="position-relative" style="left:-50%">
                       <div class="row">
                          <div class="col ml-lg-auto">
                             <form method="get" action="blog/{{$blog->id}}/edit">
                                 <button class="btn btn-outline-primary bg-white"  style="border-radius: 30px;width:100%; min-width:80px;"> Edit </button>
                             </form>
                          </div>
                          <div class="col mr-lg-auto">
                            <form method="get" action="blog/{{$blog->id}}/delete">
                                @csrf
                                <button class="btn btn-outline-danger bg-white" style="border-radius:30px;width:100%; min-width:80px;"> Delete </button>
                            </form>
                          </div>
                        </div>
                   </div>
               </div>
            </div>
            <script type="application/javascript">
                function showBlogButtons(ind){
                    $$('blog-invisible')[ind].className="blog-invisible position-absolute animate-buttons"
                    $$('blog-status')[ind].className = 'blog-status blur'
                    $$('blog-title')[ind].className = 'title blog-title blur'
                    $$('blog-image')[ind].className = 'image blog-image blur'
                     $('.blur').css({'color':'transparent', 'text-shadow':'0 0 5px #000', 'opacity':'.31'})
                }
                function hideBlogButtons(ind){
                    $$('blog-invisible')[ind].className="invisible blog-invisible position-absolute"
                    $('.blur').css({'color':'', 'text-shadow':'', 'opacity':''})
                    $$('blog-status')[ind].className = 'blog-status'
                    $$('blog-title')[ind].className = 'title blog-title'
                    $$('blog-image')[ind].className = 'image blog-image'

                }

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
        </div>
     </div>
   </div>
  @endforeach
  </div>
    <div class="mt-3" style="margin-left:40%;">
        {{$blogs->links()}}
    </div>
</div>

@endsection
