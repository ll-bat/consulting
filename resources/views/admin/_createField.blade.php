

<div class="form-group p-2">
    <input class="form-control modal-input" name="name" placeholder="{{ __('ახალი სფერო') }}" id="modal-form-input" />
    <div class="invalid-feedback">
        <p class="text-danger"> {{ __("ასეთი სფერო უკვე არსებობს") }} </p>
    </div>
    <div class="valid-feedback">
        <p class="text-success"> {{ __("სფერო წარმატებით დაემატა") }} </p>
    </div>
</div>
