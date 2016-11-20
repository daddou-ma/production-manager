<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Command;
use App\Material;

use App\Http\Requests\CommandRequest;

use Illuminate\Support\Facades\Input;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commands = Command::with(['provider','materials'])->ordered(true)->get();

        

        return $commands->toJson();
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
    public function store(CommandRequest $request)
    {
        //
        $command = Command::create($request->all());
        $materials = Input::get('materials');

        $ids = array();
        $total_ttc = 0;

        foreach ($materials as $material) {
            # code...
            $mantant_facture = $material['pivot']['unite_price']*$material['pivot']['quantity'];
            $taux_euro = $mantant_facture + $material['pivot']['pret'];
            $taux_dinars = $taux_euro * $material['pivot']['euro_dinars'];
            $taux_achat = $taux_dinars + ($taux_dinars * $material['pivot']['taux_douane'] / 100) + $material['pivot']['transit_fees'];
            $calculed_price = $taux_achat / $material['pivot']['quantity'];
            //array_push($ids, [$material['id'] => ['quantity' => $material['pivot']['quantity']]]);
            $ids[$material['id']] = ['quantity' => $material['pivot']['quantity'],
                'unite_price' => $material['pivot']['unite_price'],
                'mantant_facture' => $mantant_facture,
                'pret' => $material['pivot']['pret'],
                'taux_euro' => $taux_euro,
                'euro_dinars' => $material['pivot']['euro_dinars'],
                'taux_dinars' => $taux_dinars,
                'taux_douane' => $material['pivot']['taux_douane'],
                'transit_fees' => $material['pivot']['transit_fees'],
                'taux_achat' => $taux_achat,
                'calculed_price' => $calculed_price
            ];
            $mat = material::find($material['id']);
            $mat->quantity = $pro->quantity + $material['pivot']['quantity'];
            $mat->quantity = ($mat->quantity + $calculed_price) /2;
            $mat->save();
            $total_ttc = $total_ttc + $taux_achat;
        }
        $command->materials()->attach($ids);
        $command->count_materials = $command->materials()->count();
        $command->total_price = $total_ttc;
        $command->save();
        /*$ids = array();

        foreach ($materials as $material) {
            $mat = Material::find($material['id']);
            if ($mat->quantity < $material['pivot']['quantity']) {
                $quantity = $mat->quantity;
            }
            else {
                $quantity = $material['pivot']['quantity'];
            }
            
            $ids[$material['id']] = ['quantity' => $quantity,
                'price' => $material['pivot']['price']
            ];
            
            $mat->quantity = $mat->quantity - $quantity;
            $mat->save();

        }


        
        $command->materials()->sync($ids);
        $command->count_materials = $command->materials()->count();*/
        $command->save();

        return $command->toJson();
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
        $command = Command::with(['provider','materials'])->find($id);

        return $command->toJson();
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
    public function update(CommandRequest $request, $id)
    {
        //
        $command = Command::find($id);
        $command->update($request->all());
        $materials = Input::get('materials');

        $ids = array();

        foreach ($command->materials as $material) {
            $material->quantity = $material->quantity + $material->pivot->quantity;
            $material->save();
        }
        $command->materials()->detach();

        foreach ($materials as $material) {
            $mat = Material::find($material['id']);
            if ($mat->quantity < $material['pivot']['quantity']) {
                $quantity = $mat->quantity;
            }
            else {
                $quantity = $material['pivot']['quantity'];
            }
            
            $ids[$material['id']] = ['quantity' => $quantity,
                'price' => $material['pivot']['price']
            ];
            
            $mat->quantity = $mat->quantity - $quantity;
            $mat->save();
        }
        $command->materials()->attach($ids);
        $command->count_materials = $command->materials()->count();
        $command->save();
        return $command->toJson();
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
        $command = Command::find($id);
        $command->actif = false;
        $command->save();

        return $command->toJson();
    }
}
