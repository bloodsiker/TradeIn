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
 * Class ProfileController
 */
class ProfileController extends Controller
{

    public function profile()
    {
        $user = \Auth::user();

        return view('cabinet.profile.index', compact('user'));
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
            $user->email = $request->get('email');
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

    public function logout(Request $request)
    {
        \Auth::logout();

        return redirect()->route('main');
    }
}
