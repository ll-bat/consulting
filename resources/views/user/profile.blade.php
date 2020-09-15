@extends('layouts/zim')







<?php
    $users = \App\User::all();
?>


@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card card-user" style="border-radius: 15px;">
                <div class="image">

                    <img src="{{$profile->pathBack()}}" />
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="">
                            <img src="{{$profile->pathAvatar()}}" class="avatar border-gray" />
                            <h5 class="title">{{current_user()->username}}</h5>
                        </a>
                        <p class="description" style="font-size:.9em">
                            <?php echo '@'; ?>{{ $profile->firstname }}_{{$profile->lastname}}
                        </p>
                    </div>
                    <p class="description text-center" style="font-size:.9em;">
                        "I like the way i work with <br />
                         No diggity <br/>
                        I wanna bag it up "
                    </p>
                </div>
                <div class="card-footer" style="margin-top:-30px;">
                    <hr>
                    <div class="button-container">
                        <div class="row" >
                            <div class="col-lg-3  col-md-4 col-4 ml-auto">
                                <img  class=""
                                      style="width:30px;height:30px;cursor:pointer; padding:4px; border-radius:50%"
                                      src="/icons/edit1.png"
                                      title='Edit background image'
                                      onclick = "editImage(1)"
                                />
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ml-auto mr-auto">
                                <img src="/icons/camera.png"
                                     style="width:30px;height:30px;cursor:pointer; padding:4px;  border-radius:50%"
                                     title='Edit profile image'
                                     onclick = "editImage(2)"
                                />
                            </div>
                            <div class="col-lg-3 col-md-4 col-4 ">
                                <img src="/icons/change.png"
                                     style="width:30px;height:30px;cursor:pointer; padding:4px; "
                                     onclick = "editInfo()"
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
                    <p class="text-danger text-sm pl-2" >
                        {{ $message}}
                    </p>
                    @enderror

                    @error('avatar')
                    <p class="text-danger text-sm pl-2" >
                        {{ $message}}
                    </p>
                    @enderror

                    <button class="btn btn-danger float-right mt-auto mb-auto"
                            style="margin-top:0;
                            font-size:.8em;border-radius:25px;padding:6px;">Submit</button>

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
                        <label class="" style="font-size:.8em;">Username</label>
                        <input type="text"
                               class="form-control"
                               placeholder="Username"
                               name="username"
                               value="{{auth()->user()->username}}" />
                        @error('username')
                           <p class="text-danger text-sm">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="" style="font-size:.8em;">Email address</label>
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
                        <label class="" style="font-size:.8em;">password</label>
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
                            >Update</button>
                        </div>
                    </div>
                   </form>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card card-user" style="border:none; border-radius:10px;">
                <div class="card-header">
                    <h5 class="card-title">Edit Profile</h5>
                </div>

             <div class="card-body">
               <form method="post" action="profile">
                   @csrf
                   @method('patch')
                <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                             <label class="" style="font-size:.8em;">First name</label>
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
                            <label class="" style="font-size:.8em;">Last name</label>
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
                             <label style="font-size:.8em;">Address</label>
                             <input type="text" class="form-control"
                                    placeholder="Home Address"
                                    value="{{$profile->address}}"
                                    name="address"
                             />
                             @error('address')
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
                             <label style="font-size:.8em;">City</label>
                             <input type="text" class="form-control"
                                    placeholder="City"
                                    value="{{$profile->city}}"
                                    name="city"
                             />
                             @error('city')
                             <p class="text-danger text-sm pl-2">
                                 {{$message}}
                             </p>
                             @enderror
                         </div>
                     </div>
                     <div class="col-md-4 px-md-1">
                         <div class="form-group">
                             <label style="font-size:.8em;">Country</label>
                             <input type="text" class="form-control"
                                    placeholder="Country"
                                    value="{{$profile->country}}"
                                    name="country"
                             />
                             @error('country')
                             <p class="text-danger text-sm pl-2">
                                 {{$message}}
                             </p>
                             @enderror
                         </div>
                     </div>
                     <div class="col-md-4 pl-md-1">
                         <div class="form-group">
                             <label style="font-size:.8em;">Postal Code</label>
                             <input type="number" class="form-control"
                                    placeholder="Zip"
                                    value="{{$profile->postalCode}}"
                                    name="postalCode"
                             />
                             @error('postalCode')
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
                             <label for="" style="font-size:.9em;">About me</label>
                             <textarea class="form-control"
                                       placeholder="Something about myself"
                                       name="aboutMe"
                             >{{$profile->aboutMe}}</textarea>
                             @error('aboutMe')
                             <p class="text-danger text-sm pl-2">
                                 {{$message}}
                             </p>
                             @enderror
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="update ml-auto mr-auto">
                         <button type="submit" class="btn btn-primary btn-round bg-info" style="border-radius:20px;font-size:.8em;">Update Profile</button>
                     </div>
                  </div>
                 </form>
                 <script type='application/javascript'>
                     function fileClick(){
                         $1('output').style.opacity = '.4'
                         alert('fine')
                     }
                     function editImage(type){
                         if (type == 1)
                             $1('profileBack').click()
                         else if(type == 2)
                             $1('profileImage').click()
                     }
                     function imageLoad(event, imgId){
                             $1('editPanel').style.display='block'
                             let input = event.target;

                             let reader = new FileReader();
                             reader.onload = function(){
                                 let dataURL = reader.result;
                                 let output = $1(imgId);
                                 output.src = dataURL;
                             };
                             reader.readAsDataURL(input.files[0]);
                             $1(imgId).style.opacity = '1';
                     }

                     function togglePassVisibility(){
                         if ($1('pass01').type == 'password'){
                             $1('pass01').type  = 'text'
                             $1('eye01').className = 'fa fa-eye text-info'
                         }
                         else {
                             $1('pass01').type  = 'password'
                             $1('eye01').className = 'fa fa-eye-slash text-info'
                         }
                     }

                 </script>
                </div>
            </div>
        </div>
    </div>
@endsection
