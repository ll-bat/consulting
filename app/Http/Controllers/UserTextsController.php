<?php

namespace App\Http\Controllers;

use App\UserText;
use App\Danger;
use App\Udanger;
use App\Control;
use App\ControlDanger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTextsController extends Controller
{
    private int $fieldId = 0;

    /**
     * @param string $method
     * @param array $parameters
     * @return Response
     */
    public function callAction($method, $parameters)
    {
        $this->fieldId = session()->get('_fieldId');
        return parent::callAction($method, $parameters);
    }

    public function index()
    {
        $dangers = [];
        $controls = UserText::where('type', 'control')->where('field_id', $this->fieldId)->get();
        $udangers = UserText::where('type', 'udanger')->where('field_id', $this->fieldId)->get();
        $empty = $controls->count() == 0 && $udangers->count() == 0;

        foreach ($controls as $c) {
            $d = Danger::find($c->danger_id)->name;
            $dangers[$d][] = $c;
        }

        return view('admin.docs.usertexts', compact('dangers', 'udangers', 'empty'));
    }

    public function editControl($id)
    {
        $model = UserText::findOrFail($id);
        $dangers = Danger::where(['field_id' => $this->fieldId])->get();

        return view('admin.docs.edit-usertext-control', compact('model', 'dangers'));
    }

    public function editUdanger($id)
    {
        $udanger = UserText::findOrFail($id);

        return view('admin.docs.edit-usertext-udanger', compact('udanger'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function deleteControl($id): RedirectResponse
    {
        $model = UserText::find($id);
        $model->delete();

        return redirect()->to('user/docs/added-by-users')->with('message', 'კონტროლის ზომა წარმატებით წაიშალა');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function updateControl($id): RedirectResponse
    {
        $data = \request()->validate([
            'name' => ['required', 'string'],
            'k' => 'numeric|nullable',
            'rploss' => 'boolean',
            'danger' => 'array',
            'danger.*' => 'integer|exists:dangers,id'
        ]);

        $data['danger'] = $data['danger'] ?? [];

        if (isset($data['rploss'])) $data['rploss'] = true;
        else $data['rploss'] = false;

        $data['k'] = $data['k'] ?? 1;
        $data['field_id'] = $this->fieldId;

        $control = Control::create($data);
        $control->dangers()->attach($data['danger']);

        $model = UserText::find($id);
        $model->delete();

        return redirect()->to('user/docs/added-by-users')->with('message', 'კონტროლის ზომა წარმატებით დაემატა');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function updateUdanger($id): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'string|required'
        ]);

        Udanger::create(['name' => $data['name'], 'field_id' => $this->fieldId]);
        $id = intval($id);
        $model = UserText::findOrFail($id);
        $model->delete();

        return redirect()->to('user/docs/added-by-users')->with('message', 'ოპერაცია წარმატებით შესრულდა');
    }

    public function store($model)
    {
        if (gettype($model) == 'string') {
            $model = UserText::findOrFail($model);
        }

        $control = Control::create(['name' => $model->name, 'k' => '1', 'rploss' => 0, 'field_id' => $this->fieldId]);
        $control->dangers()->attach([$model->danger_id]);
        $model->delete();

        $cnt = UserText::where('danger_id', $model->danger_id)->where(['field_id' => $this->fieldId])->count();

        return response($cnt, 200);
    }

    public function storeUdanger($model)
    {
        if (gettype($model) == 'string') {
            $model = UserText::findOrFail($model);
        }

        $udanger = Udanger::create(['name' => $model->name, 'field_id' => $this->fieldId]);
        $model->delete();

        $cnt = UserText::where('type', 'udanger')->where(['field_id' => $this->fieldId])->count();

        return response($cnt, 200);
    }

    /**
     * @param $model
     * @return RedirectResponse
     */
    public function deleteUdanger($model): RedirectResponse
    {
        if (in_array(gettype($model), ['string', 'integer'])) {
            $model = UserText::findOrFail(intval($model));
        }

        $model->delete();

        $cnt = UserText::where('type', 'udanger')->where(['field_id' => $this->fieldId])->count();

        return redirect()->to('user/docs/added-by-users')->with('message', 'ოპერაცია წარმატებით შესრულდა');
    }
}
