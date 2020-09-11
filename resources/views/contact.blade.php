@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="css/style.css" />
@endsection

@section('content')
<main class='mb-5 pb-5'>
    <div class="slider-area2">
        <div class="slider-height2 hero-overly2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <h4> Get in touch</h4>
        <div class="row">
            <div class="col-xl-8 col-md-12">
                  <form method="POST">
                       <div class="form-group">
                           <label for="body"></label>
                           <textarea class="form-control"
                                     rows="7"
                                     placeholder="Enter message"
                                     style="font-size:1em;"
                           ></textarea>
                       </div>

                      <div class="row">
                          <div class="col mt-10">
                              <input type="text"
                                     class="form-control"
                                     id="name" style="font-size: 1rem; height:3rem;"
                                     placeholder="Enter name" name="name">
                          </div>
                          <div class="col mt-10">
                              <input type="email"
                                     class="form-control" style="font-size: 1rem; height:3rem;"
                                     placeholder="Email" name="email">
                          </div>
                      </div>

                      <div class="form-group mt-10">
                          <label for="subject"></label>
                          <input type="text"
                                 class="form-control"
                                 placeholder="Subject"
                                 style="font-size:1rem;height:3rem;">
                      </div>

                      <input type="submit" class="boxed-btn text-dark mt-4" />
                  </form>
            </div>
            <div class="col-xl-3 offset-1 mt-5 d-xl-block d-none">
                <div class="container">
                    <div class="text-left">
                     <div class="">
                        <div class="mt-10">
                            <i class="fas fa-home text-secondary" style="font-size:1.5em;"> </i>
                            <span class="pl-2"> Tbilisi, Georgia </span> <br/>
                        </div>
                        <div class="mt-sm-5 mt-35">
                            <i class="fas fa-phone text-secondary" style="font-size:1.5em;"> </i>
                            <span class="pl-2"> +1(234) 995 12 </span> <br/>
                        </div>
                        <div class="mt-sm-5 mt-35 mb-5">
                            <i class="fas fa-envelope text-secondary" style="font-size:1.5em;"> </i>
                            <span class="pl-2"> my@example.com </span> <br/>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    <br />
    <br />
    <br />
@endsection
