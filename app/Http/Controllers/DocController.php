<?php


namespace App\Http\Controllers;

use App\Export;
use App\Field;
use App\Helperclass\QuestionsJson;
use App\Helperclass\UserInputs;
use App\Objects;
use App\Process;
use App\UserText;
use App\Helperclass\Filter;
use App\Helperclass\FinalData;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class DocController extends Controller
{
    public function index()
    {
        $fieldId = session()->get('_fieldId') ?? false;
        if (!$fieldId) {
            return redirect()->route('admin.fields');
        }
        $cnt = UserText::where(['field_id' => $fieldId, 'is_ignored' => false])->select('id')->first();
        if ($cnt) {
            $cnt = 1;
        }
        $procs = Process::where('field_id', $fieldId)->orderBy('created_at', 'asc')->get();

        return view('admin.docs.index', compact('procs', 'cnt', 'fieldId'));
    }

    public function show()
    {
        return view('admin.docs.check');
    }

    private function validateDocumentHeaders() {
        $rules = [
            '_documentAuthorNames' => 'required|string|max:400',
            '_documentAddress' => 'required|string|max:600',
            '_documentDescription' => 'required|string|max:900',
            '_documentFirstDate' => 'required|string|max:50',
            '_documentSecondDate' => 'required|string|max:50',
            '_documentNumber' => 'required|string|max:50',
            '_filename' => 'required|string|max:512',
            '_objectId' => 'integer|required',
        ];

        $messages = [
            '_documentAuthorNames' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 400 - ს"),
            '_documentAddress' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 600 - ს"),
            '_documentDescription' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 900 - ს"),
            '_documentFirstDate' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს"),
            '_documentSecondDate' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს"),
            '_documentNumber' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს"),
            '_filename' => __("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 512 - ს"),
        ];

        Validator::make(request()->all(), $rules, $messages)->validate();
    }

    public function prepareDoc()
    {
        /*
        $rules = [
            'isNew' => 'boolean|required',
            'objectId' => 'integer|required',
            'fieldId' => 'integer|required',
            'filename' => 'required|string|max:512',
            '_documentAuthorNames' => 'required|string|max:400',
            '_documentAddress' => 'required|string|max:600',
            '_documentDescription' => 'required|string|max:900',
            '_documentFirstDate' => 'required|string|max:50',
            '_documentSecondDate' => 'required|string|max:50',
            '_documentNumber' => 'required|string|max:50'
        ];

        $messages = [
            '_documentAuthorNames' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 400 - ს")',
            '_documentAddress' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 600 - ს")',
            '_documentDescription' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 900 - ს")',
            '_documentFirstDate' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს")',
            '_documentSecondDate' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს")',
            '_documentNumber' => '__("შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს")'
        ];

        \Illuminate\Support\Facades\Validator::make(request()->all(), $rules, $messages)
            ->validate();

        $objectId = \request('objectId');
        $fieldId = \request('fieldId');
        $filename = \request('filename');

        $ok = Objects::where('id', $objectId)->where('user_id', current_user()->id)->limit(1)->count() > 0;
        if (!$ok) {
            return response('Such object does not exist', 404);
        }

        $ok = Field::where('id', $fieldId)->limit(1)->count() > 0;
        if (!$ok) {
            return \response('Such field does not exit', 404);
        }

        $data = [
            'objectId' => $objectId,
            'filename' => $filename,
            'fieldId' => $fieldId,
            'author-names' => request('_documentAuthorNames'),
            'address' => request('_documentAddress'),
            'description' => request('_documentDescription'),
            'first_date' => request('_documentFirstDate'),
            'second_date' => request('_documentSecondDate'),
            'number' => request('_documentNumber')
        ];

        if (request('isNew')) {
//            $data['isNew'] = true;
//            session()->put('_docData', $data);

        } else {
            \request()->validate([
                'docId' => 'required|integer'
            ]);

            $docId = \request('docId');
            $export = Export::where('id', $docId)
                ->where('user_id', current_user()->id)
                ->select('data')
                ->get()
                ->toArray();

            if (!$export) {
                return \response('Such document does not exist', 404);
            }

//            $content = json_decode($export[0]['data']);
//            $content = (new QuestionsJson($content))->getData();
//
//            $data['isNew'] = false;
//            $data['docId'] = $docId;
//            $data['data'] = \Psy\Util\Json::encode($content);
//
//            session()->put('_docData', $data);
        }

        return 'all-done';
        */
        throw new Exception('not implemented error');
    }

    /**
     * @return bool
     */
    public function validateDoc(): bool
    {
        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function validateRequest(): array
    {
//        if (!$this->validateDoc()) {
//            throw new Exception('You have to first choose an object', 400);
//        }

        return request()->validate([
            'data' => 'required|string',
            'field_id' => 'required|boolean',
            'document_id' => 'integer|nullable',
            'copied_document_id' => 'integer|nullable',
        ]);
    }

//    /**
//     *@return int
//     */
//    public function getFieldId(): int
//    {
//        return session()->has('_docData') ?
//            session()->get('_docData')['fieldId'] :
//            session()->get('_questionsData')['fieldId'];
//    }

    /**
     * @return string
     * @throws Exception
     */
    public function submit(): string
    {
        $validatedData = $this->validateRequest();
        $data = $validatedData['data'];
        $fieldId = $validatedData['field_id'];
        $document_id = $validatedData['document_id'] ?? false;
        $copied_document_id = $validatedData['copied_document_id'] ?? false;

        $should_get_headers = $copied_document_id || !$document_id;
        $document_headers = [];
        if ($should_get_headers) {
            // this means document is new or copied
            $this->validateDocumentHeaders();
            $document_headers['author-names'] = request('_documentAuthorNames');
            $document_headers['address'] = request('_documentAddress');
            $document_headers['description'] = request('_documentDescription');
            $document_headers['first_date'] = request('_documentFirstDate');
            $document_headers['second_date'] = request('_documentSecondDate');
            $document_headers['number'] = request('_documentNumber');
            $document_headers['filename'] = request('_filename');
            $document_headers['objectId'] = request('_objectId');
        }

        try {
            $data = json_decode($data);
        } catch (Exception $exception) {
            throw new Exception('Invalid data format', 400);
        }

        if (gettype($data) !== 'array') {
            throw new Exception("Invalid data format", 400);
        }

        $filter = new Filter($data, $fieldId, $copied_document_id);
        $data = $filter->getData();

        request()->validate(
            $filter->getImageRule()
        );

        /**
         * Upload user images to remote server and save new names.
         */
        foreach ($data as $ind => $d) {
            if ($d['data']['hasImage'] && !isset($d['data']['oldImage'])) {
                //   $name = request($d['imageName'])->store('testing');
                $name = cloudinary()->upload(request($d['data']['imageName'])->getRealPath())->getSecurePath();
                $data[$ind]['data']['imageName'] = $name;
            }
        }

        /**
         * As we already have some useful data for creating UserInputs, implement the rest here...
         */

        /**
         * Set false to $exportId by default.
         */
        $exportId = $document_id;

        /**
         * Create finalData instance to save new data.
         */
        $reader = new FinalData($exportId);
        $reader->init($data, $fieldId, $document_headers);

        /**
         * After FinalData init method, we have exportId.
         */
        $exportId = $reader->getExportId();

        /**
         * If the user adds custom potentialLosses, controls or udangers, we should create corresponding records in database.
         */
        UserInputs::createRecords($exportId, $fieldId, $filter->getAddedValues());

        /**
         * Clear session.
         */
        $this->clearSession();

        /**
         * Return new form path to user
         */
        return route('user.export', ['export' => $exportId]);
    }

    /**
     * Clears session vars to avoid unexpected behavior;
     */
    public function clearSession() {
        session()->forget(['_docData', '_questionsData', '_oldImages', '_exportId']);
    }

}
