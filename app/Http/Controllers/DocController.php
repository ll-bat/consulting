<?php


namespace App\Http\Controllers;

use App\Export;
use App\Field;
use App\Helperclass\QuestionsJson;
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


class DocController extends Controller
{
    public function index()
    {
        $fieldId = session()->get('_fieldId') ?? false;
        if (!$fieldId) {
            return redirect()->route('admin.fields');
        }
        $cnt = UserText::where('field_id', $fieldId)->count();
        $procs = Process::where('field_id', $fieldId)->orderBy('created_at', 'asc')->get();

        return view('admin.docs.index', compact('procs', 'cnt'));
    }

    public function show()
    {
        return view('admin.docs.check');
    }

    public function prepareDoc()
    {
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
            '_documentAuthorNames' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 400 - ს',
            '_documentAddress' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 600 - ს',
            '_documentDescription' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 900 - ს',
            '_documentFirstDate' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს',
            '_documentSecondDate' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს',
            '_documentNumber' => 'შეყვანილი სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს 50 - ს'
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
            $data['isNew'] = true;
            session()->put('_docData', $data);

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

            $content = json_decode($export[0]['data']);
            $content = (new QuestionsJson($content))->getData();

            $data['isNew'] = false;
            $data['docId'] = $docId;
            $data['data'] = \Psy\Util\Json::encode($content);

            session()->put('_docData', $data);
        }

        return 'all-done';
    }

    /**
     * @return bool
     */
    public function validateDoc(): bool
    {
        return session()->has("_docData") || session()->has('_questionsData');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function validateRequest(): array
    {
        if (!$this->validateDoc()) {
            throw new Exception('You have to first choose an object', 400);
        }

        return request()->validate([
            'data' => 'required|string',
        ]);
    }

    /**
     *@return int
     */
    public function getFieldId(): int
    {
        return session()->has('_docData') ?
            session()->get('_docData')['fieldId'] :
            session()->get('_questionsData')['fieldId'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function submit(): string
    {
        $data = $this->validateRequest()['data'];
        $fieldId = $this->getFieldId();

        try {
            $data = json_decode($data);
        } catch (Exception $exception) {
            throw new Exception('Invalid data format', 400);
        }

        if (gettype($data) !== 'array') {
            throw new Exception("Invalid data format", 400);
        }

        $filter = new Filter($data, $fieldId);
        $data = $filter->getData();

        request()->validate(
            $filter->getImageRule()
        );

        foreach ($data as $ind => $d) {
            if ($d['data']['hasImage'] && !isset($d['data']['oldImage'])) {
                //   $name = request($d['imageName'])->store('testing');
                $name = cloudinary()->upload(request($d['data']['imageName'])->getRealPath())->getSecurePath();
                $data[$ind]['data']['imageName'] = $name;
            }
        }

        $exportId = $this->showData($data, $fieldId);
        $this->clearSession();
        return route('user.export', ['export' => $exportId]);
    }

    /**
     * Clears session vars to avoid unexpected behavior;
     */
    public function clearSession() {
        session()->forget(['_docData', '_questionsData', '_oldImages', '_exportId']);
    }

    /**
     * @param $data
     * @param int $fieldId
     * @return false|Application|ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function showData($data, int $fieldId)
    {
        $exportId = false;
        if (session()->has('_questionsData')) {
            $exportId = session()->get("_questionsData")['exportId'];
        }

        $reader = new FinalData($exportId);
        $reader->init($data, $fieldId);

        return $reader->getExportId();
    }

}
