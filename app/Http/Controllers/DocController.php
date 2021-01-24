<?php


namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Objects;
use App\Process;
use App\Ploss;
use App\Udanger;
use App\UserText;
use App\Helperclass\Data;
use App\Helperclass\Filter;
use App\Helperclass\FinalData;
use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\RiskCalculator;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


class DocController extends Controller
{
    public function index()
    {
        $cnt = UserText::count();
        $procs = Process::orderBy('created_at', 'asc')->get();

        return view('admin.docs.index', compact('procs', 'cnt'));
    }

    public function show()
    {
        return view('admin.docs.check');
    }

    public function prepareDoc()
    {
        request()->validate([
            'isNew' => 'boolean|required'
        ]);

        if (request('isNew')) {
            \request()->validate([
                'objectId' => 'integer',
                'filename' => 'string|max:512'
            ]);

            $objectId = \request('objectId');
            $ok = Objects::where('id', $objectId)->where('user_id', current_user()->id)->limit(1)->count() > 0;
            if (!$ok) {
                return response('Such object does not exist', 400);
            }

            $filename = \request('filename');

            $data = [
                'isNew' => false,
                'objectId' => $objectId,
                'filename' => $filename
            ];

            session()->put('_docData', $data);
            return 'all-done';
        }
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
     * @return string
     * @throws Exception
     */
    public function submit(): string
    {
        $data = $this->validateRequest()['data'];
        try {
            $data = json_decode($data);
        } catch (Exception $exception) {
            throw new Exception('Invalid data format', 400);
        }

        if (gettype($data) !== 'array') {
            throw new Exception("Invalid data format", 400);
        }

        $filter = new Filter($data);
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

        $exportId = $this->showData($data);
        return route('user.export', ['export' => $exportId]);
    }

    /**
     * @param $data
     * @return false|Application|ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function showData($data)
    {
        $exportId = false;
        if (session()->has('_questionsData')) {
            $exportId = session()->get("_questionsData")['exportId'];
        }

        $reader = new FinalData($exportId);
        $reader->init($data);

        return $reader->getExportId();
    }

}
