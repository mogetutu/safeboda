<?php

namespace Safeboda\Http\Controllers;

use Safeboda\Promocode;

class DeactivatePromocodes extends Controller
{
    /**
     * @var Promocode
     */
    private $promocode;

    /**
     * DeactivatePromocodes constructor.
     *
     * @param Promocode $promocode
     */
    public function __construct(Promocode $promocode)
    {
        $this->promocode = $promocode;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke()
    {
        $ids = request('ids', false);
        $updated = false;
        if ($ids) {
            $updated = Promocode::whereIn('id', $ids)
                ->where('active', true)
                ->update(['active' => false]);
        }

        return response([
            'updated' => (bool) $updated,
        ]);
    }
}
