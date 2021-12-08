<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use App\Models\Customer;
use App\Models\CarType;
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
                        'rents.price','rents.fuel_cost','rents.driver_get','rents.other_cost',
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

        $car_types = CarType::all();
        
        return view('accounts.income', compact('car_types','incomes'));
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
                    ->leftjoin('expenses','rents.id','expenses.rent_id')
                    ->leftjoin('car_types','rents.car_type_id','car_types.id')
                    ->select('rents.*','car_types.name as car_type_name')
                    ->orderBy('rents.id','DESC')
                    ->where('rents.status', 3);

        if ($start_date && $end_date) {
            $query = $query->whereBetween('expenses.date', [$start_date, $end_date]);
        }

        if ($request->car_type_id) {
            $query = $query->where('rents.car_type_id', $request->car_type_id);
        }

        $expenses   = $query->paginate(20)->appends(request()->query());
        $car_types  = CarType::all();
        
        return view('accounts.expense', compact('expenses','car_types'));
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
