<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Fabrication;
use App\Product;
use App\Material;

use App\Http\Requests\FabricationRequest;

class FabricationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fabrications = Fabrication::with(['product'])->ordered(true)->get();

        return $fabrications->toJson();
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
    public function store(FabricationRequest $request)
    {
        //
        $fabrication = Fabrication::create($request->all());

        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity + $fabrication->quantity * 1000;
        $product->save();

        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity - ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        } 

        return $fabrication->toJson();
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
        $fabrications = Fabrication::with(['client','product'])->find($id);

        return $fabrications->toJson();
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
    public function update(FabricationRequest $request, $id)
    {
        //
        $fabrication = Fabrication::find($id);

        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity - $fabrication->quantity * 1000;
        $product->save();

        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity + ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        $fabrication->update($request->all());

        $product->quantity = $product->quantity + $fabrication->quantity * 1000;
        $product->save();

        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity - ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        return $fabrication->toJson();
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
        $fabrication = Fabrication::find($id);
        $fabrication->actif = false;
        $fabrication->save();

        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity - $fabrication->quantity * 1000;
        $product->save();

        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity + ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        return $fabrication->toJson();
    }
}
