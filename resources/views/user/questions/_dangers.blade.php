<div>
    <div class='card test-shadow rounded-8' v-if='showDangers' style="border-left: 8px solid #6957b8;">
        <div class='card-body ml-2 pl-2'>
            <p class='px-2 py-3 pb-0' style='font-size:1.3rem;'> {{ __("აირჩიეთ საფრთხე") }} </p>
            <div class="form-group py-1 px-3" style='width:55%;' v-if='currentDangers.length > 0'>
                <div class="mt-2">
                    <div v-for='(d,i) in currentDangers'>
                        <label class="ns-container mb-3 pl-5 pt-1" style="color: #393838;" @mousedown="chooseDanger(d.id)">@{{d.name}}
                            <div class="ns-test">
                                <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin" :class="{'hovered-checkmark-diff': (d.id === dangerId) }"
                                     style='border-radius:50%;'>
                                    <span class='text-center'
                                          :class="{'checked-circle-diff': (d.id === dangerId)}"></span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="danger-skeleton" v-if="showDangerLoader"></div>
</div>
