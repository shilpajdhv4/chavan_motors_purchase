<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
         $this->middleware('permission:enq_location_list|enq_location_add|enq-location-edit');
        //$this->middleware('auth');
    }
    
     
    public function listLocation(){
//        $location = \App\Location::where(['is_active'=>0])->get();
        $location = DB::table('tbl_location')
                  ->select('tbl_location.*','tbl_company_master.company_name')
                  ->leftjoin('tbl_company_master','tbl_company_master.company_id','tbl_location.comp_id')
                  ->where(['tbl_location.is_active'=>0])
                  ->get();
        return view('enq_location.enq_location',['location'=>$location]);
    }
  
    public function addLocation(){
        $company_det = \App\Company::select('company_id','company_name')->get();
        return view('enq_location.add_location',['company_det'=>$company_det]);
    }
    
    public function saveLocation(Request $request){
        $requestData = $request->all();
		$id = trim($requestData['loc_name']);
//echo $id;;exit;
			if (\App\Location::where('loc_name', $id)->where(['is_active'=>0])->exists()) {
				//echo "if";exit;
				 Session::flash('alert-danger', 'Location Already exists!');
				return redirect('enq_location_add');
				
			}else{
        $requestData['user_id'] = Auth::user()->id;
        
        \App\Location::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_location_list');
			}
    }
   
    public function editLocation(){
        $id = $_GET['id'];
        $location = \App\Location::where(['loc_id'=>$id])->first();
        $company_det = \App\Company::select('company_id','company_name')->get();
        return view('enq_location.edit_location',['location'=>$location,'company_det'=>$company_det]);
    }
    
    public function updateLocation(Request $request){
        $requestData = $request->all();
        $id = $requestData['loc_id'];
        $location = \App\Location::where(['loc_id'=>$id])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enq_location_list');
    }
    
    public function deleteLocation($id){
        $query= \App\Location::where('loc_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_location_list');
    }
    
}