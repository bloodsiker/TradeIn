<?php

namespace App\Http\Controllers\Cabinet;

use App\Facades\UserLog;
use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use App\Models\Network;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserController
 */
class UserController extends Controller
{

    public function list(Request $request)
    {
        $roles = $networks = [];
        $query = User::select('users.*')->with('role', 'shop', 'network');

        if (\Auth::user()->isAdmin()) {
            $networks = Network::all();
            $shops = Shop::all();
            $roles = Role::all();
        }

        if (\Auth::user()->isNetwork()) {
            if ($request->get('role_id') && !in_array((int) $request->get('role_id'), [Role::ROLE_NETWORK, Role::ROLE_SHOP], true)) {
                return redirect()->route('cabinet.user.list')
                    ->with('danger', 'У вас нет прав для фильтрации пользователей по этой роли!');
            }

            $shops = Shop::where('network_id', \Auth::user()->network_id)->get();
            $roles = Role::whereIn('id', [Role::ROLE_NETWORK, Role::ROLE_SHOP])->get();

            $allowShop = $shops->contains(function ($value, $key) use ($request) {
                return $value->id === (int) $request->get('shop_id');
            });

            if ($request->get('shop_id') && !$allowShop) {
                return redirect()->route('cabinet.user.list')
                    ->with('danger', 'Вы не можете просматривать пользователей которые не находятся в вашей торговой сети!');
            }

            $query->where('network_id', \Auth::user()->network_id);
        }

        if ($request->get('network_id')) {
            $query->where('network_id', $request->get('network_id'));
        }

        if ($request->get('shop_id')) {
            $query->where('shop_id', $request->get('shop_id'));
        }

        if ($request->get('role_id')) {
            $query->where('role_id', $request->get('role_id'));
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

            UserLog::log('Добавил нового пользователя '. $user->id);

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

            UserLog::log('Отредактировал пользователя '. $user->id);

            return redirect()->route('cabinet.user.list')->with('success', 'Информация обновлена');
        }

        return view('cabinet.users.edit', compact('user', 'roles', 'networks', 'shops'));
    }

    public function logs(Request $request)
    {
        $networks = Network::all();
        $shops = Shop::all();
        $users = User::all();

        $query = \App\Models\UserLog::select('user_logs.*');
        $query->join('users', 'users.id', '=', 'user_logs.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if ($request->get('network_id')) {
            $query->where('users.network_id', $request->get('network_id'));
        }

        if ($request->get('shop_id')) {
            $query->where('users.shop_id', $request->get('shop_id'));
        }

        if ($request->get('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->get('date')) {
            $date = Carbon::parse($request->get('date'))->format('Y-m-d');
            $query->whereDate('user_logs.created_at', '=', $date);
        }

        $logs = $query->orderBy('id', 'DESC')->paginate(30);

        return view('cabinet.users.logs', compact('logs', 'users', 'networks', 'shops'));
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->get('id'));

        if ($user) {
            $user->delete();

            UserLog::log('Удалил пользователя '. $user->id);

            return response(['status' => 1, 'type' => 'success', 'message' => "Пользователь {$user->fullName()} удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::import(new UserImport($request), $request->file('file'));
            UserLog::log('Импортировал пользователей');

            return redirect()->back();
        }

        return back()->with('danger', 'Ошибка при импорте!');
    }
}
