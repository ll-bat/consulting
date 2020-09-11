<?php

namespace App\Http\Controllers;

use App\Udanger;
use Illuminate\Http\Request;

class UdangerController extends Controller
{
     public function index(){
         return Udanger::all();
     }

     public function create(){
         return Udanger::create(['name' => 'null'])->id;
     }

     public function save(){

        $data = \request()->validate([
            'id' => 'integer|required|exists:udangers,id',
            'name' => 'required|string',
        ]);

        $udanger = Udanger::find($data['id']);
        $udanger->update($data);

        return response('success', 200);
    }

   public function delete(Udanger $udanger){
       $udanger->delete();

       return response('deleted', 200);
   }
}
