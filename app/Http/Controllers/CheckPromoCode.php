<?php

namespace Safeboda\Http\Controllers;

use Illuminate\Http\Request;
use Safeboda\Promocode;
use function array_merge;

class CheckPromoCode extends Controller
{
    /**
     * @var Promocode
     */
    private $promocode;

    /**
     * CheckPromoCode constructor.
     *
     * @param Promocode $promocode
     */
    public function __construct(Promocode $promocode)
    {
        $this->promocode = $promocode;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $request->only('code', 'origin', 'destination');
        $validCode = $this->promocode->where('code', $request->code)->active()->count();
        if (!$validCode) {
            return response(['data' => [
                'valid' => (bool) $validCode,
                'polyline' => null,
            ]]);
        }
        $points = [$request->origin, $request->destination];

        return response(['data' => [
            'valid' => $this->promocode->validateCode($request->code, $points),
            'polyline' => $this->promocode->getPolyline(array_merge($request->origin, $request->destination)),
        ]]);
    }
}
