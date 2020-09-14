<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(){
        $user = auth()->user();
        $data = request()->validate([
            'username' => ['required', 'string', 'max:255' ,'alpha_dash'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($data['email'] != $user->email){
            request()->validate([
                'email' => ['unique:users']
            ]);
        }
        
        if (request('password'))
        {
            $val = request()->validate(['password' => ['required', 'string', 'min:8', 'max:255']]);
            $data['password'] = bcrypt($val['password']);
        }

        $user->update($data);

        return back();
    }
}
