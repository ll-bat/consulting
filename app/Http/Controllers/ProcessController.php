<?php

namespace App\Http\Controllers;

use App\Process;
use App\Danger;
use App\DangerProcess;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcessController extends Controller
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
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'required|string'
        ]);

        Process::create(['name' => $data['name'], 'field_id' => $this->fieldId]);

        return back()->with('message', __("პროცესი წარმატებით შეიქმნა"))->with('created', 1);
    }

    public function edit(Process $process)
    {
        $list = $process->getDangerIds();

        $ydanger = Danger::whereIn('id', $list)->get();
        $ndanger = Danger::whereNotIn('id', $list)->where(['field_id' => $this->fieldId])->get();

        return view('admin.docs.edit-process', compact('process', 'ydanger', 'ndanger'));
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     */
    public function update(Process $process): RedirectResponse
    {
        $data = \request()->validate([
            'name' => 'required|string'
        ]);

        $process->update(['name' => $data['name']]);
        return redirect()->to('user/docs')->with('message', __("პროცესი წარმატებით განახლდა"));
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Process $process): RedirectResponse
    {
        if (DangerProcess::where('process_id', $process->id)->count() > 0) {
            //    return back()->with('error', '__("გთხოვთ, ამოშალოთ ყველა შემავალი საფრთხე")');
            DangerProcess::where('process_id', $process->id)->delete();
        }

        $process->delete();
        return redirect()->to('user/docs')->with('message', __("პროცესი წარმატებით წაიშალა"));
    }

    /**
     * @param Process $process
     * @return RedirectResponse
     */
    public function copy(Process $process): RedirectResponse
    {
        $newProcess = Process::create(['name' => $process->name, 'field_id' => $process->field_id]);

        $data = [];
        foreach ($process->getDangers() as $d) {
            $data[] = ['danger_id' => $d->danger_id, 'process_id' => $newProcess->id];
        }

        DangerProcess::insert($data);

        return back()->with('message', __("პროცესი წარმატებით დაკოპირდა"))->with('created', 1);
    }

    /**
     * @param Process $process
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function detach(Process $process, Danger $danger): RedirectResponse
    {
        DangerProcess::where('process_id', $process->id)->where('danger_id', $danger->id)->delete();

        return back()->with('message', __("საფრთხე წარმატებით ამოიშალა"));
    }

    /**
     * @param Process $process
     * @param Danger $danger
     * @return RedirectResponse
     */
    public function attach(Process $process, Danger $danger): RedirectResponse
    {
        DangerProcess::create(['process_id' => $process->id, 'danger_id' => $danger->id]);

        return back()->with('message', __("საფრთხე წარმატებით დაემატა"));
    }

}
