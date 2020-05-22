<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 */
class UserController extends Controller
{

    public function list()
    {
        $users = User::all();

        return view('cabinet.users.list', compact('users'));
    }

    public function add(Request $request)
    {
        $roles = Role::all();
        $networks = Network::all();

        if ($request->isMethod('post')) {
            $request->validate([
                'name'       => ['required', 'min:3', 'max:255'],
                'surname'    => ['required', 'min:3', 'max:255'],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'birthday'   => ['nullable', 'date'],
                'phone'      => ['nullable'],
                'network_id' => ['required', 'numeric'],
                'password'   => ['required', 'string', 'min:8', 'confirmed'],
            ]);


            $user = new User([
                'role_id' => $request->get('role_id'),
                'network_id' => $request->get('network_id'),
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'birthday' => $request->filled('birthday') ? Carbon::parse($request->get('birthday'))->format('Y-m-d') : null,
                'is_active' => $request->get('is_active'),
                'password' => Hash::make($request->get('password')),
            ]);

            $user->save();

            return redirect()->route('cabinet.user.list')->with('success', 'Пользователь добавлен!');
        }

        return view('cabinet.users.add', compact('roles', 'networks'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();
        $networks = Network::all();

        if ($request->isMethod('post')) {

            $user->role_id = $request->get('role_id');
            $user->network_id = $request->get('network_id');
            $user->name = $request->get('name');
            $user->surname = $request->get('surname');
            $user->email = $request->get('email');
            $user->birthday = Carbon::parse($request->get('birthday'))->format('Y-m-d');
            $user->is_active = $request->get('is_active');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->save();

            return redirect()->route('cabinet.user.list')->with('success', 'Информация обновлена');
        }

        return view('cabinet.users.edit', compact('user', 'roles', 'networks'));
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            $user->delete();

            return redirect()->route('cabinet.user.list')->with('success', 'Пользователь удален!');
        }

        return redirect()->route('cabinet.user.list')->with('danger', 'Ошибка при удалении!');
    }
}
