<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Export;
use App\Field;
use App\Objects;
use App\Rels;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserDocsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        session()->forget("_docData");
        session()->forget("_questionsData");

        $objects = Objects::select('id', 'name')->get()->toArray();
        $fields = Field::select('id', 'name')->get()->toArray();
        $docs = Export::where('user_id', current_user()->id)
            ->select('id', 'filename')
            ->get()
            ->toArray();

        return view('user.preQuestions', compact('objects', 'docs', 'fields'));
    }

    /**
     * @return Application|Factory|RedirectResponse|View
     * @throws \Exception
     */
    public function show()
    {
        if (!session()->has('_docData')) {
            if (!session()->has('_questionsData')) {
                return redirect()->route('user.preQuestions');
            }
        } else {
            session()->forget('_questionsData');
        }

        $exportId = null;
        $data = null;

        $obj = session()->get('_questionsData') ?? false;
        if (!$obj) {
            session()->forget('_oldImages');
            $docData = session()->get('_docData');
            if (!$docData['isNew']) {
               $data = $docData['data'];
            }
        } else {
            $data = $obj['data'];
        }


        return view('user.questions.index', compact('data'));
    }


}
