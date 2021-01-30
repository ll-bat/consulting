<?php

namespace App\Http\Controllers;

use App\Process;
use App\Danger;
use App\DangerProcess;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * @return RedirectResponse|int
     */
    public function check()
    {
        $fieldId = session()->get('_fieldId') ?? false;
        if (!$fieldId) {
            return redirect()->route("admin.fields");
        }
        return $fieldId;
    }

    /**
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $fieldId = $this->check();

        $data = request()->validate([
            'name' => 'required|string'
        ]);

        Process::create(['name' => $data['name'], 'field_id' => $fieldId]);

        return back()->with('message', 'პროცესი წარმატებით შეიქმნა')->with('created', 1);
    }

    public function edit(Process $process)
    {
        $list = $process->getDangerIds();

        $ydanger = Danger::whereIn('id', $list)->get();
        $ndanger = Danger::whereNotIn('id', $list)->get();

        return view('admin.docs.edit-process', compact('process', 'ydanger', 'ndanger'));
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     */
    public function update(Process $process): RedirectResponse
    {
        $fieldId = $this->check();
        if ($fieldId != $process->field_id) {
            return redirect()->route('admin.fields');
        }

        $data = \request()->validate([
            'name' => 'required|string'
        ]);

        $process->update(['name' => $data['name']]);
        return redirect()->to('user/docs')->with('message', 'პროცესი წარმატებით განახლდა');
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Process $process): RedirectResponse
    {
        $fieldId = $this->check();
        if ($fieldId != $process->field_id) {
            return redirect()->route('admin.fields');
        }

        if (DangerProcess::where('process_id', $process->id)->count() > 0) {
            //    return back()->with('error', 'გთხოვთ, ამოშალოთ ყველა შემავალი საფრთხე');
            DangerProcess::where('process_id', $process->id)->delete();
        }

        $process->delete();
        return redirect()->to('user/docs')->with('message', 'პროცესი წარმატებით წაიშალა');
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     */
    public function copy(Process $process): RedirectResponse
    {
        $fieldId = $this->check();
        if ($fieldId != $process->field_id) {
            return redirect()->route('admin.fields');
        }

        $newProcess = Process::create(['name' => $process->name, 'field_id' => $fieldId]);

        $data = [];
        foreach ($process->getDangers() as $d) {
            $data[] = ['danger_id' => $d->danger_id, 'process_id' => $newProcess->id];
        }

        DangerProcess::insert($data);

        return back()->with('message', 'პროცესი წარმატებით დაკოპირდა')->with('created', 1);
    }

    /**
     * @param Process $process
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function detach(Process $process, Danger $danger): RedirectResponse
    {
        DangerProcess::where('process_id', $process->id)->where('danger_id', $danger->id)->delete();

        return back()->with('message', 'საფრთხე წარმატებით ამოიშალა');
    }

    /**
     * @param Process $process
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function attach(Process $process, Danger $danger): RedirectResponse
    {
        DangerProcess::create(['process_id' => $process->id, 'danger_id' => $danger->id]);

        return back()->with('message', 'საფრთხე წარმატებით დაემატა');
    }

}
