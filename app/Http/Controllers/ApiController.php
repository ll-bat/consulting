<?php

namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Ploss;
use App\Process;
use App\Udanger;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param Process $process
     * @return array
     */
    public function getDangers(Process $process): array
    {
        return $process->getDangerIds();
    }

    /**
     * @param Danger $danger
     * @return array
     */
    public function getControls(Danger $danger): array
    {
        return $danger->getControlIds();
    }

    /**
     * returns all data
     */
    public function getAllData(): array
    {
        $processes = Process::select('id', 'name')->get();
        $dangers = Danger::select('id', 'name')->get();
        $controls = Control::select('id', 'name')->get();
        $ploss = Ploss::select('id', 'name')->get();
        $udanger = Udanger::select('id', 'name')->get();

        return compact('processes', 'dangers', 'controls', 'ploss', 'udanger');
    }
}
