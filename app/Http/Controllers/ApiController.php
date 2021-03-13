<?php

namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Ploss;
use App\Process;
use App\Udanger;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    private int $fieldId = 0;

    /**
     * @param string $method
     * @param array $parameters
     * @return Response
     * @throws Exception
     */
    public function callAction($method, $parameters)
    {
        $this->fieldId = $this->getFieldId();
        return parent::callAction($method, $parameters);
    }

    /**
     * @param Process $process
     * @return array
     * @throws Exception
     */
    public function getDangers(Process $process): array
    {
        if ($process->field_id != $this->fieldId) {
            throw new Exception('Field mismatch');
        }
        $dangerIds = $process->getDangerIds();
        return Danger::whereIn('id', $dangerIds)->select('id', 'name')->get()->toArray();
    }


    /**
     * @param Danger $danger
     * @return array
     * @throws Exception
     */
    public function getControls(Danger $danger): array
    {
        if ($danger->field_id != $this->fieldId) {
            throw new Exception('Field mismatch');
        }

        $controlIds = $danger->getControlIds();
        return Control::whereIn('id', $controlIds)
            ->select('id', 'name', 'is_first_option_off')
            ->orderBy('k', 'desc')
            ->get()
            ->toArray();
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
        if (session()->has('_fieldId')) {
            return session()->get('_fieldId');
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

    /**
     * @return array
     */
    public function getPlossUdanger(): array
    {
        $ploss = Ploss::where('field_id', $this->fieldId)->get();
        $udanger = Udanger::where('field_id', $this->fieldId)->get();

        return [
            'ploss' => $ploss,
            'udanger' => $udanger,
        ];
    }
}
