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
use GuzzleHttp\Client;
use Exception;
use DB;
use Auth;
use PDF;

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

        $rents = $query->paginate(12)->appends(request()->query());

        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();     

        return view('rent.new.index', compact('rents','car_types','models','years'));
    }

    /**
     * show invoice
    */
    public function invoice ($id)
    {
        $rent = Rent::join('customers','rents.customer_id','customers.id')
                    ->select('customers.name','customers.phone','rents.*')
                    ->where('rents.id', $id)->first();
        
        $pdf = PDF::loadView('invoice', compact('rent'));
        $pdf->setPaper('A4', 'Portrait');
        //return $pdf->stream("Invoice-AS".$id.".pdf");
        return $pdf->download("Invoice-AS-".$id.".pdf");
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

        return view('rent.new.create', compact('car_types','models','years','customers','drivers'));
    }

    /**
     * store
     */
    public function store (Request $request) 
    {   
        $this->validate($request,[
            'car_type_id'   => 'required',    
            'model_id'      => 'required',    
            'year_id'       => 'required'
        ]);
        
        DB::beginTransaction();
        
        try {
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
            $rent->drop_datetime    = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
            $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
            $rent->price            = $request->price;
            $rent->advance          = $request->advance;
            $rent->commission       = $request->commission;
            $rent->remaining        = $request->remaining;
            $rent->note             = $request->note;
            $rent->created_by       = Auth::id();
            $rent->updated_by       = Auth::id();
            $rent->save();
            
            $customer = $request->customer_id != null ? Customer::find($request->customer_id) : '';
            $driver = $request->driver_id != null ? Driver::find($request->driver_id) : '';
            
            
            if ($request->rent_type == 1) {
                $rentType = 'Drop Only';
            }elseif ($request->rent_type == 2) {
                $rentType = 'Round Trip';
            }elseif ($request->rent_type == 3) {
                $rentType = 'Body Rent';
            }elseif ($request->rent_type == 4) {
                $rentType = 'Monthly';
            }
            
            $pickup_date_time = isset($request->pickup_datetime) ? date('Y-m-d H:i', strtotime($request->pickup_datetime)) : "";
            $msg = "Booking Confirmation, Car Type: ".$rent->CarType->name.", Car Model: ".$rent->CarModel->name.", Car Number: ".$request->reg_number.", Rent Type: ".$rentType.", Pickup Location: ".$request->pickup_location.", Date and Time: ".$pickup_date_time.", Drop Location: ".$request->drop_location.", Price: ".$request->price.", Advance: ".$request->advance.", Remaining: ".$request->remaining.", Customer Number: ".$customer->phone.", Driver Number: ".$driver->phone.". __ Autospire Logistics 01912278827";
         
            if ($request->customer_id != null) {
                $client = new Client();            
                $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $customer->phone ."&message=".$msg);
            } 
            
            if ($request->driver_id != null) {
                $client = new Client();              
                $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $driver->phone ."&message=".$msg);
            }
            
            DB::commit();
            
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error_message', $ex->getMessage());
        }
        
        return redirect()->route('rent.index')->with('message','Rent added successfully');
    }

    /**
     * show edit page
     */
    public function edit ($id) 
    {        
        $rent      = Rent::find($id);
        $car_types = CarType::all();
        $models    = CarModel::where('car_type_id', $rent->car_type_id)->get();
        $years     = Year::all(); 
        $customers = Customer::all(); 
        $drivers   = Driver::all(); 

        return view('rent.new.edit', compact('rent','car_types','models','years','customers','drivers'));
    }

    /**
     * rent update
     */
    public function update(Request $request, $id) 
    {
        $this->validate($request,[
            'car_type_id'   => 'required',    
            'model_id'      => 'required',    
            'year_id'       => 'required' 
        ]);
        
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
        $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
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
    public function statusUpdate (Request $request) 
    {
        $rent = Rent::find($request->rent_id);

        if ($request->status == 3) {

            $income             = new Income();
            $income->name       = 'Income From commission';
            $income->date       = date('Y-m-d');
            $income->amount     = $rent->commission;
            $income->amount     = $rent->commission;
            $income->created_by = Auth::id();
            $income->updated_by = Auth::id();
            $income->save();

        }

        $rent->status = $request->status;
        $rent->update();

        return redirect()->route('rent.index')->with('message','Rent status update successfully');
    }
    
    //show all upcoming rent
    public function upcoming(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->select('*')
                    ->whereDate('pickup_datetime', $today)
                    ->orderBy('id', 'DESC');

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

        $rents = $query->paginate(12)->appends(request()->query());

        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();     

        return view('rent.upcoming.index', compact('rents','car_types','models','years'));
    }
    
    
    /**
     * show edit page
     */
    public function upcomingEdit ($id) 
    {        
        $rent      = Rent::find($id);
        $car_types = CarType::all();
        $models    = CarModel::where('car_type_id', $rent->car_type_id)->get();
        $years     = Year::all(); 
        $customers = Customer::all(); 
        $drivers   = Driver::all(); 

        return view('rent.upcoming.edit', compact('rent','car_types','models','years','customers','drivers'));
    }
    
    /**
     * upcoming rent update
     */
    public function upcomingUpdate(Request $request, $id) 
    {
        $this->validate($request,[
            'car_type_id'   => 'required',    
            'model_id'      => 'required',    
            'year_id'       => 'required' 
        ]);
        
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
        $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
        $rent->driver_get       = $request->driver_get;
        $rent->driver_accomodation  = $request->driver_accomodation;
        $rent->fuel_cost        = $request->fuel_cost;
        $rent->toll_charge      = $request->toll_charge;
        $rent->note             = $request->note;
        $rent->updated_by       = Auth::id();
        
        if ($rent->update()) {
            return redirect()->route('upcoming.index')->with('message','Rent update successfully');
        } else {
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //show all cancel rent
    public function cancel(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->select('*')
                    ->whereDate('pickup_datetime', $today)
                    ->where('status', 4)
                    ->orderBy('id', 'DESC');

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

        $rents = $query->paginate(12)->appends(request()->query());

        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();     

        return view('rent.cancel.index', compact('rents','car_types','models','years'));
    }

    //show all cancel rent
    public function complete(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->select('*')
                    ->whereDate('pickup_datetime', $today)
                    ->where('status', 3)
                    ->orderBy('id', 'DESC');

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

        $rents = $query->paginate(12)->appends(request()->query());

        $car_types = CarType::all();
        $models    = CarModel::all();
        $years     = Year::all();     

        return view('rent.complete.index', compact('rents','car_types','models','years'));
    }
}
