<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reminder;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * show dashboard summary
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

        return view("dashboard.index", compact('reminders', 'customers'));
    }
}
