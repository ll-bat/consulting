









<div class='border-black my-5 box-parent'>
    <div class='box-content'>
       <div class='box-toolbar d-flex m-0'>
           <div class='box-title p-3'>
                <span> Text </span>
           </div>
           <div class='d-flex p-1 toolbar-second' id='tools-{{$id}}'>
               <button class="btn btn-default font-weight-bold my-2 mx-3 px-3 box-item @if ($obj['is-bold']) is-selected @endif"
                       id='bold-{{$id}}' style=''
                       onclick = "boxBoldHandler(event, '{{$element}}', '{{$id}}', '{{$page}}')"
                       > B </button>
               <select class='box-item my-2 mx-3' id='font-{{$id}}'
                       onchange = "boxFontsizeHandler(event, '{{$element}}', '{{$id}}', '{{$page}}')"
                       style='height:40px;color:darkcyan'>
                     @foreach (['1', '1.2', '1.5', '2', '3', '5'] as $key)
                        <option value='{{$key}}' @if ($obj['font-size'] == $key) selected @endif> {{$key}} </option>
                     @endforeach
               </select>
               <div class='box-item mr-3 mt-2 mb-2 ml-0' onclick="this.children[0].click()">
                   <input type='color' class='invisible m-0 p-0' id='color-{{$id}}'
                          onchange = "boxColorHandler(event, '{{$element}}', '{{$id}}', '{{$page}}')"
                          style='width:0;height:0;' />
                   <div class='mx-3' id='color-n-{{$id}}'
                        style="width:25px; height:20px;margin-top:-17px; background:{{$obj['color']}};"></div>
               </div>
               <div class="my-3 mx-3 d-none d-md-block">
                   <a class="box-src-image-title" href="{{$data->texts->getElementImage($page, $element)}}" target="blank"> {{ __("ნიმუში") }} </a>
               </div>
           </div>
       </div>
      <div class='m-0'>
        <!-- <input type='text' class='form-control my-input' id='input-{{$id}}' placeholder='{{ __("შეიყვანეთ ტექსტი") }}' /> -->
        <textarea class="form-control my-input @if ($obj['is-bold']) font-weight-bolder @endif p-3"
                  id='input-{{$id}}'
                  rows='5'
                  oninput="boxInputHandler(event,'{{$element}}', '{{$id}}', '{{$page}}')"
                  style="color: {{$obj['color']}}; font-size: {{$obj['font-size']}}rem;"
                  placeholder='{{ __("შეიყვანეთ ტექსტი") }}'
        >{{$obj['value']}}</textarea>
      </div>
  </div>
  <button class='btn btn-primary border-0 my-4'
          id='click-{{$id}}'
          onclick = "boxUpdateHandler('{{$element}}', '{{$id}}', '{{$page}}')"
          style='background: darkcyan !important;'>

         <div class='d-flex'>
             <span class="spinner-border spinner-border-sm mt-1 mr-1 d-none" id='box-spinner-{{$id}}'></span>
             <span> {{ __("შენახვა") }} </span>
         </div>
  </button>

</div>

