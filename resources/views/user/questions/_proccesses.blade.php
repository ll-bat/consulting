<div class='text-left d-none' id='show_data'>
    <div class='card rounded-10 shadow-none modified-animation' id='edit-process'
         style='border-bottom-left-radius: 0; border-bottom-right-radius: 0;'>
        <div class='card-body ml-2 pl-2'>
            <p class='py-2 px-2' style='font-size:1.3rem;'> აირჩიეთ პროცესი </p>
            <div class="form-group">
                {{--                <label for="sel1">Select list:</label>--}}
                {{--                <select-component title="ყველა პროცესი"--}}
                {{--                                  :data="allProcess"--}}
                {{--                                  select-event="selectProcess"--}}
                {{--                                  @select="filterDangers">--}}
                {{--                </select-component>--}}
                <div class="mt-4">
                    <div v-for='(p,i) in processes'>
                        <label class="ns-container m-3" style="color: #393838;" @mousedown="chooseProcess(p.id)"> @{{ p.name }}
                            <div class="mod-chbox-checkmark" :class="{'hovered-checkmark': (p.id === processId) }"
                                 style='border-radius:50%;'>

                            <span class='text-center'
                                  :class="{'checked-circle': (p.id === processId)}">
                            </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
