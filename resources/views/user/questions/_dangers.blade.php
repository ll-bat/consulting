


<div class='anim-half-width anim-margin' style='background-color:#673ab7;border-radius:0px;border-right:1px solid #673ab7;box-shadow:2px 2px 4px grey !important'>
     <div class='card shadow-none anim-half-width anim-margin' v-if='canShow == true'
          style='border-radius:10px;!important;border-top-right-radius:100px;border-bottom-left-radius:25px;'>
         <div class='card-body ml-2 pl-2'>
              <p class= 'ns-font-family ns-dark-color p-3 pb-0' style='font-size:1.3rem;'> აირჩიეთ საფრთხე </p>
              <div class="form-group p-3" style='width:55%;' v-if='odan.length > 0'>
                   <label for="sel1">Select list:</label>
                   <select class="form-control py-2 px-2" @change="chooseOcon()" id="sel2" style='line-height:2rem;'>
                       <option class="p-5" selected disabled style='font-size:1.1rem !important'>ყველა საფრთხე</option>
                          <option class='p-5' v-for='d in odan' style='max-width: 400px; font-size:1.1rem !important;font-weight:400;' :value='d.id'
                          > @{{d.name}}
                          </option>
                   </select>
              </div>
              <!-- <div class='d-flex' v-else >
                 <img src='/icons/frown.png' width='40' />
                 <p class='pl-2 mt-2 text-secondary text-sm'> სამწუხაროდ, არჩეული პროცესი არ მოიცავს არცერთ საფრთხეს :)) </p>
              </div> -->
         </div>
     </div>
</div>
