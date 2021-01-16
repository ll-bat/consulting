<?php


namespace App\Http\Controllers;

use App\Control;
use App\Danger;
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
use Illuminate\Http\Request;
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


    public function submit(Request $request)
    {
        $req = $request->validate([
            'data' => 'required|array'
        ]);

        $filter = new Filter($req['data']);
        $data = $filter->getData();

        $rule = [];
        foreach ($data as $d) {
            $d = $d['data'];

            if ($d['hasImage'])
                $rule[$d['imageName']] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        $obj = new Data($data);

        session()->put('rule', $rule);
        session()->put('data', $obj);

        return response('done', 200);
    }

    public function saveData(Request $request)
    {
        $rule = session()->get('rule');
        $obj = session()->get('data');

        $request->validate($rule);
        $data = $obj->getData();

        $controls = [];
        $udangers = [];

        foreach ($data as $ind => $d) {
            $d = $d['data'];

            if ($d['hasImage']) {
                //   $name = request($d['imageName'])->store('testing');
                $name = cloudinary()->upload(request($d['imageName'])->getRealPath())->getSecurePath();
                $data[$ind]['data']['imageName'] = $name;
            }

            foreach ($d['newControls'] as $newControl) {
                $controls[] = $newControl['value'];
            }

            foreach ($d['newUdangers'] as $newUdanger) {
                $udangers[] = $newUdanger['value'];
            }
        }

        $controlModels = UserText::whereIn('name', $controls)
            ->where(['type' => 'control'])
            ->select('name', 'danger_id')
            ->get();

        $udangerModels = UserText::whereIn('name', $udangers)
            ->where(['type' => 'udanger'])
            ->select('name', 'danger_id')
            ->get();

        $controls = $udangers = [];

        foreach ($controlModels as $controlModel) {
            $controls[$controlModel->danger_id][$controlModel->name] = true;
        }

        foreach ($udangerModels as $udangerModel) {
            $udangers[$udangerModel->danger_id][$udangerModel->name] = true;
        }

        $userId = current_user()->id;

        foreach ($data as $ind => $d) {
            $did = $d['did'];
            $d = $d['data'];

            foreach ($d['newControls'] as $nc) {
                $model = isset($controls[$did][$nc['value']]);

                if (!$model) {
                    UserText::create(['user_id' => $userId,
                        'danger_id' => $did, 'name' => $nc['value'],
                        'type' => 'control']);
                    $controls[$did][$nc['value']] = true;
                }
            }

            foreach ($d['newUdangers'] as $nc) {
                $model = isset($udangers[$did][$nc['value']]);

                if (!$model) {
                    UserText::create(['user_id' => current_user()->id,
                        'danger_id' => $did, 'name' => $nc['value'],
                        'type' => 'udanger']);
                    $udangers[$did][$nc['value']] = true;
                }
            }
        }

        $obj->setData($data);
        session()->put('data', $obj);

        return response('completed', 200);
    }

    public function showData(): \Illuminate\Http\RedirectResponse
    {
        $obj = session()->get('data')->getData();

        $reader = new FinalData();
        $reader->init($obj);

        session()->forget('data');
        return redirect()->route('user.export', ['export' => $reader->getExportId()]);
    }

}
