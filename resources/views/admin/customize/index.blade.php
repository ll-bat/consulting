@extends('layouts/zim')







@section('header')
    <style>
      .my-btn {
          background: none;
          border: none;
          font-size: 1.5rem;
          transition: all .4s ease-in;
      }

      .my-btn:hover {
          color: darkblue !important;
      }

      .my-btn:focus {
          outline: 0;
      }

      #c-images {
          transition: all .5s ease-out;
      }

      .my-item {
          font-size: 1.2rem;
          color: grey;
      }

      .item-button {
          background: none;
          border: none;
          transition: all .4s ease-in;
      }

      .item-button:hover {
          text-decoration: underline;
      }

      .item-button:focus {
          outline: 0;
      }

      .my-input {
          color: black;
          border: 1px solid rgba(0,0,0,.3) !important;
          border-top-left-radius:0 !important;
          border-top-right-radius:0 !important;
          border:none !important;
      }

      .my-input:focus {
          border-color: grey !important;
          box-shadow: 10px 10px 20px lightgrey !important;
      }

      .box-toolbar {
          border-top-left-radius: 20px;
          border-top-right-radius: 10px;
          /* border-bottom: 1px solid lightgrey; */
          background: rgba(0,0,0,.02);
      }

      .box-item {
          border: none;
          border-right: 1px solid lightgrey !important;
          cursor:pointer;
          transition: all .4s ease-in;
      }

      .box-item:hover {
          background-color: lightgrey !important;
          color: black !important;
      }

      .box-src-image-title {
          color: grey;
          transition: .2s ease-in;
      }

      .box-src-image-title:hover {
          color: #0c2646 ;
          text-decoration: none !important;
      }

      .box-item:focus {
          background-color: lightgrey !important;
          color: black !important;
          outline: 0;
      }

      .box-item:link {
          background-color: transparent !important;
          outline: 0;
      }

      .box-title {
          color: white;
          font-weight:bold;
          background:#009999;
      }

      .is-selected {
          /* background: rgba(0,0,0,.65); */
          background: darkcyan;
          color:white;
      }

      .is-selected:hover {
          background: rgba(0,0,0,.65) !important;
          color:white !important;
      }

      .box-content {
          box-shadow: 4px 4px 8px lightgrey, -2px -2px 4px lightgrey;
      }

      .box-image-button {
          border: none;
          background: none;
      }

      .box-image-button:focus {
          outline: 0;
      }

      .box-trash {
          padding: 10px 12px;
          background: rgba(0,0,0,.1);
          border-radius: 50%;
          transition: all .4s ease-in;
      }

      .box-trash:hover {
          background: rgba(0,0,0,.2);
      }

      .box-trash:active {
          background: grey;
      }

      .box-save-button {
          bottom:10px;
          color: grey;
          border: none;
          border-radius: 5px;
          background:rgba(0,0,0,.1);
          font-size: 1rem;
          transition: all .3s ease-in;
      }

      .box-save-button:hover {
          background: rgba(0,0,0,.2);
      }

      .box-save-button:focus {
          outline: 0;
      }


    </style>



    <script type = 'application/javascript'>
          class GlobalObject {
              constructor(){

              }

              create(name, toolbox){
                  this[name] = toolbox
              }
          }

          let app = new GlobalObject
    </script>

    <script src="/js/toolbox.js"></script>
@endsection


