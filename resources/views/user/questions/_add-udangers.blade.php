


 <div>
      <div class="card rounded-10 ns-font-family ns-dark-color my-4 p-2 ns-card partial-shadow"
           style='border-top:10px solid purple !important;' v-for = '(u,idx) in data.newUdangers'>
           <div class='d-flex'>
              <div style='width:85%'>
                  <p class='p-4 pb-0 mb-0 text-secondary'
                     style='font-size:1.2rem;'> ვინ იმყოფება საფრთხის ქვეშ
                     (<span class='text-muted text-sm'>არასავალდებულო<span>) </p>
               </div>
              <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                  <button v-if='idx == data.newUdangers.length-1' class='bg-white px-2 py-1 m-btn text-purple' @click="addInArray('newUdangers')"
                          style='border:0 !important;'
                   ><i class='fa fa-plus pr-2'></i>ახალი
                   </button>

                   <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('newUdangers',idx)"
                          style='border:0 !important;'
                   ><i class='fa fa-remove pr-2'></i>წაშლა
                   </button>

                   <div class='hoverable-underline' :class="{'bg-danger' : idx != data.newUdangers.length -1, 'bg-purple': idx == data.newUdangers.length -1}"></div>
               </div>
           </div>

           <div class='ns-input-container pl-4 pb-4'>
                   <textarea type="text"
                             rows='1'
                             class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                             placeholder='დაამატეთ'
                             v-model = 'u.value'
                             onclick="$(this).next().addClass('ns-test-underline')"
                             onblur ="$(this).next().removeClass('ns-test-underline')"
                             ></textarea>
                   <div class="ns-underline" style='background-color:purple !important'></div>
            </div>
        </div>
</div>
