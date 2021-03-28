<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CarYearController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('years')->select('*');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        $years = $query->paginate(12);
        return view('setting.car_year.index', compact('years'));
    }
}
