<?php
  $current_route = Request::path();
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel = "icon" href ="/img/title/test.png"
          type = "image/x-icon">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Google+Sans:400,500|Roboto:300,400,400i,500,700&amp;subset=latin,vietnamese,latin-ext,cyrillic,greek,cyrillic-ext,greek-ext" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css" /> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  

    <link href="/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="/css/custom.css" />
    <link rel="stylesheet" href="/css/zestyle.css" />
    <link rel="stylesheet" href="/css/flaticon.css">

    <link rel="stylesheet" href="/css/dif/owl.carousel.min.css">
	<link rel="stylesheet" href="/css/dif/slicknav.css">
	<link rel="stylesheet" href="/css/dif/flaticon.css">
	<link rel="stylesheet" href="/css/dif/animate.min.css">
	<link rel="stylesheet" href="/css/dif/magnific-popup.css">
	<link rel="stylesheet" href="/css/dif/fontawesome-all.min.css">
	<link rel="stylesheet" href="/css/dif/themify-icons.css">
	<link rel="stylesheet" href="/css/dif/slick.css">
	<link rel="stylesheet" href="/css/dif/nice-select.css">
	<link rel="stylesheet" href="/css/dif/style.css">

    <script type='application/javascript' src="/js/custom.js"></script>
    @yield('css')

    <style>
        
        .nav-link {
            transition: .3s ease-in;
        }
        .nav-link:hover {
            opacity: .8 !important;
        }

        .borderdown {
            width:0;
            height:.1rem;
            background-color: black;
            margin-left:.1rem;
            margin-right:.1rem;
            transition: all .3s ease-in;
            margin-left:50%;
        }

        .hoverable:hover .borderdown {
            margin-left:0;
            width: 100%;
        }

        .text-red-white {
            color:red !important;
        }

        .text-red-white: hover {
            color: white;
        }

        .login-btn {
            padding-left:1.2rem !important;
            padding-right:1.2rem !important;
        }
    </style>
</head>
<body class="" @if ($current_route == '') style='background-color:rgba(0,0,0,.04)' @endif>
<header>
    <div class="header-area">
        <div class="main-header">
            <div class="header-bottom  header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                                <a href="/"><img src="/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10">
                            <div class="menu-wrapper  d-flex align-items-center justify-content-end">
                                <div class="main-menu d-none d-lg-block">
                                    <nav> 
                                        <ul id="navigation">                                                                                          
                                            <li>
                                               <a href="/" class='nav-link'>Home</a>
                                            </li>
                                            <li><a href="{{route('about')}}" class='nav-link'>About</a></li>
                                            <li><a href="{{route('blog')}}" class='nav-link'>Blogs</a></li>
                                            <li><a href="{{route('services')}}" class='nav-link'>Services</a>
                                                <ul class="submenu">
                                                    <li><a href="#">service 1</a></li>
                                                    <li><a href="#">service 2</a></li>
                                                    <li><a href="#">service 3</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{route('contact')}}" class='nav-link'>Contact</a></li>
                                            @auth
                                               <li><a href="{{route('user.home')}}" class='d-md-flex d-lg-block'>
                                                   <img src='{{current_user()->pathAvatar()}}' class='rounded-pill' width='40' height='40' />
                                                   <span class='d-lg-none d-block p-2'> My profile </span>
                                                  </a>
                                                </li>
                                           @endauth
                                           @guest 
                                             <li class='position-lg-absolute position-md-relative' style='right:-1rem;'>
                                                 <a href="{{route('login')}}" class='btn btn-outline-danger login-btn text-red-white' style='padding-top:.5rem !important; padding-bottom:.5rem !important;'>Login</a>
                                            </li>
                                           @endguest
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

  <main class="">
      @yield('content')
  </main>
  <script>
            function showComments(k){

                let c = $$('comments')[k].style.display

                if (c === "")
                {
                    $$('comments')[k].style.display  = "none"
                }
                else
                    $$('comments')[k].style.display = ""
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function postComment(k,i) {
                $.ajax({
                    url: '/comment/' + i,
                    type: 'post',
                    data:
                        '_token={{csrf_token()}}',
                    data: {
                        body: $$('postComment')[k].value
                    },
                    success: function (res) {
                        
                    },
                    error: function (request, status, error) {
                        set(request.responseText);
                    }
                });

                    $$('error-message')[k].innerHTML = ''
                    renderComment($$('postComment')[k].value, k)
                    $$('postComment')[k].value = ''


                function set(res) {
                    $$('error-message')[k].innerHTML = 'გთხოვთ შეიყვანოთ ტექსტი'
                }
            }

            function encodeHTML(s) {
                   return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
            }

            function renderComment(body, i) {
                if (body == '') return
                body = encodeHTML(body)
                
                let result = `
                               <div class="media p-3 mb-4 ml-3" style="width: 100%; ">
                                  <img src="{{getAvatar()}}" class="mr-3 mt-3 rounded-circle" style="width:40px;height:40px">
                                  <div class="media-body" style="padding-bottom:-1px;">
                                        <h6>@ <b class="text-info">{{auth()->user()->username ?? false}}</b> said..</h6>
                                        <p class="text-muted font-weight-bolder ns-font-family"
                                           style="font-size:.9em;line-height: 2em;">${body}...</p>
                                          </div>
                                         </div> `
                $$("all-comments")[i].innerHTML += result
                // console.log($$('all-comments')[i])
            }

            $(window).on('autoresize', function(){
             $('.autoresize').on('input', function () {
                 this.style.height = 'auto';

                 this.style.height =
                     (this.scrollHeight) + 'px';
             });
  })
  </script>

    <br /><br /><br />
    <div class="footer" style="background-color: rgb(8, 11, 18);">
        <div style="margin-left:50px;margin-top:20px;margin-right:50px;">
            <hr style="border:none; border-top:1px solid rgba(35, 49, 72,1);">
            <p class="text-white" style="font-family: 'Yu Gothic'"> Copyright ©2020 All rights reserved |
                This template is made by <span style="color:red">Colorlib</span></p>
            <div class="float-right pb-2">
                <a href="#" class="pl-3"><i class="fab fa-twitter" ></i></a>
                <a href="#" class="pl-3"><i class="fab fa-facebook"></i></a>
                <a href="#" class="pl-3"><i class="fa fa-globe"    ></i></a>
                <a href="#" class="pl-3"><i class="fab fa-instagram" ></i></a>
            </div>
        </div>
    </div>

    <script src="/js/dif/jquery.slicknav.min.js"></script>
    <script src="/js/dif/jquery.nice-select.min.js"></script>
    <script src="/js/dif/jquery.sticky.js"></script>

    <script src="/js/dif/owl.carousel.min.js"></script>
    <script src="/js/dif/slick.min.js"></script>

    <script src="/js/dif/wow.min.js"></script>
    <script src="/js/dif/animated.headline.js"></script>
    <script src="/js/dif/jquery.magnific-popup.js"></script>

    <script src="/js/dif/jquery.counterup.min.js"></script>
    <script src="/js/dif/jquery.ajaxchimp.min.js"></script>

    <script src="/js/dif/plugins.js"></script>
    <script src="/js/dif/main.js"></script>

     @yield('script') 
</body>
</html>
