



<div v-if='showControls' class='bg-white full-shadow' style='border: 2px solid lightgrey; border-radius:5px;'>
       <table class='table'>
            <thead >
                  <th class='text-center py-4 bg-light' style='font-size: 1.2rem;width:50%;color: #9999ff;border-right:2px solid lightgrey;'> კონტროლის ზომები </th>
                  <th v-for="answer in controlAnswers" style='font-size: .7rem !important;'>@{{ answer.text }}</th>
            </thead>

            <tbody>
                 <tr v-for = '(o,i) in currentControls'>
                       <td class='text-center mt-3' style='font-size:.7rem;height:80px;border-right:2px solid lightgrey;background-color: rgba(0,0,0,.0176);'> @{{o.name}} </td>

                       <td v-for = "(v,ind) in controlAnswers" style='width: 19%;' :title='v.label'>
                             <label class="ns-container"
                                    @mousedown="helpers.toggleControl(o.id, ind, 'checked-circle');" >

                                   <div class="mod-chbox-checkmark"
                                        :class="{'hovered-checkmark': helpers.checkControl(o.id,ind)}"
                                        :id="helpers.chboxId(o.id, ind, 'control')"
                                        style='border-radius:50%; left:calc(50% - 10px);'>

                                        <span class='text-center'
                                              :class="{'checked-circle': helpers.checkControl(o.id,ind)}"
                                              :id="helpers.checkedId(o.id, ind, 'control')">
                                        </span>
                                   </div>

                              </label>

                       </td>
                 </tr>
            </tbody>
       </table>
</div>




<!-- <div v-if='canShowOcon' style='padding:0; background-color:white; box-shadow:2px 2px 4px lightgrey, -2px -2px 4px lightgrey;border:1px solid lightgrey'>
      <div class="card rounded-10 ns-font-family ns-dark-color mb-0 p-2 shadow-none sizeable-control"
           style='border-left:1px solid lightgrey; border-radius:0'
           v-for='(o,i) in ocon'
           :class="{'control-border-bottom' : i != ocon.length - 1}"
           >
          <div class="card-body ml-2 pl-1">
                <div class='ml-3'>
                    <h4 class='pt-1 pl-0 text-lg' v-if='i == 0'>
                        გთხოვთ, აირჩიოთ შესაბამისი პასუხი თითოეული კონტროლის ზომის შემთხვევაში
                    </h4>
                    <p class='mt-3'> @{{o.name}} </p>
                    <div v-for = '(v,ind) in controlAnswers'>
                          <label class="ns-container" :class="v.class" @mousedown="toggleControl(o.id,ind, 'checked-circle');">
                              <span class='text-dark font-weight-bolder' style='font-size:1em' >@{{v.text}} </span>
                              <span clasas='text-muted text-sm'>@{{v.label}} </span>
                              <div class="mod-chbox-checkmark" :class="{'hovered-checkmark': checkControl(o.id,ind)}" :id="chboxId(o.id, ind, 'control')" style='border-radius:50%'>
                                   <span class='' :class="{'checked-circle': checkControl(o.id,ind)}" :id="checkedId(o.id, ind, 'control')"></span>
                              </div>
                          </label>
                    </div>
                </div>
          </div>
      </div>
</div> -->
