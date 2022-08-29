<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceCharge;
use DB;

class MaintenanceChargeController extends Controller
{
    /**
     * get all maintenance charges
    */
    public function index (Request $request) 
    {        
        $today = date('Y-m-d');
        $start_date = isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date))  : date('Y-m-d', strtotime('-31 days', strtotime($today)));
        $end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date )) : $today;
        
        $query = DB::table('maintenance_charges');

        if ($request->purpose) {
            $query = $query->where('purpose', 'like', "{$request->purpose}%");
        }
        
        $query = $query->whereBetween('date', [$start_date, $end_date]);

        $maintenances = $query->paginate(12)->appends(request()->query()); 
        
        $total_maintenace_charge= MaintenanceCharge::sum('amount');

        return view('maintenance.index', compact('start_date', 'end_date', 'maintenances', 'total_maintenace_charge'));
    }

    /**
     * show create page
    */
    public function create () {
        return view('maintenance.create');
    }

    /**
     * store
    */
    public function store (Request $request) 
    {
        $this->validate($request,[
            'date'        => 'required',    
            'purpose'     => 'required',
            'amount'      => 'required'
        ]);
                
        try {

            $data = $request->all();
            MaintenanceCharge::create($data);

        } catch (\Exception $ex) {
            
            return redirect()->back()->with('error_message', $ex->getMessage());
        }
        
        return redirect()->route('maintenance.index')->with('message','Maintenance Charge added successfully');
    }

    
    /**
     * show edit page
    */
    public function edit ($id) {
        $maintenance = MaintenanceCharge::find($id);
        return view('maintenance.edit', compact('maintenance'));
    }

    /**
     * update
    */
    public function update (Request $request, $id) 
    {
        $this->validate($request,[
            'date'        => 'required',    
            'purpose'     => 'required',
            'amount'      => 'required'
        ]);
                
        try {

            $data = $request->all();
            $maintenance = MaintenanceCharge::find($id);
            $maintenance->update($data);

        } catch (\Exception $ex) {
            
            return redirect()->back()->with('error_message', $ex->getMessage());
        }
        
        return redirect()->route('maintenance.index')->with('message','Maintenance Charge added successfully');
    }

    /**
     * destroy
    */
    public function destroy (Request $request) 
    {
        MaintenanceCharge::find($request->id)->delete();
        return response()->json();
    }
}
