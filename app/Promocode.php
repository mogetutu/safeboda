<?php

namespace Safeboda;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Safeboda\Scopes\NotExpired;

class Promocode extends Model
{
    protected $dates = [
        'expires_at',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $fillable = [
        'code',
        'active',
        'expires_at',
        'discount',
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new NotExpired);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }
}
