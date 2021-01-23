<?php

namespace App\Http\Controllers;

use App\Objects;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ObjectsController extends Controller
{
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
}
