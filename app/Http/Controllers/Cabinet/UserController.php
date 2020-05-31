<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 */
class UserController extends Controller
{

    public function list(Request $request)
    {
        $roles = $networks = [];
        $query = User::select('users.*');

        if ($request->has('network_id') && $request->get('network_id')) {
            $query->where('network_id', $request->get('network_id'));
        }

        if ($request->has('shop_id') && $request->get('shop_id')) {
            $query->where('shop_id', $request->get('shop_id'));
        }

        if ($request->has('role_id') && $request->get('role_id')) {
            $query->where('role_id', $request->get('role_id'));
        }

        if (\Auth::user()->isAdmin()) {
            $networks = Network::all();
            $shops = Shop::all();
            $roles = Role::all();
        } elseif (\Auth::user()->isNetwork()) {
            $shops = Shop::where('network_id', \Auth::user()->network_id)->get();
            $roles = Role::whereIn('id', [Role::ROLE_NETWORK, Role::ROLE_SHOP])->get();
            $query->where('network_id', \Auth::user()->network_id);
        }

        $users = $query->get()->sortByDesc('id');

        return view('cabinet.users.list', compact('users', 'networks', 'shops', 'roles'));
    }

    public function add(Request $request)
    {
        $roles = Role::all();
        $networks = Network::all();

        if ($request->isMethod('post')) {
            $request->validate([
                'name'       => ['required', 'min:3', 'max:255'],
                'surname'    => ['required', 'min:3', 'max:255'],
                'patronymic' => ['nullable', 'min:3', 'max:255'],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'birthday'   => ['nullable', 'date'],
                'phone'      => ['nullable'],
                'network_id' => ['nullable', 'numeric'],
                'password'   => ['required', 'string', 'min:6'],
            ]);


            $user = new User([
                'role_id'    => $request->get('role_id'),
                'network_id' => $request->get('network_id'),
                'shop_id'    => $request->get('shop_id'),
                'name'       => $request->get('name'),
                'surname'    => $request->get('surname'),
                'patronymic' => $request->get('patronymic'),
                'email'      => $request->get('email'),
                'phone'      => $request->get('phone'),
                'birthday'   => $request->filled('birthday') ? Carbon::parse($request->get('birthday'))->format('Y-m-d') : null,
                'is_active'  => $request->get('is_active'),
                'password'   => Hash::make($request->get('password')),
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
        $shops = $user->network_id ? Shop::where('network_id', $user->network_id)->get() : [];

        if ($request->isMethod('post')) {

            $user->role_id = $request->get('role_id');
            $user->network_id = $request->get('network_id');
            $user->shop_id = $request->get('shop_id');
            $user->name = $request->get('name');
            $user->surname = $request->get('surname');
            $user->patronymic = $request->get('patronymic');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->birthday = Carbon::parse($request->get('birthday'))->format('Y-m-d');
            $user->is_active = $request->get('is_active');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->save();

            return redirect()->route('cabinet.user.list')->with('success', 'Информация обновлена');
        }

        return view('cabinet.users.edit', compact('user', 'roles', 'networks', 'shops'));
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->get('id'));

        if ($user) {
            $user->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Пользователь {$user->fullName()} удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
