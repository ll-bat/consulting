



<div v-for = '(p,idx) in data.rpersons'>
       <div class="card rounded-10 ns-font-family ns-dark-color ns-card partial-shadow my-4 p-2" style=''>
             <!-- <p class='p-4 pb-0 mb-0 text-secondary' style='font-size:1.2rem;'>{{ __("დაამატეთ პასუხისმგებელი პირი") }}  </p> -->

             <div class='d-flex'>
                 <div style='width:85%'>
                     <p class='p-4 pb-0 mb-0 text-secondary'
                        style='font-size:1.2rem;'> {{ __("დაამატეთ პასუხისმგებელი პირი") }} </p>
                  </div>
                 <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                     <button v-if='idx == data.rpersons.length-1' class='bg-white px-2 py-1 m-btn text-blue' @click="addInArray('rpersons')"
                             style='border:0 !important;'
                      ><i class='fa fa-plus pr-2'></i>{{ __("ახალი") }}
                      </button>

                      <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('rpersons',idx)"
                             style='border:0 !important;'
                      ><i class='fa fa-remove pr-2'></i>{{ __("წაშლა") }}
                      </button>

                      <div class='hoverable-underline' :class="{'bg-danger' : idx != data.rpersons.length -1, 'bg-blue': idx == data.rpersons.length -1}"></div>
                  </div>
              </div>

             <div class='card-body ns-input-container pl-4 pb-4'>
                     <textarea type="text"
                               rows='1'
                               class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                               placeholder='{{ __("დაამატეთ") }}'
                               v-model='p.value'
                               onclick="$(this).next().addClass('ns-test-underline')"
                               onblur ="$(this).next().removeClass('ns-test-underline')"
                               ></textarea>
                     <div class="ns-underline" id='test-underline'></div>
               </div>
       </div>
</div>
