




<div class='card-body text-left px-4' style='font-size:1.2em;'>
      <h6 class='text-primary font-weight-bolder py-3 px-2 is-moving'> ვინ იმყოფება საფრთხის ქვეშ </h6>

       @foreach ($udangers as $ind => $u)
          <div class='d-flex py-1 px-3 is-moving' id='full-udanger{{$u->id}}'>
             <a class='pb-1 text-secondary'   id='text-udanger{{$u->id}}'
                href="added-by-users/udanger/{{$u->id}}/edit"
                onmousedown='testit(event)'
                > {{$ind + 1}}.&nbsp; {{$u->name}} </a>
             <div class='px-3' id='div-udanger{{$u->id}}'>
                 <div class='d-flex'>
                      <button class='mybtn' id='check-button-udanger{{$u->id}}'
                              onclick="checkButtonClick({{$u->id}}, 'udanger')">
                         <i class='fa fa-check'></i>
                       </button>

                       <div id='spinner-udanger{{$u->id}}' class='d-none'>
                          <div class='spinner-sm spinner-border text-primary'  style='width:22px;height:22px;'></div>
                       </div>

                       <button class='mybtn remove' id='remove-button-udanger{{$u->id}}'
                               onclick="removeButtonClick({{$u->id}}, 'udanger')">
                           <i class="fa fa-trash-alt"></i>
                       </button>

                       <div id='rspinner-udanger{{$u->id}}' class='d-none'>
                          <div class='spinner-sm spinner-border text-primary'  style='width:22px;height:22px;'></div>
                       </div>

                  </div>
              </div>
          </div>
       @endforeach
 </div>
