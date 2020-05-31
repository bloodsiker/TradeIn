<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'phone', 'password', 'role_id', 'network_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function network()
    {
        return $this->hasOne(Network::class, 'id', 'network_id');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    public function fullName()
    {
        return $this->name .' ' . $this->surname .' ' .$this->patronymic;
    }

    public function getShop()
    {
        return $this->shop ? $this->shop->name : null;
    }

    public function getNetwork()
    {
        return $this->network ? $this->network->name : null;
    }

    public function getAvatar()
    {
        return $this->avatar ?: 'assets/img/no-avatar.png';
    }

    public function attributeStatus($attribute)
    {
        if ($attribute === 'text') {
            return $this->is_active ? 'Активный' : 'Не активный';
        } elseif ($attribute === 'color') {
            return $this->is_active ? 'success' : 'danger';
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return Auth::user()->role_id === Role::ROLE_ADMIN;
    }

    public function isNetwork()
    {
        return Auth::user()->role_id === Role::ROLE_NETWORK;
    }

    public function isShop()
    {
        return Auth::user()->role_id === Role::ROLE_SHOP;
    }
}
