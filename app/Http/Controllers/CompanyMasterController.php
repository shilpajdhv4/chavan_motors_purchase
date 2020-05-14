<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class CompanyMasterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        // $this->middleware('permission:enq_location_list|enq_location_add|enq-location-edit');
        //$this->middleware('auth');
    }
    
     
    public function listCompany(){
        $company_list = \App\Company::where(['is_active'=>0])->get();
        return view('company_master.company',['company_list'=>$company_list]);
    }
  
    public function addCompany(){
        return view('company_master.add_company');
    }
    
    public function saveCompany(Request $request){
        $requestData = $request->all();
        //    echo "<pre>";print_r($requestData);exit;
        $id = trim($requestData['company_name']);
        if (\App\Company::where('company_name', $id)->exists()) {
            Session::flash('alert-danger', 'Company Already exists!');
            return redirect('list-company');
        }else{
            if(isset($requestData['approval_level'])){
                $requestData['level_permission'] = json_encode($requestData['approval_level']);
            }
            if(isset($requestData['return_level'])){
                $requestData['return_permission'] = json_encode($requestData['return_level']);
            }
            \App\Company::create($requestData);
            Session::flash('alert-success', 'Added Successfully.');
            return redirect('list-company');
        }
    }
   
    public function editCompany(){
        $id = $_GET['id'];
        $company = \App\Company::where(['company_id'=>$id])->first();
        return view('company_master.edit_company',['company'=>$company]);
    }
    
    public function updateCompany(Request $request){
        $requestData = $request->all();
     ///   echo "<pre>";print_r($requestData);exit;
        $id = $requestData['company_id'];
        $location = \App\Company::where(['company_id'=>$id])->first();
        if(isset($requestData['approval_level'])){
            $requestData['level_permission'] = json_encode($requestData['approval_level']);
        }else{
            $requestData['level_permission'] = NULL;
        }
        if(isset($requestData['return_level'])){
            $requestData['return_permission'] = json_encode($requestData['return_level']);
        }else{
            $requestData['return_permission'] = NULL;
        }
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('list-company');
    }
    
    public function deleteCompany($id){
        $query= \App\Company::where('company_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('list-company');
    }
    
    public function validateCompany($id){
        if (\App\Company::where('company_name', $id)->exists()) {
            echo 'Company Already exists!';
        }
    }
    
}