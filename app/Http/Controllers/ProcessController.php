<?php

namespace App\Http\Controllers;

use App\Process;
use App\Danger;
use App\DangerProcess;

use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function addProcess(){
        $data  = request()->validate([
            'name' => 'required|string'
        ]);

        Process::create($data);
        
        return back()->with('message', 'პროცესი წარმატებით შეიქმნა')->with('created', 1);
   }

   public function edit(Process $process){
       $list = $process->getDangerIds();

       $ydanger = Danger::whereIn('id', $list)->get();
       $ndanger = Danger::whereNotIn('id', $list)->get();

       return view('admin.docs.edit-process', compact('process', 'ydanger', 'ndanger'));
   }

   public function update(Process $process){
       $data = \request()->validate([
           'name' => 'required|string'
       ]);

       $process->update($data);
       return redirect()->to('user/docs')->with('message', 'პროცესი წარმატებით განახლდა');
   }

   public function delete(Process $process){
       if (DangerProcess::where('process_id', $process->id)->count() > 0){
        //    return back()->with('error', 'გთხოვთ, ამოშალოთ ყველა შემავალი საფრთხე');
           DangerProcess::where('process_id', $process->id)->delete();
       }
       
       $process->delete();
       return redirect()->to('user/docs')->with('message', 'პროცესი წარმატებით წაიშალა');
   }

   public function copy(Process $process){
       $newprocess = Process::create(['name' => $process->name]);

       foreach ($process->getDangers() as $d){
           DangerProcess::create(['danger_id' => $d->danger_id, 'process_id' => $newprocess->id]);
       }

       return back()->with('message', 'პროცესი წარმატებით დაკოპირდა')->with('created', 1);
   }

   public function detach(Process $process, Danger $danger){
        DangerProcess::where('process_id', $process->id)->where('danger_id',$danger->id)->delete();

        return back()->with('message', 'საფრთხე წარმატებით ამოიშალა');
   }

   public function attach(Process $process, Danger $danger){
        DangerProcess::create(['process_id' => $process->id, 'danger_id' => $danger->id]);

        return back()->with('message', 'საფრთხე წარმატებით დაემატა');
   }

}
