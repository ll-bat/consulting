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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ObjectsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(){
        $objects = current_user()->getObjects();

        return view('user.objects', [
            'objects' => array_reverse(
                index($objects, 'id')
            )
        ]);
    }

    /**
     * @return Application|ResponseFactory|Response|string
     */
    public function create() {
        $res = $this->validateName();
        $name = $res['name'];

        if (!$this->isUnique($name)) {
            return $this->fail(__("ასეთი ობიექტი უკვე არსებობს"), 400);
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
            return $this->fail(__("ასეთი ობიექტი უკვე არსებობს"), 400);
        }

        $ok = $objects->update(['name' => $name]);
        if (!$ok) {
            return $this->fail(__('დაფიქსირდა შეცდომა, სცადეთ თავიდან'), 400);
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

    /**
     * @param int $object
     * @return Application|Factory|View
     */
    public function show(int $object) {
        $like = \request('key');
        if (!is_string($like) || strlen($like) > 200) {
            $like = null;
        }

        $docs = Export::where(['object_id' => $object, 'user_id' => current_user()->id])
            ->latest();

        $path = 'docs';

        if ($like) {
            $docs = $docs->where('filename', 'like',  '%' . $like . '%');
            $path .= '?key=' . $like;
        }

        $docs = $docs->simplePaginate(10);

        $docs->setPath($path);

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
            return redirect()->route('user.objects')->with('message', ['success' => false, 'message' => __("ვერ მოხერხდა ობიექტის წაშლა. მოცემული ობიექტი შეიცავს დოკუმენტებს")]);
        }

        return redirect()->route('user.objects')->with('message', ['success' => true, 'message' => __("ობიექტი წარმატებით წაიშალა")]);
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
