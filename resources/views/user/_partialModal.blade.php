<button type="button" class="btn btn-primary d-none" id="partial-modal-open-button" data-toggle="modal"
        data-target="#partial-modal-content"></button>

<!-- The Modal -->
<div class="modal" id="partial-modal-content">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> {{ $title }} </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" id="model-update-url" value="" />
                @include($form)
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger border-0" data-dismiss="modal">გაუქმება</button>
                <button type="button"
                        id="partial-modal-button"
                        class="btn btn-primary border-0">
                    <span class="spinner-border spinner-border-sm d-none" id="modal-button-spinner"></span>
                    შენახვა
                </button>
            </div>

        </div>
    </div>
</div>
