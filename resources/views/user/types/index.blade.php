@extends('layouts/zim')

<?php

/**
 * @var User[] $users
 */
?>

@section('header')
    <link rel="stylesheet" href="/css/switch.css"/>
@endsection

@section('content')

    <table class="table table-hover border bg-white">
        <thead>
        <tr class="text-center">
            <th> Image</th>
            <th> Username</th>
            <th> Firstname</th>
            <th> Lastname</th>
            <th> Type</th>
            <th> Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="text-center">
                <td>
                    <img src="{{ $user->pathAvatar() }}" height="40"/></td>
                <td> {{ $user->username }}</td>
                <td> {{ $user->profile->firstname }}</td>
                <td> {{ $user->profile->lastname }}</td>
                <?php
                     [$class, $type] = ['text-primary', 'სტანდარტული'];
                     if ($user->type == \App\User::TYPE_PREMIUM) {
                         [$class, $type] = ['text-orange', 'პრემიუმი'];
                     } else if ($user->type == \App\User::TYPE_VIP) {
                         [$class, $type] = ['text-success', 'VIP'];
                     }
                ?>
                <td class="{{ $class }}"> {{ $type }} </td>
                <td>
                    <?php
                    $params = \Psy\Util\Json::encode([
                        'status' => (int) $user->status,
                        'type' => $user->type,
                        'userId' => $user->id
                    ]); ?>
                    <button class="bg-transparent border-0 form-edit" data-params="{{ $params }}">
                        <i class="fa fa-pencil text-primary"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('user/types/_modal')

    <script>
        {
            let data = {};
            const STATUS_ACTIVE = "{{ \App\User::STATUS_ACTIVE }}"
            const STATUS_INACTIVE = "{{ \App\User::STATUS_INACTIVE }}"
            const TYPE_STANDARD = "{{ \App\User::TYPE_STANDARD }}"
            const TYPE_PREMIUM = "{{ \App\User::TYPE_PREMIUM }}"
            const TYPE_VIP = "{{ \App\User::TYPE_VIP }}"

            const statusClasses = {
                [STATUS_ACTIVE]: {message: 'აქტიური', className: "text-success"},
                [STATUS_INACTIVE]: {message: "არააქტიური", className: "text-danger"}
            };

            const typeClasses = {
                [TYPE_PREMIUM]: {message: 'პრემიუმი', className: "text-orange"},
                [TYPE_STANDARD]: {message: 'სტანდარტული', className: "text-primary"},
                [TYPE_VIP]: {message: 'VIP', className: "text-success"},
            }

            $('.form-edit').each((idx, button) => {
                $(button).on('click', e => {
                    console.log(button.getAttribute('data-params'), statusClasses, typeClasses);
                    const {status, type, userId} = JSON.parse(button.getAttribute('data-params'));
                    changeStatus(status);
                    changeType(type);
                    data = {userId, status, type};
                    $('#modal-button').click();
                });
            });

            $('#user-status').on('change', e => {
                changeStatus(e.target.checked ? 1 : 0);
            });

            $('#user-type').on('change', e => {
                changeType(e.target.value);
            })

            $('#modal-submit-button').on('click', async e => {
                const status = await $.post(`types/${data.userId}/save`, {
                    type: data.type,
                    status: data.status
                }).catch(err => {
                    alert(err.responseJSON.message);
                });

                window.location = '';
            })

            function changeStatus(status) {
                const {message, className} = statusClasses[status];
                data.status = status;
                $1('user-status').checked = status;
                $('#user-status-label').text(message)
                $1('user-status-label').className = className;
            }

            function changeType(type) {
                const {message, className} = typeClasses[type];
                data.type = type;
                $('#user-type').val(type);
                $('#user-type-label').text(message)
                $1('user-type-label').className = className;
            }
        }
    </script>
@endsection

