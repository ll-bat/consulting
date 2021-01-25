<div>
    <div class='card shadow-none rounded-10' v-if='showDangers'>
        <div class='card-body ml-2 pl-2'>
            <p class='p-3 pb-0' style='font-size:1.3rem;'> აირჩიეთ საფრთხე </p>
            <div class="form-group py-1 px-3" style='width:55%;' v-if='currentDangers.length > 0'>
{{--                <label for="sel1">Select list:</label>--}}
{{--                <select-component title="ყველა საფრთხე"--}}
{{--                                  :data="dangerSelect"--}}
{{--                                  :set-default="true"--}}
{{--                                  select-event="selectDanger"--}}
{{--                                  id="danger-id"--}}
{{--                                  @select="filterControls"--}}
{{--                ></select-component>--}}
                <div class="mt-4">
                    <div v-for='(d,i) in currentDangers'>
                        <label class="ns-container m-3" style="color: #393838;" @mousedown="chooseDanger(d.id)"> @{{  d.name }}
                            <div class="mod-chbox-checkmark" :class="{'hovered-checkmark': (d.id === dangerId) }"
                                 style='border-radius:50%;'>

                            <span class='text-center'
                                  :class="{'checked-circle': (d.id === dangerId)}">
                            </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
