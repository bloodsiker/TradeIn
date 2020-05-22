<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class NetworkController
 */
class NetworkController extends Controller
{

    public function list()
    {
        $networks = Network::all();

        return view('cabinet.networks.list', compact('networks'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'min:3', 'max:255']
            ]);

            $network = new Network([
                'name' => $request->get('name'),
            ]);

            $network->save();

            return redirect()->route('cabinet.network.list')->with('success', 'Торговая сеть добавлена!');
        }

        return redirect()->route('cabinet.network.list');
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
