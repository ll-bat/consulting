@extends('layouts/zim')








@section('toolbar')

<button class="btn btn-outline-primary font-weight-bold border-0 m-0 px-3 py-1"
        onclick="_createNewObject()"
        style="margin-bottom: 4px !important;color:rgba(0,0,200, .5)">
    <i class="fa fa-plus pl-0 pr-2"></i>
    ობიექტის დამატება
</button>

@endsection
@section('content')

@foreach($objects as $id => $object)
<div class="bg-white px-4 py-3 border rounded-10 partial-shadow border-0 mt-3">
    <div class="d-flex " style="justify-content: space-between;">
        <div class="d-flex">
            <img src="/icons/3d.png" width="40" height="40" />
            <a href="objects/{{ $object['id'] }}" class="text-lg mx-4 mt-2"> {{ $object['name'] }} </a>
        </div>
        <div class="d-flex">
            <span class="mr-4 mt-3"> <b>{{ count($object['docs']) }} </b> doc(s) </span>
            <button class="btn btn-primary border-0 px-2 py-1" onclick="_updateObject('{{ $object['name'] }}', {{ $object['id'] }})">
                <i class="fa fa-pencil-alt" style="font-size: .85rem"></i>
            </button>
        </div>
    </div>
</div>
@endforeach
@if (count($objects) < 1)
    <p class="alert text-white" style="background-color:rgba(0,0,200, .5)"> თქვენ არ გაქვთ ობიექტები </p>
@endif

@include('user._modal')

<script>
    let $data = {

    }

    function _createNewObject() {
        $data = {name: ''};
        _openModal();
    }

    function _updateObject(name, id) {
        $data = { id, name };
        _openModal(name);
    }

    function _openModal(val) {
        $('#objectModal #object-name').removeClass('is-invalid is-valid').val(val);
        $('#new-object-modal').click();
    }

    function changeObjectName(val) {
        $data['name'] = val;
    }

    async function submitObjectModal() {
        if ($data['name'].trim().length < 1) {
            alert('გთხოვთ, შეიყვანოთ ტექსტი');
            return;
        } else {
            $('#objectModal #object-submit-button').addClass('disabled').find('.spinner-border').removeClass('d-none')
        }
        let url = '';
        if (parseInt($data['id'])) {
            url = `objects/${$data['id']}/update`;
        } else {
            url = `objects/create`;
        }
        let res = await $.post(url, {
            'name' : $data['name']
        }).catch(err => {
            if (err.responseText === 'nop1') {
                $('#objectModal #object-name').addClass('is-invalid');
            } else {
                alert("რაღაც მოხდა. გთხოვთ, სცადოთ თავიდან");
            }
        });

        if (res) {
            $('#objectModal #object-name').removeClass("is-invalid").addClass('is-valid');
            tout(() => {
                window.location = '';
            }, 500);
        }

        $('#objectModal #object-submit-button').removeClass('disabled').find('.spinner-border').addClass('d-none')
    }

</script>
@endsection


