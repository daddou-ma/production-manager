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
        // get all fabrications
        $fabrications = Fabrication::with(['product'])->ordered(true)->get();

        // return fabrications as json
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
        // create new fabrication
        $fabrication = Fabrication::create($request->all());

        // add quantite produced to the product quantity
        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity + $fabrication->quantity*1000;
        $product->count_fabrication = $product->fabrications()->count();
        $product->save();

        // for each material used to produce the product substract from quantity
        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity - ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        } 

        // return fabrication as json
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
        // get fabrication by id
        $fabrications = Fabrication::with(['client','product'])->find($id);

        // return fabrication as json
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
        // get fabrication by id
        $fabrication = Fabrication::find($id);

        /*
        *   Before Updating Th Fabrication
        */
        // subtract the old quantity produced from the actual one
        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity - $fabrication->quantity*1000;
        $product->count_fabrication = $product->fabrications()->count();
        $product->save();

        // adding the old quantity of the mater$product->count_fabrications = $product->fabrications()->count();ials to the actual one
        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity + ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        /*
        *   Updating Thr Fabrication
        */
        $fabrication->update($request->all());

        /*
        *   After Updating The Fabrication
        */
        // adding the old quantity produced to the actual one
        $product->quantity = $product->quantity + $fabrication->quantity*1000;
        $product->count_fabrication = $product->fabrications()->count();
        $product->save();

        // subtracting the old quantity of the materials from the actual one
        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity - ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        // return the edited fabrication
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
        // find fabrication and deleting it by seting actif false
        $fabrication = Fabrication::find($id);
        $fabrication->actif = false;
        $fabrication->save();

        /*
        *   After Deleting The Fabrication
        */
        // subtract the old quantity produced from the actual one
        $product = Product::with(['materials'])->find($fabrication->product_id);
        $product->quantity = $product->quantity - $fabrication->quantity*1000;
        $product->count_fabrication = $product->fabrications()->count();
        $product->save();

        // adding the old quantity of the materials to the actual one
        foreach ($product->materials as $mat) {
            $material = Material::find($mat->id);
            $material->quantity = $material->quantity + ($mat->pivot->quantity * $fabrication->quantity);
            $material->save();
        }

        // return the deleted fabrication
        return $fabrication->toJson();
    }
}
