<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Import\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Models\Customer;
use DB;
use Log;
class CustomerController extends Controller
{
    //show all
    public function index(Request $request)
    {
        $query = DB::table('customers')->select('*')->orderBy('name','ASC');

        if ($request->name) {
            $query = $query->where('name', 'like', "{$request->name}%");
        }

        if ($request->phone) {
            $query = $query->where('phone', $request->phone);
        }

        $customers = $query->paginate(12);

        return view('customer.index', compact('customers'));
    }

    /**
     * bulk customer upload
    */
    public function bulkUpload(Request $request)
    {  
        try {
                        
            $request->validate([
                'excel_file' => 'required'
            ]);
            Log::info("started");
            if($request->hasFile('excel_file')){

                $file       = $request->file('excel_file');
                $file_name  = time().".".$file->getClientOriginalExtension();
                $directory  = 'uploads/customer/excel_file/';
                $file->move($directory, $file_name);
                $file_path  = $directory.$file_name;
                
                Excel::import(new CustomerImport(), $file_path);

                unlink($file_path);
            }
            Log::info("endd");
        } catch (\Exception $ex) {

            return response()->json([
                'status' => 403,
                'data'   => $ex->getMessage(),
            ]);
        }  
            
        return response()->json([
            'status' => 201,
            'data'   => [],
        ]);
    }

    //store
    public function store(Request $request){

        $validators = Validator::make($request->all(),[
            'name'   => 'required',
            'phone'  => 'required',
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }

        try {

            $customer          = new Customer();
            $customer->name    = $request->name;
            $customer->phone   = $request->phone;
            $customer->save();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $customer
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $customer
        ]);            
    }

    //update
    public function update(Request $request){

        $validators = Validator::make($request->all(),[
            'name'   => 'required',
            'phone'  => 'required',
        ]);

        if($validators->fails()){
            return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);
        }

        try {

            $customer          = Customer::find($request->id);
            $customer->name    = $request->name;
            $customer->phone   = $request->phone;
            $customer->update();

        } catch (\Throwable $ex) {
            return Response::json([
                'status'    => false,
                'message'   => $ex->getMessage(),
                'data'      => $customer
            ]);
        }

        return Response::json([
            'status'    => true,
            'data'      => $customer
        ]); 
    }

    //destroy
    public function destroy(Request $request){
        Customer::find($request->id)->delete();
        return response()->json();
    }

    /**
     * Export Customer
    */
    public function export ()
    {
        return Excel::download(new CustomerExport, 'customer.xlsx');
    }
}
