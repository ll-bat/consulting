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
        $exportId = null;
        $data = null;

        $obj = session()->get('questions-data') ?? false;
        session()->put('questions-data', false);

        if ($obj) {
            [$data, $exportId] = $obj;
            session()->put('exportId', $exportId);
        } else {
            session()->put('exportId', false);
            session()->forget('oldImages');
        }

        return view('user.questions.index', compact('data', 'exportId'));
    }


}
