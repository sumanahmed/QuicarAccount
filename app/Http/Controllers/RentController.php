<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\Year;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Income;
use App\Models\Rent;
use Illuminate\Http\Request;
use DB;
use Auth;

class RentController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('rents')->select('*')->orderBy('id', 'DESC');

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

        $rents = $query->paginate(12);

        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();     

        return view('rent.index', compact('rents','car_types','models','years'));
    }

    /**
     * show create page
     */
    public function create () 
    {        
        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all(); 
        $customers = Customer::all(); 
        $drivers   = Driver::all(); 

        return view('rent.create', compact('car_types','models','years','customers','drivers'));
    }

    /**
     * store
     */
    public function store (Request $request) 
    {   
        $rent                   = new Rent();
        $rent->car_type_id      = $request->car_type_id;
        $rent->model_id         = $request->model_id;
        $rent->year_id          = $request->year_id;
        $rent->customer_id      = $request->customer_id;
        $rent->driver_id        = $request->driver_id;
        $rent->reg_number       = $request->reg_number;
        $rent->total_person     = $request->total_person;
        $rent->rent_type        = $request->rent_type;
        $rent->status           = $request->status;
        $rent->pickup_location  = $request->pickup_location;
        $rent->pickup_datetime  = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
        $rent->drop_location    = $request->drop_location;
        $rent->drop_datetime    = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
        $rent->driver_accomodation = $request->driver_accomodation;
        $rent->start_date       = date('Y-m-d', strtotime($request->start_date));
        $rent->billing_date     = date('Y-m-d', strtotime($request->billing_date));
        $rent->note             = $request->note;
        $rent->created_by       = Auth::id();
        $rent->updated_by       = Auth::id();
        
        if ($rent->save()) {
            return redirect()->route('rent.index')->with('message','Rent added successfully');
        } else {
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * show create page
     */
    public function edit ($id) 
    {        
        $rent      = Rent::find($id);
        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all(); 
        $customers = Customer::all(); 
        $drivers   = Driver::all(); 

        return view('rent.edit', compact('rent','car_types','models','years','customers','drivers'));
    }

    /**
     * rent update
     */
    public function update(Request $request, $id) 
    {
        $rent                   = Rent::find($id);
        $rent->car_type_id      = $request->car_type_id;
        $rent->model_id         = $request->model_id;
        $rent->year_id          = $request->year_id;
        $rent->customer_id      = $request->customer_id;
        $rent->driver_id        = $request->driver_id;
        $rent->reg_number       = $request->reg_number;
        $rent->total_person     = $request->total_person;
        $rent->rent_type        = $request->rent_type;
        $rent->status           = $request->status;
        $rent->pickup_location  = $request->pickup_location;
        $rent->pickup_datetime  = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
        $rent->drop_location    = $request->drop_location;
        $rent->drop_datetime    = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
        $rent->driver_accomodation = $request->driver_accomodation;
        $rent->start_date       = date('Y-m-d', strtotime($request->start_date));
        $rent->billing_date     = date('Y-m-d', strtotime($request->billing_date));
        $rent->note             = $request->note;
        $rent->updated_by       = Auth::id();
        
        if ($rent->update()) {
            return redirect()->route('rent.index')->with('message','Rent update successfully');
        } else {
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * rent destroy
     */
    public function destroy(Request $request){ 
        Rent::find($request->id)->delete();
        return response()->json();
    }

    /**
     * status update
     */
    public function statusUpdate ($rent_id, $status) 
    {
        $rent = Rent::find($rent_id);

        if ($status == 3) {

            $income         = new Income();
            $income->name   = 'Income From commission';
            $income->date   = date('Y-m-d');
            $income->amount = $rent->commission;
            $income->amount = save();

        }

        $rent->status = $status;
        $rent->update();
    }

}
