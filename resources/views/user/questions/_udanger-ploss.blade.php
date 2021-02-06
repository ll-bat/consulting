
<div class="pb-0 mt-3">
    <div v-for = 'c in combined'>
        <div class="card rounded mb-0" :class="c.class" :style="c.style">
            <div class="card-body ml-3 mt-2 mb-2">
                <p class="mb-4 text-lg"> @{{ c.text }}</p>
                <div v-for="(d,i) in c.data">
                    <label class="ns-container mt-3 pl-5 pt-1" @mousedown="c.update(d.id)" style="font-size:.95em; color:rgba(0,0,0,.8);">@{{ d.name }}
                        <div class="ns-test">
                            <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin"
                                 :class="{'hovered-checkmark-bg hovered-checkmark-diff-cyan' : c.check(d.id)}"
                                 :id="helpers.chboxId(d.id, 0, c.type)">

                                <span class="checked-diff" :class="{'' : c.check(d.id)}"
                                      :id="helpers.checkedId(d.id, 0, c.type)">
                                </span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
