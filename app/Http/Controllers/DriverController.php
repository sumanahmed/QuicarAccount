<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use App\Models\Driver;
use DB;

class DriverController extends Controller
{
    //show all
    public function index(Request $request){

        $query = DB::table('drivers')->select('*');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }

        $drivers = $query->get();

        return view('driver.index', compact('drivers'));
    }

    //store
    public function store(Request $request){

        $validators = Validator::make($request->all(),[
            'name'   => 'required',
            'phone'  => 'required',
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }

        try {

            $driver          = new Driver();
            $driver->name    = $request->name;
            $driver->phone   = $request->phone;
            $driver->save();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $driver
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $driver
        ]);            
    }

    //update
    public function update(Request $request){

        $validators = Validator::make($request->all(),[
            'name'   => 'required',
            'phone'  => 'required',
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }

        try {

            $driver          = Driver::find($request->id);
            $driver->name    = $request->name;
            $driver->phone   = $request->phone;
            $driver->update();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $driver
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $driver
        ]); 
    }

    //destroy
    public function destroy(Request $request){
        Driver::find($request->id)->delete();
        return response()->json();
    }
}
