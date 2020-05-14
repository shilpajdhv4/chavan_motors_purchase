<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use File;
use Session;
use Excel;
use Samples;
use App\Imports\ImportUsers;
use Illuminate\Support\Facades\Auth;
use DB;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:vendor_list|add_vendor');
    }
    
    public function mobValidate($id) {
        $id = trim($id);
        $user_comp_id = Auth::user()->comp_id;
        if (\App\VendorList::where('mob_no', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
            echo "Mobile No Already exists!";
        }
    } 
    
     public function gstValidate($id) {
        $id = trim($id);
        $user_comp_id = Auth::user()->comp_id;
        if (\App\VendorList::where('gst_no', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
            echo "GST NO Already exists!";
        }
    } 
    
    public function panValidate($id) {
        $id = trim($id);
        $user_comp_id = Auth::user()->comp_id;
        if (\App\VendorList::where('pan_card_no', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
            echo "Pan Card No Already exists!";
        }
    } 
    
    public function add_vendor()
    {
       $user_comp_id = Auth::user()->comp_id;
       $list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get(); 
       return view('order.add_vendor',['product_type'=>$list]); 
    }
    
    public function save_vendor(Request $request)
    {
       $requestData = $request->all();
       $current_date=date("Y-m-d");
       $id = Auth::user()->id;
       $user_comp_id = Auth::user()->comp_id;
       if (!empty($requestData['vendor_name'])) {
			if (\App\VendorList::where('vendor_name', $id)->exists()) {
				Session::flash('alert-danger', 'Item Desc Already exists!');
				return redirect('add_item_form');
			}else{
           $requestData['user_id']=$id;
           $requestData['inserted_date']=$current_date;
           $requestData['comp_id'] = $user_comp_id;
           $requestData['product_type']= json_encode($requestData['product_type'],true);
           
            \App\VendorList::create($requestData);   

           
          Session::flash('alert-success', 'Saved Successfully.');
          return redirect('vendor_list');
			}
       }
    }
    
    public function get_item_no_vendor($vendor_name)
    {
        $vendor_list = \App\VendorList::select('item_desc','item_no')->where(['vendor_name'=>$vendor_name])->get();
        
        echo json_encode($vendor_list,true);
    }
    
    public function get_item_details_vendor($item_no)
    {
        $item_details = \App\VendorList::select('item_desc','price','qty')->where(['item_no'=>$item_no])->first();
        
        echo json_encode($item_details,true);
    }
    
    public function vendor_list()
    {
        $user_comp_id = Auth::user()->comp_id;
        $vendor_list = \App\VendorList::select('*')->where(['comp_id'=>$user_comp_id])->orderBy('id','asc')->get();
        return view('order.vendor_list',['vendor_list'=>$vendor_list]);
        
    }
    
    public function downloadFile($id) {
        $file = 'vendor_invoice/'.$id;
        $name = basename($file);
        return response()->download($file, $name);
    }
}