<?php

namespace Safeboda\Http\Controllers;

use DB;
use Safeboda\Http\Requests\Promocode as PromocodeFormRequest;
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
    public function store(PromocodeFormRequest $request)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

    //pass validator errors as errors object for ajax response

            return response()->json(['errors' => $validator->errors()]);
        } else {
            $content = DB::table('promocodes')->insertGetId($request->toArray());

            return response([
            'created' => (bool) $content,
            'count' => count($content),
        ]);
        }
    }
}
