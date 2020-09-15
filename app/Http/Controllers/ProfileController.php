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
            'aboutMe'   => ['string', 'max:255','nullable']
        ]);

        $profile = auth()->user()->profile;

        $profile->update($data);

        return back();
    }

    public function store(){
        $data = request()->validate([
            'avatar'    => ['image'],
            'background'=> ['image']
        ]);

        $profile = auth()->user()->profile;

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
