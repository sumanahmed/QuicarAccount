<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class AccountsController extends Controller
{
    /**
     * show income
     */
    public function income (Request $request) {
        $query = DB::table('incomes')->select('*')->orderBy('id','DESC');

        if ($request->date) {
            $query = $query->where('date', 'like', date('Y-m-d', strtotime($request->date)));
        }

        $incomes = $query->get();
        
        return view('accounts.income', compact('incomes'));
    }

    /**
     * show expense
     */
    public function expense (Request $request) {

        $query = DB::table('expenses')->join('users','expenses.user_id','users.id')
                    ->select('expenses.*','users.name as expense_by')
                    ->orderBy('id','DESC');

        if ($request->date) {
            $query = $query->where('date', 'like', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->user_id) {
            $query = $query->where('user_id', $request->user_id);
        }

        $expenses   = $query->get();
        $users      = User::all();
        return view('accounts.expense', compact('expenses','users'));
    }

    /**
     * show summary
     */
    public function summary (Request $request) {

        $start_date = isset($request->start_date) ? date('Y-m-d',strtotime($request->start_date)) : '1971-01-01';
        $end_date   = isset($request->end_date) ? date('Y-m-d',strtotime($request->end_date)) : date('Y-m-d');

        $expenses = DB::table('expenses')->join('users','expenses.user_id','users.id')
                    ->select('expenses.*','users.name as expense_by')
                    ->orderBy('expenses.id','DESC')
                    ->whereBetween('expenses.date', [$start_date, $end_date])
                    ->get();

        $incomes = DB::table('incomes')
                    ->select('*')
                    ->orderBy('id','DESC')
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();

        $total_expense = Expense::whereBetween('date', [$start_date, $end_date])->sum('amount');
        $total_income  = Income::whereBetween('date', [$start_date, $end_date])->sum('amount');
        
        return view('accounts.summary', compact('expenses','incomes','total_expense','total_income'));
    }
}
