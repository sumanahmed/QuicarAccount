<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CarType;
use Validator;
use Response;
use DB;

class CarTypeController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('car_types')->select('*');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        $car_types = $query->paginate(12);
        return view('setting.car_type.index', compact('car_types'));
    }

    //store
    public function store(Request $request){
        $validators=Validator::make($request->all(),[
            'name' => 'required'
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $car_type         = new CarType();
            $car_type->name   = $request->name;
            if($car_type->save()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $car_type
                ]);
            }else{
                return Response::json([
                    'status'        => 403,
                    'data'          => []
                ]);
            }
        }
    }

    //update
    public function update(Request $request){
        $validators=Validator::make($request->all(),[
            'name' => 'required'
        ]);
        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }else{
            $car_type         = CarType::find($request->id);
            $car_type->name   = $request->name;
            if($car_type->update()){
                return Response::json([
                    'status'    => 201,
                    'data'      => $car_type
                ]);
            }else{
                return Response::json([
                    'status'        => 403,
                    'data'          => []
                ]);
            }
        }
    }

    //destroy
    public function destroy(Request $request){
        CarType::find($request->id)->delete();
        return response()->json();
    }
}
