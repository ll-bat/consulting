@extends('layouts.zim')



@section('header')

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <style>
        .rounded-10 {
            border-radius: 10px;
        }

        .rounded-5 {
            border-radius: 5px;
        }

        .rounded-7 {
            border-radius: 7px;
        }

        .p60 {
            width: 60%;
        }

        .p80 {
            width: 80%;
        }

        .p90 {
            width: 90%;
        }

        .p100 {
            width: 100%;
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


    </style>

@endsection


@section('content')
    <div class="container text-center position-absolute">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 col-sm-12 col-12 mr-4">
                <div class="" :class="{'d-none': !loading}" style="margin-top:30%;">
                    <div class="spinner-border text-warning d-none d-sm-inline-block" style="width:5rem; height: 5rem;border-width: 10px;"></div>
                </div>
                <div v-for="(component,index) in components">
                    <component @choose='changeShadow(index)'
                               :is='component.name'
                               :object='component'
                               :nselected='index != ns'
                               :index='index'
                               :class="{'faded' : index != ns}"
                               class="ns-object-created"
                    >
                        <template #ipanel="{comp}">
                            <ipanel-component
                                :type='component.type'
                                @changing='changeType(index, $event, comp)'>
                            </ipanel-component>
                        </template>

                        <template #image="{comp}">
                            <div class='card-image'>
                                <template v-if='component.hasImage'>
                                       <span class='m-3 position-absolute' @click='removeImage(comp)'>
                                           <i class='nc-icon nc-simple-remove ns-image-remove-icon'></i>
                                         </span>
                                    <img :src="component.image" class='p-4'/>
                                </template>
                                <div v-if='comp.imageLoading[0]' class='ml-4 mb-5 p-3 pb-5'>
                                    <div class='m-3 position-absolute' @click='removeImage(comp)'>
                                        <div class="spinner-border text-primary"
                                             style='width:50px;height:50px;'
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <input type='file' class='d-none' :id="'editimage'+index"
                                   @change='editImage($event, comp)'/>
                        </template>

                        <template #full-panel="{comp}">
                            <div class='mt-4' style='width:94%;margin:auto;'>
                                <hr/>
                            </div>

                            <div class="float-left ml-3">
                                <div class="d-flex">
                                    <p class="text-primary font-weight-bolder text-sm pl-1">N: </p>
                                    <input type="text"
                                           class="form-control ns-index-border text-primary font-weight-bolder ml-1"
                                           style="width:45px;margin-top:-.47rem"
                                           @click="activeCheckIcon(index)"
                                           v-model="component.newindex" />
                                    <div class="d-none edit-index created pointer" @click="clickCheckIcon(component,index)">
                                        <i class="fa fa-check position-absolute text-success edit-index-bg rounded-pill p-2"
                                           style="margin-top: -.16rem; margin-left:-.3rem;"
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div class="float-right">
                                <div class="d-flex" style="">

                                    <div>
                                        <div class='mb-1 mr-2' style='margin-top:-2px;'>
                                            <delete-component
                                                slot='delete'
                                                @delete='deleteComponent(component.id, component.index)'>
                                            </delete-component>
                                        </div>
                                    </div>

                                    <div>
                                        <div class='mr-3' @click='clickImage(index)'>
                                            <i class='nc-icon nc-image text-primary font-weight-bold h-hover-grey ns-hover-b'
                                               style='cursor:pointer;'></i>
                                        </div>
                                    </div>

                                    <div class='mr-3 text-sm mt-1 text-muted pl-2'
                                         style='border-left:1px solid lightgrey'>
                                        <span class='text-muted ns-font-family ns-font-normal'> Required </span>
                                    </div>

                                    <div class='mr-3' style='margin-top:7px;'>
                                        <label class="switch">
                                            <input type="checkbox" :checked='component.required'
                                                   @click="toggleRequire(component.id, comp)">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div class="spinner-border text-info mx-1 my-1 mr-3" v-if="comp.saving"
                                         style="height:20px;width:20px;">
                                    </div>

                                    <div class='mx-1 my-1 mr-3 testit' v-else
                                         style='height:20px; width:20px;'>
                                        <i class='nc-icon nc-check-2 text-warning font-weight-bolder'></i>
                                    </div>

                                </div>

                            </div>

                        </template>

                    </component>
                    <!--  -->
                </div>
                
                <button class='btn btn-primary  rounded border-0 ml-2 float-left d-none' 
                       :class="{'d-block': !loading}" 
                       style='width:7rem'
                       @click='update()'
                       >
                   <span class="spinner-border spinner-border-sm" :class="{'d-none': !updating}"></span>
                       Update 
                </button>

            </div>


            <div class="col-1 text-left d-none d-md-block" id="actions-panel" style="min-width:90px;">
                <panel-component></panel-component>
            </div>
        </div>
        

        <div style='margin-bottom:100px;'></div>
    </div>

    <div class="position-absolute text-left d-md-none mr-3 mr-sm-5" id="sm-actions-panel" style="width:30%; left:35%;top:1rem;">
        <panel-component></panel-component>
    </div>

    <script type="application/javascript">
        $(window).on('scroll', function () {
            let t = $(window).scrollTop();
            setTimeout(() => {
                $1('actions-panel').style.marginTop = Math.floor(t).toString() + 'px'
                $1('sm-actions-panel').style.marginTop = Math.floor(t).toString() + 'px'

            }, 300)
        })

    </script>

@endsection
