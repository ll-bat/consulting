<div v-if='showControls'>
    <div class="card rounded-5 modified-shadow ns-font-family ns-dark-color mt-4 mb-0 p-2 shadow-none border-0 remove-control-border"
         v-for='(c,idx) in data.newControls'>
        <div class='d-flex'>
            <div style='width:85%'>
                <p class='p-4 pb-0 mb-0 text-secondary'
                   style='font-size:1.2rem;'>{{ __("დაამატეთ კონტროლის ზომა") }}
                   <span class='text-muted text-sm'> ({{ __("არასავალდებულო") }}) </span> </p>
            </div>
            <div class='m-2 mt-4 mr-1 hoverable' style='width:15%;min-width:100px;'>
                <button v-if='idx == data.newControls.length-1' class='text-orange bg-white px-2 py-1 m-btn'
                        @click="addInArray('newControls')"
                        style='border:0 !important;'
                ><i class='fa fa-plus pr-2'></i>{{ __("ახალი") }}
                </button>
                <button v-else class='bg-white px-2 py-1 m-btn text-danger' @click="removeFromArray('newControls', idx)"
                        style='border:0 !important;'
                ><i class='fa fa-remove pr-2'></i>{{ __("წაშლა") }}
                </button>
                <div class='hoverable-underline'
                     :class="{'bg-danger' : idx != data.newControls.length -1, 'bg-warning': idx == data.newControls.length -1}"></div>
            </div>
        </div>
        <div class='card-body ns-input-container pl-4 pb-3 mt-0 pt-0'>
                      <textarea type="text"
                                rows='1'
                                class="form-control docs-input border-0  ns-textarea ns-font-family border-bottom bg-white autoresize"
                                placeholder='Your answer here'
                                v-model='c.value'
                                onclick="$(this).next().addClass('ns-test-underline');_onFocusHandler(this)"
                                onblur="$(this).next().removeClass('ns-test-underline');_onBlurHandler(this)"
                      ></textarea>
            <div class="ns-underline" style='background-color:orange !important'></div>
        </div>
    </div>
</div>
