<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
         $this->middleware('permission:list-department|add-department|edit-department|delete-department');
        //$this->middleware('auth');
    }
    
    public function departmentValidate($id,$id1) {
        $id = trim($id);
        if (\App\DepartmentDetails::where('depart_name', $id)->where(['is_active'=>0,'comp_id'=>$id1])->exists()) {
            echo "Department Name Already exists!";
        }
    } 
    
    public function locValidate($id){
        $id = trim($id);
//        if (\App\Location::where('loc_name', $id)->where('comp_id',$id1)->exists()) {
        if (\App\Location::where('loc_name', $id)->exists()) {
            echo "Location Already exists!";
        }
    }

    public function listDepartment(){
      //  $department = \App\DepartmentDetails::where(['is_active'=>0])->get();
         $department = DB::table('tbl_depart_details')
                  ->select('tbl_depart_details.*','tbl_company_master.company_name')
                  ->leftjoin('tbl_company_master','tbl_company_master.company_id','tbl_depart_details.comp_id')
                  ->where(['tbl_depart_details.is_active'=>0])
                  ->get();
        return view('department.list_dept',['department'=>$department]);
    }
  
    public function addDepartment(){
        $company_det = \App\Company::select('company_id','company_name')->get();
        return view('department.add_department',['company_det'=>$company_det]);
    }
    
    public function saveDepartment(Request $request){
        $requestData = $request->all();
       // $requestData['user_id'] = Auth::user()->id;
        $id = trim($requestData['depart_name']);
        if (\App\DepartmentDetails::where('depart_name', $id)->where(['comp_id'=>$requestData['comp_id'],'is_active'=>0])->exists()) {
			Session::flash('alert-danger', 'Department Already exists!');
			return redirect('add-department');
        }else{
        \App\DepartmentDetails::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
		return redirect('list-department');
		}
        
    }
   
    public function editDepartment(){
        $id = $_GET['id'];
        $department = \App\DepartmentDetails::where(['id'=>$id])->first();
        $company_det = \App\Company::select('company_id','company_name')->get();
        return view('department.edit_department',['department'=>$department,'company_det'=>$company_det]);
    }
    
    public function updateDepartment(Request $request){
        $requestData = $request->all();
        $id = $requestData['loc_id'];
        $location = \App\DepartmentDetails::where(['id'=>$id])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('list-department');
    }
    
    public function deleteDepartment($id){
        $query= \App\DepartmentDetails::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('list-department');
    }
    
}