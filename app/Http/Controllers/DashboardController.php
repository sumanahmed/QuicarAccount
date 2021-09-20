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
        $start_date = date('Y-m-d');
        $end_date   = date('Y-m-d', strtotime($start_date. " +3 days"));
        $reminders  = DB::table('reminders')
                        ->join('customers','reminders.customer_id','customers.id')
                        ->select('reminders.*','customers.name','customers.phone')
                        ->orderBy('reminders.id','desc')
                        ->where('next_contact_datetime', '!=', null)
                        ->whereDate('next_contact_datetime', '>=', $start_date)
                        ->whereDate('next_contact_datetime', '<=', $end_date)
                        ->orderBy('next_contact_datetime','ASC')
                        ->get();

        return view("dashboard.index", compact('reminders'));
    }
}
