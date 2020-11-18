@extends('layouts/zim')







@section('header')
    <style>

       .mybtn {
           background: transparent;
           border: none;
           outline: 0;
           color:lightgrey;
           transition: .3s ease-in;
       }

       .mybtn:hover {
           color:green;
       }

       .remove:hover {
           color: darkred;
       }

       .mybtn:active {
           color:grey;
       }

       .mybtn:link, .mybtn:focus {
           outline: 0;
       }

       @keyframes _animSpinner {
           0% {opacity: .2; }
           100% {opacity: 1;}

       }

       .anim-spinner {
           animation: _animSpinner .51s;
       }

       @keyframes _animText {
           25% {opacity:1; transform: translateY(-7px);}
           100% {opacity:0 ;transform: translateY(50px) scaleX(.5);margin-left:2px}
       }

       .anim-text {
           animation: _animText 1s;
       }

       @keyframes _animateScale {
           from {transform: scaleX(0) scaleY(0); opacity: 0;}
           to {

           }
       }

       .animate-scale {
           animation: _animateScale .2s ease-out;
       }

       .animate-scale-fast {
           animation: _animateScale .1s ease-out;
       }

       @keyframes _fallDown {
           from {transform:scaleY(0) rotateY(180deg); opacity:0}
       }

       .animate-fall-dawn {
           animation: _fallDown .4s ease-in;
       }

       .animate-fall-dawn-fast {
           animation: _fallDown .2s ease-in;
       }

       @keyframes _isMoving {
           from {transform: translateY(20px) rotateX(-60deg) scaleX(0.6)}
       }
       .is-moving {
           opacity: 0;
       }

       .move {
           animation: _isMoving .15s ease-out;
           opacity: 1 !important;
       }
   </style>
@endsection

@section('toolbar')

@endsection

@section('content')

<div class="zim-container mb-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12" id="main-part">
              @if (Session('message'))
                         <p class='alert alert-success text-left text-white'>
                               {{Session('message')}}
                         </p>
               @endif

               @if (Session('error'))
                         <p class='alert alert-danger text-left text-white'>
                               {{Session('error')}}
                         </p>
               @endif

        </div>

        <div class="col-lg-7 col-md-10 col-sm-12 col-12">
               <div class='card rounded-10 border-0 pb-3 animate-scale'>
                    @include('admin.docs._usertext-control-part')
                </div>
        </div>

        <div class="col-lg-7 col-md-10 col-sm-12 col-12" id='udangers'>
               <div class='card rounded-10 border-0 pb-3 animate-fall-dawn' style="">
                    @include('admin.docs._usertext-udanger-part')
               </div>
        </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
     <script>

          function clickAction(method,url,id, did,remid){
              axios[method](url, {}).then(res => {
                  let cnt = res.data
                  if (cnt == 0) $1(remid).remove();
              })
                 .catch((err) => {
                     alert('სამწუხაროდ, შეცდომა დაფიქსირდა. გთხოვთ სცადოთ თავიდან')
                     console.log(err.response.data)
                })
          }

          function animateAction(id1,id2,id3,id4, id5){
              $(`#${id1}`).remove()
              $(`#${id2}`).addClass("anim-spinner").removeClass('d-none')

              tout(() => {
                 $(`#${id3}`).addClass('anim-text')
                 $(`#${id2}`).remove()
                 $(`#${id4}`).remove()
                 tout(() => {
                    // $(`#${id3}`).remove()
                    $(`#${id5}`).remove()
                 },700)
              }, 400)
          }

          function buttonClick(){

          }

          function checkButtonClick(id, type, did){
              let st  = `${type}${id}`
              let id1 = `check-button-${st}`, id2 = `spinner-${st}`,id3 = `text-${st}`, id4 = `div-${st}` , id5 = `full-${st}`
              let url = `add-control/${id}`,remid = `danger${did}`
              if (type == 'udanger') {
                  url   = `add-udanger/${id}`
                  remid = `udangers`
              }

              clickAction('post', url, id, did,remid)
              animateAction(id1, id2, id3, id4, id5)
          }

          function removeButtonClick(id, type, did){
              let st  = `${type}${id}`
              let id1 = `remove-button-${st}`, id2 = `rspinner-${st}`,id3 = `text-${st}`, id4 = `div-${st}`, id5 = `full-${st}`
              let url = `added-by-users/control/${id}/delete`,remid = `danger${did}`
              if (type == 'udanger') {
                  url   = `added-by-users/udanger/${id}/delete`
                  remid = `udangers`
              }

              clickAction('post', url, id, did,remid)
              animateAction(id1, id2, id3, id4, id5)
          }

          function testit(ev){
              let rightclick = ev.which == 3 || ev.button == 2
              if (rightclick){
                alert(rightclick)
                ev.preventDefault()
              }
          }

          function startAnimation(){
            let cnt = $2('is-moving').length
            let cur = 0

            let upd = setInterval(() => {
                move(cur++)
                if (cur == cnt) clearInterval(upd)
            },100)

            function move(i){
                add($2('is-moving')[i], 'move')
            }
          }

          let path = '{{url()->previous()}}'
          let hs  = path.split('/').includes('added-by-users')

          if (!hs) startAnimation()
          else $('.is-moving').css({'opacity': '1'})

     </script>
@endsection
