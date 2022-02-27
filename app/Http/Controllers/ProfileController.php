<?php

namespace App\Http\Controllers;

use Faker\Provider\File;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
       return view('user.profile' ,[
           'profile' => auth()->user()->profile
           ]);
    }

    public function update(){

        $data = request()->validate([
            'firstname' => ['string', 'max:50', 'nullable'],
            'lastname'  => ['string', 'max:50', 'nullable'],
            'address'   => ['string', 'max:120','nullable'],
            'city'      => ['string', 'max:50', 'nullable'],
            'country'   => ['string', 'max:50', 'nullable'],
            'postalCode'=> ['string', 'max:15', 'nullable'],
            'aboutMe'   => ['string', 'max:255','nullable'],
            'phone' => ['string', 'max:17', 'nullable'],
            'organization' => ['boolean'],
            'work_organization' => ['string', 'max:255', 'nullable'],
            'work' => ['string', 'max:255', 'nullable'],
            'position_in_organization' => ['string', 'max:255', 'nullable'],
        ]);

        if ($data['phone']) {
            $phone = str_replace(' ', '', $data['phone']);
            $phone = intval($phone);
            $data['phone'] = $phone;
        }

        $is_organization = $data['organization'];
        $is_organization = intval($is_organization);
        $is_organization = (bool)$is_organization;
        $data['organization'] = $is_organization;

        if ($is_organization) {
            $data['work'] = null;
        } else {
            $data['work_organization'] = null;
            $data['position_in_organization'] = null;
        }

        $profile = auth()->user()->profile;

        $profile->update($data);

        return back();
    }

    public function store(){
        $data = request()->validate([
            'avatar'    => ['image'],
            'background'=> ['image']
        ]);

        $profile = auth()->user()->profile;#

        if (isset($data['avatar'])){
            if ($profile->avatar != '' && $profile->avatar != 'null')
                if (file_exists('storage/'.$profile->avatar))
                    unlink('storage/'.$profile->avatar);

            // $data['avatar'] = request('avatar')->store('avatars');
            $data['avatar'] = cloudinary()->upload(request()->file('avatar')->getRealPath())->getSecurePath();
        }

        if (isset($data['background'])){
            if ($profile->background != '' && $profile->background != 'null')
                if (file_exists('storage/'.$profile->background))
                   unlink('storage/'.$profile->background);

                   $data['background'] = cloudinary()->upload(request()->file('background')->getRealPath())->getSecurePath();
        }

        $profile->update($data);

        return back();
    }
}
