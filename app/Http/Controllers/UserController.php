<?php

namespace App\Http\Controllers;

use App\Export;
use App\Helperclass\Content;
use App\Objects;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class UserController extends Controller
{
    public function edit(User $user) {
        $objects = $user->getObjects();

        return view('user.objects', [
            'objects' => array_reverse(
                index($objects, 'id')
            ),
            'readonly' => true
        ]);
    }

    /**
     * @param $user
     * @param $objects
     * @return Application|Factory|View
     */
    public function objectDocs($user, $objects) {
        $docs = Export::where(['object_id' => $objects])
            ->latest()
            ->simplePaginate(10);

        return view('user.mydocs', [
            'docs' => $docs,
            'readonly' => true
        ]);
    }

    public function showDoc($user, $object, Export $export) {
        $con = new Content($export);
        $docAbout = $con->docAbout;
        $con = $con->getData();

        $id = $export->id;
        $this->data = $con;

        return view('user.docs.form', [
            'countAll' => $con[0],
            'object' => $con[1],
            'docId' => $id,
            'filename' => $export->filename,
            'docAbout' => $docAbout,
            'readonly' => true
        ]);
    }

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
