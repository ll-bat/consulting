<?php
/**
 * @var Objects[] $objects
 * @var string $filename
 * @var int $objectId
 */

use App\Objects;

?>

<button type="button" id="modal-button" class="btn btn-primary d-none" data-toggle="modal"
        data-target="#form-modal"></button>
<div class="modal" id="form-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> დოკუმენტის შეცვლა </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body mx-2 my-1">
                <div class="form-group">
                    <label class="text-muted">სახელი:</label>
                    <input class="form-control p-3"
                           id="modal-input"
                           placeholder="შეიყვანეთ სახელი"/>

                    <div class="valid-feedback">
                        <p> ოპერაცია წარმატებით დასრულდა </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-muted">ობიექტი:</label>
                    <select class="form-control" id="modal-doc-object-id">
                        <option value disabled> აირჩიეთ ობიექტი</option>
                        @foreach($objects as $o)
                            <option value="{{ $o['id'] }}"> {{ $o['name'] }} </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        <p> სამწუხაროდ შეცდომა დაფიქსირდა, სცადეთ თავიდან </p>
                    </div>
                    <div class="valid-feedback">
                        <p> ოპერაცია წარმატებით დასრულდა </p>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger border-0" data-dismiss="modal">დახურვა</button>
                <button type="button" class="btn btn-primary border-0" id="modal-submit-button">
                    <span class="spinner-border spinner-border-sm d-none" id="modal-submit-spinner"></span>
                    <span class="py-2 px-1"> შენახვა </span>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    $('#form-modal #modal-input').on('keydown', e => {
        if (e.key === 'Enter') {
            $('#modal-submit-button').click();
        }
    })

    $('#doc-rename-a').on('click', e => {
        e.preventDefault();
        $('#modal-input').val("{{ $filename }}").removeClass('is-invalid');
        $('#modal-doc-object-id').val("{{ $objectId }}").removeClass('is-invalid')
        $('#modal-button').click();
    })

    $('#modal-submit-button').on('click', async e => {
        const el = $('#modal-input');
        const select = $('#modal-doc-object-id');
        if (el.val().length < 1 || !select.val()) {
            alert('გთხოვთ, შეიყვანოთ ტექსტი');
            return;
        }
        const url = `/user/doc/{{ $docId }}/update`;
        const data = {
            filename: el.val(),
            objectId: select.val()
        };

        $('#modal-submit-button').addClass('disabled');
        $('#modal-submit-spinner').removeClass('d-none');

        const res = await $.post(url, data).catch(err => {
            select.addClass('is-invalid');
            $('#modal-submit-button').removeClass('disabled');
            $('#modal-submit-spinner').addClass('d-none');
        })

        if (res) {
            select.removeClass('is-invalid').addClass('is-valid');
            el.removeClass('is-invalid').addClass('is-valid');
            tout(() => {
                window.location = '';
            }, 400);
        }
    })
</script>
