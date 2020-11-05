






<div class="row">

@foreach ($data->services->getServices() as $id => $service)

   <div class="col-lg-5 col-md-8 col-sm-10 col-12 border px-5 pt-5 ml-auto mr-auto text-center mb-5"
        id = 'service-no-{{$id}}'
        style='border-color: rgba(0,0,0,.2) !important'>
       <div class="single-cat text-center mb-50">
           <div class="cat-icon position-relative">
               <!-- <i class='fa fa-plus mb-5' style='font-size: 5rem;color:#eb566c;'></i> -->
               <img src="{{$service['image']}}" onload="this.style.opacity='1'"
                    class='mb-4' 
                    style='opacity:.3; transition: all .3s ease-in;height:80px; max-height:80px;min-height:80px;max-width:170px' />
               <div class='position-absolute' style='top:0; right:0;'>
                  <button class='box-image-button' onclick='$(this).next().click()'>
                     <i class='fa fa-pencil text-primary'></i>
                  </button>
                  <input type='file' class='d-none'  onchange="serviceImageHandler(event, this, '{{$id}}')" />
               </div>

               <div class='position-absolute' style='top:0; left:0;'>
                   <button class='box-image-button' onclick="serviceDeleteHandler('{{$id}}')">
                        <i class='fa fa-trash text-danger box-trash'></i>
                   </button>
               </div>

           </div>
           <div class="cat-cap">
               <textarea type='text' class='form-control p-2 autoresize' rows='1' 
                         style='border-color: rgba(0,0,0,.18) !important'
                         oninput = "serviceTitleHandler(event,'{{$id}}')"
                         placeholder='სათაური'>{{$service['title']}}</textarea>

               <textarea type='text' class='form-control p-2 mt-4 autoresize' 
                         style='border-color: rgba(0,0,0,.18) !important'
                         oninput = "serviceDescriptionHandler(event,'{{$id}}')"
                         placeholder='აღწერა'> {{$service['description']}} </textarea>
           </div>
       </div>
       <div class='spinner text-primary spinner-border position-absolute d-none' 
            style='bottom:10px;  right:10px; width:20px; height:20px;'></div>
        
        <label class="ns-container mt-3 p-0 text-secondary" 
               style='font-size:.95em; color:rgba(0,0,0,.8);'> გამოჩნდეს მთავარ გვერდზე
             <input type="checkbox" onchange="serviceCheckboxHandler(this.checked, '{{$id}}')" 
                    @if ($service['shown'] == 'true') checked @endif />
             <span class="chbox-checkmark mt-1"></span>
        </label>

        <button class='box-save-button my-4 px-3 py-1'  onclick = "serviceUpdateHandler('{{$id}}')"
                style=''>

               <div class='d-flex'> 
                     <span class="spinner-border spinner-border-sm mt-1 mr-1 d-none" id='service-spinner-{{$id}}'></span>
                     <span> განახლება </span>
              </div>

        </button>
   </div>

@endforeach

</div>


<script type='application/javascript'> 

class Service {
  services = []

  constructor(services){
       this.services = services

       Object.keys(services).forEach(s => {
           this['image-'+s] = new FormData()
           this['image-'+s].append('id', s)
       })
  }

  addImage(id, image){
      id = 'image-'+id 

      if (this[id].has('image')){
          this[id].remove('image')
      }

      this[id].append('image', image)
  }

  delete(id){
      axios['post']('modify/delete-service', {
          id: id
      })
         .then(res => {

         })
         .catch(err => {
             alert("An error has occured")
             console.log(err)
         })
  }

  save(id){

      for (let a of ['title', 'description', 'shown']){
          if (this['image-'+id].has(a))
              this['image-'+id].delete(a)

          this['image-'+id].append(a, this.services[id][a])
          this['image-'+id].append('image-name', this.services[id]['image'])
      }

      $1('service-spinner-'+id).classList.remove('d-none')

      axios['post']('modify/services', this['image-'+id])
        .then(res => {
            this.services[id]['image'] = res.data
            $1('service-spinner-'+id).classList.add('d-none')
            if (this['image-'+id].has('image')){
                   this['image-'+id].delete('image')
            }
        })
        .catch(err => {
            alert('სამწუხაროდ შეცდომა დაფიქსირდა, გთხოვთ სცადოთ თავიდან')
            console.log(err)
            $1('service-spinner-'+id).classList.add('d-none')
            if (this['image-'+id].has('image')){
                   this['image-'+id].delete('image')
             }
        })

  }
}
app.service = new Service({!! $data->services->getJson('services') !!})

function serviceImageHandler(event, elm, id){
       let el = elm.parentNode.parentNode.children[0];
       el.style.opacity = '.3'

       el.parentNode.parentNode.parentNode.children[1].classList.remove('d-none')

       imageLoad(event, null,  (data) => {
             el.src = data 
             el.parentNode.parentNode.parentNode.children[1].classList.add('d-none')
             app.service.addImage(id, event.target.files[0])
       })
}
</script>

<script type='application/javascript'>

let service = app.service

function serviceTitleHandler(ev,id){
    service.services[id]['title'] = ev.target.value 
}

function serviceDescriptionHandler(ev,id){
    service.services[id]['description'] = ev.target.value 
}

function serviceCheckboxHandler(value, id){
    service.services[id]['shown'] = value
}

function serviceUpdateHandler(id){
    service.save(id)
}

function serviceDeleteHandler(id){

    service.delete(id)

    tout(() => {
        $1('service-no-'+id).remove()
    }, 200)
}

</script>