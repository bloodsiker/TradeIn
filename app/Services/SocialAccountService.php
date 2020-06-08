<?php
namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

/**
 * Class SocialAccountService
 */
class SocialAccountService
{

    public function getUser(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        return null;
    }

    /**
     * @param ProviderUser $providerUser
     * @param $provider
     * @param $role
     *
     * @return mixed
     */
    public function createOrGetUser(ProviderUser $providerUser, $provider, $role = null)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'role_id' => $role,
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }
    }

    /**
     * @param ProviderUser $providerUser
     * @param $provider
     */
    public function linkSocialAccount(ProviderUser $providerUser, $provider)
    {
        $account = new SocialAccount([
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider
        ]);

        $user = User::whereEmail(\Auth::user()->email)->first();

        $account->user()->associate($user);
        $account->save();
    }
}
