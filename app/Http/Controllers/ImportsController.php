<?php

namespace App\Http\Controllers;

use App\Danger;
use App\Control;
use App\ControlDanger;
use App\Helperclass\ExcelReader;
use App\Imports\ProcessesImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportsController extends Controller
{


    public function importProcess(Request $request)
    {

    }

    public function importDanger(Request $request)
    {
        request()->validate([
            'danger' => 'required'
        ]);

        $extension = $request->file('danger')->getClientOriginalExtension();
        if (!in_array($extension, explode(',', "csv,xlsx,xls"))) {
            return back()->with('error', 'გთხოვთ ატვირთოთ ექსელის დოკუმენტი');
        }

        try {
            $data = Excel::toArray(new ProcessesImport, request('danger'));
            $reader = new ExcelReader($data);
            $data = $reader->getData();
        } catch (\Exception $e){
            return back()->with('error', 'სამწუხაროდ, შეცდომა დაფიქსირდა. გთხოვთ, სცადოთ თავიდან.');
        }

        $dangers = [];
        $controls = [];

        DB::beginTransaction();

        foreach ($data as $ind => $d) {
            if (!$reader->filterDangerField($d)) {
                DB::rollBack();
                return back()->with('error', "ინფორმაციის განლაგება ექსელის დოკუმენტში არასწორია. შეამოწმეთ მონაცემი - ". ($ind+1));
            }

            if (!isset($dangers[$d[0]])) {
                $danger = Danger::where('name', $d[0])->first();
                if ($danger == null) {
                    $danger = Danger::create(['name' => $d[0], 'k' => $d[1]]);
                } else {
                    $danger->update(['k' => $d[1]]);
                }

                $dangers[$d[0]] = $danger->id;
            }

            if (!isset($controls[$d[2]])) {
                $control = Control::where('name', $d[2])->first();

                if ($control == null) {
                    $control = Control::create(['name' => $d[2], 'k' => $d[3], 'rploss' => $d[4]]);
                } else {
                    $control->update(['name' => $d[2], 'k' => $d[3], 'rploss' => $d[4]]);
                }

                $controls[$d[2]] = $control->id;
            }
        }

        foreach ($data as $d) {
            $has = ControlDanger::where('control_id', $controls[$d[2]])->where('danger_id', $dangers[$d[0]])->first();

            if ($has == null)
                ControlDanger::create(['control_id' => $controls[$d[2]], 'danger_id' => $dangers[$d[0]]]);
        }

        DB::commit();
        return back()->with('message', 'ოპერაცია წარმატებით დასრულდა');
    }


    public function importControl(Request $request, Danger $danger)
    {
        request()->validate([
            'control' => 'required'
        ]);

        $extension = $request->file('control')->getClientOriginalExtension();
        if (!in_array($extension, explode(',', "csv,xlsx,xls"))) {
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

        $controls = [];

        DB::beginTransaction();

        foreach ($data as $ind => $d) {

            if (!$reader->filterControlField($d)){
                DB::rollBack();
                return redirect()->route($route, [$danger->id])->with('error', 'ინფორმაციის განლაგება ექსელის დოკუმენტში არასწორია. მონაცემი - '. ($ind+1));
            }

            if (!isset($controls[$d[0]])) {
                $control = Control::where('name', $d[0])->first();

                if ($control == null) {
                    $control = Control::create(['name' => $d[0], 'k' => $d[1], 'rploss' => $d[2]]);
                } else {
                    $control->update(['k' => $d[1], 'rploss' => $d[2]]);
                }

                $controls[$d[0]] = $control->id;
            }
        }

        foreach ($data as $d) {
            $has = ControlDanger::where('control_id', $controls[$d[0]])->where('danger_id', $danger->id)->first();

            if ($has == null)
                ControlDanger::create(['control_id' => $controls[$d[0]], 'danger_id' => $danger->id]);
        }

        DB::commit();
        return redirect()->route($route, [$danger->id])->with('message', 'ოპერაცია წარმატებით დასრულდა');
    }
}
