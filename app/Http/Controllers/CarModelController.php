<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\CarType;
use Validator;
use Response;
use DB;

class CarModelController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('models')
                    ->join('car_types','models.car_type_id','car_types.id')
                    ->select('models.*','car_types.name as car_type_name');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->car_type_id) {
            $query = $query->where('car_type_id', $request->car_type_id);
        }

        $car_models = $query->paginate(12);
        $car_types  = CarType::all();
        return view('setting.car_model.index', compact('car_models','car_types'));
    }

    //store
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(),[
            'car_type_id'   => 'required',
            'name'          => 'required'
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        $car_model               = new CarModel();
        $car_model->name         = $request->name;
        $car_model->car_type_id  = $request->car_type_id;
        if($car_model->save()){

            $query = DB::table('models')
                    ->join('car_types','models.car_type_id','car_types.id')
                    ->select('models.*','car_types.name as car_type_name')
                    ->where('models.id', $car_model->id)
                    ->first();

            return Response::json([
                'status'    => 201,
                'data'      => $query
            ]);
        }else{
            return Response::json([
                'status'        => 403,
                'data'          => []
            ]);
        }            
    }

    //update
    public function update(Request $request)
    {
        $validators=Validator::make($request->all(),[
            'car_type_id'   => 'required',
            'name'          => 'required'
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }
        
        $car_model               = CarModel::find($request->id);
        $car_model->name         = $request->name;
        $car_model->car_type_id  = $request->car_type_id;

        if($car_model->update()){

            $query = DB::table('models')
                    ->join('car_types','models.car_type_id','car_types.id')
                    ->select('models.*','car_types.name as car_type_name')
                    ->where('models.id', $car_model->id)
                    ->first();

            return Response::json([
                'status'    => 201,
                'data'      => $query
            ]);
        }else{
            return Response::json([
                'status'        => 403,
                'data'          => []
            ]);
        }
            
    }

    //destroy
    public function destroy(Request $request){
        CarModel::find($request->id)->delete();
        return response()->json();
    }
}
