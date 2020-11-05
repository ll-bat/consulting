<?php

namespace App\Http\Controllers;

use App\Helperclass\Customizable;
use App\Helperclass\Texts;
use App\Helperclass\Services;
use Illuminate\Http\Request;

class CustomizeController extends Controller
{
      public function index(){
          $obj = new Customizable();
    
        //   dd($obj);

          return view("admin.customize.index", [
              'data' => $obj
          ]);
      }

      public function upload(){
            $req = request()->validate([
                  'name' => 'required|string',
                  'image' => 'required|image'
            ]);
                                                          
            if (in_array($req['name'], ['home', 'blogs', 'services', 'about', 'contact'])){
                $model = new Customizable();
                $data  = $model->getData();

                if (isset($data['images']) && isset($data['images'][$req['name']])){
                    // $name = "/storage/" . $data['images'][$req['name']];

                    // unset($name);
                }

                $imageName = cloudinary()->upload(request()->file('image')->getRealPath())->getSecurePath(); 

                if (!isset($data['images'])){
                    $data['images'] = [];
                }
                
                $data['images'][$req['name']] = $imageName;

                $model->saveData($data);
            }

            else {
                return  response('Unknown', 404);
            }

            return response('all-done', 200);
      }

      public function store(Request $request){
            $data = $request->validate([
                'page'    => 'required|string',
                'element' => 'required|string',
                'is-bold' => 'required|boolean',
                'font-size' => 'required|numeric',
                'color' => 'required|string|max:25',
                'value' => 'nullable|string'
            ]);

            $data['value'] = $data['value'] ?? '';

            $texts = new Texts();

            $done = $texts->update($data['page'], $data['element'], [
                 'is-bold' => $data['is-bold'],
                 'font-size' => $data['font-size'],
                 'color' => $data['color'],
                 'value' => $data['value']
            ]);

            if (!$done){
                return response("bad request", 403);
            }

            return response('all-done', 200);
      }


}
