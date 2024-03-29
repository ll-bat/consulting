<?php

namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\ControlDanger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ControlController extends Controller
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

    /**
     * @return Application|Factory|View
     */
    public function newControl()
    {
        $dangers = Danger::where(['field_id' => $this->fieldId])->get();
        $controls = Control::where(['field_id' => $this->fieldId])->orderBy('created_at', 'asc')->get();
        return view("admin.docs.control", compact('dangers', 'controls'));
    }

    /**
     * @return RedirectResponse
     */
    public function createControl(): RedirectResponse
    {
        $data = $this->validateRequest();
        $data['field_id'] = $this->fieldId;

        $control = Control::create($data);
        if (isset($data['danger']))
            $control->dangers()->attach($data['danger']);

        $message = __("კონტროლის ზომა შეიქმნა წარმატებით");
        return back()->with('message', $message)->with('created', '1');
    }

    public function edit(Control $control)
    {
        $list = [];
        foreach ($control->getAllControl() as $c)
            $list[] = $c;

        return view('admin.docs.edit-control', [
            'control' => $control,
            'dangers' => Danger::where(['field_id' => $this->fieldId])->get(),
            'list' => $list
        ]);
    }

    /**
     * @param Control $control
     * @return RedirectResponse
     */
    public function update(Control $control): RedirectResponse
    {
        $data = $this->validateRequest();
        $data['danger'] = $data['danger'] ?? [];

        $list = [];

        foreach ($control->allControl() as $c) {
            $list[] = $c->danger_id;
        }

        foreach ($list as $l) {
            if (!in_array($l, $data['danger'])) {
                $control->dangers()->detach(['danger_id' => $l]);
            }
        }

        foreach ($data['danger'] as $p) {
            if (!in_array($p, $list)) {
                $control->dangers()->attach($p);
            }
        }

        $control->update($data);

        $message = __("კონტროლის ზომა წარმატებით განახლდა");
        return back()->with('message', $message);
    }

    /**
     * @return array
     */
    public function validateRequest(): array
    {
        $data = \request()->validate([
            'name' => ['required', 'string'],
            'k' => 'numeric|nullable',
            'rploss' => 'boolean',
            'is_first_option_off' => 'boolean',
            'danger' => 'array',
            'danger.*' => 'integer|exists:dangers,id'
        ]);

        $data['is_first_option_off'] = isset($data['is_first_option_off']);

        if (isset($data['rploss'])) {
            $data['rploss'] = true;
        } else {
            $data['rploss'] = false;
        }

        $data['k'] = $data['k'] ?? 1;

        return $data;
    }

    /**
     * @param Control $control
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete(Control $control)
    {
        ControlDanger::where('control_id', $control->id)->delete();
        $control->delete();
        return response('done', 200);
    }

    /**
     * @param Control $control
     * @return RedirectResponse
     * @throws \Exception
     */
    public function rdelete(Control $control): RedirectResponse
    {
        $this->delete($control);
        return redirect()->to('user/docs/new-control')->with('message', '__("კონტროლის ზომა წარმატებით წაიშალა")');
    }
}
