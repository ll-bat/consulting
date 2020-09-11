<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Export;
use App\Rels;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDocsController extends Controller
{
    



    public function show(){
        return view('user.questions.index');
    }



    public function index(){
        $ques = Docs::orderBy('index', 'asc')->get();

        return view('user.docs.index', [
            'ques' => $ques
        ]);
     }

     public function getValidationRule(&$validator, $doc){

        $type = $doc->type;
        if ($type == 'upload') $type = 'mimes:jpeg,jpg,png';
        elseif ($type == 'paragraph') $type = 'string';
        elseif ($type == 'checkbox') $type = 'array';
        else $type = 'integer';

        $rule = [$type];
        if ($doc->required) $rule[] = 'required';
        else $rule[] = 'nullable';

        $validator[$doc->name] = $rule;
        if ($doc->type == 'checkbox'){
            $validator[$doc->name.'.*'] = 'integer';
        }
     }

     public function submit(){
         $docs = Docs::all();

         $validator = [];

         foreach ($docs as $doc) {
             $this->getValidationRule($validator, $doc);
         }

//         dd($validator);
         $data = \request()->validate($validator);

         $docs = $this->process($docs,$data);

         if (!$docs){
             return back();
         }


         $pdf = PDF::loadView('exports.pdf.result', ['docs' => $docs]);
         $this->savePdf($pdf);
         return $pdf->stream();
     }

     public function savePdf($pdf){
         $dir = 'exports/';
         $filename = 'result_'.time().'.pdf';
         Storage::put("{$dir}{$filename}", $pdf->output());

         Export::create(['user_id' => current_user()->id, 'filename' => $filename]);
     }

     public function process($docs, $data){
         $ys = true;
         $rels = [];

         foreach ($docs as $doc) {
             $ys = $this->getData($doc,$data, $rels);
             if (!$ys) return false;
         }

         $data = [];

         foreach ($docs as $doc){
             if (isset($rels[$doc->name])){
                 $doc->value = $rels[$doc->name];
                 $data[$doc->name] = $doc;
             }
         }


         return $data;
     }

     public function getData($doc, $params, &$rels){
         $data = null;
         $type = $doc->type;

         if (!isset($params[$doc->name])) {
             if (!$doc->required) return true;
             else return false;
         }

         if ($type == 'checkbox'){
             $data = Rels::where('docs_id', $doc->id)->whereIn('id',  $params[$doc->name])->get();
             if (count($data) == 0) return false;

             $rels[$doc->name] = $data->map(function($d){
                 return $d->value;
             });
         }
         elseif ($type == 'radio' || $type == 'dropdown'){
             $data = Rels::where('docs_id', $doc->id)->where('id', $params[$doc->name])->first();
             if (!$data) return false;
             $rels[$doc->name] = $data->value;
         }
         elseif ($type == 'paragraph' || $type == 'upload')
         {
             $rels[$doc->name] = $params[$doc->name];
         }

         return true;
     }


}
