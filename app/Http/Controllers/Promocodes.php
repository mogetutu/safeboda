<?php

namespace Safeboda\Http\Controllers;

use DB;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        $content = DB::table('promocodes')->insert($request->toArray());

        return response(['created' => $content]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Safeboda\Promocode $promocode
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Promocode $promocode)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Safeboda\Promocode $promocode
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Promocode $promocode)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Safeboda\Promocode $promocode
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promocode $promocode)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Safeboda\Promocode $promocode
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promocode $promocode)
    {
    }
}
