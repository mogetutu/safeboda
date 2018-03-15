<?php

namespace Safeboda\Http\Controllers;

use Safeboda\Http\Requests\StorePromoCode;
use Safeboda\Promocode;

class Promocodes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Promocode[]
     */
    public function index()
    {
        return response(['data' => Promocode::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePromoCode $request
     *
     * @return array
     */
    public function store(StorePromoCode $request)
    {
        $promocode = Promocode::create($request->all());

        return response([
            'created' => $promocode,
        ]);
    }
}
