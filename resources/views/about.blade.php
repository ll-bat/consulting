@extends('layouts/app')


<?php
  $route = Request::route()->getName();
?>

@section('css')
    <link rel="stylesheet" href="css/style.css" />
@endsection

@section('content')
    @include('_header', ['page' => "about"])

<?php
    $page = 'about';

    $info = [
               [
                  [
                      'text' => $modifies->getTextFor($page, 'title-1') ?? '',
                      'style' => $modifies->getStyleFor($page, 'title-1') ?? '',
                  ],
                  [
                      'text' => $modifies->getTextFor($page, 'description-1') ?? '',
                      'style' => $modifies->getStyleFor($page, 'description-1') ?? '',
                  ]
              ],
              [
                [
                    'text' => $modifies->getTextFor($page, 'title-2') ?? '',
                    'style' => $modifies->getStyleFor($page, 'title-2') ?? '',
                ],
                [
                    'text' => $modifies->getTextFor($page, 'description-2') ?? '',
                    'style' => $modifies->getStyleFor($page, 'description-2') ?? '',
                ]
              ],
            ];

?>

<div class="about-details section-padding30">
    <div class="container">
        <div class="row">
            <div class="offset-xl-1 col-lg-8">
                @foreach ($info as $fo)
                     <div class="about-details-cap mb-50">
                         <h4 style="{{$fo[0]['style']}}">{{$fo[0]['text']}}</h4>
                         <p style="{{$fo[1]['style']}}"> {{$fo[1]['text']}} </p>
                     </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<brr /> <br /> <br />
<brr /> <br /> <br />
<brr /> <br /> <br />
<brr /> <br /> <br />
@endsection
