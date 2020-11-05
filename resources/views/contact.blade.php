@extends('layouts/app')

<?php 
  $route = Request::route()->getName();
?>

@section('css')
    <link rel="stylesheet" href="css/style.css" />
@endsection

@section('content')
<main class='mb-5 pb-5'>

    @include('_header', ['page' => 'contact'])

    <div class="container mt-5">
        @if (session()->has('message'))
           <p class='alert text-white mb-5' style='background-color:#19303B !important'> {{session('message')}} </p>
        @endif
        <h4> Get in touch</h4>
        <div class="row">
            <div class="col-xl-8 col-md-12">
                  <form method="POST" action='contact'>
                       @csrf
                       <div class="form-group">
                           <label for="body"></label>
                           <textarea class="form-control"
                                     rows="7"
                                     name='message'
                                     placeholder="Enter message"
                                     style="font-size:1em;"
                           ></textarea>

                           @error('message')
                              <p class='text-danger text-sm'> {{$message}} </p>
                           @enderror
                       </div>

                      <div class="row">
                          <div class="col mt-10">
                              <input type="text"
                                     class="form-control"
                                     id="name" style="font-size: 1rem; height:3rem;"
                                     placeholder="Enter name" name="name">
                           
                             @error('name')
                                <p class='text-danger text-sm'> {{$message}} </p>
                             @enderror
                          </div>
                          <div class="col mt-10">
                              <input type="email"
                                     class="form-control" style="font-size: 1rem; height:3rem;"
                                     placeholder="Email" name="mail" />
                              @error('mail')
                                  <p class='text-danger text-sm'> {{$message}} </p>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group mt-10">
                          <label for="subject"></label>
                          <input type="text"
                                 class="form-control"
                                 name='subject'
                                 placeholder="Subject"
                                 style="font-size:1rem;height:3rem;" />

                          @error('subject')
                              <p class='text-danger text-sm'> {{$message}} </p>
                          @enderror
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
    <br /><br />  <br />
    <br /><br />  <br />
@endsection
