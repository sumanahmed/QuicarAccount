<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use App\Models\Owner;

class OwnerController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('owners')->select('*');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }

        $owners = $query->get();
        
        return view('owner.index', compact('owners'));
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

            $owner               = new Owner();
            $owner->name         = $request->name;
            $owner->phone        = $request->phone;
            $owner->car_type_id  = $request->car_type_id;
            $owner->model_id     = $request->model_id;
            $owner->year_id      = $request->year_id;
            $owner->driver_id    = $request->driver_id;
            $owner->contract_amount  = $request->contract_amount;
            $owner->save();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $owner
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $owner
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

            $owner          = Owner::find($request->id);
            $owner->name         = $request->name;
            $owner->phone        = $request->phone;
            $owner->car_type_id  = $request->car_type_id;
            $owner->model_id     = $request->model_id;
            $owner->year_id      = $request->year_id;
            $owner->driver_id    = $request->driver_id;
            $owner->contract_amount  = $request->contract_amount;
            $owner->update();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $owner
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $owner
        ]); 
    }

    //destroy
    public function destroy(Request $request){
        Owner::find($request->id)->delete();
        return response()->json();
    }
}
