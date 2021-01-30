<?php

namespace App\Http\Controllers;

use App\Field;
use App\Ploss;
use App\Process;
use App\Udanger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FieldController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        $fields = Field::all();
        return view('admin.fields', compact('fields'));
    }

    /**
     * @param Field $field
     * @return RedirectResponse
     */
    public function show(Field $field): RedirectResponse
    {
        session()->put('_fieldId', $field->id);
        return redirect()->route('admin.docs');
    }

    /**
     * @return Application|ResponseFactory|Response|string
     */
    public function create() {
        \request()->validate([
            'name' => 'required|string|max:512'
        ]);

        $name = \request('name');

        $exists = Field::where('name', $name)->limit(1)->count() > 0;
        if ($exists) {
            return $this->fail('ასეთი სფერო უკვე არსებობს');
        }

        $ok = Field::create(['name' => $name]);
        if ($ok) {
            return route('admin.fields');
        }

        return $this->fail('სამწუხაროდ, ვერ მოხერხდა სფეროს შექმნა');
    }

    /**
     * @param Field $field
     * @return Application|ResponseFactory|Response|string
     */
    public function update(Field $field)
    {
        \request()->validate([
            'name' => 'required|string|max:512'
        ]);

        $name = \request('name');

        if ($name === $field->name) {
            return route('admin.fields');
        }

        $exists = Field::where('name', $name)->limit(1)->count() > 0;
        if ($exists) {
            return $this->fail('ასეთი სფერო უკვე არსებობს');
        }

        $ok = $field->update(['name' => $name]);
        if ($ok) {
            return route('admin.fields');
        }

        return $this->fail('სამწუხაროდ, ვერ მოხერხდა სფეროს განახლება');
    }

    /**
     * @param Field $field
     * @return Application|ResponseFactory|Response|string
     */
    public function delete(Field $field) {
        $ok = Process::where('field_id', $field->id)->limit(1)->count() < 1;
        if (!$ok) {
            return redirect()->route('admin.fields')->with('message', ['success' => false, 'message' => 'გთხოვთ, წაშალოთ ამ სფეროში არსებული მონაცემები(პროცესები)']);
        }
        $ok = Ploss::where('field_id', $field->id)->limit(1)->count() < 1;
        if (!$ok) {
            return redirect()->route('admin.fields')->with('message', ['success' => false, 'message' => 'გთხოვთ, წაშალოთ ამ სფეროში არსებული მონაცემები(პოტენციური ზიანი)']);
        }
        $ok = Udanger::where('field_id', $field->id)->limit(1)->count() < 1;
        if (!$ok) {
            return redirect()->route('admin.fields')->with('message', ['success' => false, 'message' => 'გთხოვთ, წაშალოთ ამ სფეროში არსებული მონაცემები(ვინ იმყოფება საფრთხის ქვეშ)']);
        }

        $ok = $field->delete();
        if ($ok) {
            return redirect()->route('admin.fields')->with('message', ['success' => true, 'message' => 'სფერო წარმატებით წაიშალა']);
        }
        return redirect()->route('admin.fields')->with('message', ['success' => false, 'message' => 'ვერ მოხერხდა სფეროს წაშლა. სცადეთ თავიდან']);
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
