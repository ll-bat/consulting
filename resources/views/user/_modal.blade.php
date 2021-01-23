<button type="button" class="btn btn-primary d-none" id="new-object-modal" data-toggle="modal"
        data-target="#objectModal"></button>

<!-- The Modal -->
<div class="modal" id="objectModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> ობიექტის დამატება </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <input class="form-control"
                       id="object-name"
                       onchange="changeObjectName(this.value)"
                       placeholder="შექმენით ახალი"/>
                <div class="invalid-feedback">
                    <p> ასეთი ობიექტი უკვე არსებობს </p>
                </div>
                <div class="valid-feedback">
                    <p> ოპერაცია წარმატებით დამთავრდა </p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger border-0" data-dismiss="modal">გაუქმება</button>
                <button type="button"
                        id="object-submit-button"
                        onclick="submitObjectModal()"
                        class="btn btn-primary border-0">

                    <span class="spinner-border spinner-border-sm d-none"></span>
                    შენახვა
                </button>
            </div>

        </div>
    </div>
</div>
