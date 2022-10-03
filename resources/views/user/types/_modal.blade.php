
<button type="button"
        id="modal-button"
        class="btn btn-primary d-none"
        data-toggle="modal"
        data-target="#form-modal"
></button>

<div class="modal" id="form-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> {{ __("პარამეტრები") }} </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body mx-2 my-1">
                @include('user/types/_form')
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger border-0" data-dismiss="modal">{{ __("დახურვა") }}</button>
                <button type="button" class="btn btn-primary border-0" id="modal-submit-button">{{ __("შენახვა") }}</button>
            </div>

        </div>
    </div>
</div>
