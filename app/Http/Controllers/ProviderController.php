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
        // get all providers as json 
        $providers = Provider::with(['commands.materials'])->ordered(true)->get();

        // return providers as json
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
        // create a provider
        $provider = Provider::create($request->all());

        $provider->count_commands = $provider->commands()->count();
        $provider->save();

        // return provider created as json
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
        // get a client by id
        $providers = Provider::with(['commands.materials'])->find($id);

        // return the provider as json
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
        // find provider and updating it
        $provider = Provider::find($id);
        $provider->update($request->all());

        // return updated provider as json
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
        // find provider by id and deleting it by set actif to false
        $provider = Provider::find($id);
        $provider->actif = false;
        $provider->save();

        $provider->count_commands = $provider->commands()->count();
        $provider->save();

        // return deleted provider as json
        return $provider->toJson();
    }
}
