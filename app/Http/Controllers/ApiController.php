<?php

namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Ploss;
use App\Process;
use App\Udanger;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param Process $process
     * @return array
     */
    public function getDangers(Process $process): array
    {
        $dangerIds = $process->getDangerIds();
        return Danger::whereIn('id', $dangerIds)->select('id', 'name')->get()->toArray();
    }


    /**
     * @param Danger $danger
     * @return array
     */
    public function getControls(Danger $danger): array
    {
        $controlIds = $danger->getControlIds();
        return Control::whereIn('id', $controlIds)->select('id', 'name')->get()->toArray();
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getFieldId(): int
    {
        if (session()->has('_docData')) {
            return session()->get('_docData')['fieldId'];
        }
        if (session()->has('_questionsData')) {
            return session()->get('_questionsData')['fieldId'];
        }
        throw new Exception('Field not specified');
    }

    /**
     * returns all data
     * @throws Exception
     */
    public function getAllData(): array
    {
        $fieldId = $this->getFieldId();

        $processes = Process::where('field_id', $fieldId)->select('id', 'name')->get();
        $ploss = Ploss::where('field_id', $fieldId)->select('id', 'name')->get();
        $udanger = Udanger::where('field_id', $fieldId)->select('id', 'name')->get();

        return compact('processes','ploss', 'udanger');
    }
}
