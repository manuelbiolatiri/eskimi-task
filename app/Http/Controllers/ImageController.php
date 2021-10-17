<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
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
            'campaign_id' => "required",
            'image' => "required|image|max:1999",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                return response()->json(['status' => false,'message' => $message]);
            }
        }

        try{
            
            $campaign = Campaign::find($request->input('campaign_id'));
            if($campaign){
                $image = $request->file('image');
                $fileName = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileNameToStore = $fileName."_"."_".time(). ".".$extension;
                $path = $request->file('image')->storeAs('public/campaign-images/',$fileNameToStore);
                $image = Image::create([
                    'campaign_id' =>  $request->input('campaign_id'),
                    'url' =>  $fileNameToStore
                ]);
                return response()->json(['status'=>true,'image' => $image]);
            }else{
                return response()->json(['status'=>false,'message' =>'campaign not found']);
            }

        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();

        return response()->json('Image deleted!');
    }
}
