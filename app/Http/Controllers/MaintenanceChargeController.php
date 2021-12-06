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
    public function index (Request $request) {
        $query = DB::table('maintenance_charges');

        if ($request->purpose) {
            $query = $query->where('purpose', 'like', "{$request->purpose}%");
        }

        if ($request->date) {
            $query = $query->where('rents.date', $request->date);
        }

        $maintenances = $query->paginate(12)->appends(request()->query()); 

        return view('maintenance.index', compact('maintenances'));
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
