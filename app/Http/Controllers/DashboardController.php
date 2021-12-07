<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MaintenanceCharge;
use App\Models\Reminder;
use App\Models\Rent;
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
        $next_date  = date('Y-m-d', strtotime($start_date. " +1 days"));

        $days_ago_31 = date('Y-m-d', strtotime('-31 days', strtotime($start_date)));
        
        $current_month_first_date = date('Y-m-01');
        $current_month_last_date = date('Y-m-d');
        
        $data['new_rent'] = Rent::where('status', 1)->count('id');
        $data['complete_rent'] = Rent::where('status', 3)->count('id');
        $data['today_reminder'] =  DB::table('reminders')->whereDate('next_contact_datetime', '=', $start_date)->count('id');
        $data['tomorrow_reminder'] =  DB::table('reminders')->whereDate('next_contact_datetime', '=', $next_date)->count('id');
        
        $first_date_prev_month = date("Y-n-j", strtotime("first day of previous month"));
        $last_date_prev_month  = date("Y-n-j", strtotime("last day of previous month"));
        
        $prev_month_income =  DB::table('incomes')
                                    ->join('rents','incomes.rent_id','rents.id')
                                    ->whereDate('rents.pickup_datetime', '>=', $first_date_prev_month)
                                    ->whereDate('rents.pickup_datetime', '<=', $last_date_prev_month)
                                    ->sum('rents.price');        
        
        $prev_month_expense =  DB::table('incomes')
                                    ->join('rents','incomes.rent_id','rents.id')
                                    ->whereDate('rents.pickup_datetime', '>=', $first_date_prev_month)
                                    ->whereDate('rents.pickup_datetime', '<=', $last_date_prev_month)
                                    ->sum(\DB::raw('rents.fuel_cost + rents.driver_get + rents.other_cost'));
                                    
        $data['prev_month_earn'] =  ($prev_month_income - $prev_month_expense);
                                    
        $current_month_income =  DB::table('incomes')
                                    ->join('rents','incomes.rent_id','rents.id')
                                    ->whereDate('rents.pickup_datetime', '>=', $current_month_first_date)
                                    ->whereDate('rents.pickup_datetime', '<=', $current_month_last_date)
                                    ->sum('rents.price');        
        
        $current_month_expense =  DB::table('incomes')
                                    ->join('rents','incomes.rent_id','rents.id')
                                    ->whereDate('rents.pickup_datetime', '>=', $current_month_first_date)
                                    ->whereDate('rents.pickup_datetime', '<=', $current_month_last_date)
                                    ->sum(\DB::raw('rents.fuel_cost + rents.driver_get + rents.other_cost'));
                                    
        $data['current_month_earn'] =  ($current_month_income - $current_month_expense);
        
        
        $total_income  =  Income::sum('amount');
        $total_expense =  Expense::sum('amount');
        $maintenance_charge = MaintenanceCharge::sum('amount');

        $data['total_earn'] = $total_income;
        $data['net_cash']   = $total_income - ($total_expense + $maintenance_charge);

        $query = DB::table('reminders')
                    ->join('customers','reminders.customer_id','customers.id')
                    ->select('reminders.*','customers.name','customers.phone')
                    ->orderBy('reminders.id','desc');

        if ($request->day != 0) {
            $day = (int)$request->day;
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

        return view("dashboard.index", compact('data', 'reminders', 'customers'));
    }
}
