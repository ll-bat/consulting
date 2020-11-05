<?php

namespace App\Http\Controllers;

use App\Helperclass\Services;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = new Services();
 
        return response($services->getServices(),200);
    }

    public function create(Request $request){
        $request->validate([
            'id' => 'required|string'
        ]);

        $services = new Services();

        $services->create($request['id']);

        return response('all-done', 200);
    }
   
    public function store(Request $request){
        $data = $request->validate([
             'id' => 'required|string',
             'title' => 'nullable|string',
             'description' => 'nullable|string',
             'shown' => 'required|string',
             'image' => 'nullable|image',
             'image-name' => 'required|string',
        ]);

        if (isset($data['image'])){
            $data['image'] = cloudinary()->upload(request()->file('image')->getRealPath())->getSecurePath(); 
        }

        else $data['image'] = $data['image-name'];

        $services = new Services();

        $services->update($data['id'], [
            'title' => $data['title'], 
            'description' => $data['description'],
            'shown' => $data['shown'],
            'image' => $data['image']
        ]);

        return response($data['image'], 200);
  }

  public function delete(Request $request){
       $request->validate([
           'id' => 'required|string'
       ]);

       $services = new Services();

       $flag = $services->delete($request['id']);

       return response($flag, 200);
  }

}
