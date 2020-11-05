













<main>
    <div class="slider-area2" 
         style='background-image:url(/{{$modifies->getImageName($route)}});height:auto; min-height:500px; max-height:900px;'>
        <div class="slider-height2  d-flex align-items-center" style='background:transparent'>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2  text-center">
                            <p style="{{$modifies->getStyleFor($page, 'title') ?? ''}}">
                                   {{$modifies->getTextFor($page, 'title') ?? ''}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
