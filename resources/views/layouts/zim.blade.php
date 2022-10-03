<?php
$abroutes = ['admin.blog'];
$route = Request::route()->getName();
$current_route = Request::path();
$path = '';

if (in_array($route, $abroutes))
    $path = route($route);
?>

    <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Home
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <link rel="icon" href="{{getAvatar()}}"
          type="image/x-icon">

    <link href="/css/paper-dashboard.css?v=2.0.1" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/zestyle.css"/>
    <link rel="stylesheet" href="/css/forzim.css"/>

    <script type='application/javascript'
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type='application/javascript'
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type='application/javascript'
            src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    @yield('header')

    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/custom.js"></script>

    <style>
        .partial-sidebar {
            width: 70px !important;;
            overflow: hidden;
            transition: all .5s ease-out;
        }

        .partial-sidebar:hover {
            width: 260px !important;
            overflow: hidden;
        }

        .bg-normal {
            background-color: rgb(244, 243, 239)
        }

        .bg-docs {
            background-color: rgba(69, 97, 144, .06);
            /* background-color: #f5f7f8; */
        }

        .ns-bottom {
            /* border-bottom:1px solid rgba(0,0,0,.3); */
            box-shadow: 4px 0 5px lightgrey;
        }
    </style>
</head>

<body class="@if (!in_array($route,collapsedRoutes())) bg-docs @else bg-normal @endif"
      style="@if ($route == 'user.questions') background-color:rgba(0, 255, 128, 0.035); @endif">
