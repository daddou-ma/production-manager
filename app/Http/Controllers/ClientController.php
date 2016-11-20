<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Client;

use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all clients 
        $clients = Client::with(['deliveries.products'])->ordered(true)->get();

        // return clients as json
        return $clients->toJson();
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
    public function store(ClientRequest $request)
    {
        // Create the new client
        $client = Client::create($request->all());

        // update the deliveries count in the client table
        $client->count_deliveries = $client->deliveries()->count();
        $client->save();

        // return the client json
        return $client->toJson();
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
        $clients = Client::with(['deliveries.products'])->find($id);

        // return client as json
        return $clients->toJson();
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
    public function update(ClientRequest $request, $id)
    {
        // find the client by id and update it
        $client = Client::find($id);
        $client->update($request->all());

        // update the deliveries count in the client table
        $client->count_deliveries = $client->deliveries()->count();
        $client->save();

        // return client as json
        return $client->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find client by id and deleting it by set actif to false
        $client = Client::find($id);
        $client->actif = false;
        $client->save();

        // return client deleted as json
        return $client->toJson();
    }
}
