<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Services\SocialAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialAuthController
 */
class SocialAuthController extends Controller
{
    /**
     * @param $provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function providerRedirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param Request $request
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function facebookCallback(Request $request, SocialAccountService $service)
    {
        if(Session::has('social_facebook')){
            $service->linkSocialAccount(Socialite::driver('facebook')->user(), 'facebook');
            Session::forget('social_facebook');
            return redirect()->route('cabinet.profile')->with(['success' => 'Facebook аккаунт привязан']);
        }

        $user = $service->getUser(Socialite::driver('facebook')->user(), 'facebook');

        if ($user) {
            auth()->login($user);

            return redirect()->route('cabinet.main');
        }

        return redirect()->back()->with('danger', 'Пользователь не найден');
    }

    /**
     * @param Request $request
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleCallback(Request $request, SocialAccountService $service)
    {
        if(Session::has('social_google')){
            $service->linkSocialAccount(Socialite::driver('google')->user(), 'google');
            Session::forget('social_google');
            return redirect()->route('cabinet.profile')->with(['success' => 'Google аккаунт привязан']);
        }

        $user = $service->getUser(Socialite::driver('google')->user(), 'google');

        if ($user) {
            auth()->login($user);

            return redirect()->route('cabinet.main');
        }

        return redirect()->back()->with('danger', 'Пользователь не найден');
    }

    /**
     * @param Request $request
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function linkedinCallback(Request $request, SocialAccountService $service)
    {
        if(Session::has('social_linkedin')){
            $service->linkSocialAccount(Socialite::driver('linkedin')->user(), 'linkedin');
            Session::forget('social_linkedin');
            return redirect()->route('cabinet.profile')->with(['success' => 'Linkedin аккаунт привязан']);
        }

        $user = $service->getUser(Socialite::driver('linkedin')->user(), 'linkedin');

        if ($user) {
            auth()->login($user);

            return redirect()->route('cabinet.main');
        }

        return redirect()->back()->with('danger', 'Пользователь не найден');
    }
}
