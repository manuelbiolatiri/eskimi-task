<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::with('images')->get()->toArray();
        return array_reverse($campaigns);    
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
    public function store(Request $request)
    {
 
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'from' => "required",
            'to' => "required",
            'daily_budget' => "required",
            'total_budget' => "required",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => "The given data was invalid.", 'errors' =>$errors],422);
        }
        $campaign = new Campaign([
            'name' => $request->input('name'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'daily_budget' => $request->input('daily_budget'),
            'total_budget' => $request->input('total_budget')
        ]);
        $campaign->save();

        return response()->json(['campaign' => $campaign],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        $images = $campaign->images;
        return response()->json($campaign);
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'from' => "required",
            'to' => "required",
            'daily_budget' => "required",
            'total_budget' => "required",
        ]);
        $campaign = Campaign::find($id);
        $campaign->update($request->all());

        return response()->json('Campaign updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::find($id);
        $campaign->delete();

        return response()->json('Campaign deleted!');
    }
}
