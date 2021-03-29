<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Models\Owner;
use App\Models\Year;
use App\Models\CarModel;
use GuzzleHttp\Client;
use DB;

class OwnerController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('owners')
                    ->leftjoin('car_types','owners.car_type_id','car_types.id')
                    ->leftjoin('models','owners.model_id','models.id')
                    ->leftjoin('years','owners.year_id','years.id')
                    ->select('owners.*','car_types.name as car_type_name',
                        'models.name as model_name', 'years.name as year_name')
                    ->orderBy('owners.id', 'DESC');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }

        if ($request->car_type_id) {
            $query = $query->where('car_type_id', $request->car_type_id);
        }

        if ($request->model_id) {
            $query = $query->where('model_id', $request->model_id);
        }

        if ($request->year_id) {
            $query = $query->where('year_id', $request->year_id);
        }

        $owners = $query->paginate(12);
        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();        
        return view('owner.index', compact('owners','car_types','models','years'));
    }

    //store
    public function store(Request $request)
    {       
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
            $owner->address      = $request->address;
            $owner->car_type_id  = $request->car_type_id;
            $owner->model_id     = $request->model_id;
            $owner->year_id      = $request->year_id;
            $owner->driver_id    = isset($request->driver_id) ? $request->driver_id : Null;
            $owner->contract_amount  = $request->contract_amount;
            $owner->save();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => []
            ]);
        }

        $new_owner = DB::table('owners')
                ->leftjoin('car_types','owners.car_type_id','car_types.id')
                ->leftjoin('models','owners.model_id','models.id')
                ->leftjoin('years','owners.year_id','years.id')
                ->select('owners.*','car_types.name as car_type_name',
                    'models.name as model_name', 'years.name as year_name')
                ->where('owners.id', $owner->id)
                ->first();

        return Response::json([
            'status'    => true,
            'data'      => $new_owner
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
            $owner->address      = $request->address;
            $owner->car_type_id  = $request->car_type_id;
            $owner->model_id     = $request->model_id;
            $owner->year_id      = $request->year_id;
            $owner->driver_id    = isset($request->driver_id) ? $request->driver_id : Null;
            $owner->contract_amount  = $request->contract_amount;
            $owner->update();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $owner
            ]);
        }

        $new_owner = DB::table('owners')
                ->leftjoin('car_types','owners.car_type_id','car_types.id')
                ->leftjoin('models','owners.model_id','models.id')
                ->leftjoin('years','owners.year_id','years.id')
                ->select('owners.*','car_types.name as car_type_name',
                    'models.name as model_name', 'years.name as year_name')
                ->where('owners.id', $owner->id)
                ->first();

        return Response::json([
            'status'    => true,
            'data'      => $new_owner
        ]); 
    }

    //destroy
    public function destroy(Request $request){
        Owner::find($request->id)->delete();
        return response()->json();
    }

    /**
     * send sms
     */
    public function sendSMS (Request $request) 
    {  
        $owner = Owner::find($request->owner_id); 
        $client = new Client();            
        $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $owner->phone ."&message=".$request->sms);
    }
}
