<?php

namespace App\Http\Controllers;

use App\Export;
use App\Helperclass\Json;
use App\Helperclass\Obj;
use App\Helperclass\Content;
use App\Helperclass\QuestionsJson;
use App\Objects;
use FontLib\EOT\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class MyDocsController extends Controller
{
      protected $data = [];

      public function show(Export $export){
         $this->authorize('show-doc', $export);

         $con = new Content($export);
         $con = $con->getData();

        //  dd($con);

         $id  = $export->id;

         $this->data = $con;

         return view('user.docs.form', [
             'countAll' => $con[0],
             'object'   => $con[1],
             'docId'    => $id
         ]);
      }

      public function edit(Export $export) {
          $this->authorize('show-doc', $export);

          $data = json_decode($export->data);
          $data = (new QuestionsJson($data))->getData();


          session()->put('questions-data', [json_encode($data), $export->id]);

          return redirect('/user/questions');
      }



      public function export(Export $export){
          $this->authorize('show-doc', $export);

          $validator = Validator::make(request()->all(),[
              'pdf' => 'nullable|boolean',
              'excel' => 'nullable|boolean'
          ]);

          if ($validator->fails()){
               return redirect()->route('user.export', $export->id)->with('errors', ['Choose at least one']);
          }

          if (request('pdf')){
              return $this->downloadPdf($export);
          }

          else if (request('excel')){
              return $this->downloadExcel($export);
          }

          else {
              return redirect()->route('user.export', $export->id)->with('errors', ['Choose at least one']);
          }
      }

      public function downloadExcel(Export $export){
          $name = 'My Excel Document.xlsx';
          return Excel::download(new UsersExport($export), $name);
      }

      public function downloadPdf(Export $export){
           $this->authorize('show-doc', $export);

           $filename = $export->filename;

           $dompdf = new Dompdf();
           $customPaper = array(0,0,900,2700);
           $dompdf->set_paper($customPaper);

           $con = new Content($export, 'pdf');
           $con = $con->getData();

           $view = view('user.docs.pdf_table', [
               'countAll' => $con[0],
               'object'   => $con[1]
           ])->render();

           $dompdf->loadHtml($view);
           $dompdf->render();

           $dompdf->stream();

           return true;
      }

      public function delete(Export $export): RedirectResponse
      {
          $this->authorize('show-doc', $export);

          $export->delete();

          return back();
      }
}
