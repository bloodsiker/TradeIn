<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackRequest;
use App\Models\Network;
use App\Models\Role;
use App\Models\Shop;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Class ProfileController
 */
class ProfileController extends Controller
{

    public function profile(Request $request)
    {
        $user = \Auth::user();

        $account['facebook'] = SocialAccount::whereProvider('facebook')
            ->where('user_id', $user->id)
            ->first();
        $account['google'] = SocialAccount::whereProvider('google')
            ->where('user_id', $user->id)
            ->first();
        $account['linkedin'] = SocialAccount::whereProvider('linkedin')
            ->where('user_id', $user->id)
            ->first();

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

            if ($request->hasFile('avatar')) {
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

        return view('cabinet.profile.index', compact('user', 'account'));
    }

    public function bonus(Request $request)
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->modify('- 1 month');

        $query = BuybackRequest::where('user_id', Auth::id());

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d 00:00');
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d 23:59');
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d 00:00');
            $to = Carbon::now()->format('Y-m-d 23:59');
            $query->whereBetween('created_at', [$from, $to]);
        } else {
            $from = Carbon::now()->modify('- 1 month')->format('Y-m-d 00:00');
            $to = Carbon::now()->format('Y-m-d 23:59');
            $query->whereBetween('created_at', [$from, $to]);
        }

        $bonuses = $query->where('is_accrued', true)
            ->orderBy('paid_at', 'DESC')->with('paidBy')->get();

        $sumPaid['paid'] = BuybackRequest::whereBetween('created_at', [$from, $to])
            ->where('is_paid', true)->sum('bonus');
        $sumPaid['all'] = BuybackRequest::where('is_paid', true)->sum('bonus');
        $sumPaid['not_paid'] = BuybackRequest::where(['is_paid' => false, 'is_accrued' => true])->sum('bonus');

        return view('cabinet.profile.bonus', compact('now', 'lastMonth', 'bonuses', 'sumPaid'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function linkSocialAccount(Request $request)
    {
        if ($request->get('provider') === 'google') {
            Session::push('social_google', true);
            return redirect()->route('login.social', ['provider' => $request->get('provider')]);

        } elseif ($request->get('provider') === 'linkedin') {
            Session::push('social_linkedin', true);
            return redirect()->route('login.social', ['provider' => $request->get('provider')]);

        } elseif ($request->get('provider') === 'facebook') {
            Session::push('social_facebook', true);
            return redirect()->route('login.social', ['provider' => $request->get('provider')]);
        }

        return redirect()->back()->with('danger', 'Не верный провайдер');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlinkSocialAccount(Request $request)
    {
        SocialAccount::whereProvider($request->get('provider'))->where('user_id', Auth::id())->delete();
        return redirect()->back()->with(['success' => $request->get('provider') . ' аккаунт отвязан']);
    }

    public function logout(Request $request)
    {
        \Auth::logout();

        return redirect()->route('main');
    }
}
