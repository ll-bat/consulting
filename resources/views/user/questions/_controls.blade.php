<div v-if='showControls' class='bg-white modified-shadow rounded-8' style="border: 2px solid lightgrey">
    <table class='table'>
        <thead>
        <th class='text-center py-4 bg-light' style='font-size: 1.2rem;
                      width:50%;
                      border-top-left-radius: 8px;
                      color: #9999ff;
                      border-right:1px solid #d3d3d3;'>კონტროლის ზომები
        </th>
        <th class="text-center" v-for="answer in controlAnswers" style='font-size: .7rem !important;'>@{{answer.text}}
        </th>
        </thead>
        <tbody>
        <tr v-for='(o,i) in currentControls'>
            <td class='text-center mt-3'
                style='font-size:.7rem;
                           height:80px;
                           border-right:1px solid lightgrey;
                           background-color: rgba(0,0,0,.0176);'>
                @{{o.name}}
            </td>

            <td v-for="(v,ind) in controlAnswers" style='width: 19%;' :title='v.label'>
                <label class="ns-container"
                       @mousedown="helpers.toggleControl(o.id, ind, 'checked-circle');">

                    <div class="ns-test" style="left: calc(50% - 25px);">
                        <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin"
                             :class="{'hovered-checkmark-diff controls-border-color': helpers.checkControl(o.id,ind)}"
                             :id="helpers.chboxId(o.id, ind, 'control')"
                             style='border-radius:50%;'>

                        <span class='text-center'
                              :class="{'checked-circle-diff controls-bg-color': helpers.checkControl(o.id,ind)}"
                              :id="helpers.checkedId(o.id, ind, 'control')">
                        </span>
                        </div>
                    </div>

                </label>

            </td>
        </tr>
        </tbody>
    </table>
</div>

