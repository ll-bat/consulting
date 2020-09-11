@extends('layouts.app')


@section('css')

    <style>
       .left-border {
           border-left:.7rem solid #1B4961;
           transition:all .4s ease-out;
       }

       .home-blog-area:hover .sizeable-border {
           border-left-width:2rem;
       }

       .text-orange {
           color: orange;
       }

       .bg-orange {
           background-color: orange;
       }

       .lh1 {
           line-height: 1rem;
       }

       .spray {
           transform: rotate(180deg);
           transition:.05s ease;
       }

       .authorization {
           /* text-shadow:.1rem .1rem .1rem lightgrey, -.1rem -.1rem .1rem lightgrey; */
           color: #EB566C;

       }

       
       .authorization:hover {
           color:#C55161;

       }

       .registration {
           /* text-shadow:.1rem .1rem .1rem lightgrey, -.1rem -.1rem .1rem lightgrey; */
           color:blueviolet

       }
       .registration:hover {
           opacity:.9;
           color:purple;
       }

       .ns-border {
           width:100%;
           height:.1rem;
           border-bottom: 1px dotted lightgrey;
           bottom: -.5rem;
           transition: all .2s ease;
       }


       .ns-underline {
           width:0%;
           height:.12rem;
           background-color:purple !important;
           bottom: -.5rem;
           transition:all .3s ease-out;
       }

       .hoverable:hover .ns-underline {
           width:100%;
       }

       .hoverable:hover .ns-border {
           width:0;
       }

       .hero-btn {
           background-color: #CF4B56 !important;
       }

       .hero-btn:hover {
           background-color: #C55161 !important;
       }

    </style>
@endsection

@section('content')
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="/img/logo/loder.jpg" alt="">
            </div>
        </div>
    </div>
