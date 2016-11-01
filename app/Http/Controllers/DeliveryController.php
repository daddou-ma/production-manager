<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Delivery;

use App\Http\Requests\DeliveryRequest;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $deliveries = Delivery::with(['client','products'])->ordered()->get();

        return $deliveries->toJson();
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
    public function store(DeliveryRequest $request)
    {
        //
        $delivery = Delivery::create($request->all());
        /*$delivery->full_name = $request->full_name;
        $delivery->nrc = $request->nrc;
        $delivery->nif = $request->nif;
        $delivery->na = $request->na;
        $delivery->address = $request->address;
        $delivery->phone = $request->phone;
        $delivery->fax = $request->fax;*/
        //$delivery->save();

        return $delivery->toJson();
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
        $deliveries = Delivery::with(['client','products'])->find($id);

        return $deliveries->toJson();
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
    public function update(DeliveryRequest $request, $id)
    {
        //
        $delivery = Delivery::find($id);
        $delivery->update($request->all());
        return $delivery->toJson();
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
        $delivery = Delivery::find($id);
        $delivery->actif = false;
        $delivery->save();

        return $delivery->toJson();
    }
}
