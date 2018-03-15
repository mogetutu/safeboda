<?php

namespace Safeboda;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Polyline;
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
        'latitude',
        'longitude',
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

    /**
     * @param $promocode
     * @param array $points
     *
     * @return bool
     */
    public function validateCode($promocode, array $points)
    {
        $codes = [];
        $expression = 'SELECT code, ((ACOS(SIN(:latitude * PI() / 180) * SIN(latitude * PI() / 180) + COS(:latitude2 * PI() / 180) * COS(latitude * PI() / 180) * COS((:longitude - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance FROM promocodes HAVING distance <= :radius ORDER BY distance ASC';
        foreach ($points as $point) {
            $latitude = head($point);
            $longitude = end($point);

            $code = DB::select(
                $expression,
                [
                    'latitude' => $latitude,
                    'latitude2' => $latitude,
                    'longitude' => $longitude,
                    'radius' => config('safeboda.promocodes.radius'),
                ]
            );

            array_push($codes, array_pluck($code, 'code'));
        }

        return in_array($promocode, array_collapse($codes));
    }

    /**
     * @param array $points
     *
     * @return string
     */
    public function getPolyline(array $points)
    {
        return Polyline::encode($points);
    }
}
