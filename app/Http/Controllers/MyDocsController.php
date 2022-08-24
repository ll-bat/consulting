<?php

namespace App\Http\Controllers;

use App\Export;
use App\Helperclass\Json;
use App\Helperclass\Obj;
use App\Helperclass\Content;
use App\Helperclass\QuestionsJson;
use App\Objects;
use Exception;
use FontLib\EOT\File;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use App\Exports\UsersExport;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class MyDocsController extends Controller
{
    protected $data = [];

    /**
     * @param Export $export
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function show(Export $export)
    {
        $this->authorize('show-doc', $export);

        $con = new Content($export);
        $docAbout = $con->docAbout;
        $con = $con->getData();

        $id = $export->id;
        $this->data = $con;
        $userObjects = Objects::where('user_id', current_user()->id)
            ->select('id', 'name')
            ->get();

        return view('user.docs.form', [
            'countAll' => $con[0],
            'object' => $con[1],
            'docId' => $id,
            'filename' => $export->filename,
            'objects' => $userObjects,
            'objectId' => $export->object_id,
            'docAbout' => $docAbout
        ]);
    }

    /**
     * @param Export $export
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function edit(Export $export)
    {
        $this->authorize('show-doc', $export);

        session()->forget('_docData');

        return redirect()->route('user.questions', [
            'document_id' => $export->id,
        ]);
    }

    /**
     * @param Export $export
     * @return mixed
     * @throws Exception
     */
    public function update(Export $export) {

        $this->authorize('show-doc', $export);

        \request()->validate([
            'filename' => 'required|string|max:512',
            'objectId' => 'required|integer'
        ]);

        $query = ['filename' => \request('filename')];

        if (!$export->object_id !== \request('objectId')) {
            $ok = Objects::where('id', \request('objectId'))
                ->where('user_id', current_user()->id)
                ->limit(1)
                ->count() > 0;

            if (!$ok) {
                throw new Exception('Such object does note exist', 404);
            } else {
                $query['object_id'] = \request('objectId');
            }
        }

        $ok = $export->update($query);
        if ($ok) {
            return 'all-done';
        }
        throw new Exception('Error occurred', 400);
    }

    /**
     * @param Export $export
     * @return bool|\Illuminate\Auth\Access\Response
     * @throws AuthorizationException
     */
    private function _authorize(Export $export) {
        if (current_user()->isAdmin()) {
            return true;
        }
        return $this->authorize('show-doc', $export);
    }

    /**
     * @param Export $export
     * @return bool|RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function export(Export $export)
    {
        $this->_authorize($export);

        $validator = Validator::make(request()->all(), [
            'pdf' => 'nullable|boolean',
            'excel' => 'nullable|boolean',
            'word' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.export', $export->id)->with('errors', ['Choose at least one']);
        }

        if (request('pdf')) {
            return $this->downloadPdf($export);
        } else if (request('excel')) {
            return $this->downloadExcel($export);
        } else if (\request('word')) {
            return $this->downloadWord($export);
        } else {
            return redirect()->route('user.export', $export->id)->with('errors', ['Choose at least one']);
        }
    }

    private function downloadWord(Export $export)
    {
        $pw = new PhpWord();
        $section = $pw->addSection();
//        $section->getStyle()->setPageSizeW(30000);

        $con = new Content($export, 'pdf');
        $docAbout = $con->docAbout;
        $con = $con->getData();
        $html = view('user.docs.table_body', [
            'countAll' => $con[0],
            'object' => $con[1],
            'docAbout' => $docAbout
        ])->render();

        Html::addHtml($section, $html, true, false);
        $uniqueName = 'HTML-' . time() . '.docx';
        $pw->save($uniqueName);
        return response()->download(public_path($uniqueName))->deleteFileAfterSend();
    }

    /**
     * @param Export $export
     * @return BinaryFileResponse
     * @throws AuthorizationException
     */
    private function downloadExcel(Export $export): BinaryFileResponse
    {
        $this->_authorize($export);

        $name = $export->filename;
        $parts = explode('.', $name);
        if (count($parts) < 2) {
            $name .= '.xlsx';
        } else {
            $extension = $parts[count($parts) - 1];
            if (!in_array($extension, ['xlsx', 'csv', 'xlsm', 'xlt'])) {
                $name .= '.xlsx';
            }
        }
        return Excel::download(new UsersExport($export), $name);
    }

    /**
     * @param Export $export
     * @return bool
     * @throws AuthorizationException
     * @throws \Throwable
     */
    private function downloadPdf(Export $export): bool
    {
        $this->_authorize($export);

        $con = new Content($export, 'pdf');
        $docAbout = $con->docAbout;
        $con = $con->getData();

        $height = $con[0] * 50 + 400;
        $height = max($height + 300, 900);

        $dompdf = new Dompdf();
        $customPaper = array(0, 0, 1200, $height);
        $dompdf->setPaper($customPaper);

        $view = view('user.docs.pdf_table', [
            'countAll' => $con[0],
            'object' => $con[1],
            'docAbout' => $docAbout
        ])->render();

        $dompdf->loadHtml($view);
        $dompdf->render();

        $dompdf->stream($export->filename);

        return true;
    }

    /**
     * @param Export $export
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function delete(Export $export): RedirectResponse
    {
        $this->authorize('show-doc', $export);

        $export->delete();

        return back();
    }
}
