<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Product;

use Illuminate\Support\Facades\Input;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::with(['fabrications','deliveries.client','materials'])->ordered()->get();

        return $products->toJson();
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
    public function store(ProductRequest $request)
    {
        //
        $product = Product::create($request->all());
        $materials = Input::get('materials');

        $ids = array();

        foreach ($materials as $material) {
            # code...
            //array_push($ids, [$material['id'] => ['quantity' => $material['pivot']['quantity']]]);
            $ids[$material['id']] = ['quantity' => $material['pivot']['quantity']];
        }
        $product->materials()->sync($ids);
        $product->count_materials = $product->materials()->count();
        $product->save();

        return $product->toJson();
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
        $product = Product::with(['fabrications','deliveries.client','materials'])->find($id);

        return $product->toJson();
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
    public function update(ProductRequest $request, $id)
    {
        //
        $product = Product::find($id);
        $product->update($request->all());
        $materials = Input::get('materials');

        $ids = array();

        foreach ($materials as $material) {
            # code...
            //array_push($ids, [$material['id'] => ['quantity' => $material['pivot']['quantity']]]);
            $ids[$material['id']] = ['quantity' => $material['pivot']['quantity']];
        }
        $product->materials()->sync($ids);
        $product->count_materials = $product->materials()->count();
        $product->save();
        return $product->toJson();
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
        $product = Product::find($id);
        $product->actif = false;
        $product->save();

        return $product->toJson();
    }
}
