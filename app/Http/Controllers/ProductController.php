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

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:add_product|enq_location_add|enq-location-edit');  
        $this->middleware('auth');
    }
  
    public function subcatValidate($id){
        $id = trim($id);
        $user_comp_id = Auth::user()->comp_id;
        if (\App\ProductCategory::where('product_name', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
            echo "Product Sub Category Already exists!";
        }
    }
    
    public function add_product()
    {
        $user_comp_id = Auth::user()->comp_id;
        $list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get();
        return view('order.add_product',['type'=>$list]);
    }
    
    public function save_product_cate(Request $request)
    {
        $requestData = $request->all();
        $user_comp_id = Auth::user()->comp_id;
        if (!empty($requestData['product_name'])) {
            $id = trim($requestData['product_name']);
//echo $id;;exit;
            if (\App\ProductCategory::where('product_name', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
                    //echo "if";exit;
                     Session::flash('alert-danger', 'Product Sub Category Already exists!');
                    return redirect('add_product');
            }else{
                $requestData['comp_id'] = $user_comp_id;
                \App\ProductCategory::create($requestData);
                Session::flash('alert-success', 'Saved Successfully.');
                return redirect('product_list');
            }
        }
    }
    
    public function product_list()
    {
        $user_comp_id = Auth::user()->comp_id;
        $list = \App\ProductCategory::orderBy('id','asc')->where(['comp_id'=>$user_comp_id])->get();
        return view('order.product_list',['list'=>$list]);
    }
    
    public function edit_product_list()
    {
        $id = $_GET['id'];
        $user_comp_id = Auth::user()->comp_id;
        $list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get();
        $data = \App\ProductCategory::where(['id'=>$id])->where(['comp_id'=>$user_comp_id])->first();
        return view('order.edit_product',['data'=>$data,'type'=>$list]);
    }
    
    public function edit_product_cate(Request $request,$id)
    {
        $requestData = $request->all();
        $user_comp_id = Auth::user()->comp_id;
        $users = \App\ProductCategory::findorfail($id);
        $requestData['comp_id'] = $user_comp_id;
        $requestData['modified_at'] = date("Y-m-d h:i:s");
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('product_list');
    }
    
    

}