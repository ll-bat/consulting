<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    private $data = [];

    public function __construct($data){
          $this->data = $data;
          $this->init();
    }

    public function init(){
        $pdf = PDF::loadView('exports.pdf.result', $this->data);
        return $pdf->download('result.pdf');
    }

    public function show(Export $export){
        //   $file =  Storage::get($export->path());

        //   $response = Response::make($file, 200);
        //   $response->header('Content-Type', 'application/pdf');
        //   return $response;
    }
}
