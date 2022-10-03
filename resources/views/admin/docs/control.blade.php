@extends('layouts/zim')







@section('header')
    <style>
        .button-dropdown {
            border-radius: 4px !important;
            border: 1px solid grey;
        }

        .slowly {
            transition: all .25s ease-in;
        }
    </style>
@endsection



@section('content')

    <div class="zim-container">
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 col-12 mr-4 ml-5 mr-5" id="main-part">

                @if (Session('message'))
                    <p class='alert text-left text-white' style="background: darkcyan;">
                        {{Session('message')}}
                    </p>
                @endif

                <div
                    class='card card-user mt-3 text-left shadow-none'
                    style='border: 1px solid grey'>
                    <div class='card-title mb-1 mt-3 pointer' onclick="toggleCollapse(this,'add-new-control')">
                        <i class='fa fa-plus float-left ml-3 mt-1'></i>
                        <p class='pl-5 font-weight-bold'> {{ __("ახალი კონტროლის ზომა") }} </p>
                    </div>
                </div>

                <form method='post' action='new-control' class='d-none' id='add-new-control'>
                    @csrf

                    <div class='card partial-shadow radius-10 border-0' style=''>
                        <div class='d-flex'>
                            <div class='m-3 w-75'>
                                <div class='form-group'>
                                          <textarea type='text' class='form-control autoresize'
                                                    placeholder='{{ __("დაამატეთ კონტროლის ზომა") }}'
                                                    oninput="$(window).trigger('autoresize')"
                                                    name='name'>{{old('name')}}</textarea>
                                </div>
                                @error('name')
                                <p class='text-sm text-danger text-left'> {{$message}} </p>
                                @enderror
                            </div>
                            <div class='mx-2 mt-3 text-left'>
                                <input type='text' class='form-control border-0 autoresize'
                                       placeholder='K:1'
                                       name='k'
                                       value="{{old('k')}}"
                                       style='width:3rem;border-bottom:1px solid #009999 !important;border-radius:0'
                                       name='k'/>
                            </div>
                        </div>

                        <label class="ns-container text-secondary text-left ml-3 mb-3"
                               style='font-size:.95em; color:rgba(0,0,0,.8);'> {{ __("ამცირებს პოტენციურ ზიანს") }}
                            <input type="checkbox"
                                   name="rploss"
                                   value="1"
                                   @if (old('rploss') == '1') checked @endif
                            >
                            <span class="chbox-checkmark"></span>
                        </label>

                        <label class="ns-container text-secondary text-left ml-3 mt-2 mb-3"
                               style='font-size:.95em; color:rgba(0,0,0,.8);'> {{ __("არსებული კონტროლის ზომის პასუხის დამალვა") }}
                            <input type="checkbox"
                                   name="is_first_option_off"
                                   value="1">
                            <span class="chbox-checkmark"></span>
                        </label>
                    </div>

                    <div class='card text-left border-0 partial-shadow'
                         style=''>
                        <div class='card-body ml-2 pl-1 pb-4' required>
                            <p class='ml-1 mt-2 mb-4 font-weight-bolder' style="color: #009999"> {{ __("აირჩიეთ საფრთხე") }} </p>

                            @foreach($dangers as $danger)
                                <label class="ns-container mt-3 ml-3 text-secondary"
                                       style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$danger->name}}
                                    <input type="checkbox"
                                           name="danger[]"
                                           value="{{ $danger->id }}"
                                           @if(is_array(old('danger')) && in_array($danger->id, old('danger'))) checked @endif
                                    >
                                    <span class="chbox-checkmark"></span>
                                </label>
                            @endforeach

                            @if ($dangers->count() == 0)
                                <p class='text-secondary font-weight-bolder ml-3'> {{ __("საფრთხეები არ არის") }} </p>
                            @endif

                            @error('danger')
                            <p class='text-sm text-danger mt-2 mb-0 pb-0'> {{$message}} </p>
                            @enderror
                        </div>
                    </div>

                    <div class='text-left my-4'>
                        <button class='btn border-0 px-4' style="background-color:#009999; color: white;"> {{ __("შექმნა") }}</button>
                    </div>

                </form>

                <ul class="list-group text-left" style="border-radius:5px;">
                    <li class="list-group-item font-weight-bold py-3 pointer" onclick='toggleCollapse(this)' style="border: 1px solid #009999;color: #009999;;">
                        <i class='fa fa-plus float-left'></i>
                        <span class="pl-4"> {{ __("ყველა კონტროლის ზომა") }} </span>
                    </li>
                    @foreach($controls as $ind => $control)
                        <li class="list-group-item pl-4 controls-panel d-none"
                            style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);
                            border-left: 1px solid rgba(0,0,0,0.09);
                            border-right: 1px solid rgba(0,0,0,.09);
                            @if ($ind == count($controls)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif
                            ">
                            <div class="row">
                                <div class="col-md-10 col-12">
                                    {{$control->name}}
                                </div>
                                <div class="col-md-2 col-2 text-md-center text-left this-div">
                                    <a class='btn this-color' href='control/{{$control->id}}/edit'
                                       style='background-color:transparent !important;color:#009999'>
                                        {{ __("შეცვლა") }}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @if ($controls->count() == 0)
                        <li class="list-group-item d-none controls-panel pl-4">
                            <p class='text-secondary'> {{ __("თქვენ არ გაქვთ კონტროლის ზომები") }} </p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class='position-absolute' id='button-dropdown' style='left:0;top:0;display:none;'>
        <button class='btn btn-outline-secondary bg-white capitalize px-4' onclick='buttonClick(event)'>Delete</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="application/javascript">
        class Obj {
            constructor() {
            }

            click() {
                $1(this.getId()).remove()
                this.delete()
            }

            delete() {
                axios['delete'](`control/${this.cid}/delete`)
                    .then(res => {
                    })
                    .catch(err => {
                        alert(err.response.data)
                        console.log(err.response.data)
                    })
            }

            setId(id, cid) {
                this.id = id
                this.cid = cid
            }

            getId() {
                return this.id
            }

            getCid() {
                return this.cid
            }
        }


        function toggleCollapse(obj, id) {
            if (id) {
                obj.parentNode.remove()
                remove($1(id), 'd-none')
                return
            }

            if ($('.controls-panel').hasClass('d-none')){
                $('.controls-panel').removeClass('d-none')
                $(obj).css({'color': 'white', 'background-color': '#009999'})
            }
            else
            {
                $('.controls-panel').addClass('d-none')
                $(obj).css({'background-color' : 'white', 'color':'#009999', 'border': '1px solid #009999'})
            }
        }

        @if (Session('created')) toggleCollapse() @endif

        let obj = new Obj()

        function hasClick(ev, id, cid) {
            let rightclick = ev.which == 3 || ev.button == 2
            if (rightclick) {
                let l = ev.pageX - 60, r = ev.pageY
                st($1('button-dropdown'), `l:${l}px;t:${r}px;d:block`)
                st($1(id), 'o:.3')
                obj.setId(id, cid)
                dom.addEventListener('click', clickEvent)
            }
        }

        function clickEvent(e) {
            st($1('button-dropdown'), 'd:none');
            $('.slowly').css({'opacity': '1'})
        }

        function buttonClick(e) {
            obj.click()
        }

        $1('clickable').addEventListener('contextmenu', event => event.preventDefault());

    </script>

@endsection
