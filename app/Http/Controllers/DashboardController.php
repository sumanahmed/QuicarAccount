<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * show dashboard summary
     */
    public function index () {
        return view("dashboard.index");
    }
}
