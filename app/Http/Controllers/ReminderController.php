<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Customer;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Auth;
use DB;

class ReminderController extends Controller
{
    /**
     * show all reminder
     */
    public function index (Request $request) 
    {
        $query = DB::table('reminders');

        if ($request->customer_id) {
            $query = $query->where('customer_id', $request->customer_id);
        }

        if ($request->car_type_id) {
            $query = $query->where('car_type_id', $request->car_type_id);
        }

        $reminders = $query->paginate(12);
        $car_types = CarType::all();
        $customers = Customer::all();

        return view('reminder.index', compact('reminders','car_types', 'customers'));
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
        $this->validate($request,[
            'car_type_id'   => 'required'
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
            $reminder->rent_type            = $request->rent_type;
            $reminder->pickup_location      = $request->pickup_location;
            $reminder->pickup_datetime      = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
            $reminder->drop_location        = $request->drop_location;
            $reminder->drop_datetime        = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
            $reminder->asking_price         = $request->asking_price;
            $reminder->user_offered         = $request->user_offered;
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
        $car_types  = CarType::all();

        return view('reminder.edit', compact('reminder','car_types'));
    }

    /**
     * rent update
     */
    public function update(Request $request, $id) 
    {
        $this->validate($request,[
            'car_type_id'   => 'required'
        ]);
        
        $reminder                       = Reminder::find($id);
        $reminder->customer_id          = $reminder->customer_id;
        $reminder->car_type_id          = $request->car_type_id;
        $reminder->total_person         = $request->total_person;
        $reminder->rent_type            = $request->rent_type;
        $reminder->pickup_location      = $request->pickup_location;
        $reminder->pickup_datetime      = isset($request->pickup_datetime) ? date('Y-m-d H:i:s', strtotime($request->pickup_datetime)) : Null;
        $reminder->drop_location        = $request->drop_location;
        $reminder->drop_datetime        = isset($request->drop_datetime) ? date('Y-m-d H:i:s', strtotime($request->drop_datetime)) : Null;
        $reminder->asking_price         = $request->asking_price;
        $reminder->user_offered         = $request->user_offered;
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
}
