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
                    ->join('rents','incomes.rent_id','rents.id')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->select('incomes.*','rents.pickup_datetime','car_types.name as car_type_name',
                        'rents.price','rents.fuel_cost','rents.driver_get','rents.other_cost',
                        'rents.car_type_id','rents.pickup_datetime'
                    )
                    ->whereBetween('date', [$start_date, $end_date])
                    ->orderBy('rents.pickup_datetime','DESC');
                    
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
        
        $car_types = CarType::all();
        $incomes = $query->get();
        
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
        
        $query = DB::table('expenses')
                    ->join('users','expenses.user_id','users.id')
                    ->join('rents','expenses.rent_id','rents.id')
                    ->join('car_types','rents.car_type_id','car_types.id')
                    ->select('expenses.*','rents.pickup_datetime','car_types.name as car_type_name',
                        'rents.price','rents.fuel_cost','rents.driver_get','rents.other_cost',
                        'rents.car_type_id', 'users.name as expense_by'
                    )
                    ->orderBy('expenses.id','DESC');

        if ($request->date) {
            $query = $query->where('expenses.date', 'like', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->car_type_id) {
            $query = $query->where('expenses.car_type_id', $request->car_type_id);
        }

        $expenses   = $query->get();
        $car_types  = CarType::all();
        
        return view('accounts.expense', compact('expenses','car_types'));
    }

    /**
     * show summary
     */
    public function summary (Request $request) 
    {
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;

        // $expenses = DB::table('expenses')
        //             ->select('rent_id', DB::raw('SUM(amount) as amount'))
        //             ->groupBy('rent_id')
        //             ->whereBetween('date', [$start_date, $end_date])
        //             ->orderBy('rent_id', 'DESC')
        //             ->get();

        // $incomes = DB::table('incomes')
        //             ->select('rent_id', DB::raw('SUM(amount) as amount'))
        //             ->groupBy('rent_id')
        //             ->orderBy('id','DESC')
        //             ->whereBetween('date', [$start_date, $end_date])
        //             ->orderBy('rent_id', 'DESC')
        //             ->get();

        // $total_expense = Expense::whereBetween('date', [$start_date, $end_date])->sum('amount');
        // $total_income  = Income::whereBetween('date', [$start_date, $end_date])->sum('amount');
        
        $records = DB::table('rents')
                    ->leftJoin('incomes','rents.id','incomes.rent_id')
                    ->leftJoin('expenses','rents.id','expenses.rent_id')
                    ->select('rents.id as rent_id', 'rents.pickup_datetime','rents.price',
                            DB::raw('SUM(expenses.amount) as expense'), 
                            DB::raw('SUM(incomes.amount) as income')
                    )
                    ->whereDate('rents.pickup_datetime', '>=', $start_date)
                    ->whereDate('rents.pickup_datetime', '<=', $end_date)
                    ->groupBy('rents.id', 'rents.pickup_datetime','rents.price')
                    ->orderBy('rents.pickup_datetime', 'DESC')
                    ->get();
  
        return view('accounts.summary', compact('records'));
    }
}
