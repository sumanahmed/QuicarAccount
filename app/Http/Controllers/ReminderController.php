<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Customer;
use App\Models\Reminder;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Auth;
use DB;

class ReminderController extends Controller
{
    /**
     * show all reminder
     */
    public function index (Request $request) 
    {
        $query = DB::table('reminders')
                    ->join('customers','reminders.customer_id','customers.id')
                    ->select('reminders.*','customers.name','customers.phone')
                    ->orderBy('reminders.id','desc');

        if ($request->day != 0) {
            $day = (int)$request->day;
            $start_date = date('Y-m-d');
            $end_date = $day != 100 ? date('Y-m-d', strtotime($start_date. " + $day days")) : date('Y-m-d');
            $query = $query->where('next_contact_datetime', '!=', null)
                            ->whereDate('next_contact_datetime', '>=', $start_date)
                            ->whereDate('next_contact_datetime', '<=', $end_date);
        }        

        if ($request->customer_id) {
            $query = $query->where('customer_id', $request->customer_id);
        }

        $reminders = $query->paginate(12)->appends(request()->query());
        $customers = Customer::all();

        return view('reminder.index', compact('reminders','customers'));
    }

    /**
     * show create page
     */
    public function create () 
    {        
        $car_types = CarType::all();
        return view('reminder.create', compact('car_types'));
    }

    /**
     * store
     */
    public function store (Request $request) 
    {   
        $this->validate($request, [
            'car_type_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);
        
        DB::beginTransaction();
        
        try {

            $exist_customer = Customer::where('phone', $request->phone)->first();

            if ($exist_customer != null) {
                $customer_id = $exist_customer->id;
            } else {
                $customer = new Customer();
                $customer->name = $request->name;
                $customer->phone = $request->phone;
                $customer->save();

                $customer_id = $customer->id;
            }

            $reminder                       = new Reminder();
            $reminder->customer_id          = $customer_id;
            $reminder->car_type_id          = $request->car_type_id;
            $reminder->total_person         = $request->total_person;
            $reminder->total_day            = $request->total_day;
            $reminder->rent_type            = $request->rent_type;
            $reminder->pickup_location      = $request->pickup_location;
            $reminder->status               = $request->status;
            $reminder->pickup_datetime      = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
            $reminder->drop_location        = $request->drop_location;
            $reminder->drop_datetime        = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
            $reminder->return_datetime      = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
            $reminder->asking_price         = $request->asking_price;
            $reminder->user_offered         = $request->user_offered;
            $reminder->interested           = $request->interested;
            $reminder->contact_date         = date('Y-m-d', strtotime($request->contact_date));
            $reminder->driver_accomodation  = $request->driver_accomodation;
            $reminder->next_contact_datetime= $request->next_contact_datetime;
            $reminder->note                 = $request->note;
            $reminder->created_by           = Auth::id();
            $reminder->updated_by           = Auth::id();
            $reminder->save();
            
            DB::commit();
            
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error_message', $ex->getMessage());
        }
        
        return redirect()->route('reminder.index')->with('message','Reminder added successfully');
    }

    /**
     * show edit page
     */
    public function edit ($id) 
    {        
        $reminder   = Reminder::find($id);
        $customer   = Customer::find($reminder->customer_id);        
        $car_types  = CarType::all();

        return view('reminder.edit', compact('reminder', 'customer', 'car_types'));
    }

    /**
     * rent update
     */
    public function update(Request $request, $id) 
    {      
        $this->validate($request, [
            'car_type_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);

        $reminder = Reminder::find($id);

        if ($reminder->customer_id != null) {
            $customer = Customer::find($reminder->customer_id);
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->update();
        }

        $reminder                       = Reminder::find($id);
        $reminder->customer_id          = $reminder->customer_id;
        $reminder->car_type_id          = $request->car_type_id;
        $reminder->total_person         = $request->total_person;
        $reminder->total_day            = $request->total_day;
        $reminder->rent_type            = $request->rent_type;
        $reminder->pickup_location      = $request->pickup_location;
        $reminder->status               = $request->status;
        $reminder->pickup_datetime      = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
        $reminder->drop_location        = $request->drop_location;
        $reminder->drop_datetime        = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $reminder->return_datetime      = isset($request->return_datetime) ? date('Y-m-d H:i:s', strtotime($request->return_datetime)) : Null;
        $reminder->asking_price         = $request->asking_price;
        $reminder->user_offered         = $request->user_offered;
        $reminder->interested           = $request->interested;
        $reminder->contact_date         = date('Y-m-d', strtotime($request->contact_date));
        $reminder->driver_accomodation  = $request->driver_accomodation;
        $reminder->next_contact_datetime= $request->next_contact_datetime;
        $reminder->note                 = $request->note;
        $reminder->updated_by           = Auth::id();
        
        if ($reminder->update()) {
            return redirect()->route('reminder.index')->with('message','Rent update successfully');
        } else {
            return redirect()->back()->with('error_message','Sorry, something went wrong');
        }
    }

    /**
     * rent destroy
     */
    public function destroy(Request $request){ 
        Reminder::find($request->id)->delete();
        return response()->json();
    }

    /**
     * send sms
    */
    public function sendSMS (Request $request) 
    {
        $phone = $request->phone;
        $msg = $request->message;
        $client = new Client();            
        $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $phone ."&message=".$msg);
    }

    /**
     * details
    */
    public function details($id) 
    {
        $reminder = Reminder::find($id);
        $customer   = Customer::find($reminder->customer_id);        
        $car_types  = CarType::all();

        return view('reminder.details', compact('reminder', 'customer', 'car_types'));
    }
}
