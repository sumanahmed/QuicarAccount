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
use App\Exports\CompleteRentExport;
use App\Library\Helper;
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
        // $today = date('Y-m-d');
        // $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        // $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;

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

        if ($request->start_date && $request->end_date) {
            $query->whereDate('rents.pickup_datetime', '>=',  date('Y-m-d', strtotime($request->start_date)))
                    ->whereDate('rents.pickup_datetime', '<=',  date('Y-m-d', strtotime($request->end_date)));
        }
                
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
        ini_set('max_execution_time', 300);
        ini_set("memory_limit","512M");
        libxml_use_internal_errors(true);
        
        $rent = Rent::join('customers','rents.customer_id','customers.id')
                    ->select('customers.name','customers.phone','rents.*')
                    ->where('rents.id', $id)->first();
                    
        // return view('invoice2', compact('rent'));
        
        $pdf = PDF::loadView('invoice', compact('rent'));
        $pdf->setPaper('A4', 'Portrait');
        // return $pdf->stream("Invoice-AS".$id.".pdf");
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
        
        try {
            $rent                   = new Rent();
            $rent->outside_agent    = $request->outside_agent;
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
            // $rent->drop_datetime    = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
            $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
            $rent->price            = $request->price;
            $rent->advance          = $request->advance;
            $rent->commission       = $request->commission;
            $rent->remaining        = $request->remaining;
            $rent->referred_by      = $request->referred_by;

            $rent->rent             = (float) $request->rent;
            $rent->body_rent        = (float) $request->body_rent;
            $rent->fuel             = (float)$request->fuel;
            $rent->driver_accomodation  = (float)$request->driver_accomodation;
            $rent->total_vehicle    = (float)$request->total_vehicle;
            $rent->kilometer        = (float)$request->kilometer;

            $rent->note             = $request->note;
            $rent->created_by       = Auth::id();
            $rent->updated_by       = Auth::id();
            $rent->save();

            if ($request->customer_id != null) {

                $admin_mobile = '01711005548';
                $customer = Customer::find($request->customer_id);

                $sms = urlencode("অটোস্পায়ার থেকে গাড়ি বুকিং করার জন্য আপনাকে ধন্যবাদ। গাড়ির ধরন : ". $rent->CarType->name .", ট্যুর লোকেশান : ". $rent->drop_location .", তারিখ ও সময় : ". date('j F, Y, g:i a', strtotime($rent->pickup_datetime)) .", মোট ভাড়া : ". $rent->price ."  টাকা, অগ্রিম : ". $rent->advance ."  টাকা, বাকি আছে : ". ( $rent->price -  $rent->advance) ." টাকা। অটোস্পায়ার বদলে দিবে আপনার ট্রাভেল অভিজ্ঞতা। হেল্প : 01912278827 / 01614945969");

                Helper::sendSMS($customer->phone, $sms);
                Helper::sendSMS($admin_mobile, $sms);
            }
            
        } catch (Exception $ex) {
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
        $rent->outside_agent    = $request->outside_agent;
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
        // $rent->drop_datetime    = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $rent->return_datetime  = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
        $rent->price            = $request->price;
        $rent->advance          = $request->advance;
        $rent->commission       = $request->commission;
        $rent->remaining        = $request->remaining;
        $rent->referred_by      = $request->referred_by;

        $rent->rent             = (float) $request->rent;
        $rent->body_rent        = (float) $request->body_rent;
        $rent->fuel             = (float)$request->fuel;
        $rent->driver_accomodation  = (float)$request->driver_accomodation;
        $rent->total_vehicle    = (float)$request->total_vehicle;
        $rent->kilometer        = (float)$request->kilometer;

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

            $commission = $rent->commission != 0 ? $rent->commission : 0;

            if ($status == 3) {

                if ($rent->outside_agent == 1) {
                    $commnet_text   = "(From Outside Agent)";
                    $income_amount  = $commission;
                } else {
                    $commnet_text   = "(After Total Cost)";
                    $total_cost     = ($other_cost + $fuel_cost + $driver_get + $toll_charge);
                    $income_amount  = (float)($rent->price - $total_cost);
                }                
    
                $income             = new Income();
                $income->name       = 'Net Income '. $commnet_text;
                $income->date       = date('Y-m-d');
                $income->amount     = (float)$income_amount;
                $income->rent_id    = $request->rent_id;
                $income->created_by = Auth::id();
                $income->updated_by = Auth::id();
                $income->save();
    
            }

            if ($status == 3 && $rent->outside_agent == 2) {
    
                if ($driver_get != 0) {
                    $this->addExpense($driver_get, 'Driver Cost', $request->rent_id);
                }
        
                if ($other_cost != 0) {
                    $this->addExpense($other_cost, 'Other Cost', $request->rent_id);
                }
                
                if ($fuel_cost != 0) {
                    $this->addExpense($fuel_cost, 'Fuel Cost', $request->rent_id);
                }
                
                if ($toll_charge != 0) {
                    $this->addExpense($toll_charge, 'Toll Charge', $request->rent_id);
                }
            }
    
            $rent->status       = $status;
            $rent->driver_get   = $driver_get;
            $rent->fuel_cost    = $fuel_cost;
            $rent->other_cost   = $other_cost;
            $rent->toll_charge  = $toll_charge;
            $rent->total_km     = $total_km;
            $rent->update();   

            if ($status == 4 && $rent->customer_id != null) { // $status 4 mean cancel

                $admin_mobile = '01711005548';
                $customer = Customer::find($rent->customer_id);

                $sms = urlencode("আপনার বুকিং টি বাতিল করা হয়েছে। অনুগ্রহ করে আমাদের হেল্পলাইনে ফোন করুন। অটোস্পায়ার : 01912278827");

                Helper::sendSMS($customer->phone, $sms);
                Helper::sendSMS($admin_mobile, $sms);
            }

            if ($status == 3) { // status 3 mean complete

                $admin_mobile = '01711005548';

                $cash = ($rent->price - ($rent->driver_get + $rent->fuel_cost + $rent->toll_charge + $rent->other_cost));

                $sms = urlencode("ক্যাশ কালেকশন হয়েছে। গাড়ির ধরন : ". $rent->CarType->name .", যাত্রার তারিখ ও সময় : ". date('j F, Y, g:i a', strtotime($rent->pickup_datetime)) .", লোকেশন : ".$rent->drop_location.", ভাড়া : ". $rent->price ."  টাকা, ড্রাইভার : ". $rent->driver_get .", ফুয়েল : ". $rent->fuel_cost ." টাকা, টোল : ". $rent->toll_charge ." টাকা, অন্যান্য : ". $rent->other_cost ." টাকা, ক্যাশ : ". $cash ." টাকা। অটোস্পায়ার : 01912278827");

                Helper::sendSMS($admin_mobile, $sms);
            }
            
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
        // $rent->drop_datetime    = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
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
        return Excel::download(new CompleteRentExport, 'complete_rent.xlsx');
        
        // return Excel::raw('Complete Rent', function($excel) {
        //     $excel->sheet('Users', function($sheet) {
                
        //         $rents = Rent::join('customers', 'rents.customer_id','customers.id')
        //                     ->select('customers.name', 'phone')
        //                     ->where('rents.status', 3)
        //                     ->get();
                            
        //         foreach ($rents as $key => $rent) {
        //             $payload[] = array('name' => $rent['name'], 'mobile' => $value['phone']);
        //         }
        //         $sheet->fromArray($payload);
        //     });
        // })->download('xls');
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
