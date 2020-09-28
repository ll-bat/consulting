@extends('layouts/zim')







@section('header')
    <style>
        .slowdown {
          transition: all 1s ease-in;
        }
        .ns-circle {
          width:20px;height:20px;
          border-radius:50%;
          border:1px solid lightgrey;
        }
        .h-border{
           border-bottom:1px solid transparent;
        }
        .h-border:hover{
            border-bottom:1px dotted grey;
            cursor:pointer;
        }
        .input-group{
          font-family: 'Comic Sans MS';
        }
        .lowercase {
          text-transform: lowercase;
        }
        
        @keyframes _ns-anim{
            from { opacity:.4;}
            to {}
        }
        .ns-anim {
            animation: _ns-anim .5s;
        }

        .left-colored-border {
            border-top-left-radius:4px;
            border-bottom-left-radius:4px;
            border-left:5px solid blue;
        }

        .autoresize {
            display: block;
            overflow: hidden;
            resize: none;
        }

        .text-sm {
            font-size: .8em;
        }

        #actions-panel {
            transitions: all 20s ease-in-out;
        }

        .ns-icon {
            width: 17px;
            height: 17px;
        }

        .colorLeftBorder {
            border-left: 5px solid blueviolet;
        }

        .leftBorder {
            border-left-color: white !important;
        }

        .ns-border-bottom {
            border-bottom: 2px inset rgb(163, 164, 223);
        }

        .h-hover-grey {
            padding: 7px;
            transition: all .5s ease-in;
        }

        .h-hover-grey:hover {
            background-color: rgba(0, 0, 0, .1);
            border-radius: 40%;
            opacity: .8;
        }

        .ns-hover-b {
            color: black;
        }

        .ns-hover-b:hover {
            color: grey;
        }

        .ns-image-remove-icon {
            cursor: pointer;
            background-color: rgb(243, 243, 243);
            box-shadow: 0 1px 0px #b5b8b6;
            color: #5c5959;
            font-size: 1.1em;
            border-radius: 50%;
            padding: 12px;
            transition: all .4s ease;
        }

        .ns-image-remove-icon:hover {
            background-color: #e1e1e4;
            color: rgb(78, 76, 76);
        }

        .ns-loading {
            transition: all .6s ease-in;
            opacity: .7;
        }

        @keyframes object-created {
            from {
                opacity: 0.5;
                margin-top: -20px;
            }
            to {
                opacity: 1
            }
        }

        .ns-object-created {
            -webkit-animation: object-created .6s;
            -o-animation: object-created .6s;
            animation: object-created .6s;
        }

        .ns-index-border {
            border:none !important;
            border-radius: 0px !important;
            border-bottom:1px solid transparent !important;
        }
        .ns-index-border:focus {
            border-bottom-color: blue !important;
        }

        .card {
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12) !important;
            border-radius: 10px !important;
            border-bottom-left-radius: 0px !important;
        }

        @keyframes _created {
            from {opacity: 0}
            to {opacity: 1}
        }

        .created {
            -webkit-animation: _created .5s;
            -o-animation: _created .5s;
            animation: _created .5s;
        }

        .edit-index-bg {
            background-color: transparent;
            transition: all .41s ease-in;
        }
        .edit-index-bg:hover {
            background-color: rgba(0,0,0,.1);
        }
        .faded {
            opacity: .8;
            box-shadow: none !important;
            box-shadow: -.031rem 0 .031rem lightgrey !important;
        }

        .my-btn {
            border: 2px solid #003366 !important;
            color: #003366;
        }
        .my-btn:hover {
            background-color: #003366 !important;
        }

   </style>

   <style>
     .hover-lt-border {
         border: 1px solid lightgrey !important;
     }
     .hover-lt-border:focus {
         transition:all 1s ease-in;
         border-top-right-radius:0;
         border-bottom-right-radius:0;
         border-right:5px solid blue !important;
     }
   </style>
@endsection



@section('content')

