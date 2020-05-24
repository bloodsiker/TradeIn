<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    /**
     * @var string
     */
    protected $table = 'social_accounts';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $builder
     * @param $provider
     *
     * @return mixed
     */
    public static function scopeWhereProvider(Builder $builder, $provider)
    {
        return $builder->where('provider', $provider);
    }

    /**
     * @param Builder $builder
     * @param $provider_user_id
     *
     * @return mixed
     */
    public static function scopeWhereProviderUserId(Builder $builder, $provider_user_id)
    {
        return $builder->where('provider_user_id', $provider_user_id);
    }
}
