<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Command;

use App\Http\Requests\CommandRequest;

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
        $commands = Command::with(['provider','materials'])->ordered()->get();

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
        /*$command->full_name = $request->full_name;
        $command->nrc = $request->nrc;
        $command->nif = $request->nif;
        $command->na = $request->na;
        $command->address = $request->address;
        $command->phone = $request->phone;
        $command->fax = $request->fax;*/
        //$command->save();

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
        $commands = Command::with(['provider','materials'])->find($id);

        return $commands->toJson();
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
