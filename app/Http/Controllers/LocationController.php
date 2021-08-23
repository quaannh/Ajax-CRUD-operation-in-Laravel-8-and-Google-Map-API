<?php

namespace App\Http\Controllers;
use App\Models\location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $map = location::get();
        return view('location.index',['map'=>$map]);
    }

    public function fetch()
    {
        $location = location::all();
        return response()->json([
            'location'=>$location,
        ]);
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
            'name'=> 'required|max:200',
            'lat'=>'required|max:200',
            'long'=>'required|max:200',
            'desc'=>'required|max:200',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $location = new location();
            $location->name = $request->input('name');
            $location->lat = $request->input('lat');
            $location->long = $request->input('long');
            $location->desc = $request->input('desc');
            $location->save();
            return response()->json([
                'status'=>200,
                'message'=>'Location Added Successfully.'
            ]);
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
        $location = location::find($id);
        if($location)
        {
            return response()->json([
                'status'=>200,
                'location'=> $location,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Location Found.'
            ]);
        }
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
            'name'=> 'required|max:200',
            'lat'=>'required|max:200',
            'long'=>'required|max:200',
            'desc'=>'required|max:200',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $location = location::find($id);
            if($location)
            {
                $location->name = $request->input('name');
                $location->lat = $request->input('lat');
                $location->long = $request->input('long');
                $location->desc = $request->input('desc');
                $location->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Location Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Location Found.'
                ]);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = location::find($id);
        if($location)
        {
            $location->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Location Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Location Found.'
            ]);
        }
    }
}
