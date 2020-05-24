<?php

namespace App\Http\Controllers;

use App\Services\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;
use Session;

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
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function facebookCallback(SocialAccountService $service)
    {
        if(Session::has('social_facebook')){
            $service->linkSocialAccount(Socialite::driver('facebook')->user(), 'facebook');
            Session::forget('social_facebook');
            return redirect()->route('user.setting')->with(['message' => ' facebook аккаунт привязан']);
        }

        $user = $service->createOrGetUser(Socialite::driver('facebook')->user(), 'facebook');

        auth()->login($user);

        return redirect()->route('cabinet.main');
    }

    /**
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleCallback(SocialAccountService $service)
    {
        if(Session::has('social_google')){
            $service->linkSocialAccount(Socialite::driver('google')->user(), 'google');
            Session::forget('social_google');
            return redirect()->route('user.setting')->with(['message' => ' google аккаунт привязан']);
        }

        $user = $service->createOrGetUser(Socialite::driver('google')->user(), 'google');

        auth()->login($user);

        return redirect()->route('cabinet.main');
    }

    /**
     * @param SocialAccountService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function linkedinCallback(SocialAccountService $service)
    {
        if(Session::has('social_linkedin')){
            $service->linkSocialAccount(Socialite::driver('linkedin')->user(), 'linkedin');
            Session::forget('social_linkedin');
            return redirect()->route('user.setting')->with(['message' => ' linkedin аккаунт привязан']);
        }

        $user = $service->createOrGetUser(Socialite::driver('linkedin')->user(), 'linkedin');

        auth()->login($user);

        return redirect()->route('cabinet.main');
    }
}
