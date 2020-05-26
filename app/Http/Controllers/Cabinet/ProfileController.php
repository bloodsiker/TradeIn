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

    public function profile(Request $request)
    {
        $user = \Auth::user();

        if ($request->isMethod('post')) {

            $request->validate([
                'name'       => ['required', 'min:3', 'max:255'],
                'surname'    => ['required', 'min:3', 'max:255'],
                'patronymic' => ['nullable', 'min:3', 'max:255'],
                'birthday'   => ['nullable', 'date'],
                'phone'      => ['nullable'],
                'password'   => ['nullable', 'string', 'min:6'],
            ]);

            $user->name = $request->get('name');
            $user->surname = $request->get('surname');
            $user->patronymic = $request->get('patronymic');
            $user->phone = $request->get('phone');
            $user->birthday = Carbon::parse($request->get('birthday'))->format('Y-m-d');

            if ($request->has('avatar')) {
                $path = '/image/profile/';
                $image = $request->file('avatar');
                $name = sha1(time().random_bytes(5)) . '.' . trim($image->getClientOriginalExtension());
                $fullPatch = $path . $name;

                $image->storeAs($path, $name, 'publicImage');

                $user->avatar = $fullPatch;
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->save();

            return redirect()->route('cabinet.profile')->with('success', 'Информация обновлена');
        }

        return view('cabinet.profile.index', compact('user'));
    }

    public function logout(Request $request)
    {
        \Auth::logout();

        return redirect()->route('main');
    }
}
