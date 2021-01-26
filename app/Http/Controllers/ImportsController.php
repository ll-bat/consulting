<?php

namespace App\Http\Controllers;

use App\Danger;
use App\Control;
use App\ControlDanger;
use App\Helperclass\ExcelReader;
use App\Imports\ProcessesImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function importDanger(Request $request): RedirectResponse
    {
        request()->validate([
            'danger' => 'required'
        ]);

        $extension = $request->file('danger')->getClientOriginalExtension();
        if (!in_array($extension, explode(',', "csv,xlsx,xls,xlt"))) {
            return back()->with('error', 'გთხოვთ ატვირთოთ ექსელის დოკუმენტი');
        }

        try {
            $data = Excel::toArray(new ProcessesImport, request('danger'));
            $reader = new ExcelReader($data);
            $data = $reader->getData();
        } catch (\Exception $e){
            return back()->with('error', 'სამწუხაროდ, შეცდომა დაფიქსირდა. გთხოვთ, სცადოთ თავიდან.');
        }


        foreach ($data as $ind => $d) {
            if (!$reader->filterDangerField($d)) {
                return back()->with('error', "ინფორმაციის განლაგება ექსელის დოკუმენტში არასწორია. შეამოწმეთ მონაცემი - ". ($ind+1));
            }
        }

        $dangers = [];
        $controls = [];

        $used = []; $conUsed = [];
        foreach ($data as $ind => $d) {
            if (!isset($used[$d[0]])) {
                $used[$d[0]] = true;
                $dangers[] = $d[0];
            }
            if (!isset($conUsed[$d[2]])) {
                $conUsed[$d[2]] = true;
                $controls[] = $d[2];
            }
        }

        $dangers = Danger::whereIn('name', $dangers)->get();
        $controls = Control::whereIn('name', $controls)->get();

        $mappedDangers = [];
        foreach ($dangers as $danger) {
            $mappedDangers[$danger->name] = $danger;
        }

        $mappedControls = [];
        foreach ($controls as $control) {
            $mappedControls[$control->name] = $control;
        }

        DB::beginTransaction();

        foreach ($data as $ind => $d) {
            $currentDanger = $d[0];
            $dangerK = $d[1];
            $currentControl = $d[2];
            $controlK = $d[3];
            $rploss=  $d[4];

            if (!isset($mappedDangers[$currentDanger])) {
                $mappedDangers[$currentDanger] = Danger::create(['name' => $currentDanger, 'k' => $dangerK]);
            } else {
                if ($mappedDangers[$currentDanger]->k != $dangerK) {
                    $mappedDangers[$currentDanger]->update(['k' => $dangerK]);
                }
            }

            if (!isset($mappedControls[$currentControl])) {
                $mappedControls[$currentControl] = Control::create(['name' => $currentControl, 'k' => $controlK, 'rploss' => $rploss]);
            } else {
                if (!($mappedControls[$currentControl]->k == $controlK && $mappedControls[$currentControl]->rploss == $rploss)) {
                    $mappedControls[$currentControl]->update(['k' => $controlK, 'rploss' => $rploss]);
                }
            }
        }

        foreach ($data as $d) {
            $currentDanger = $d[0];
            $currentControl = $d[2];

            $dangerId = $mappedDangers[$currentDanger]->id;
            $controlId = $mappedControls[$currentControl]->id;

            $ok = ControlDanger::where('control_id', $controlId)->where('danger_id', $dangerId)->limit(1)->count() > 0;
            if (!$ok) {
                ControlDanger::create(['control_id' => $controlId, 'danger_id' => $dangerId]);
            }
        }

        DB::commit();
        return back()->with('message', 'ოპერაცია წარმატებით დასრულდა');
    }

    /**
     * @param Request $request
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function importControl(Request $request, Danger $danger): RedirectResponse
    {
        request()->validate([
            'control' => 'required'
        ]);

        $extension = $request->file('control')->getClientOriginalExtension();
        if (!in_array($extension, explode(',', "csv,xlsx,xls,xlt"))) {
            return back()->with('error', 'გთხოვთ ატვირთოთ ექსელის დოკუმენტი');
        }

        $route = 'danger.show';

        try {
            $data = Excel::toArray(new ProcessesImport, request('control'));
            $reader = new ExcelReader($data);
            $data = $reader->getData();
        } catch (\Exception $e){
            return back()->with('error', 'სამწუხაროდ, შეცდომა დაფიქსირდა. გთხოვთ, სცადოთ თავიდან.');
        }


        foreach ($data as $ind => $d) {
            if (!$reader->filterControlField($d)){
                return redirect()->route($route, [$danger->id])->with('error', 'ინფორმაციის განლაგება ექსელის დოკუმენტში არასწორია. მონაცემი - '. ($ind+1));
            }
        }

        DB::beginTransaction();

        $controls = [];
        $used = [];

        foreach ($data as $d) {
            $currentControl = $d[0];
            if (!isset($used[$currentControl])) {
                $used[$currentControl] = true;
                $controls[] = $currentControl;
            }
        }

        $controls = Control::whereIn('name', $controls)->get();

        $mappedControls = [];
        foreach ($controls as $control) {
            $mappedControls[$control->name] = $control;
        }

        foreach ($data as $ind => $d) {
            $currentControl = $d[0];
            $controlK = $d[1];
            $rploss = $d[2];

            if (!isset($mappedControls[$currentControl])) {
                $mappedControls[$currentControl] = Control::create(['name' => $currentControl, 'k' => $controlK, 'rploss' => $rploss]);
            } else {
                if (!($mappedControls[$currentControl]->k == $controlK && $mappedControls[$currentControl]->rploss == $rploss)) {
                    $mappedControls[$currentControl]->update(['k' => $controlK, 'rploss' => $rploss]);
                }
            }
        }

        foreach ($data as $d) {
            $currentControl = $d[0];
            $controlId = $mappedControls[$currentControl]->id;

            $ok = ControlDanger::where('control_id', $ind)->where('danger_id', $danger->id)->limit(1)->count() > 0;
            if (!$ok) {
                ControlDanger::create(['danger_id' => $danger->id, 'control_id' => $controlId]);
            }
        }

        DB::commit();
        return redirect()->route($route, [$danger->id])->with('message', 'ოპერაცია წარმატებით დასრულდა');
    }
}
