


<div class='pb-0 mt-3'>
        <div v-for = 'c in combined'>
              <div class='card rounded mb-0' :class='c.class' :style='c.style'>
                   <div class="card-body ml-3 mt-2 mb-2">
                        <p class='mb-4 text-lg'> @{{c.text}} </p>
                        <div v-for = '(d,i) in c.data'>
                            <label class="ns-container mt-3" @mousedown='c.update(d.id)' style='font-size:.95em; color:rgba(0,0,0,.8);'>@{{d.name}}
                                <div class="mod-chbox-checkmark"
                                     :class="{'hovered-checkmark' : c.check(d.id)}"
                                     :id='helpers.chboxId(d.id, 0, c.type)'>

                                    <span :class="{'checked' : c.check(d.id)}"
                                          :id='helpers.checkedId(d.id,0,c.type)'>
                                    </span>
                                </div>
                                <span class='hover-chbox'></span>
                           </label>
                        </div>
                   </div>
              </div>
         </div>
</div>
