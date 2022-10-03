

<div class="form-group p-2">
    <input class="form-control modal-input" name="name" placeholder="{{ __('ახალი ობიექტი') }}" id="modal-form-input" />
    <div class="invalid-feedback">
        <p class="text-danger"> {{ __("ასეთი ობიექტი უკვე არსებობს") }} </p>
    </div>
    <div class="valid-feedback">
        <p class="text-success"> {{ __("ობიექტი წარმატებით დაემატა") }}/{{ __("განახლდა") }} </p>
    </div>
</div>
