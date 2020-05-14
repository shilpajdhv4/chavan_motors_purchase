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

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:item_list|add_item_form|edit_item_list');
    }
    
    public function add_item_form(){
        $last_id='';
        $user_comp_id = Auth::user()->comp_id;
        $list = \App\ProductCategory::orderBy('id','asc')->where(['comp_id'=>$user_comp_id])->get();
        $prod_list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get();
        $item_last_id = \App\ItemList::orderBy('id','desc')->limit('1')->first();
        if($item_last_id=='' || $item_last_id==null)
        {
         $last_id=1;   
        }
        else
        {
         $last_id=$item_last_id->id + 1;     
        }
        return view('order.add_item_form',['list'=>$list,'prod_list'=>$prod_list,'last_id'=>$last_id]);
    }
    
    public function item_list(){
        $user_comp_id = Auth::user()->comp_id;
        $list = \App\ItemList::orderBy('id','asc')->where(['comp_id'=>$user_comp_id])->get();
        return view('order.item_list',['list'=>$list]);
    }
    
    
    
    public function save_item(Request $request)
    {
       $current_date=date("Y-m-d");
       $id = Auth::user()->id;
       $user_comp_id = Auth::user()->comp_id;
       $requestData = $request->all();
        if (!empty($requestData['prod_type'])) {
            $id = trim($requestData['item_desc']);
            if (\App\ItemList::where('item_desc', $id)->where(['comp_id'=>$user_comp_id])->exists()) {
                    Session::flash('alert-danger', 'Item Desc Already exists!');
                    return redirect('add_item_form');
            }else{
                $requestData['user_id']=$id;
                $requestData['comp_id'] = $user_comp_id;
                $requestData['inserted_date']=$current_date;
                    \App\ItemList::create($requestData);
                    Session::flash('alert-success', 'Saved Successfully.');
                    return redirect('item_list');
            }
        }
    }
    
    public function edit_item_list(Request $request)
    {
            $id = $_GET['id'];
            $user_comp_id = Auth::user()->comp_id;
            $data = \App\ItemList::where(['id'=>$id])->where(['comp_id'=>$user_comp_id])->first();
            $list = \App\ProductCategory::where(['comp_id'=>$user_comp_id])->orderBy('id','asc')->get();
            $prod_list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get();
            return view('order.edit_item_list',['data'=>$data,'list'=>$list,'prod_list'=>$prod_list]);
       
    }
    
    public function update_item_list(Request $request,$id)
    {
//        echo $id;
            $requestData = $request->all();
            $user_comp_id = Auth::user()->comp_id;
//            echo "<pre>";print_r($requestData);exit;
            $current_date=date("Y-m-d");
            $id2 = Auth::user()->id;
            $users = \App\ItemList::findorfail($id);
            $requestData['modified_at'] = date("Y-m-d h:i:s");
            $requestData['user_id'] = $id2;
            $requestData['comp_id'] = $user_comp_id;
            $users->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
            return redirect('item_list');
       
    }
    
  

}