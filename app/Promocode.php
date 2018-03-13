<?php

namespace Safeboda;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Polyline;
use Safeboda\Scopes\NotExpired;
use function array_merge;

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

    /**
     * @param $promocode
     * @param array $origin
     * @param array $destination
     *
     * @return bool
     */
    public function validateCode($promocode, array $origin, array $destination)
    {
        $originlatitude = head($origin);
        $originlongitude = end($origin);

        $destinationlatitude = head($destination);
        $destinationlongitude = end($destination);

        $expression = 'SELECT code, ((ACOS(SIN(:latitude * PI() / 180) * SIN(latitude * PI() / 180) + COS(:latitude2 * PI() / 180) * COS(latitude * PI() / 180) * COS((:longitude - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance FROM promocodes HAVING distance <= :radius ORDER BY distance ASC';

        $originCodes = DB::select(
            $expression,
            [
                'latitude' => $originlatitude,
                'latitude2' => $originlatitude,
                'longitude' => $originlongitude,
                'radius' => config('safeboda.promocodes.radius'),
            ]
        );

        $destinationCodes = DB::select(
            $expression,
            [
                'latitude' => $destinationlatitude,
                'latitude2' => $destinationlatitude,
                'longitude' => $destinationlongitude,
                'radius' => config('safeboda.promocodes.radius'),
            ]
        );

        $codes = array_merge($originCodes, $destinationCodes);

        return in_array($promocode, array_pluck($codes, 'code'));
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
