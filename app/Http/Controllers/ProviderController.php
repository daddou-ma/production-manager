<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Provider;

use App\Http\Requests\ProviderRequest;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $providers = Provider::with(['commands.materials'])->ordered()->get();

        return $providers->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        //
        $provider = Provider::create($request->all());
        /*$provider->full_name = $request->full_name;
        $provider->nrc = $request->nrc;
        $provider->nif = $request->nif;
        $provider->na = $request->na;
        $provider->address = $request->address;
        $provider->phone = $request->phone;
        $provider->fax = $request->fax;*/
        //$provider->save();

        return $provider->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $providers = Provider::with(['commands.materials'])->find($id);

        return $providers->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        //
        $provider = Provider::find($id);
        $provider->update($request->all());
        return $provider->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $provider = Provider::find($id);
        $provider->actif = false;
        $provider->save();

        return $provider->toJson();
    }
}