<div class="container text-center position-absolute mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 col-sm-12 col-12 mr-4">

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

                <div class='text-left w-100 px-2' style=''>
                   <button class='btn btn-outline-primary rounded-pill border-0' id='proccreate' onclick="show($1('procarea'))">
                      <i class='fa fa-plus'></i>
                      პროცესი
                    </button>

                    <a href='docs/new-danger' class='btn btn-outline-danger rounded-pill border-0'>
                      <i class='fa fa-plus'></i>
                      საფრთხე
                    </a>

                    <a href='docs/new-control' class='btn my-btn rounded-pill' style='border:0 !important'>
                      <i class='fa fa-plus'></i>
                      კონტროლის ზომა
                    </a>

                    <a href='docs/added-by-users' class='btn rounded-pill' style='border:0 !important'>
                      <i class='fa fa-plus'></i>
                      დამატებული(<b>{{$cnt}}</b>)
                    </a>
                    
                    <a href='docs/check' class='btn btn-outline-secondary rounded-pill border-0' style='border-width:2px;'>
                      <i class='fa fa-pencil'></i>
                      შეამოწმე
                    </a>

                </div>
                  
                <form method='post' action='docs/add-process' class="text-left @if (!$errors->has('name')) d-none @endif" id='procarea'>
                    @csrf
                    <div class="border rounded bg-white mt-3 p-2" style='border-color:rgba(0,100,255, .3) !important'>
                           <textarea
                                class='form-control autoresize p-1 pl-2 hover-lt-border'
                                placeholder='პროცესის სახელი'
                                name='name'
                            >{{old('name')}} </textarea>

                       @error('name')
                           <p class='text-danger text-sm text-left pl-2 mt-2 mb-0' style='margin-top:-1rem;'> {{ $message }} </p>
                      @enderror
                    </div>
                    <button class='btn btn-primary border-0 capitalize mt-4 ml-2 py-1 px-3'> create </button>
                </form>

                <div class='card card-user mt-3 text-left rounded-10 shadow-none left-colored-border ns-border-bottom' style='border-left-color:orange'>
                     <div class='card-title mb-2 mt-3'>
                          <p class='pl-4 font-weight-bold text-warning'> პროცესები </p>
                     </div>
                     
                     <div class='pl-4 py-2'>
                       @foreach($procs as $ind => $proc)
                         <div class='d-md-flex d-block'>
                             <div class='w-75'>
                                 <p class="@if (Session('created') && $ind == $proc->count()-1) font-weight-bolder @else text-muted @endif"> {{$ind + 1}}. {{$proc->name}} </p>
                             </div>
                             <div class='w-25 d-flex'>
                                 <a href='docs/process/{{$proc->id}}/edit' class='btn btn-outline-primary rounded-pill text-sm py-1'> edit </a>
                                 <a href='docs/process/{{$proc->id}}/copy' class='btn btn-outline-secondary rounded-pill text-sm py-1'> copy </a> 
                             </div>
                         </div>
                       @endforeach

                       @if ($procs->count() == 0)
                                   <p class='text-secondary ml-3'> თქვენ არ გაქვთ პროცესები </p>
                       @endif
                     </div>
                </div>


                <div class='card mt-3 text-left rounded-10 shadow-none left-colored-border ns-border-bottom' onclick="$('#potential-loss').removeClass('d-none')">
                     <div class='card-title mb-2 mt-3 pointer'>
                          <p class='pl-4 font-weight-bold text-primary'> პოტენციური ზიანი </p>
                     </div>
                     
                     <div class='pl-4 pt-2 pb-3 d-none' id='potential-loss'>
                          <div v-for='o in ploss'>
                               <fbody-component :data='o' type='1' url='docs/save-ploss' placeholder='დაამატეთ პოტენციური ზიანი' @saving = 'psaving=true' @saved='psaving=false' @deleted='deletePloss'></fbody-component>
                          </div>
                          <div class='d-flex'>
                               <div class='ns-circle'></div>
                               <span class='ml-3 text-muted text-sm h-border' @click='addNewPloss()'> დამატება </span>
                               <div class='position-absolute' style='right:.4rem;'>
                               
                                    <div class="spinner-border text-info mx-1 my-1 mr-3" v-if="psaving"
                                         style="height:20px;width:20px;">
                                    </div>

                                    <div class='mx-1 my-1 mr-3 testit' v-else
                                         style='height:20px; width:20px;'>
                                        <i class='nc-icon nc-check-2 text-warning font-weight-bolder'></i>
                                    </div>

                               </div>
                         </div>
                     </div>
                </div>


                <div class='card mt-3 text-left rounded-10 shadow-none left-colored-border ns-border-bottom' onclick="$('#udanger').removeClass('d-none')"  style='border-left-color:purple'>
                                         
                     <div class='card-title mb-2 mt-3 pointer'>
                          <p class='pl-4 font-weight-bold' style='color:purple'> ვინ იმყოფება საფრთხის ქვეშ  </p>
                     </div>
                     
                     <div class='pl-4 pt-2 pb-3 d-none' id='udanger'>
                          <div v-for='o in udanger'>
                               <fbody-component :data='o' type='2' url='docs/save-udanger' placeholder='დაამატეთ მონაცემი' @saving = 'usaving=true' @saved='usaving=false' @deleted='deletePloss'></fbody-component>
                          </div>
                          <div class='d-flex'>
                               <div class='ns-circle'></div>
                               <span class='ml-3 text-muted text-sm h-border' @click='addNewUdanger()'> დამატება </span>
                               <div class='position-absolute' style='right:.4rem;'>
                               
                                    <div class="spinner-border text-info mx-1 my-1 mr-3" v-if="usaving"
                                         style="height:20px;width:20px;color:purple !important;">
                                    </div>

                                    <div class='mx-1 my-1 mr-3 testit' v-else
                                         style='height:20px; width:20px;'>
                                        <i class='nc-icon nc-check-2 text-warning font-weight-bolder' style='color:purple !important;'></i>
                                    </div>

                               </div>
                         </div>
                     </div>
                </div>



            </div>
        </div>
</div>

<script type="application/javascript">
       function show(obj){
           obj.classList.remove('d-none')
       }

</script>

@endsection