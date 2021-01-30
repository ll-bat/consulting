<?php

namespace App\Http\Controllers;

use App\Ploss;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Integer;

class PlossController extends Controller
{
    private int $fieldId = 0;

    /**
     * @param string $method
     * @param array $parameters
     * @return Application|ResponseFactory|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function callAction($method, $parameters)
    {
        $fieldId = session()->get('_fieldId') ?? 0;
        if (!$fieldId) {
            return response(['redirect' => true], 400);
        }
        $this->fieldId = (int)$fieldId;
        return parent::callAction($method, $parameters);
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        return Ploss::where('field_id', $this->fieldId)->get();
    }

    /**
     * @return array|integer
     */
    public function create()
    {
        return Ploss::create(['name' => 'null', 'k' => '3', 'field_id' => $this->fieldId])->id;
    }

    public function save()
    {
        $data = \request()->validate([
            'id' => 'integer|required|exists:plosses,id',
            'name' => 'nullable|string',
            'k' => 'string'
        ]);

        if ($data['name'] == '') {
            $data['name'] = ' ';
        }

        $ploss = Ploss::where('id', $data['id'])->where('field_id', $this->fieldId)->first();
        if ($ploss) {
            $ploss->update($data);
        } else {
            throw new Exception("Can't update ploss");
        }

        return response('success', 200);
    }

    public function delete(Ploss $ploss)
    {
        if ($ploss->field_id != $this->fieldId) {
            throw new Exception('Choose field', 400);
        }

        $ploss->delete();

        return response('deleted', 200);
    }

}