</div>
   <main>
       <div class="slider-area ">
            <div class="slider-active" >
                <div class="single-slider slider-height d-flex align-items-center" style=''>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-7 col-md-8">
            
                                <div class="hero__caption" style=''>
                                    <span data-animation="fadeInLeft" data-delay="1.6s">Committed to success</span>
                                    <p style='color:darkcyan;text-shadow:.1rem .1rem .1rem black;font-size:3rem;line-height:4rem;' 
                                       data-animation="fadeInLeft" data-delay="1.8s" >ჩვენ წარმატების მიღწევაში გეხმარებით</p>
                                    <!-- <p class='d-md-block d-sm-none text-secondary' style='color:rgba(0,0,0,.5)' data-animation="fadeInUp" data-delay=".9s"> ჩვენი სერვისებით სარგებლობისათვის, აუცილებელია  
                                    <br> გაიარო <a href='' class='authorization font-weight-bolder'>  ავტორიზაცია </a>, ან <a href='' class='registration font-weight-bolder' style=''>დარეგისტრირდე </a> ახლავე.</p> -->
                    
                                    <div class='mb-5' data-animation="fadeInLeft" data-delay="2s" style='font-size:1.3rem;'> 
                                        <div class='d-flex'>
                                           <div class='position-relative hoverable'>
                                               <a href="{{route('login')}}" class='font-weight-bolder authorization'>  
                                                   ავტორიზაცია 
                                               </a> 
                                               <div class='ns-underline position-absolute' style='background-color:#EB566C !important'></div>
                                               <div class='ns-border position-absolute'></div>
                                            </div>
                                            
                                            <div class='position-relative hoverable ml-3'>
                                                <a href="{{route('register')}}" class='font-weight-bolder registration'
                                                   style=''>რეგისტრაცია 
                                                </a> 
                                               <div class='ns-underline position-absolute' style=''></div>
                                               <div class='ns-border position-absolute' style=''></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hero__btn" data-animation="fadeInLeft" data-delay="1.6s">
                                        <a href="{{route('services')}}" class="btn hero-btn py-4 px-3" style='font-size:1rem;border-radius:0;font-weight:normal;'>ჩვენი სერვისები</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
        

        <div class="categories-area section-padding30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle mb-70">
                            <span>Our Top Services</span>
                            <p class='font-weight-bolder' style='font-size:3em;line-height:1em;'>ჩვენი საუკეთესო სერვისები</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center mb-50">
                            <div class="cat-icon">
                                <span class="flaticon-team"></span>
                            </div>
                            <div class="cat-cap">
                                <h5><a href=""> კონსულტირება </a></h5>
                                <p>There are many variations of passages of lorem Ipsum available but the new majority have suffered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center mb-50">
                            <div class="cat-icon">
                                <span class="flaticon-result"></span>
                            </div>
                            <div class="cat-cap">
                                <h5><a href=""> დოკუმენტის ექსპერტიზა </a></h5>
                                <p>There are many variations of passages of lorem Ipsum available but the new majority have suffered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center mb-50">
                            <div class="cat-icon">
                                <span class="flaticon-development"></span>
                            </div>
                            <div class="cat-cap">
                                <h5><a href=""> რისკების შეფასება </a></h5>
                                <p>There are many variations of passages of lorem Ipsum available but the new majority have suffered.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>  

         <!-- rgba(0,0,0,.04) -->

         @if ($blogs->count() > 0)
           <div class="home-blog-area section-padding30 position-relative" 
             style='background-color:rgba(0,0,0,.04);padding-top:10rem;margin-bottom:7rem;'
             >
                      
                <div class='position-absolute'
                    style = 'right:.5rem;bottom:.5rem;' id='sprays-area'>
                    <img src='/img/testit/spray-6.png' class='spray' id='spray999' />
                </div>

               <div class='position-absolute left-border sizeable-border d-none d-lg-block' 
                   style='left:0;top:0;height:100%;'></div>
                
               <div class='position-absolute left-border d-none d-sm-block d-lg-none' 
                   style='left:0;top:0;height:100%;'></div>
                
               
               <div class="container">
                 <!-- Section Tittle -->
                 <div class="row">
                     <div class="col-lg-12">
                         <div class='position-absolute d-sm-block d-md-none'
                                style = 'top:-5rem;bottom:-1rem;left:-1rem;'>
                             <img src='/img/testit/testit.png' style='width:100%; height:100%;' />
                         </div>

                         <div class="section-tittle mb-100 ml-5 position-relative">
                             <span> სიახლეები </span>
                             <p class='font-weight-bolder mt-3' 
                                style="font-size:3rem; line-height:3rem;">ჩვენი უახლესი ბლოგები </p>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     @foreach ($blogs as $blog)
                     <div class="col-xl-6 col-lg-6 col-md-6 invisible">
                         <div class="home-blog-single mb-30">
                             <div class="blog-img-cap">
                                 <div class="blog-img">
                                     <img src="{{$blog->path()}}" style='height:20rem;' alt="">
                                     <ul>
                                         <li>By Admin   -   {{$blog->postDate()}}</li>
                                     </ul>
                                 </div>
                                 <div class="blog-cap" style='height:16rem;'>
                                     <h3><a>{{$blog->title}}</a></h3>
                                     <p class='overflow-hidden' style='max-height:60px;'> {{$blog->excerpt}} </p>
                                     <a href="blog/{{$blog->id}}" 
                                        class="more-btn bg-white  position-absolute"
                                        style='bottom:3rem;'>Read more</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                    @endforeach
                 </div>
            </div>
           @endif
        </div>
   </main>

    <script src='js/spray.js'></script>
    <script>

        function createSpray(){
            let spray = new Spray()
            spray.create(['/img/testit/spray-0.png', 'spray0','sprays-area'])
            spray.addRoute([100, 200, 1, 1, 2, 1, 90])
            spray.addRoute([100, 200, -1, -1, 1.4, 1.6])
            spray.start()
        }

        createSpray()


    </script>
@endsection
