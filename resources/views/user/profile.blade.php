@extends('layouts/zim')


<?php
use App\User;use Illuminate\Support\Facades\Auth;$users = User::all();

$user = Auth::user();

[$class, $type] = ['text-primary', 'სტანდარტული'];
if ($user->type == User::TYPE_PREMIUM) {
    [$class, $type] = ['text-orange', 'პრემიუმი'];
} else if ($user->type == User::TYPE_VIP) {
    [$class, $type] = ['text-success', 'VIP'];
}
?>


@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card card-user" style="border-radius: 15px;">
                <div class="image">
                    <img src="{{$profile->pathBack()}}"/>
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="">
                            <img src="{{$profile->pathAvatar()}}" class="avatar border-gray"/>
                            <h5 class="title">{{current_user()->username}}</h5>
                        </a>
                        <p class="description" style="font-size:.9em">
                            <?php echo '@'; ?>{{ $profile->firstname }}_{{$profile->lastname}}
                        </p>
                    </div>
                    <p class="text-center" style="font-size: .9rem;">
                        <span class="description"> მომხმარებლის ტიპი : </span>
                        <span class="{{ $class }} font-weight-bold"> {{ $type }} </span>
                    </p>
                </div>
                <div class="card-footer" style="margin-top:-30px;">
                    <hr>
                    <div class="button-container">
                        <div class="row">
                            <div class="col-lg-3  col-md-4 col-4 ml-auto">
                                <img class=""
                                     style="width:30px;height:30px;cursor:pointer; padding:4px; border-radius:50%"
                                     src="/icons/edit1.png"
                                     title='Edit background image'
                                     onclick="editImage(1)"
                                />
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ml-auto mr-auto">
                                <img src="/icons/camera.png"
                                     style="width:30px;height:30px;cursor:pointer; padding:4px;  border-radius:50%"
                                     title='Edit profile image'
                                     onclick="editImage(2)"
                                />
                            </div>
                            <div class="col-lg-3 col-md-4 col-4 ">
                                <img src="/icons/change.png"
                                     style="width:30px;height:30px;cursor:pointer; padding:4px; "
                                     onclick="editInfo()"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" id="editPanel" style="display:none;border:none;border-radius: 25px; height:auto;">
                <form method="post" action="profileImage" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">

                        <img src="" class="pl-2" id='output' width="65" style="opacity:.3"/>
                        <img src="" class="pl-2" id='output2' width="65" style="opacity:.3"/>

                        <input type="file" id="profileBack"
                               style="display:none;"
                               name="background"
                               onchange="imageLoad(event,'output')"
                        />
                        <input type="file" id="profileImage"
                               style="display:none;"
                               name="avatar"
                               onchange="imageLoad(event, 'output2')"
                        />
                        @error('background')
                        <p class="text-danger text-sm pl-2">
                            {{ $message}}
                        </p>
                        @enderror

                        @error('avatar')
                        <p class="text-danger text-sm pl-2">
                            {{ $message}}
                        </p>
                        @enderror

                        <button class="btn btn-danger float-right mt-auto mb-auto"
                                style="margin-top:0;
                            font-size:.8em;border-radius:25px;padding:6px;">ატვირთვა
                        </button>

                    </div>
                </form>
            </div>

            <div class="card" style="border:none;border-radius: 15px;">
                <div class="card-header" style="">
                    <h6 class="card-title">Credentials</h6>
                </div>
                <div class="card-body" style="margin-top:-30px;">
                    <form method="post" action="account">
                        @csrf
                        @method('patch')
                        <div class="form-group mt-3" style="">
                            <label class="" style="font-size:.8em;">იუზერნეიმი</label>
                            <input type="text"
                                   class="form-control"
                                   placeholder="Username"
                                   name="username"
                                   value="{{auth()->user()->username}}"/>
                            @error('username')
                            <p class="text-danger text-sm">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="" style="font-size:.8em;">მეილი</label>
                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   placeholder="Email"
                                   value="{{auth()->user()->email}}"
                            />
                            @error('email')
                            <p class="text-danger text-sm">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="" style="font-size:.8em;">პაროლი</label>
                            <div style="display:flex">
                                <input type="password" class="form-control" id="pass01"
                                       placeholder="Password"
                                       name="password"
                                />
                                <span class="position-absolute mt-1 pointer"
                                      style="right:10px;"
                                      onclick="togglePassVisibility()"
                                >
                                <i class="fa fa-eye-slash text-info" id="eye01"></i>
                            </span>
                            </div>

                            @error('password')
                            <p class="text-danger text-sm">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="update ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary btn-round"
                                        style="border-radius: 25px;
                                    background-color: rgba(87, 192, 194, .9);
                                    font-size: .9em;
                                    border:none;"
                                >განახლება
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card card-user" style="border:none; border-radius:10px;">
                <div class="card-header">
                    <h5 class="card-title">პროფილის რედაქტირება</h5>
                </div>

                <div class="card-body">
                    <form method="post" action="profile" onsubmit="validateInfo(event)">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="" style="font-size:.8em;">სახელი</label>
                                    <input type="text" class="form-control"
                                           placeholder="Firstname"
                                           value="{{$profile->firstname}}"
                                           name="firstname"
                                    />
                                    @error('firstname')
                                    <p class="text-danger text-sm pl-2">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="" style="font-size:.8em;">გვარი</label>
                                    <input type="text" class="form-control"
                                           placeholder="Lastname"
                                           value="{{$profile->lastname}}"
                                           name="lastname"
                                    />
                                    @error('lastname')
                                    <p class="text-danger text-sm pl-2">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="font-size:.8em;">მობილური</label>
                                    <input type="text" class="form-control"
                                           placeholder="598******"
                                           value="{{$profile->phone}}"
                                           name="phone"
                                           id="phone"
                                    />
                                    @error('phone')
                                    <p class="text-danger text-sm pl-2">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-1">
                                <div class="form-group">
                                    <label class="mx-2" style="font-size:.8em;">ორგანიზაცია</label>
                                    <input type="radio"
                                           class="position-absolute mt-1 ml-2"
                                           style="width: 20px; height: 20px; "
                                           value="1"
                                           name="organization"
                                           id="organization"
                                    />
                                    @error('organization')
                                    <p class="text-danger text-sm pl-2">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 px-md-1">
                                <div class="form-group">
                                    <label class="mx-2" style="font-size:.8em;">ფიზიკური პირი</label>
                                    <input type="radio"
                                           class="position-absolute mt-1 ml-2"
                                           style="width: 20px; height: 20px"
                                           value="0"
                                           name="organization"
                                           id="physical_person"
                                    />
                                    @error('physical_person')
                                    <p class="text-danger text-sm pl-2">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 pl-md-1">
                            </div>
                        </div>
                        <div class="row" id="work_organization" style="display: none">
                            <div class="col-12">
                                <label for="" style="font-size:.9em;">ორგანიზაცია</label>
                                <input class="form-control"
                                       name="work_organization"
                                       id="work_organization_value"
                                />
                                @error('work_organization')
                                <p class="text-danger text-sm pl-2">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="row" id="work" style="display: none">
                            <div class="col-12">
                                <label for="" style="font-size:.9em;">სამუშაო ადგილი</label>
                                <input class="form-control"
                                       name="work"
                                       id="work_value"
                                />
                                @error('work')
                                <p class="text-danger text-sm pl-2">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4" id="position_in_organization" style="display: none">
                            <div class="col-12">
                                <label for="" style="font-size:.9em;">სამუშაო ადგილი ორგანიზაციაში</label>
                                <input class="form-control"
                                       name="position_in_organization"
                                       id="position_in_organization_value"
                                />
                                @error('position_in_organization')
                                <p class="text-danger text-sm pl-2">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="update ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary btn-round bg-info"
                                        style="border-radius:20px;font-size:.8em;"> პროფილის განახლება
                                </button>
                            </div>
                        </div>
                    </form>
                    <script type='application/javascript'>
                        function fileClick() {
                            $1('output').style.opacity = '.4'
                            alert('fine')
                        }

                        function editImage(type) {
                            if (type == 1)
                                $1('profileBack').click()
                            else if (type == 2)
                                $1('profileImage').click()
                        }

                        function imageLoad(event, imgId) {
                            $1('editPanel').style.display = 'block'
                            let input = event.target;

                            let reader = new FileReader();
                            reader.onload = function () {
                                let dataURL = reader.result;
                                let output = $1(imgId);
                                output.src = dataURL;
                            };
                            reader.readAsDataURL(input.files[0]);
                            $1(imgId).style.opacity = '1';
                        }

                        function togglePassVisibility() {
                            if ($1('pass01').type == 'password') {
                                $1('pass01').type = 'text'
                                $1('eye01').className = 'fa fa-eye text-info'
                            } else {
                                $1('pass01').type = 'password'
                                $1('eye01').className = 'fa fa-eye-slash text-info'
                            }
                        }

                        function validateInfo(event) {
                            let phone = String(document.querySelector('#phone').value).trim()
                            if (phone.length > 0) {
                                if (phone.length > 17) {
                                    alert('მობილურის ფორმატი არასწორია')
                                    event.preventDefault();
                                }
                                if (isNaN(Number(phone.replaceAll(' ', '')))) {
                                    alert('მობილურის ფორმატი არასწორია')
                                    event.preventDefault();
                                }
                            }
                            const organization = document.getElementsByName('organization');
                            let isOrganization = 1;
                            for (let radio of organization) {
                                if (radio.checked) {
                                    isOrganization = parseInt(radio.value)
                                    break;
                                }
                            }
                            isOrganization = !!isOrganization;
                            if (isOrganization) {
                                let organization = document.querySelector('#work_organization_value').value
                                organization = String(organization).trim();
                                if (organization.length < 1) {
                                    alert('გთხოვთ, შეიყვანოთ ორგანიზაცია')
                                    event.preventDefault();
                                }
                            }
                        }
                        {
                            let isOrganization = parseInt("{{ $user->profile->organization }}")
                            isOrganization = !!isOrganization;
                            document.querySelector('#organization').checked = isOrganization;
                            document.querySelector('#physical_person').checked = !isOrganization;
                            function switchWork(isOrganization) {
                                if (isOrganization) {
                                    document.querySelector('#work_organization').style.display = "";
                                    document.querySelector('#work').style.display = "none";
                                    document.querySelector('#position_in_organization').style.display = ''
                                } else {
                                    document.querySelector('#work').style.display = "";
                                    document.querySelector('#work_organization').style.display = "none";
                                    document.querySelector('#position_in_organization').style.display = 'none'
                                }
                            }
                            switchWork(isOrganization);
                            document.querySelector('#organization').addEventListener('click', () => switchWork(true))
                            document.querySelector('#physical_person').addEventListener('click', () => switchWork(false))
                            function decode(str) {
                                return str.replaceAll('&#039;', "'").replaceAll('&quot;', '"').replaceAll('&lt;', '<').replaceAll('&gt;', '>').replaceAll('&amp;', '&')
                            }
                            const workOrganizationValue = decode("{{ $profile->work_organization }}")
                            const workValue = decode("{{ $profile->work }}")
                            const positionInOrganizationValue = decode("{{ $profile->position_in_organization }}")
                            if (isOrganization) {
                                document.querySelector('#work_organization_value').value = workOrganizationValue
                                document.querySelector('#work_value').value = '';
                                document.querySelector('#position_in_organization_value').value = positionInOrganizationValue
                            } else {
                                document.querySelector('#work_organization_value').value = '';
                                document.querySelector('#work_value').value = workValue;
                                document.querySelector('#position_in_organization_value').value = '';
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
