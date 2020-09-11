<?php

namespace App\Http\Controllers;

use App\Export;
use App\Helperclass\Json;
use App\Helperclass\Obj;
use FontLib\EOT\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MyDocsController extends Controller
{
      public function index(){
          $docs = Export::where('user_id', current_user()->id)->latest()->get();
          return view('user.mydocs', compact('docs'));
      }

      public function show(Export $export){
         $this->authorize('show-doc', $export);

         $json = new Json();
         $data = $json->load($export->filename);

         $countAll = $data[2];
         $object = new Obj($data[0], $data[1], $data[2]);

         return view('user.docs.form', compact('object', 'countAll'));
      }

      public function download(Export $export){
        //   $this->authorize('show-doc', $export);

        //   $filename = $export->filename;

        //   $headers = array(
        //       'Content-Type: application/pdf',
        //   );

        //   return Response::download(storage_path("app/public/exports/$filename"), 'result.pdf', $headers);
      }

      public function delete(Export $export){
          $this->authorize('show-doc', $export);

          if (file_exists($export->filename)){
              unlink($export->filename);
          }

          $export->delete();

          return back();
      }
}
