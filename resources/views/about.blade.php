@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="css/style.css" />
@endsection

@section('content')
    @include('_header', ['name' => 'About us'])

<div class="about-details section-padding30">
    <div class="container">
        <div class="row">
            <div class="offset-xl-1 col-lg-8">
                <div class="about-details-cap mb-50">
                    <h4>Our Mission</h4>
                    <p>Consectetur adipiscing elit, sued do eiusmod tempor ididunt udfgt labore et dolore magna aliqua. Quis ipsum suspendisces gravida. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus.
                    </p>
                    <p> Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan.</p>
                </div>

                <div class="about-details-cap mb-50">
                    <h4>Our Vision</h4>
                    <p>Consectetur adipiscing elit, sued do eiusmod tempor ididunt udfgt labore et dolore magna aliqua. Quis ipsum suspendisces gravida. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus.
                    </p>
                    <p> Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="team-area mb-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="cl-xl-7 col-lg-8 col-md-10">
                <!-- Section Tittle -->
                <div class="section-tittle mb-70">
                    <span>Our Professional members </span>
                    <h2>Our Team Mambers</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- single Tem -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <!-- <img src="{{url('/img/gallery/team3.png')}}" alt=""> -->
                    </div>
                    <div class="team-caption">
                        <h3><a href="#">Ethan Welch</a></h3>
                        <span>UX Designer</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <!-- <img src="{{url('/img/gallery/team2.png')}}" alt=""> -->
                    </div>
                    <div class="team-caption">
                        <h3><a href="#">Ethan Welch</a></h3>
                        <span>UX Designer</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <!-- <img src="{{testBack()}}" alt=""> -->
                    </div>
                    <div class="team-caption">
                        <h3><a href="#">Ethan Welch</a></h3>
                        <span>UX Designer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
