<?php

namespace App\Http\Controllers;

use App\Ploss;
use Illuminate\Http\Request;

class PlossController extends Controller
{
      public function index(){
          return Ploss::all();
      }

      public function create(){
         return Ploss::create(['name' => 'null', 'k' => '3'])->id;
      }

      public function save(){

          $data = \request()->validate([
              'id' => 'integer|required|exists:plosses,id',
              'name' => 'nullable|string',
              'k' => 'string'
          ]);

          if ($data['name'] == '') $data['name'] = ' ';
          $ploss = Ploss::find($data['id']);
          $ploss->update($data);

          return response('success', 200);
      }

     public function delete(Ploss $ploss){
         $ploss->delete();

         return response('deleted', 200);
     }
}
