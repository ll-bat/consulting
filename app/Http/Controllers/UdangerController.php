<?php

namespace App\Http\Controllers;

use App\Udanger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Util\Exception;

class UdangerController extends Controller
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
     * @return mixed
     */
    public function index()
    {
        return Udanger::where('field_id', $this->fieldId)->get();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function create()
    {
        return Udanger::create(['name' => 'null', 'field_id' => $this->fieldId])->id;
    }

    /**
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function save()
    {
        $data = \request()->validate([
            'id' => 'integer|required|exists:udangers,id',
            'name' => 'nullable|string',
        ]);

        if ($data['name'] == '') $data['name'] = ' ';

        $udanger = Udanger::where('id', $data['id'])->where('field_id', $this->fieldId)->first();
        if (!$udanger) {
            throw new Exception('Such udanger does not exist');
        }

        $udanger->update($data);

        return response('success', 200);
    }

    /**
     * @param Udanger $udanger
     * @return Application|ResponseFactory|Response
     * @throws \Exception
     */
    public function delete(Udanger $udanger)
    {
        if ($udanger->field_id != $this->fieldId) {
            throw new \Exception('field_id mismatch');
        }

        $udanger->delete();

        return response('deleted', 200);
    }
}
