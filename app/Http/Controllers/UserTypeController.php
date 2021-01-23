<?php

namespace App\Http\Controllers;

use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psy\Util\Json;

class UserTypeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        $users = User::orderBy('updated_at', 'DESC')->get();
        return view('user/types/index', compact('users'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return bool
     */
    public function save(Request $request, User $user)
    {
        $request->validate([
            'status' => 'boolean',
            'type' => 'integer',
        ]);

        list($status, $type) = [$request->get('status'), $request->get('type')];

        if (!in_array($type, [$user::TYPE_VIP, $user::TYPE_PREMIUM, $user::TYPE_STANDARD])) {
            throw new ValidationException('Non-valid user type');
        }

        $flag = $user->update(['status' => $status, 'type' => $type]);
        if (!$flag) {
            throw new \Exception("Can't update user");
        }

        return true;
    }
}
