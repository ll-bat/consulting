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

       @keyframes _myAnimation{
           from { transform: translateY(125px)  scaleX(.9) scaleY(.8);}
           to {opacity: 1}
       }

       .my-animation-d1 {
           animation: _myAnimation 1s ease-out;
       }
       .my-animation-d2 {
           animation: _myAnimation 1.5s ease-out;
       }
       .my-animation-d3 {
           animation: _myAnimation 2s ease-out;
       }
       
       .wall {
           transition: all 1s ease-out;
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
                                        <div class='d-md-flex d-none'>
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

                                        <div class='row d-block d-md-none'>
                                             <div class='col text-left'>
                                                <div class='position-relative hoverable'>
                                                    <a href="{{route('login')}}" class='font-weight-bolder authorization'>  
                                                        ავტორიზაცია 
                                                    </a> 
                                                 </div>
                                             </div>
                                             <div class='col'>
                                                 <div class='position-relative hoverable mt-2'>
                                                     <a href="{{route('register')}}" class='font-weight-bolder registration'
                                                        style=''>რეგისტრაცია 
                                                     </a> 
                                                 </div>
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
                            <span class='ns-anim-0'>Our Top Services</span>
                            <p class='font-weight-bolder ns-animation-d2' style='font-size:3em;line-height:1em;'>ჩვენი საუკეთესო სერვისები</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 anim-d1">
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
                    <div class="col-lg-4 col-md-6 col-sm-6 anim-d2">
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
                    <div class="col-lg-4 col-md-6 col-sm-6 anim-d3">
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
         <div class='position-relative' style=''>
                 <div class='position-absolute bg-info wall wall-1'
                          style='width:91%; height:100%;bottom:30px;left:50px;box-shadow:0 0 0 white, -2px -2px 8px grey;'>
                 </div>

                 <div class='position-absolute bg-warning  wall wall-2'
                          style='width:91%; height:100%;bottom:20px;left:20px;box-shadow:0 0 0 white, -2px -2px 8px grey; wih:97%'>
                 </div>
     
                <div class="home-blog-area section-padding30 position-relative" 
                  style='background-color:#F5F5F5;padding-top:10rem;margin-bottom:7rem;box-shadow:2px 2px 4px lightgrey, -2px -2px 8px grey;width:100%;'>
                                   
                <div class='position-absolute'
                    style = 'right:.5rem;bottom:.5rem;' id='sprays-area'>
                    <img src='/img/testit/spray-6.png' class='spray invisible' id='spray999' />
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
                             <span class='ns-animation-d2'> სიახლეები </span>
                             <p class='font-weight-bolder ns-animation-d3 ns-attached attached-d2 attached-d3 mt-3' 
                                style="font-size:3rem; line-height:3rem;">ჩვენი უახლესი ბლოგები </p>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     @foreach ($blogs as $ind=>$blog)
                     <div class="col-xl-6 col-lg-6 col-md-6">
                         <div class="home-blog-single mb-30 d{{($ind+2) % 4}}">
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

            <div class='position-absolute has-animation d-none d-lg-block' style='top:-55px;right:10%'>
                 <img src='/icons/clip-3.png' width='180' />
            </div>

           @endif
           </div>
        </div>
   </main>

    <script src='js/spray.js'></script>
    <script>
        
        let sprays = []
        
        function moveAway(i){
            sprays[i].moveAway()
        }
        
        function slowDown(i){
            sprays[i].slowDown()
        }

        function createSpray(i, p){
            let spray = new Spray()
            sprays.push(spray)
            spray.create([`/img/testit/spray-${i%7}.png`, `spray${i}`,'sprays-area'])
            spray.addRoute([300, 2.5, -1, 1, 1, 1, -75, p])
            spray.start()

            tout(() => {
               $1(`spray${i}`).setAttribute('onmouseover', `moveAway(${i})`)
               $1(`spray${i}`).setAttribute('onmouseout', `slowDown(${i})`)
            },200)
        }

        function createSprays(n){
            for (let i=0; i<n; i++){
                createSpray(i, (i+1)*100 / n)
            }
        }

        createSprays(12)


        function isVisible(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
         
        tout(() => {
            $(dom).on('scroll', (ev) => {
                 let elms =[ $2('ns-animation-d1') , $2('ns-animation-d2'), $2('ns-animation-d3')]


                 for (let t = 1; t<=elms.length; t++)
                    for (let i=0; i<elms[t-1].length; i++){
                        if (isVisible(elms[t-1][i]))
                           if (!has(elms[t-1][i], `my-animation-d${t}`)){
                                   add(elms[t-1][i], `my-animation-d${t}`)
                                   if (has(elms[t-1][i]), 'ns-attached'){
                                       let all = elms[t-1][i].className.split(' ').filter((e => e.includes('-') && e.split('-')[0] == 'attached'))
                                                 .map(e => e.split('-')[1])
                                                 .forEach(e => {
                                                     $(`.${e}`).addClass(`my-animation-${e}`)
                                                 })
                                   }
                           }
                    }

                 let el = $2('has-animation')[0]

                 if (isVisible(el)){
                     if (!has(el, 'is-animated')){
                         st($2('wall-1')[0], 'tr: rotate(6deg)')
                         st($2('wall-2')[0], 'tr: rotate(3deg)')
                     }
                 }

                 el = $2('ns-anim-0')[0]

                 if (isVisible(el)){
                     if (!has(el, 'is-animated')){
                         add(el, 'is-animated my-animation-d2')

                         tout(() => {
                             for (let i=1; i<=3; i++){
                                 add($2(`anim-d${i}`)[0], `my-animation-d${i}`)
                             }
                         }, 50)
                     }
                 }
            })
        }, 200) 

    </script>
@endsection
