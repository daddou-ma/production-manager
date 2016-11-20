<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Delivery;

use App\Product;

use App\Http\Requests\DeliveryRequest;

use Illuminate\Support\Facades\Input;

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
        $deliveries = Delivery::with(['client','products'])->ordered(true)->get();

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

        $products = Input::get('products');

        $ids = array();
        $total_nt = 0;
        foreach ($products as $product) {
            # code...
            //array_push($ids, [$material['id'] => ['quantity' => $material['pivot']['quantity']]]);
            $ids[$product['id']] = ['quantity' => $product['pivot']['quantity'],
                'unite_price' => $product['pivot']['unite_price'],
                'price' => $product['pivot']['unite_price']*$product['pivot']['quantity']
            ];
            $pro = Product::find($product['id']);
            $pro->quantity = $pro->quantity - $product['pivot']['quantity'];
            $pro->save();
            $total_nt = $total_nt + $product['pivot']['unite_price']*$product['pivot']['quantity'];
        }
        $delivery->products()->attach($ids);
        $delivery->count_products = $delivery->products()->count();
        $delivery->total_notax = $total_nt;
        $delivery->total_price = $delivery->total_notax + ($delivery->total_notax * $delivery->taux_douane);
        $delivery->save();

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
        /*
        $delivery = Delivery::find($id);
        $delivery->update($request->all());
        return $delivery->toJson();
*/
        $delivery = Delivery::find($id);
        $products = Input::get('products');


        foreach ($delivery->products as $product) {
            $product->quantity = $product->quantity + $product->pivot->quantity;
            $product->save();
        }
        $delivery->products()->detach();

        $delivery->update($request->all());

        $ids = array();
        $total_nt = 0;

        foreach ($products as $product) {
            # code...
            //array_push($ids, [$material['id'] => ['quantity' => $material['pivot']['quantity']]]);
            $ids[$product['id']] = ['quantity' => $product['pivot']['quantity'],
                'unite_price' => $product['pivot']['unite_price'],
                'price' => $product['pivot']['unite_price']*$product['pivot']['quantity']
            ];
            $pro = Product::find($product['id']);
            $pro->quantity = $pro->quantity - $product['pivot']['quantity'];
            $pro->save();
            $total_nt = $total_nt + $product['pivot']['unite_price']*$product['pivot']['quantity'];
        }
        $delivery->products()->attach($ids);
        $delivery->count_products = $delivery->products()->count();
        $delivery->total_notax = $total_nt;
        $delivery->total_price = $delivery->total_notax + ($delivery->total_notax * $delivery->taux_douane / 100);

        $delivery->save();
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
        $delivery = Delivery::with(['products'])->find($id);
        $delivery->actif = false;
        $delivery->save();

        foreach ($delivery->products as $product) {
            $product->quantity = $product->quantity + $product->pivot->quantity;
            $product->save();
        }
        $delivery->products()->detach();

        return $delivery->toJson();
    }
}
