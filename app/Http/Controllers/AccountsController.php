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
use Illuminate\Support\Arr;

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
                    ->join('rents','incomes.rent_id','rents.id')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->select('incomes.*','rents.pickup_datetime','car_types.name as car_type_name','rents.id as rent_id',
                        'rents.price','rents.fuel_cost','rents.driver_get','rents.other_cost','rents.return_datetime', 'rents.outside_agent',
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
            $query = $query->whereIn('rents.car_type_id', $request->car_type_id);
        }

        if ($request->outside_agent) {
            $query = $query->where('rents.outside_agent', $request->outside_agent);
        }
        
        $incomes = $query->paginate(20)->appends(request()->query());

        $commission_income = $query->where('rents.outside_agent', 1)->sum('commission');
        
        $total_price = $query->sum('price');
        
        $company_price = $query->where('rents.outside_agent', 2)->sum('price');
        $total_cost = $query->where('rents.outside_agent', 2)->sum(DB::raw('fuel_cost + driver_get + other_cost + toll_charge'));
        
        $company_income = (float) $company_price - $total_cost;
                            
        $total_income = $query->sum('amount');

        $car_types = CarType::all();
        
        return view('accounts.income', compact('commission_income', 'company_income', 'car_types','incomes', 'total_price', 'total_cost', 'total_income'));
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
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->select('rents.*','car_types.name as car_type_name')
                    ->orderBy('rents.pickup_datetime','DESC')
                    ->where('rents.status', 3);
                    

        if ($start_date && $end_date) {
            $query = $query->whereDate('rents.pickup_datetime', '>=', $start_date)
                            ->whereDate('rents.pickup_datetime', '<=', $end_date);
        }

        if ($request->car_type_id) {
            $query = $query->whereIn('rents.car_type_id', $request->car_type_id);
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
        
        $total_rent     = $rents->sum('rents.price');
        $total_expense  = Expense::whereBetween('date', [$start_date, $end_date])->sum('amount');
        $total_maintenance = MaintenanceCharge::whereBetween('date', [$start_date, $end_date])->sum('amount');

        $income         = Income::whereBetween('date', [$start_date, $end_date])->get();
        $total_income   = $income->sum('amount');
        $company_income = $income->where('income_from', 2)->sum('amount');
        $commission     = $income->where('income_from', 1)->sum('amount');
        
        // $total_income = Income::whereBetween('date', [$start_date, $end_date])->sum('amount');
        // $total_expense =  Expense::whereBetween('date', [$start_date, $end_date])->sum('amount');
        
        $net_cash   = $total_income - $total_maintenance;

        return view('accounts.maintenance', compact('start_date', 'end_date', 'total_rent', 'total_income', 'total_expense', 'total_maintenance', 'net_cash', 'company_income', 'commission'));
    }

    /**
     * cash calculation
    */
    public function cash (Request $request)
    {  
        $query = DB::table('rents')
        ->leftjoin('incomes', 'rents.id', 'incomes.rent_id')
        ->leftjoin('expenses', 'rents.id', 'expenses.rent_id')
                    ->selectRaw('COUNT(rents.id) as total_trip,
                        SUM(rents.price) as total_price,
                        SUM(incomes.amount) as total_income,
                        SUM(expenses.amount) as total_cost,
                        MONTH(rents.pickup_datetime) month
                    ')
                    // ->orderBy('pickup_datetime', 'DESC')
                    ->where('rents.status', 3)
                    ->groupBy(DB::raw('MONTH(rents.pickup_datetime)'));

        if ($request->month && $request->month != 0) {
            $query = $query->where(DB::raw('MONTH(rents.pickup_datetime)'), $request->month);
        }

        if ($request->year && $request->year != 0) {
            $query = $query->where(DB::raw('YEAR(rents.pickup_datetime)'), $request->year);
        }

        if ($request->car_type_id) {
            $query = $query->whereIn('rents.car_type_id', $request->car_type_id);
        }
                    
        $rents = $query->get();

        // Maintenance Charge

        // $query2 = MaintenanceCharge::selectRaw('SUM(amount) as total_charge, MONTH(created_at) month')
        //                             ->groupBy(DB::raw('MONTH(created_at)'));

        $query2 = MaintenanceCharge::selectRaw('SUM(amount) as total_charge, MONTH(date) month')
                                    ->groupBy(DB::raw('MONTH(date)'));

        if ($request->month && $request->month != 0) {
            $query2 = $query2->where(DB::raw('MONTH(created_at)'), $request->month);
        }

        if ($request->year && $request->year != 0) {
            $query2 = $query2->where(DB::raw('YEAR(created_at)'), $request->year);
        }

        $charges = $query2->get();


        $records = $rents->filter(function ($obj) use ($charges) {

            $charge = Arr::first($charges, function($chargeObj, $index) use ($obj) {
                return $chargeObj['month'] == $obj->month;
            });

            $obj->total_charge = $charge ? $charge['total_charge'] : 0;

            return $obj;
        });

        $car_types = CarType::select('id', 'name')->get();
        
        return view('accounts.cash', compact('car_types', 'records'));
    }
    
    /**
     * show summary
     */
    public function summary (Request $request) 
    {        
        $query = DB::table('rents')
                    ->leftjoin('incomes', 'rents.id', 'incomes.rent_id')
                    ->leftjoin('expenses', 'rents.id', 'expenses.rent_id')
                    ->selectRaw('COUNT(rents.id) as total_rent,
                        SUM(rents.price) as total_price,
                        SUM(incomes.amount) as total_income,
                        SUM(expenses.amount) as total_expense,
                        MONTH(rents.pickup_datetime) month
                    ')
                    // ->orderBy('pickup_datetime', 'DESC')
                    ->where('rents.status', 3)
                    ->groupBy(DB::raw('MONTH(rents.pickup_datetime)'));

        if ($request->month && $request->month != 0) {
            $query = $query->where(DB::raw('rents.MONTH(pickup_datetime)'), $request->month);
        }

        if ($request->year && $request->year != 0) {
            $query = $query->where(DB::raw('YEAR(rents.pickup_datetime)'), $request->year);
        }

        if ($request->car_type_id) {
            $query = $query->whereIn('rents.car_type_id', $request->car_type_id);
        }
                    
        $car_types = CarType::select('id', 'name')->get();

        return view('accounts.summary', compact('car_types', 'records'));
    }
}
