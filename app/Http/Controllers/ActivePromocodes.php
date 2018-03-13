<?php

namespace Safeboda\Http\Controllers;

use Safeboda\Promocode;

class ActivePromocodes extends Controller
{
    /**
     * @param Promocode $promocode
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Promocode $promocode)
    {
        $activeCodes = $promocode->active()->get()->toArray();

        return response([
            'data' => $activeCodes,
        ]);
    }
}
