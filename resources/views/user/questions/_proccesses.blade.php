<div class='text-left d-none' id='show_data'  >
    <div class='card test-shadow rounded-8 modified-animation' id='edit-process'
         style='border-bottom-left-radius: 0; border-bottom-right-radius: 0;'>
        <div class='card-body ml-2 pl-2'>
            <p class='py-2 px-2' style='font-size:1.3rem;'> {{ __("აირჩიეთ პროცესი") }} </p>
            <div class="form-group">
                <div class="mt-4">
                    <div v-for='(p,i) in processes'>
                        <label class="ns-container black-75 m-4 pl-5 pt-1" @mousedown="chooseProcess(p.id)"> @{{ p.name }}
                            <div class="ns-test">
                                <div class="mod-chbox-checkmark mod-chbox-checkmark-diff ns-test-margin" :class="{'hovered-checkmark-diff': (p.id === processId) }"
                                     style='border-radius:50%;'>
                                    <span class='text-center'
                                          :class="{'checked-circle-diff': (p.id === processId)}"></span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
