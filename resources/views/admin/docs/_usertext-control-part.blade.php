



<div class='card-body text-left px-4' style='font-size:1.2em;'>
      <h6 class='text-warning font-weight-bolder py-3 px-2 is-moving'>
          {{ __("კონტროლის ზომები") }}
      </h6>

       @foreach ($dangers as $key => $d)
           <div class='mt-2 mb-4 mr-2 ml-4' id='danger{{$d[0]->danger_id}}'>
               <a href='danger/{{$d[0]->danger_id}}/edit'>
                  <h5 class='text-lightblack text-dark text-lowercase py-2 px-0 is-moving'> {{$key}} </h5>
               </a>
               @foreach ($d as $ind => $c)
                  <div class='d-flex py-1 px-2 is-moving' id='full-control{{$c->id}}'>
                     <a class='pb-1 text-secondary'   id='text-control{{$c->id}}'
                        href="added-by-users/control/{{$c->id}}/edit"
                        onmousedown='testit(event)'
                        > {{$ind + 1}}.&nbsp; {{$c->name}} </a>
                     <div class='px-3' id='div-control{{$c->id}}'>
                         <div class='d-flex'>
                              <button class='mybtn' id='check-button-control{{$c->id}}'
                                      onclick="checkButtonClick({{$c->id}}, 'control', {{$c->danger_id}})">
                                 <i class='fa fa-check'></i>
                               </button>

                               <div id='spinner-control{{$c->id}}' class='d-none'>
                                  <div class='spinner-sm spinner-border text-primary' style='width:22px;height:22px;'></div>
                               </div>

                               <button class='mybtn remove' id='remove-button-control{{$c->id}}'
                                       onclick="removeButtonClick({{$c->id}}, 'control', {{$c->danger_id}})">
                                   <i class="fa fa-trash-alt"></i>
                               </button>

                               <div id='rspinner-control{{$c->id}}' class='d-none'>
                                  <div class='spinner-sm spinner-border text-primary'  style='width:22px;height:22px;'></div>
                               </div>

                          </div>
                      </div>
                  </div>
               @endforeach
           </div>
       @endforeach
 </div>