@section('content')
  <div  class='container-fluid rounded-10 partial-shadow position-relative bg-light p-md-5 p-1'
        id = 'this-parent'
        style='min-height:1000px'>

        <div class='position-absolute' style='left: calc(50% - 50px); top:20%;' id='spinner'>
              <div class='spinner spinner-border' style='font-size: 5rem; color: purple; width:100px; height:100px;'></div>
        </div>

        <div class='d-none' id='this-content'>

              <div class='type-images'>
                    <button class='my-btn text-primary' onclick='handler(this)'> {{ __("სურათების შეცვლა") }} </button>

                    <div class='images c-images px-4 pt-4'>
                        @foreach ([__("მთავარი გვერდი") => 'home',
                                   __("ბლოგები") => 'blogs',
                                   __("სერვისები") => 'services',
                                   __("შესახებ") => 'about',
                                   __("კონტაქტი") => 'contact',
                                   __("საიტის ლოგო") => 'logo'
                                   ]
                                   as $name => $val)

                            <div class='my-item my-3'>
                                 <div class='d-flex'>
                                      <i class='fa fa-chevron-right' style='margin-top:7px;'></i>
                                      <button class='m-0 px-2 item-button' onclick='itemHandler(this)'> {{$name}} </button>
                                </div>
                                 <div class='item-box m-5'>
                                       <div class = 'row'>
                                           <div class='col-lg-3 col-md-4 col-sm-6 col-8'>
                                                <img src="{{ $data->getImage($val) }}" width = '80%' />

                                                 <div class='d-flex my-5'>
                                                      <button class='btn btn-primary text-white border-0 px-3 py-1 my-2 mr-2 ml-0' onclick="$(this).next().next().click()"> {{ __("ატვირთვა") }} </button>
                                                      <button class='btn btn-warning text-white border-0 px-3 py-1 m-2' onclick="saveHandler(this,'{{$val}}')">
                                                         <div class='d-flex'>
                                                             <span class="spinner-border spinner-border-sm mt-1 mr-1 d-none"></span>
                                                             <span> {{ __("შენახვა") }} </span>
                                                        </div>
                                                     </button>

                                                      <input type='file'
                                                             class='d-none'
                                                             onchange = "imageUploadHandler(event,'{{$val}}')"/>
                                                </div>
                                            </div>
                                       </div>
                                 </div>
                            </div>
                        @endforeach
                    </div>
               </div>

               <div class='type-texts'>
                    <button class='my-btn text-primary' onclick='handler(this)'> {{ __("ტექსტების შეცვლა") }} </button>

                    <div class='texts c-texts px-md-4 px-0 pb-2'>
                         @foreach ([__("მთავარი გვერდი") => 'home',
                                   __("ბლოგები") => 'blogs',
                                   __("სერვისები") => 'services',
                                   __("შესახებ") => 'about',
                                   __("კონტაქტი") => 'contact'
                                   ]
                                   as $name => $val)

                            <div class='my-item my-3'>
                                 <div class='d-flex'>
                                      <i class='fa fa-chevron-right' style='margin-top:7px;'></i>
                                      <button class='m-0 px-2 item-button' onclick='itemHandler(this)'> {{$name}} </button>
                                </div>

                                <div class='item-box m-5'>
                                       @include('admin.customize._customize-'.$val)
                                </div>
                            </div>
                        @endforeach
                    </div>
               </div>
        </div>
  </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type='application/javascript'>
           class Obj {
                constructor(){
                    for (let a of ['home', 'blogs', 'services', 'about', 'contact', 'logo']){
                       this[a] = new FormData()
                       this[a].append('name', a)
                    }
                }

                add(name,val){
                    if (this[name].has('image')) this[name].delete('image')

                    this[name].append('image',val)
                }

                submit(btn,name){
                    if (this[name].has('image')){
                         this.send(btn,name)
                    }
                    else alert('{{ __("გთხოვთ, ატვირთოთ სურათი") }}')
                }
                send(btn, name){
                    let fm = this[name]

                    btn.disabled = true
                    remove(btn.children[0].children[0], 'd-none')

                    let self = this

                    axios['post']('modify/upload-image', fm)
                    .then(res => {
                        console.log(res)
                        btn.disabled = false
                        self[name].delete('image')
                        add(btn.children[0].children[0], 'd-none')
                    })
                    .catch(err => {
                        alert('{{ __("სამწუხაროდ შეცდომა დაფიქსირდა, გთხოვთ სცადოთ თავიდან") }}')
                        console.log(err)
                        btn.disabled = false
                        self[name].delete('image')
                        add(btn.children[0].children[0], 'd-none')
                    })

                }

                get(name){
                    return this[name].get('image')
                }
           }
    </script>

    <script type='application/javascript'>
          let color = "#F5F7F8"

          st(dom.body, {
              background: color
          })

          $('#main-panel').next().removeClass('border-bottom-0')

          st($1('main-panel'), {
              'box-shadow' : 'none',
              'border-bottom': '1px solid lightgrey'
          })

          $(dom).ready(function(){
              $('.item-box').slideUp()
              $('.c-images > ').slideUp()
              $('.c-texts > ').slideUp()

              tout(() => {
                  $1('spinner').remove()
                  $('#this-parent').removeClass('bg-light').addClass('bg-white')
                  $('#this-content').removeClass("d-none")
              },400)
          })

          function handler(obj){
              $(obj).next().children().slideToggle()
            //   $('.c-images > ').slideToggle()
          }

          function itemHandler(obj){
              $(obj).parent().next().slideToggle()
          }

          function imageUploadHandler(event,name){

              imageLoad(event, null, (data) => {
                   event.target.parentNode.parentNode.children[0].src = data
                   obj.add(name, event.target.files[0])
              })
          }

          function saveHandler(btn, name){
               obj.submit(btn,name)
          }

          let obj = new Obj()
    </script>

    <script type='application/javascript'>

         tout(() => {
             $(window).trigger('autoresize')
         },700)


    </script>
@endsection