<div class="wrapper" @if ($route == 'admin.docs') id='app' @endif>
    <nav class="fixed-top navbar-transparent" id="mainNavbar">
        <div class="container-fluid">
            <div class="sidebar-wrapper">
                <div class="sidebar @if (!in_array($route,collapsedRoutes())) partial-sidebar @endif" data-color="white"
                     data-active-color="danger" id="sidebar">
                    <div class="logo">
                        <a href="" class="simple-text logo-mini">
                            <div class="logo-image-small">
                                <img src="/icons/conme.png">
                            </div>
                        </a>
                        <a href="" class="simple-text logo-normal" style="z-index: 2">
                            I'm {{ current_user()->username}}
                            <i class="fa fa-remove d-lg-none" style="margin-left:90px;z-index:1; color:grey"
                               onclick="$(window).trigger('resize'); event.preventDefault()"
                            ></i>
                        </a>
                    </div>

                    <div class="sidebar-wrapper" id="sidebarWrapper">
                        <ul class="nav">
                            @foreach(userRoutes() as $routes)
                                <li class="{{ $route == $routes['route'] ? 'active' : '' }} ">
                                    <a href="{{  $routes['route'] ? route($routes['route']) : ''}}">
                                        <div class="d-flex">
                                            <i class="{{$routes['icon']}}"></i>
                                            <p class="ml-2"> {{$routes['name'] }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                            @if (current_user()->isAdmin())
                                @foreach(adminRoutes() as $routes)
                                    <li class="{{ $route == $routes['route'] ? 'active' : '' }}">
                                        <a href="{{  $routes['route'] ? route($routes['route']) : ''}}">
                                            <i class="{{$routes['icon']}}"></i>
                                            <p class="ml-2"> {{$routes['name'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-panel @if (!in_array($route,collapsedRoutes())) bg-white ns-bottom  @endif"
         id="main-panel"
         style="height:65px; @if (!in_array($route,collapsedRoutes())) width:calc(100% - 70px);@endif">
        <!-- Navbar -->
        <nav
            class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent @if ((!in_array($route,collapsedRoutes())) || $route == 'admin.blog') border-bottom-0 @endif"
            style="">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle" id="navbar-toggle">
                        <button class="navbar-toggler"
                                type="button"
                                onclick="toggleButtonClick()"
                        >
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>

                    <div class="navbar-brand pb-0 pl-sm-4">
                        @if ($route == 'admin.blog')
                            <a href="blogs/create"
                               class="btn btn-info shadow text-white"
                               style="border-radius: 25px;background-color: rgba(83, 133, 163,.71)">
                                <i class="fa fa-plus" style="color:white"></i>
                                Create
                            </a>
                            <a href="blogs/categories"
                               class="btn btn-outline-info shadow text:orange"
                               style="border-radius: 25px;">
                                <i class="fa fa-pencil"></i>
                                Categories
                            </a>

                        @elseif ($route == 'blog.categories')
                            <a
                                class="btn btn-info shadow text-white rounded-pill"
                                style='margin-top:0px;'
                                onclick='createCategory()'
                            >
                                <i class="fa fa-plus"></i> New
                            </a>

                        @else
                            @yield('toolbar')
                            @if (!in_array($route, nbackRoutes()))
                                <div class="position-absolute" style="top:5px;left: 70px;">
                                    <a class='btn btn-outline-secondary' onclick="history.go(-1)">
                                        Back
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
                @if (in_array($route, toolbarRoutes()))
                    <div class="collapse navbar-collapse justify-content-end mx-5">
                        <div class='text-right mt-md-0 mt-5'>
                            <form method='post' action='../../../docs/import/controls/{{$danger->id}}'
                                  enctype="multipart/form-data">
                                @csrf
                                <input type='file' class='d-none' id='import_excel' name='control'
                                       onchange='this.parentNode.submit()'/>
                                <button class='btn text-white border-0 py-1 px-3' style="background-color: #007799"
                                        onclick="$1('import_excel').click(); event.preventDefault()"><i
                                        class='fa fa-plus'></i>
                                    {{ __("კონტრ.ზომები") }}
                                </button>
                            </form>
                            @if ($errors->has('control'))
                                <p class='text-danger text-sm'> {{ __("გთხოვთ, ატვირთოთ ექსელის დოკუმენტი") }} </p>
                            @endif
                        </div>
                    </div>
                @else
                    @if (!in_array($route, searchInvisible()))
                    <div class="collapse navbar-collapse justify-content-end" style="background-color: #F5F4F0"
                         id="navigation">
                        <form method="get" action="{{$path}}">
                            <div class="input-group no-border">
                                <input type="text"
                                       class="form-control"
                                       style="font-size:1em;"
                                       placeholder="Search..."
                                       value=""
                                       name="key"
                                >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                @endif
                <ul class="navbar-nav pointer">
                    <li class="nav-item btn-rotate dropdown c-parent-dropdown">
                        <a class="nav-link dropdown-toggle"
                           id="navbarDropdownMenuLink"
                           onclick="dropDown()"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nc-icon nc-bell-55"></i>
                        </a>
                        <div class="c-dropdown-menu dropdown-menu-right pb-0 pt-0 pl-0 border-0"
                             id='c-dropdown-menu'
                             style="border-radius:10px;"
                        >
                            <a class="dropdown-item c-dropdown-item c-top-radius py-2" href="/">{{ __("მთავარი გვერდი") }}</a>
                            @if ($route == 'danger.show')
                                <a class="dropdown-item c-dropdown-item py-2 d-block d-lg-none"
                                   onclick="$1('import_excel').click();">
                                    {{ __("კონტრ.ზომები") }}({{ __("ექსელი") }}) </a>
                            @endif
                            <a class="dropdown-item c-dropdown-item c-bottom-radius py-2"
                               onclick="$1('signOut').submit()">{{ __("გამოსვლა") }}
                            </a>

                            <form method='post' action='/logout' class='d-none' id='signOut'>
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <input type="hidden" value="{{$current_route}}" id='current_route'/>

        <div class="content pt-2">
            @yield('content')
        </div>
    </div>

    <script type="application/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function toggleButtonClick() {
            $1('mainNavbar').style.display = 'block'

            tout(() => {
                $1('sidebar').className = "sidebar collapsed show"
                let height = window.innerHeight + 10
                $('#sidebar').css({'height': height + 'px', "margin-top": "-10px", "margin-left": "260px"})
            }, 1)
        }


        function adjustScreen() {
            @if ((!in_array($route,collapsedRoutes())))
            let width = window.innerWidth
            if (width < 992) {
                $1('main-panel').style.width = '100%'
            } else {
                $1('main-panel').style.width = 'calc(100% - 70px)'
            }

            if (width < 768) {
                if ($(".ns-position-absolute").hasClass('position-absolute'))
                    $(".ns-position-absolute").removeClass('position-absolute')
            } else {
                if (!$(".ns-position-absolute").hasClass('position-absolute'))
                    $(".ns-position-absolute").addClass('position-absolute')

            }
            @endif

            adjustOtherColumns()
        }

        function adjustOtherColumns() {
            if (window.innerWidth > 850) {
                if (window.innerWidth < 1100) {
                    $('#main-part').removeClass('col-xl-6').removeClass('col-xl-7').addClass('col-xl-8')
                } else if (window.innerWidth < 1600) {
                    $('#main-part').removeClass('col-xl-6').removeClass('col-xl-8').addClass('col-xl-7')
                } else {
                    $('#main-part').removeClass('col-xl-7').removeClass('col-xl-8').addClass('col-xl-6')
                }
            }
        }

        window.addEventListener('resize', (e) => {
            adjustScreen()
        })

        $(window).resize(() => {
            $('#sidebar').css({'height': '', "margin-top": '', 'margin-left': ''})
            $1('sidebar').className = "sidebar @if (!in_array($route,collapsedRoutes())) partial-sidebar @endif"
            adjustScreen()
        })

        adjustScreen()

        $(window).on('autoresize', function () {
            $('.autoresize').on('input', function () {
                this.style.height = 'auto';

                this.style.height =
                    (this.scrollHeight) + 'px';
            });
        })

        tout(() => {
            $(window).trigger('autoresize')
        }, 200)


        function toggleCollapseClick(obj, id) {
            if (has($1(id), 'd-none')) {
                $(`#${id}`).removeClass('d-none')
                $(obj).removeClass("btn-outline-primary").addClass('btn-outline-danger')
                $(obj).text('hide')
            } else {
                $(`#${id}`).addClass('d-none')
                $(obj).removeClass("btn-outline-danger").addClass('btn-outline-primary')
                $(obj).text('show')
            }
        }

    </script>
    @yield('script')
</div>
@if ($route == 'admin.docs')
    <script type='application/javascript' src="/js/proc.js"></script>
@elseif ($route == 'admin.check')
    <script type='application/javascript' src="/js/ch.js"></script>
@elseif ($route == 'user.questions')
    <script type='application/javascript' src="/js/q.js"></script>
@elseif ($route == 'user.preQuestions')
    <script type="application/javascript" src="/js/preQuestions.js"></script>
@endif

<br/><br/><br/>
</body>

</html>
