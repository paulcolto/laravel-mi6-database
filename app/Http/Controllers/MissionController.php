<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mission = new \App\Mission;
        $agents = \App\Person::rightJoin('aliases', 'people.id', 'aliases.person_id')
        ->where('aliases.alias', 'like', '00%')
        ->distinct()
        ->pluck('name', 'people.id');

        // /resources/views/  mission/edit  .blade.php
        return view('mission/edit', compact('mission', 'agents'));
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mission = new \App\Mission;
        $mission->name = $request->input('name');
        $mission->year = $request->input('year');
        $mission->agent_id = $request->input('agent_id');

        $mission->save();

        return redirect()->route('mission.edit', $mission->id);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mission = \App\Mission::findOrFail($id);
        $agents = \App\Person::rightJoin('aliases', 'people.id', 'aliases.person_id')
        ->where('aliases.alias', 'like', '00%')
        ->distinct()
        ->pluck('name', 'people.id');

        // /resources/views/  mission/edit  .blade.php
        return view('mission/edit', compact('mission', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mission = \App\Mission::findOrFail($id);

        if($file = $request->file('image')) {
            $file->storeAs('missions', $file->getClientOriginalName(), 'uploads');
        
            $image = $mission->image ?: new \App\Image; // get the mission's image or prepare empty one
            $image->path = 'uploads/missions/'.$file->getClientOriginalName(); // set the path to the upload
            $image->save(); // save the image (automatically INSERTs the new one or UPDATEs the existing one)
        
            $mission->image_id = $image->id; // set the image_id of mission to the id of the image
        }
        
        $mission->name = $request->input('name');
        $mission->year = $request->input('year');
        $mission->agent_id = $request->input('agent_id');

        $mission->save();

        return redirect()->route('mission.edit', $mission->id);
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
    }
}
