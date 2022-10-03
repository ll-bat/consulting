



<div v-for = '(e,idx) in data.etimes'>
     <div class="card rounded-10 ns-font-family ns-dark-color ns-card partial-shadow my-4 p-2" style=''>
             <!-- <p class='p-4 pb-0 mb-0 ns-font-family text-lg'> {{ __("მიუთითეთ შესრულების ვადა") }} </p> -->
            
             <div class='d-flex'>
               <div style='width:85%'>
                   <p class='p-4 pb-0 mb-0 text-secondary'
                      style='font-size:1.2rem;'> {{ __("დაამატეთ შესრულების ვადა") }} </p>
                </div>
               <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                   <button v-if='idx == data.etimes.length-1' class='bg-white px-2 py-1 m-btn text-blue' @click="addInArray('etimes')"
                           style='border:0 !important;'
                    ><i class='fa fa-plus pr-2'></i>{{ __("ახალი") }}
                    </button>

                    <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('etimes',idx)"
                           style='border:0 !important;'
                    ><i class='fa fa-remove pr-2'></i>{{ __("წაშლა") }}
                    </button>

                    <div class='hoverable-underline' :class="{'bg-danger' : idx != data.etimes.length -1, 'bg-blue': idx == data.etimes.length -1}"></div>
                </div>
            </div>
            
            
             <div class='card-body ns-input-container pl-4 pb-4'>
                   <div class='input-group date' id='datetimepicker1'>
                       <input type='date' v-model='e.value' class="form-control w-50" />
                   </div>
             </div>
     </div>
</div>