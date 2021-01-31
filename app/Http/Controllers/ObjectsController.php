<?php

namespace App\Http\Controllers;

use App\Export;
use App\Objects;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
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

        return route('user.objects');
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
            return route('user.objects');
        }

        if (!$this->isUnique($name)) {
            return $this->fail('ასეთი ობიექტი უკვე არსებობს', 400);
        }

        $ok = $objects->update(['name' => $name]);
        if (!$ok) {
            return $this->fail("დაფიქსირდა შეცდომა, სცადეთ თავიდან", 400);
        }

        return route('user.objects');
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

        $docs = Export::where('object_id', $object[0]['id'])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('user.mydocs', compact('docs'));
    }

    /**
     * @param Objects $objects
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Objects $objects): RedirectResponse
    {
        if ($objects->user_id !== current_user()->id) {
            throw new Exception('Forbidden', 403);
        }

        try {
            $objects->delete();
        } catch (\Throwable $e) {
            return redirect()->route('user.objects')->with('message', ['success' => false, 'message' => 'ვერ მოხერხდა ობიექტის წაშლა. მოცემული ობიექტი შეიცავს დოკუმენტებს']);
        }

        return redirect()->route('user.objects')->with('message', ['success' => true, 'message' => 'ობეიქტი წარმატებით წაიშალა']);
    }

    /**
     * @param $message
     * @param int $code
     * @return Application|ResponseFactory|Response
     */
    public function fail($message, $code = 400) {
        return response([
            'errors' => [
                'name' => [$message]
            ]
        ], $code);
    }
}
