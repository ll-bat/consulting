<?php

namespace App\Http\Controllers;

use App\Export;
use App\Objects;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ObjectsController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index(){
        $docs = Export::where('user_id', current_user()->id)->select('id', 'object_id', 'filename')->latest()->get()->toArray();
        $objects = Objects::where('user_id', current_user()->id)->select('id', 'name')->get()->toArray();

        $objectMap = [];
        foreach ($objects as $o) {
            $objectMap[$o['id']] = ['name' => $o['name'], 'id' => $o['id'], 'docs' => []];
        }

        foreach ($docs as $d) {
            $objectMap[$d['object_id']]['docs'][] = $d;
        }

        return view('user.objects', [
            'objects' => array_reverse($objectMap)
        ]);
    }

    /**
     * @return Application|ResponseFactory|Response|string
     */
    public function create() {
        $res = $this->validateName();
        $name = $res['name'];

        if (!$this->isUnique($name)) {
            return response('nop1', 400);
        }

        Objects::create(['user_id' => current_user()->id, 'name' => $name]);

        return 'all-done';
    }

    /**
     * @param Objects $objects
     * @return Application|ResponseFactory|Response|string
     */
    public function update(Objects $objects) {
        if ($objects->user_id !== current_user()->id) {
            return response('Unauthorized' ,403);
        }

        $req = $this->validateName();
        $name = $req['name'];

        if ($objects->name === $name) {
            return 'all-done';
        }

        if (!$this->isUnique($name)) {
            return response('nop1', 400);
        }

        $ok = $objects->update(['name' => $name]);
        if (!$ok) {
            return response("nop2", 400);
        }

        return 'all-done';
    }

    /**
     * Validates request
     */
    public function validateName(): array
    {
        return request()->validate([
            'name' => 'required|string|max:512'
        ]);
    }

    /**
     * @param $name
     * @return bool
     */
    public function isUnique($name): bool
    {
       return Objects::where('user_id', current_user()->id)->where('name', $name)->limit(1)->count() < 1;
    }

    public function show($object) {
        $object = intval($object);

        if (!$object) {
            return \response('Bad request', 400);
        }

        $object = Objects::where('id', $object)
            ->select('id', 'user_id')
            ->get()
            ->toArray();

        if (!$object) {
            return \response('Such object does not exist', 400);
        }

        if ($object[0]['user_id'] !== current_user()->id) {
            return response('Unauthorized', 403);
        }

        $docs = Export::where('object_id', $object[0]['id'])->get();

        return view('user.mydocs', compact('docs'));
    }
}
