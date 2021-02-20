<?php

namespace App\Http\Controllers;

use App\Helperclass\UserInputs;
use App\Ploss;
use App\Process;
use App\Danger;
use App\Control;
use App\DangerProcess;
use App\ControlDanger;
use App\Udanger;
use App\UserText;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DangerController extends Controller
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

    public function show(){
        return view('admin.docs.danger', [
            'procs' => Process::where('field_id', $this->fieldId)->get(),
            'dangers' => Danger::where('field_id', $this->fieldId)->orderBy('created_at','asc')->get()
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $data = \request()->validate([
            'name' => 'required|string',
            'k'   => 'numeric|nullable',
            'process' => 'array',
            'process.*' => 'integer|exists:processes,id',
        ]);

        $data['k'] = $data['k'] ?? 1;
        $data['field_id'] = $this->fieldId;

        $danger = Danger::create($data);
        if (isset($data['process']))
          $danger->getAllProcess()->attach($data['process']);

        return back()->with('message', 'საფრთხე წარმატებით შეიქმნა')->with('created', '1');
    }

    public function edit(Danger $danger){
        $list = [];
        foreach ($danger->getProcess() as $p)
           $list[] = $p;

        $l = [];
        foreach ($danger->getControl() as $c){
            $l[] = $c;
        }

        $ycontrol = Control::whereIn('id', $l)->get();
        $ncontrol = Control::whereNotIn('id', $l)->where(['field_id' => $this->fieldId])->get();

        $controlsCount = UserText::where([
            'danger_id' => $danger->id,
            'type' => 'control'
        ])->count();

        $plossCount = UserText::where([
            'danger_id' => $danger->id,
            'type' => 'ploss'
        ])->count();

        $udangerCount = UserText::where([
            'danger_id' => $danger->id,
            'type' => 'udanger'
        ])->count();

        return view('admin.docs.edit-danger', [
            'danger' => $danger,
            'procs'  => Process::where('field_id', $this->fieldId)->get(),
            'list'   => $list,
            'ycontrol' => $ycontrol,
            'ncontrol' => $ncontrol,
            'controlsCount' => $controlsCount,
            'plossCount' => $plossCount,
            'udangerCount' => $udangerCount
        ]);
    }

    /**
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function update(Danger $danger): RedirectResponse
    {
        $data = \request()->validate([
            'name' => 'required|string',
            'k'   => 'numeric|nullable',
            'process' => 'array',
            'process.*' => 'integer|exists:processes,id'
        ]);

        $data['process'] = $data['process'] ?? [];

        $data['k'] = $data['k'] ?? 1;

        $list = [];
        foreach ($danger->processes() as $proc){
              $list[] = $proc->process_id;
        }

        foreach ($list as $l) {
            if (!in_array($l, $data['process'])){
                $danger->getAllProcess()->detach(['process_id' => $l]);
            }
        }

        foreach ($data['process'] as $p){
            if (!in_array($p, $list)){
                $danger->getAllProcess()->attach($p);
            }
        }

        $danger->update($data);

        return back()->with('message', 'საფრთხე წარმატებით განახლდა');
    }

    /**
     * @param Danger $danger
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Danger $danger): RedirectResponse
    {
        DangerProcess::where('danger_id', $danger->id)->delete();
        ControlDanger::where('danger_id', $danger->id)->delete();

        if ($danger->getAllControl()->count() > 0){
            // return back()->with('error', 'გთხოვთ, ამოშალოთ ყველა შემავალი კონტროლის ზომა');
        }

        $danger->delete();

        return redirect()->to('user/docs/new-danger')->with('message', 'საფრთხე წარმატებით წაიშალა');
    }

    /**
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function copy(Danger $danger): RedirectResponse
    {
        $newdanger = Danger::create(['name' => $danger->name, 'k' => $danger->k, 'field_id' => $danger->field_id]);

        $data = [];
        foreach ($danger->getAllControl() as $c){
            $data[] = ['control_id' => $c->control_id, 'danger_id' => $newdanger->id];
        }
        ControlDanger::insert($data);

        return back()->with('message','საფრთხე წარმატებით დაკოპირდა')->with('created', 1);
    }

    /**
     * @param Danger $danger
     * @param Control $control
     * @return RedirectResponse
     */
    public function detach(Danger $danger, Control $control): RedirectResponse
    {
        ControlDanger::where('danger_id', $danger->id)->where('control_id',$control->id)->delete();

        return back()->with('message', 'კონტროლის ზომა წარმატებით ამოიშალა');
   }

    /**
     * @param Danger $danger
     * @param Control $control
     * @return RedirectResponse
     */
   public function attach(Danger $danger, Control $control): RedirectResponse
   {
        ControlDanger::create(['danger_id' => $danger->id, 'control_id' => $control->id]);

        return back()->with('message', 'კონტროლის ზომა წარმატებით დაემატა');
   }

   public function addedByUsers(Danger $danger, $type) {
        if (!in_array($type, ['control', 'ploss', 'udanger'])) {
            return back()->with('error', 'Not found');
        }

        $data = UserText::where([
            'user_texts.danger_id' => $danger->id,
            'user_texts.type' => $type
        ])
            ->join('users', 'user_texts.user_id', 'users.id')
            ->select('users.username', 'user_texts.name', 'user_texts.export_id', 'user_texts.id', 'user_texts.is_ignored')
            ->orderBy('user_texts.created_at', 'desc')
            ->get()
            ->toArray();

        $title = 'კონტროლის ზომები';
        if ($type === 'ploss') {
            $title = 'პოტენციური ზიანი';
        } else if ($type === 'udanger') {
            $title = 'ვინ იმყოფება საფრთხის ქვეშ';
        }

        return view('admin.docs.danger-controls', [
            'data' => $data,
            'danger' => $danger->name,
            'title' => $title,
            'type' => $type
        ]);
   }

    /**
     * @param Danger $danger
     * @param $userText
     * @param $operationType
     * @return RedirectResponse
     */
   public function submitUserText(Danger $danger, $userText, $operationType): RedirectResponse
   {
       $userText = UserText::find($userText);

       function success(): RedirectResponse
       {
           return back()->with('message', 'ოპერაცია წარმატებით დასრულდა');
       }

       if (!$userText) {
           return success();
       }

       if (!in_array($operationType, ['approve', 'ignore', 'remove'])) {
           return back()->with('error', 'დაფიქსირდა შეცდომა, სცადეთ თავიდან');
       }

       if ($operationType === 'ignore') {
           $userText->update(['is_ignored' => true]);
           return success();
       }

       if ($operationType === 'approve') {
           $name = $userText->name;
           $k = false;
           $type = $userText->type;

           if ($type === 'control') {
               $k = Control::k;
           } else if ($type === 'ploss') {
               $k = Ploss::k;
           }

           $params = ['name' => $name, 'field_id' => $this->fieldId];
           if ($k) {
               $params['k'] = $k;
           }

           $types = [
               'ploss' => Ploss::class,
               'udanger' => Udanger::class,
               'control' => Control::class,
           ];

           $c = $types[$type]::create($params);

           if ($type === 'control') {
               ControlDanger::create(['control_id' => $c->id, 'danger_id' => $danger->id]);
           }

           $userText->delete();

           return success();
       } else {

           try {

               UserInputs::filterExport($userText->export_id, $danger->id, $userText->name, $userText->type);

               $userText->delete();

               return success();

           } catch (Exception $e) {

               return back()->with('error', 'დაფიქსირდა შეცდომა. გთხოვთ, სცადოთ თავიდან');

           }

       }

   }

}
