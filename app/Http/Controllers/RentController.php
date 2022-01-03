<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\Year;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Rent;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplteRentExport;
use Illuminate\Http\Request;
use Validator;
use GuzzleHttp\Client;
use Exception;
use DB;
use Auth;
use PDF;
use Mail;
use Response;

class RentController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;

        $query = DB::table('rents')
                    ->leftjoin('car_types','rents.car_type_id','car_types.id')
                    ->leftjoin('customers','rents.customer_id','customers.id')
                    ->select('rents.*','customers.name as customer_name','customers.phone as customer_phone','car_types.name as car_type_name')
                    ->orderBy('rents.id', 'DESC')->where('rents.status', 1);

        if ($request->name) {
            $query = $query->where('rents.name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('rents.phone', $request->phone);
        }

        $query->whereDate('rents.created_at', '>=', $start_date)
                ->whereDate('rents.created_at', '<=', $end_date);
                
        $total_price    = $query->sum('rents.price');
        $total_advance  = $query->sum('rents.advance');
        $total_remaining= $query->sum('rents.remaining');

        $rents = $query->paginate(12)->appends(request()->query()); 

        return view('rent.new.index', compact('rents','total_price','total_advance','total_remaining'));
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
        
        
        /** Email Send Code Start */
        
            // $data["email"] = "suman777333@gmail.com";
            // $data["title"] = "From Autospire";
            // $data["body"] = "This is Demo mail";
      
            // $pdf = PDF::loadView('invoice', $rent);
      
            // Mail::send('invoice', $rent, function($message)use($data, $pdf) {
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"])
            //             ->attachData($pdf->output(), "Invoice-AS-".$id.".pdf");
            // });
            
        /** Email Send Code  End*/
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
            'model_id'      => 'required'
        ]);
        
        DB::beginTransaction();
        
        try {
            $rent                   = new Rent();
            $rent->car_type_id      = $request->car_type_id;
            $rent->model_id         = $request->model_id;
            $rent->year_id          = $request->year_id ? $request->year_id : null;
            $rent->customer_id      = $request->customer_id ? $request->customer_id : null;
            $rent->driver_id        = $request->driver_id ? $request->driver_id : null;
            $rent->reg_number       = $request->reg_number;
            $rent->total_person     = $request->total_person;
            $rent->total_day        = (int)$request->total_day;
            $rent->rent_type        = $request->rent_type;
            $rent->pickup_location  = $request->pickup_location;
            $rent->pickup_datetime  = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
            $rent->drop_location    = $request->drop_location;
            $rent->drop_datetime    = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
            $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
            $rent->price            = $request->price;
            $rent->advance          = $request->advance;
            $rent->commission       = $request->commission;
            $rent->remaining        = $request->remaining;
            $rent->referred_by      = $request->referred_by;
            $rent->note             = $request->note;
            $rent->created_by       = Auth::id();
            $rent->updated_by       = Auth::id();
            $rent->save();
            
            // $customer = $request->customer_id != null ? Customer::find($request->customer_id) : '';
            // $driver = $request->driver_id != null ? Driver::find($request->driver_id) : '';
                        
            // if ($request->rent_type == 1) {
            //     $rentType = 'Drop Only';
            // }elseif ($request->rent_type == 2) {
            //     $rentType = 'Round Trip';
            // }elseif ($request->rent_type == 3) {
            //     $rentType = 'Body Rent';
            // }elseif ($request->rent_type == 4) {
            //     $rentType = 'Monthly';
            // }
            
            // $pickup_date_time = isset($request->pickup_datetime) ? date('Y-m-d H:i', strtotime($request->pickup_datetime)) : "";
            // $msg = "Booking Confirmation, Car Type: ".$rent->CarType->name.", Car Model: ".$rent->CarModel->name.", Car Number: ".$request->reg_number.", Rent Type: ".$rentType.", Pickup Location: ".$request->pickup_location.", Date and Time: ".$pickup_date_time.", Drop Location: ".$request->drop_location.", Price: ".$request->price.", Advance: ".$request->advance.", Remaining: ".$request->remaining.", Customer Number: ".$customer->phone.", Driver Number: ".$driver->phone.". __ Autospire Logistics 01912278827";
         
            // if ($request->customer_id != null) {
            //     $client = new Client();            
            //     $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $customer->phone ."&message=".$msg);
            // } 
            
            // if ($request->driver_id != null) {
            //     $client = new Client();              
            //     $sms    = $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $driver->phone ."&message=".$msg);
            // }
            
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
     * show details page
     */
    public function details ($id) 
    {        
        $rent      = Rent::find($id);
        $car_types = CarType::all();
        $models    = CarModel::where('car_type_id', $rent->car_type_id)->get();
        $years     = Year::all(); 
        $customers = Customer::all(); 
        $drivers   = Driver::all(); 

        return view('rent.new.details', compact('rent','car_types','models','years','customers','drivers'));
    }

    /**
     * rent update
     */
    public function update(Request $request, $id) 
    {
        $this->validate($request,[
            'car_type_id'   => 'required',    
            'model_id'      => 'required'
        ]);
        
        $rent                   = Rent::find($id);
        $rent->car_type_id      = $request->car_type_id;
        $rent->model_id         = $request->model_id;
        $rent->year_id          = $request->year_id ? $request->year_id : null;
        $rent->customer_id      = $request->customer_id ? $request->customer_id : null;
        $rent->driver_id        = $request->driver_id ? $request->driver_id : null;
        $rent->reg_number       = $request->reg_number;
        $rent->total_person     = $request->total_person;
        $rent->total_day        = (int)$request->total_day;
        $rent->rent_type        = $request->rent_type;
        $rent->pickup_location  = $request->pickup_location;
        $rent->pickup_datetime  = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
        $rent->drop_location    = $request->drop_location;
        $rent->drop_datetime    = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
        $rent->referred_by      = $request->referred_by;
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
    public function destroy(Request $request)
    { 
        Income::where('rent_id', $request->id)->delete();
        Expense::where('rent_id', $request->id)->delete();
        Rent::find($request->id)->delete();
        return response()->json();
    }

    /**
     * status update
     */
    public function statusUpdate (Request $request) 
    {   
        $status = (int)$request->status;
        $driver_get = (float)$request->driver_get;
        $other_cost = (float)$request->other_cost;
        $fuel_cost  = (float)$request->fuel_cost;
        $toll_charge  = (float)$request->toll_charge;
        $total_km  = (float)$request->total_km;
       
        
        DB::beginTransaction();
        
        try {

            $rent = Rent::find($request->rent_id);

            if ($status == 3 && $rent->commission != 0) {
    
                $income             = new Income();
                $income->name       = 'Income From commission';
                $income->date       = date('Y-m-d');
                $income->amount     = $rent->commission;
                $income->rent_id    = $request->rent_id;
                $income->created_by = Auth::id();
                $income->updated_by = Auth::id();
                $income->save();
    
            }
    
            if ($status == 3 && $rent->price != 0) {

                $total_cost = ($other_cost + $fuel_cost + $driver_get + $toll_charge);
    
                $income             = new Income();
                $income->name       = 'Net Income After Cost';
                $income->date       = date('Y-m-d');
                $income->amount     = (float)($rent->price - $total_cost);
                $income->rent_id    = $request->rent_id;
                $income->created_by = Auth::id();
                $income->updated_by = Auth::id();
                $income->save();
    
            }
    
            if ($status == 3 && $driver_get != 0) {
                $this->addExpense($driver_get, 'Driver Cost', $request->rent_id);
            }
    
            if ($status == 3 && $other_cost != 0) {
                $this->addExpense($other_cost, 'Other Cost', $request->rent_id);
            }
            
            if ($status == 3 && $fuel_cost != 0) {
                $this->addExpense($fuel_cost, 'Fuel Cost', $request->rent_id);
            }
            
            if ($status == 3 && $toll_charge != 0) {
                $this->addExpense($toll_charge, 'Toll Charge', $request->rent_id);
            }
    
            $rent->status       = $status;
            $rent->driver_get   = $driver_get;
            $rent->fuel_cost    = $fuel_cost;
            $rent->other_cost   = $other_cost;
            $rent->toll_charge  = $toll_charge;
            $rent->total_km     = $total_km;
            $rent->update();   
            
            DB::commit();

        } catch (Exception $e) {
            
            DB::rollback();
            
            return redirect()->route('rent.index')->with('message','Something went wrong');
        }
        
        return redirect()->route('rent.index')->with('message','Rent status update successfully');
    }

    public function addExpense($amount, $title, $rent_id) {
        $expense             = new Expense();
        $expense->name       = $title;
        $expense->date       = date('Y-m-d');
        $expense->amount     = $amount;
        $expense->rent_id    = $rent_id;
        $expense->user_id    = Auth::id();
        $expense->created_by = Auth::id();
        $expense->updated_by = Auth::id();
        $expense->save();
    }
    
    //show all upcoming rent
    public function upcoming(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->join('customers','rents.customer_id','customers.id')
                    ->select('rents.*','customers.name as customer_name','customers.phone as customer_phone','car_types.name as car_type_name')
                    ->orderBy('rents.id', 'DESC')
                    ->where('status', 2);

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        if ($request->pickup_datetime) {
            $query = $query->whereDate('pickup_datetime', $request->pickup_datetime);
        }

        if ($request->car_type_id) {
            $query = $query->where('car_type_id', $request->car_type_id);
        }

        $rents = $query->paginate(12)->appends(request()->query());

        return view('rent.upcoming.index', compact('rents'));
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
            'model_id'      => 'required'
        ]);
        
        $rent                   = Rent::find($id);
        $rent->car_type_id      = $request->car_type_id;
        $rent->model_id         = $request->model_id;
        $rent->year_id          = $request->year_id ? $request->year_id : null;
        $rent->customer_id      = $request->customer_id ? $request->customer_id : null;
        $rent->driver_id        = $request->driver_id ? $request->driver_id : null;
        $rent->reg_number       = $request->reg_number;
        $rent->total_person     = $request->total_person;
        $rent->total_day        = (int)$request->total_day;
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
        $rent->other_cost       = $request->other_cost;
        $rent->note             = $request->note;
        $rent->updated_by       = Auth::id();
        
        if ($rent->update()) {
            return redirect()->route('rent.upcoming.index')->with('message','Rent update successfully');
        } else {
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    //show all cancel rent
    public function cancel(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->join('customers','rents.customer_id','customers.id')
                    ->select('rents.*','customers.name as customer_name','customers.phone as customer_phone','car_types.name as car_type_name')
                    ->orderBy('rents.id', 'DESC')
                    ->where('status', 4);

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        if ($request->pickup_datetime) {
            $query = $query->whereDate('pickup_datetime', $request->pickup_datetime);
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

        return view('rent.cancel.index', compact('rents'));
    }

    //show all complete rent
    public function complete(Request $request)
    {
        $today = date('Y-m-d');
        $query = DB::table('rents')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->join('customers','rents.customer_id','customers.id')
                    ->select('rents.*','customers.name as customer_name','customers.phone as customer_phone','car_types.name as car_type_name')
                    ->orderBy('rents.id', 'DESC')
                    ->where('status', 3);

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }
        
        if ($request->pickup_datetime) {
            $query = $query->whereDate('pickup_datetime', $request->pickup_datetime);
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

        return view('rent.complete.index', compact('rents'));
    }
    
    /**
     * Export Complte Rent
    */
    public function export ()
    {
        return Excel::download(new ComplteRentExport, 'complte_rent.xlsx');
    }

    /**
     * send sms
    */
    public function sendSMS (Request $request) 
    {
        $sms_for = $request->smsFor;
        $msg = $request->message;

        $client = new Client();

        if ($sms_for == 2) {
            $driver = Driver::find(Rent::find($request->rent_id)->driver_id);
            $phone = $driver->phone;
        } else {
            $customer = Customer::find(Rent::find($request->rent_id)->customer_id);
            $phone = $customer->phone;
        }
        
        $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $phone ."&message=".$msg);            
        
    }
}
