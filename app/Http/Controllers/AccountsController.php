<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use App\Models\Customer;
use App\Models\CarType;
use App\Models\Rent;
use App\Models\MaintenanceCharge;
use Illuminate\Http\Request;
use DB;

class AccountsController extends Controller
{
    /**
     * show income
     */
    public function income (Request $request) 
    {
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;

        $query = DB::table('incomes')
                    ->leftjoin('rents','incomes.rent_id','rents.id')
                    ->leftjoin('car_types','rents.car_type_id','car_types.id')
                    ->select('incomes.*','rents.pickup_datetime','car_types.name as car_type_name','rents.id as rent_id',
                        'rents.price','rents.fuel_cost','rents.driver_get','rents.other_cost','rents.return_datetime',
                        'rents.toll_charge', 'rents.car_type_id','rents.pickup_datetime','rents.pickup_location','rents.drop_location'
                    )
                    ->orderBy('rents.pickup_datetime','DESC')
                    ->where('rents.status', 3);
                    
        if ($request->search_type == 1) { 
            $query = $query->whereDate('rents.pickup_datetime', '>=', $start_date)
                            ->whereDate('rents.pickup_datetime', '<=', $end_date);
        } 
        
        if ($request->search_type == 2) {
            $query = $query->whereBetween('incomes.date', [$start_date, $end_date]);
        }
        
        if ($request->car_type_id) {
            $query = $query->where('rents.car_type_id', $request->car_type_id);
        }
        
        $incomes = $query->paginate(20)->appends(request()->query());
        
        $total_price = $query->sum('price');
        
        $total_cost = $query->sum(DB::raw('fuel_cost + driver_get + other_cost + toll_charge'));
                            
        $total_income = $query->sum('amount');

        $car_types = CarType::all();
        
        return view('accounts.income', compact('car_types','incomes', 'total_price', 'total_cost', 'total_income'));
    }

    /**
     * show expense
     */
    public function expense (Request $request) 
    {
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;

        $query = DB::table('rents')
                    ->leftjoin('car_types','rents.car_type_id','car_types.id')
                    ->select('rents.*','car_types.name as car_type_name')
                    ->orderBy('rents.pickup_datetime','DESC')
                    ->where('rents.status', 3);

        if ($start_date && $end_date) {
            $query = $query->whereDate('rents.pickup_datetime', '>=', $start_date)
                            ->whereDate('rents.pickup_datetime', '<=', $end_date);
        }

        if ($request->car_type_id) {
            $query = $query->where('rents.car_type_id', $request->car_type_id);
        }
        
        $total_fuel_cost = $query->sum('fuel_cost');
        $total_other_cost = $query->sum('other_cost');
        $total_driver_get = $query->sum('driver_get');
        $total_toll_charge = $query->sum('toll_charge');
        
        $total_expense = $query->sum(DB::raw('rents.fuel_cost + rents.other_cost + rents.driver_get + rents.toll_charge'));
           
        $expenses   = $query->paginate(20)->appends(request()->query());
        
        $car_types  = CarType::all();
        
        return view('accounts.expense', compact('expenses','car_types', 'total_fuel_cost', 'total_other_cost', 'total_driver_get', 'total_toll_charge', 'total_expense'));
    }

    /**
     * show maintenance
     */
    public function maintenance (Request $request) 
    {        
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;
        
        $rents = Rent::whereDate('rents.pickup_datetime', '>=', $start_date)
                            ->whereDate('rents.pickup_datetime', '<=', $end_date)
                            ->where('status', 3);
        
        $total_price    = $rents->sum('rents.price');
        $total_expense  = $rents->sum(DB::raw('rents.fuel_cost + rents.other_cost + rents.driver_get + rents.toll_charge'));
        $total_income   = (float)($total_price - $total_expense);
        $total_maintenance = MaintenanceCharge::whereBetween('date', [$start_date, $end_date])->sum('amount');
        
        // $total_income = Income::whereBetween('date', [$start_date, $end_date])->sum('amount');
        // $total_expense =  Expense::whereBetween('date', [$start_date, $end_date])->sum('amount');
        
        $net_cash   = $total_income - $total_maintenance;

        return view('accounts.maintenance', compact('total_price', 'total_income', 'total_expense', 'total_maintenance', 'net_cash'));
    }

    /**
     * cash calculation
    */
    public function cash (Request $request)
    {
        
    }
    
    /**
     * show summary
     */
    public function summary (Request $request) 
    {        
        $query = DB::table('rents')
                    ->selectRaw('COUNT(id) as total_rent,
                        SUM(price) as total_price,
                        SUM(driver_get + toll_charge + fuel_cost + other_cost) as total_expense,
                        MONTH(pickup_datetime) month
                    ')
                    ->orderBy('pickup_datetime', 'DESC')
                    ->where('status', 3)
                    ->groupBy(DB::raw('MONTH(pickup_datetime)'));

        if ($request->month && $request->month != 0) {
            $query = $query->where(DB::raw('MONTH(pickup_datetime)'), $request->month);
        }

        if ($request->year && $request->year != 0) {
            $query = $query->where(DB::raw('YEAR(pickup_datetime)'), $request->year);
        }
                    
        $records = $query->get();

        return view('accounts.summary', compact('records'));
    }
}
