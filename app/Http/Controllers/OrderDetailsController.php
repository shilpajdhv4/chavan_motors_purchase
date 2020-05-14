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
use Illuminate\Support\Carbon;

class OrderDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('permission:add_product|product_list|edit_product_list');
//        $this->middleware('permission:storage_list|add_storage_location|add_storage_location|storage_location|order_list_to_tl|order_utilize_form|nofi_page|create_purchase_form|vendor_to_po_dept|checker_list');
//        $this->middleware('permission:order_form|order_list');
//         $this->middleware('permission:order_list|create_purchase_form', ['only' => ['index','show']]);
//         $this->middleware('permission:order_list', ['only' => ['create','store']]);
//         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
//         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
//        $this->user= Auth::user();
//        $this->user = Auth::user()->id;
//        print_r($emp_id=Auth::user()->id); 
//        exit();
            $this->middleware('auth');
//        print_r($emp_id=Auth::user()->id); 
//       exit();
    }
  
    
    public function index(){
//        echo $id = Auth::user()->id;
        $user_comp_id = Auth::user()->comp_id;
//        $product_grp_list = \App\ProductCategory::select('product_type')->where(['comp_id'=>$user_comp_id])->groupBy('product_type')->get();
         $product_grp_list = \App\ProductCategory::select('product_type','product_name')->groupBy('product_type')->get();
         
        return view('order.order_form',['prod_type'=>$product_grp_list]);
    }
    
    public function nofi_page(){
//        $user_comp_id = Auth::user()->comp_id;
//        $noti_data=DB::table('tbl_order')
//            ->select('tbl_item.item_no', 'tbl_item.item_desc','tbl_item.qty AS stock_qty','tbl_item.threshold_qty',DB::raw('SUM(tbl_order.qty) AS order_qty'))
//            ->leftjoin('tbl_item', 'tbl_order.item_no', '=', 'tbl_item.item_no')
//            ->groupBy('tbl_item.item_no')
//            ->groupBy('tbl_item.item_desc')
//            ->groupBy('tbl_item.qty')
//            ->groupBy('tbl_item.threshold_qty')
//            ->where(['tbl_order.purchase_status'=>1,'tbl_item.comp_id'=>$user_comp_id,])
//            ->get();
//        echo "<pre>";print_r($noti_data);
//        exit();
        return view('order.nofi_page');//,['list'=>$noti_data]);
    }
    
    public function get_product_grp($type_item)
    {
        $type_item = trim($type_item);
        $user_comp_id = Auth::user()->comp_id;
//        $product_grp_list = \App\ProductCategory::select('product_name','product_type')->where(['product_type'=>$type_item,'comp_id'=>$user_comp_id])->groupBy('product_type')->groupBy('product_name')->get();
        $product_grp_list = \App\ProductCategory::select('product_name','product_type')->where(['product_type'=>$type_item])->groupBy('product_type')->groupBy('product_name')->get();
        echo json_encode($product_grp_list,true);
    }
    
    public function get_product_grp1($type_item)
    {
        $data_arr = array();
        $type_item = trim($type_item);
        $user_comp_id = Auth::user()->comp_id;
//        echo $type_item;exit;
//        $product_grp_list = \App\ProductCategory::select('product_name','product_type')->where(['product_type'=>$type_item,'comp_id'=>$user_comp_id])->groupBy('product_type')->groupBy('product_name')->get();
        $product_grp_list = \App\ProductCategory::select('product_name','product_type')->where(['product_type'=>$type_item])->groupBy('product_type')->groupBy('product_name')->get();
      //  echo "<pre>";print_r($product_grp_list);exit;
        $vendor_data = DB::table("tbl_vendor")
                ->select("vendor_name","id")
//                ->whereRaw('FIND_IN_SET("'.$type_item.'", product_type)')
                ->where('product_type', 'like', '%"'.$type_item.'"%')
//                ->where(['comp_id'=>$user_comp_id])
                ->get();
//                \DB::table('tbl_vendor')->whereRaw(
//                'JSON_CONTAINS("$.product_type",\'["$type_item"]\')'
//            )->get();
//        $vendor_data = DB::table("tbl_vendor")
           // ->select("vendar_name","id")
//            ->whereRaw(FIND_IN_SET($type_item, 'product_type'))
//            ->whereRaw("FIND_IN_SET($type_item,product_type)")
//              ->whereJsonContains("product_type", $type_item)
//              ->get();
//        echo "<pre>";print_r($vendor_data);exit;
        $data_arr['product'] = $product_grp_list;
        $data_arr['vendor'] = $vendor_data;
        echo json_encode($data_arr,true);
    }
    
    public function get_product_type_order_form()
    {
        $user_comp_id = Auth::user()->comp_id;
        $product_grp_list = \App\ProductCategory::select('product_type')
//                          ->where(['comp_id'=>$user_comp_id])
                          ->groupBy('product_type')
                          ->get();
       
        echo json_encode($product_grp_list,true);
    }
    
    public function get_item_name($product_type,$type_item)
    {
       
        $type_item = trim($type_item);
        $user_comp_id = Auth::user()->comp_id;
//        echo $type_item."-".$product_type;exit;
        $product_grp_list = \App\ItemList::select('item_desc','item_no')
//                          ->where(['prod_type'=>$type_item,'product_grp'=>$product_type,'comp_id'=>$user_comp_id])
                          ->where(['prod_type'=>$type_item,'product_grp'=>$product_type])
                          ->get();
        echo json_encode($product_grp_list,true);
    }
    
    public function save_order_list(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        if (!empty($requestData['type'] )){
           for($i=0;$i< count($requestData['type']);$i++)
           {
               if (!empty($requestData['item_name'][$i]) && !empty($requestData['qty'][$i])) {
                    $item_name='';   
                    $item_name= explode("/", $requestData['item_name'][$i]);   
                    $data['item_name']=$item_name[0];
                    $data['item_no']=$item_name[1];
                    $data['type']=$requestData['type'][$i];
                    $data['product_grp']=$requestData['product_grp'][$i];
                    $data['qty']=$requestData['qty'][$i];
                    $data['remark']=$requestData['remark'][$i];
                    $data['branch_name']=$branch_name;
                    $data['depart_name']=$depart_name;
                    $data['user_id']=$user_id;
                    $data['inserted_date']=date("Y-m-d");
                    $data['comp_id'] = $user_comp_id;
                     \App\OrderList::create($data);
               }else{
                   Session::flash('alert-danger', 'Please Fill all fields');
               }
           }
            Session::flash('alert-success', 'Saved Successfully.');
            return redirect('order_form');
        }else{
            Session::flash('alert-danger', 'Please Fill all fields');
            return redirect('order_form');
        }
    }
    
    public function purchase_form()
    {
        $id = $_GET['id'];
        $user_comp_id = Auth::user()->comp_id;
        $order_details = \App\OrderList::select('*')->where(['id'=>$id,'comp_id'=>$user_comp_id])->first();       
        $get_price= \App\ItemList::select('price')->where(['item_no'=>$order_details->item_no,'comp_id'=>$user_comp_id])->first();
        return view('order.purchase_form',['order_list'=>$order_details,'price'=>$get_price]); 
    }
    
    public function order_tl_today_dm()
    {
        $current_date=date("Y-m-d");
        $details = array();
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('level_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->level_permission,true);
      //  echo "<pre>";print_r($cmp_json);exit;
        if(@in_array("2", $cmp_json)){
          //  echo "hi";exit;
            $details=DB::table('tbl_order')
                ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                ->select('users.name','tbl_order.*')
                ->where(['users.depart_name'=>$depart_name,'tbl_order.comp_id'=>$user_comp_id,'tbl_order.purchase_status'=>0])
                ->whereIn('tbl_order.status_approved_by_dm',array(0))
                ->get();
        }
    //    echo "<pre>";print_r($details);exit;
        
        $details_gm=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')
            ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>1,'tbl_order.comp_id'=>$user_comp_id])
            ->get();
            
        $date = \Carbon\Carbon::today()->subDays(7);
        $details_decline=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')
            ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>3,'tbl_order.comp_id'=>$user_comp_id])
            ->get();
        
        $details_hold=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')
            ->where(['users.depart_name'=>$depart_name,'tbl_order.comp_id'=>$user_comp_id])
            ->whereIn('tbl_order.status_approved_by_dm',array(2))
            ->get();

        return view('order.order_tl_today_dm',['order_list_to_dm'=>$details,'order_list_to_gm'=>$details_gm,'details_decline'=>$details_decline,'details_hold'=>$details_hold]); 
    }
    
    public function change_order_status_by_dm($id,$remark,$status)
    {
        $users = \App\OrderList::findorfail($id);
        if ($status == "Approve") {
        $requestData['status_approved_by_dm'] = "1";
        } else if ($status == "Hold") {
        $requestData['status_approved_by_dm'] = "2";
        } else {
        $requestData['status_approved_by_dm'] = "3";
        }
        $requestData['modified_at'] = date("Y-m-d h:i:s");
        $requestData['dm_date'] = date('Y-m-d');
        $requestData['status_remark_by_dm'] =$remark;
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('order_tl_today_dm');
    }
    
    
    
    public function order_tl_today_gm()
    {
        $current_date=date("Y-m-d");
        $details = array();
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('level_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->level_permission,true);
       // echo "<pre>";print_r($cmp_json);exit;
//        if(count($cmp_json)>0){
        if(@in_array("1", $cmp_json)){
        $orde_det = DB::table('tbl_order')
                ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                ->select('users.name','tbl_order.*',DB::raw('group_concat(tbl_order.id) AS order_ids'),DB::raw('SUM(tbl_order.qty) AS order_qty'));
            if(@in_array("2", $cmp_json)){
//                $details = $orde_det->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>1,'tbl_order.status_approved_by_gm'=>0,'tbl_order.purchase_status'=>0,'tbl_order.comp_id'=>$user_comp_id]);
                $details = $orde_det->where(['tbl_order.status_approved_by_dm'=>1,'tbl_order.status_approved_by_gm'=>0,'tbl_order.purchase_status'=>0,'tbl_order.comp_id'=>$user_comp_id]);
            }else{
//                $details = $orde_det->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_gm'=>0,'tbl_order.comp_id'=>$user_comp_id,'tbl_order.purchase_status'=>0]);
                $details = $orde_det->where(['tbl_order.status_approved_by_gm'=>0,'tbl_order.comp_id'=>$user_comp_id,'tbl_order.purchase_status'=>0]);
            }
//        }
        
          $details = $orde_det->groupBy('tbl_order.item_no');
          $details = $orde_det->get();
        
        }
        
//        $details=DB::table('tbl_order')
//            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
//            ->select('users.name','tbl_order.*',DB::raw('group_concat(tbl_order.id) AS order_ids'),DB::raw('SUM(tbl_order.qty) AS order_qty'))
//            ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>1,'tbl_order.status_approved_by_gm'=>0,'tbl_order.comp_id'=>$user_comp_id])
//            ->groupBy('tbl_order.item_no')
//            ->get();
        $approve_order = DB::table('tbl_order')
                        ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                        ->select('users.name','tbl_order.*')
//                        ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_gm'=>1,'tbl_order.comp_id'=>$user_comp_id])
                        ->where(['tbl_order.status_approved_by_gm'=>1,'tbl_order.comp_id'=>$user_comp_id])
                        ->get();
        $date = \Carbon\Carbon::today()->subDays(7);
        $decline_order = DB::table('tbl_order')
                       ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                       ->select('users.name','tbl_order.*')
//                       ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_gm'=>3,'tbl_order.comp_id'=>$user_comp_id])
                       ->where(['tbl_order.status_approved_by_gm'=>3,'tbl_order.comp_id'=>$user_comp_id])
                       ->where('gm_date','>=', $date)
                       ->get();
//        echo "<pre>";print_r($details);
//        exit();

        return view('order.order_tl_today_gm',['order_list_to_dm'=>$details,'approve_order'=>$approve_order,'decline_order'=>$decline_order]);
    }
    
    
    public function change_order_status_by_gm($id,$remark,$status)
    {
        $ids= explode(",", $id);
        for($i=0;$i<count($ids);$i++)
        {
        $users = \App\OrderList::findorfail($ids[$i]);
        $requestData['updated_at'] = date("Y-m-d h:i:s");
        if ($status == "Approve") {
        $requestData['status_approved_by_gm'] = "1";
        } else {
        $requestData['status_approved_by_gm'] = "3";
        }
        $requestData['status_remark_by_gm'] =$remark;
        $requestData['gm_date'] = date('Y-m-d');
        $users->update($requestData);   
        }


        Session::flash('alert-success', 'Success');
        $msg = "No";
        echo json_encode("");
            //return redirect('order_tl_today_gm');
    }
    
    public function change_order_status_by_gm_yes($id,$remark)
    {
            $users = \App\OrderList::findorfail($id);
            $requestData['modified_at'] = date("Y-m-d h:i:s");
            $requestData['status_approved_by_gm'] ="0";
            $requestData['status_remark_by_gm'] =$remark;
            $users->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
            return redirect('order_tl_today_gm');
    }
    
    
    public function order_list_to_tl()
    {
       $id = Auth::user()->id; 
       $order_details = \App\OrderList::select('*')->where(['user_id'=>$id])->orderBy('id','desc')->get();   
       $check_order_from_po = \App\ApprovedOrder::select('*')->where(['user_id'=>$id,'cheker_flag'=>"1"])->get();  
    //   echo "<pre>";print_r($check_order_from_po);exit;
       return view('order.order_list_to_tl',['order_details'=>$order_details,'order_from_po'=>$check_order_from_po]);
    }
    
    public function order_utilize_form()
    {
      $id = Auth::user()->id;   
      $check_order_from_po = \App\ApprovedOrder::select('*')->where(['user_id'=>$id,'cheker_flag'=>1])->get();     
      return view('order.order_utilize_form',['order_from_po'=>$check_order_from_po]);  
    }
    
    public function get_order_utilize_qty_tl($id)
    {
        // $orderutilize = \App\OrderUtilize::select('*')->where(['order_id'=>$id])->first(); 
        // if(empty($orderutilize))
        // {
         $check_order_from_po = \App\ApprovedOrder::select('remaning_qty','return_qty')->where(['order_id'=>$id])->first(); 
         $orderutilize = \App\OrderUtilize::select(DB::raw('sum(used_qty) as used_qty'))->where(['order_id'=>$id])->first(); 
         $actual_data['return_qty']= "Remaining Qty : ".$check_order_from_po->remaning_qty." || Used Qty : ".$orderutilize->used_qty." || Return Qty :".$check_order_from_po->return_qty;
         $actual_data['stock_qty']=$check_order_from_po->remaning_qty;
       //  $actual_data['used_total']=$orderutilize->used_qty;
        // }
        // else{
        //     $actual_data['actual_qty']=$orderutilize->actual_qty;
        //     $actual_data['stock_qty']=$orderutilize->stock_qty;
        // }
        echo json_encode($actual_data,true);
    }
    
    public function save_order_utilize(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $used_qty = 0;
        $requestData = $request->all();
        for ($i = 0; $i < count($requestData['used_qty']); $i++) {
            $data['order_id'] = $requestData['order_id'];
//            $data['actual_qty']=$requestData['actual_qty'][$i];
            $data['used_qty'] = $requestData['used_qty'][$i];
            $used_qty = $used_qty + $requestData['used_qty'][$i];
            $data['user_id'] = $user_id;
            $data['remark'] = $requestData['remark'][$i];
            $data['inserted_date'] = date("Y-m-d");
            \App\OrderUtilize::create($data);
        }
        $approve_data = \App\ApprovedOrder::where(['order_id'=>$requestData['order_id']])->first();
        $update_data['used_qty'] = $approve_data->used_qty + $used_qty;
        $update_data['remaning_qty'] = $approve_data->remaning_qty - $used_qty;
        $approve_data->update($update_data);
        Session::flash('alert-success', 'Saved Successfully.');
        return redirect('order_utilize_form');
    }
    
    public function tl_order_utilize_status($order_id)
    {       
     $user_id = Auth::user()->id;   
     $orderutilize = \App\OrderUtilize::select('*')->where(['order_id'=>$order_id,'user_id'=>$user_id])->get(); 
     $check_order_from_po = \App\ApprovedOrder::select('*')->where(['order_id'=>$order_id])->first(); 
     $print='';
     $i=1;
     foreach($orderutilize as $row)
     {
         if (empty($stock_qty)) {
                $stock_qty = $check_order_from_po->received_qty - $row->used_qty;
            } else {
                $stock_qty = $stock_qty - $row->used_qty;
            }

            $print.="<tr>"
               . "<td>$i</td>"
               . "<td>$order_id</td>"
               . "<td>$check_order_from_po->item_no</td>"
               . "<td>$check_order_from_po->item_desc</td>"
               . "<td>$check_order_from_po->received_qty</td>"
               //. "<td>$stock_qty</td>"
               . "<td>$row->used_qty</td>"
               . "<td>$row->inserted_date</td>"
               . "<td>$row->remark</td>"
               . "</tr>";  
       $i++;
     }
     echo $print;
     
    }

    
    public function show_order_details_gm($ids)
    {
        $msg='';
        $ids= explode(",", $ids);
        $order_details = \App\OrderList::select('*')->whereIn('id',$ids)->get();

       $msg.="<table class='table table-bordered'><tr>"
               . "<td>#</td>"
               . "<td>Product Type</td>"
               . "<td>Product Category</td>"
               . "<td>Item No.</td>"
               . "<td>Item Description</td>"
               . "<td>Qty</td>"
               . "</tr>";
       
       if(!empty($order_details))
       {
           $i=1;
           foreach($order_details as $row) {
               $msg.="<tr>";
               $msg.="<td>$i</td>"
                       . "<td>$row->type</td>"
                       . "<td>$row->product_grp </td>"
                       . "<td>$row->item_no</td>"
                       . "<td>$row->item_name</td>"
                       . "<td>$row->qty</td>"
                       . "";
               $msg.="</tr>";
               $i++;
           }
           
       }
       
       $msg.="</table>";
       
       echo $msg;
    }
    
  /*  public function order_list()
    {
//        $order_details = \App\OrderList::orderBy('id','asc')->get();
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('level_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->level_permission,true);
       // echo "<pre>";print_r($cmp_json);exit;
//        if(count($cmp_json)>0){
        $orde_det = DB::table('tbl_order')
                ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                ->select('users.name','tbl_order.*','users.branch_name','users.depart_name');
            if(@in_array("1", $cmp_json)){
                // $details = $orde_det->where(['tbl_order.status_approved_by_gm'=>1,'purchase_status'=>0,'tbl_order.comp_id'=>$user_comp_id]);
                $details = $orde_det->where(['tbl_order.status_approved_by_gm'=>1,'purchase_status'=>0]);
            }else if(@in_array("2", $cmp_json)){
                // $details = $orde_det->where(['tbl_order.status_approved_by_dm'=>1,'purchase_status'=>0,'tbl_order.comp_id'=>$user_comp_id]);
                $details = $orde_det->where(['tbl_order.status_approved_by_dm'=>1,'purchase_status'=>0]);
            }else{
                // $details = $orde_det->where(['purchase_status'=>0,'tbl_order.comp_id'=>$user_comp_id]);
                $details = $orde_det->where(['purchase_status'=>0]);
            }
//        }
        
          $details = $orde_det->groupBy('tbl_order.id');
          $details = $orde_det->get();
//        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0,'comp_id'=>$user_comp_id])->get();
            $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        
        return view('order.order_list',['order_list'=>$details,'location'=>$location]); 
    }
    */
    
    public function order_list()
    {
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('level_permission','company_id')->get();
        $order_arr = array();
        foreach($company as $c){
            $cmp_json = json_decode($c->level_permission,true);
        //    echo "<pre>";print_r($cmp_json);exit;
            $orde_det = DB::table('tbl_order')
                        ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
                        ->leftjoin('tbl_company_master','tbl_company_master.company_id','=','tbl_order.comp_id')
                        ->select('users.name','tbl_order.*','users.branch_name','users.depart_name','tbl_company_master.company_name');
                        if(@in_array("1", $cmp_json)){
                            $details = $orde_det->where(['tbl_order.status_approved_by_gm'=>1,'purchase_status'=>0,'tbl_order.comp_id'=>$c->company_id]);
                        }else if(@in_array("2", $cmp_json)){
                            $details = $orde_det->where(['tbl_order.status_approved_by_dm'=>1,'purchase_status'=>0,'tbl_order.comp_id'=>$c->company_id]);
                        }else{
                            $details = $orde_det->where(['purchase_status'=>0,'tbl_order.comp_id'=>$c->company_id]);
                        }        
                        $details = $orde_det->where(['users.is_active'=>0]);
            $details = $orde_det->groupBy('tbl_order.id');
            $details = $orde_det->get();
        //    echo "<pre>";print_r($details);exit;
            $order_arr[] = $details;
        }
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        return view('order.order_list',['order_list'=>$order_arr,'location'=>$location]); 
    }
    
    public function create_purchase_form()
    {
        $current_date=date("Y-m-d");
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
//        $details=DB::table('tbl_order')
//            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
//            ->select('users.name','tbl_order.*',DB::raw('group_concat(tbl_order.id) AS order_ids'),DB::raw('SUM(tbl_order.qty) AS order_qty'))
//            ->where(['tbl_order.status_approved_by_gm'=>1])
//            ->groupBy('tbl_order.item_no')
//            ->get();
        $vendor_list= \App\VendorList::orderBy('id','asc')
//                ->where(['comp_id'=>$user_comp_id])
                ->get();
        
        $product_grp_list = \App\ProductCategory::select('product_type')
//                          ->where(['comp_id'=>$user_comp_id])
                          ->groupBy('product_type')
                          ->get();
        return view('order.create_purchase_form',['product_grp_list'=>$product_grp_list,'vendor_list'=>$vendor_list]); 
    }
    
    
    public function create_purchase($v_id,$order_ids)
    {
        $user_id = Auth::user()->id;
        $last_id = \App\PurchaseOrder::orderBy('po_id', 'desc')->limit('1')->first();
        if ($last_id == '' || $last_id == null) {
            $id = 1;
        } else {
            $id = $last_id->po_id + 1;
        }
        $od = explode("-", $order_ids);
        $final_array = array();
        foreach ($od as $row) {
            $append_id[]=$ex_array =  explode(",", $row);
            $details = DB::table('tbl_order')
                    ->select('tbl_order.*', DB::raw('SUM(qty) AS order_qty'),DB::raw('group_concat(user_id) AS user_ids'))
                    ->whereIn('id', $ex_array)
                    ->groupBy('item_no')
                    ->first();
            $get_price = \App\ItemList::select('price')->where(['item_no' => $details->item_no])->first();
            $final_array[] = $details;
            $price_array[] = $get_price;
        }
        
        for ($i = 0; $i < count($append_id); $i++) {

            for ($j = 0; $j < count($append_id[$i]); $j++) {
                $insert_purchase_order = \App\OrderList::select('*')->where(['id' => $append_id[$i][$j]])->first();
                $get_price1 = \App\ItemList::select('price')->where(['item_no' => $insert_purchase_order->item_no])->first();
                $insert_data['type'] = $insert_purchase_order->type;
                $insert_data['product_grp'] = $insert_purchase_order->product_grp;
                $insert_data['order_id'] = $insert_purchase_order->id;
                $insert_data['vendor_id'] = $v_id;
                $insert_data['item_no'] = $insert_purchase_order->item_no;
                $insert_data['item_desc'] = $insert_purchase_order->item_name;
                $insert_data['price'] = $get_price1->price;
                $insert_data['qty'] = $insert_purchase_order->qty;
                $insert_data['user_id'] = $user_id;
                $insert_data['inserted_date'] = date("Y-m-d");
                $insert_data['tl_ids'] = $insert_purchase_order->user_id;
                $insert_data['po_id'] = $id;
                \App\PurchaseOrder::create($insert_data);
            }
        }
        $vendor_details= \App\VendorList::select('*')->where(['id'=>$v_id])->first();
        return view('order.purchase_form',['order_list'=>$final_array,'price'=>$price_array,'vendor_list'=>$vendor_details,'po_id'=>$id]); 
        
    }
    
    public function vendor_to_po_dept()
    {
       $user_comp_id = Auth::user()->comp_id;
       $details=DB::table('tbl_purchase_order')
            ->leftjoin('users', 'tbl_purchase_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_purchase_order.*')
            ->where(['users.is_active'=>0])
       //     ->where(['tbl_purchase_order.comp_id'=>$user_comp_id])
//            ->where('update_status', '0')
//            ->where('')
            ->orderBy('id','desc')
            ->get();
       return view('order.vendor_to_po_dept',['po_list'=>$details]); 
    }
    
    public function update_maker_po_dept($id,$loc_id)
    {
        $print = "";
        $user_comp_id = Auth::user()->comp_id;
        $item_data = explode(",", $id);
        $get_data = DB::table('tbl_sub_master_storage_location')
              ->select('tbl_master_storage_loc.rank_no','tbl_sub_master_storage_location.section_no','tbl_storage_location.current_qty','tbl_storage_location.inserted_date','tbl_storage_location.id','tbl_storage_location.id','tbl_location.loc_name')
              ->leftjoin('tbl_master_storage_loc','tbl_master_storage_loc.id','tbl_sub_master_storage_location.master_id')
              ->leftjoin('tbl_storage_location','tbl_storage_location.master_id','tbl_sub_master_storage_location.id')
              ->leftjoin('tbl_location','tbl_location.loc_id','tbl_master_storage_loc.location')
              ->where(['tbl_storage_location.item_no'=>$item_data[0]])
              ->where(['tbl_master_storage_loc.location'=>$loc_id,'tbl_sub_master_storage_location.comp_id'=>$user_comp_id])
              ->get();
               
//        $data = \App\StorageLocation::where(['item_no'=>$id])->get();
//        echo "<pre>";print_r($item_data);exit;
            $print .="<h4>Item Name :- $item_data[1] &nbsp;&nbsp;&nbsp;&nbsp;Required Qty :-  $item_data[2] &nbsp;&nbsp;&nbsp;&nbsp;Team Leader Name :-  $item_data[4]</h4>";//<button class='btn btn-foursquare swipe_items' value='$swipe_data'>SWIPE</button></h4>";
            $print .= "<form id='save_item_sl'>".csrf_field()."<input type='hidden' name='required_qty' id='required_qty' value='$item_data[2]' ><input type='hidden' name='order_id1' id='order_id' value='$item_data[3]' ><table class='table table-bordered'><tr><th>#</th>"
                    . "<th style='text-align: center;'>Location</th>"
                    . "<th style='text-align: center;'>Rack</th>"
                    . "<th style='text-align: center;'>Slots</th>"
                    . "<th style='text-align: center;'>Qty</th>"
                    . "<th style='text-align: center;'>Updated Date</th>"
                    . "<th style='text-align: center;'>Assign TL</th><th></th>"
                    . "</tr>"; 
             $i=1;
             foreach($get_data as $data){
                 $print .= "<tr id='$data->current_qty'>"
                        . "<td style='text-align: center;'>$i</td>"
                        . "<td style='text-align: center;'>$data->loc_name</td>"
                        . "<td style='text-align: center;'>$data->rank_no</td>"
                        . "<td style='text-align: center;'>$data->section_no</td>"
                        . "<td style='text-align: center;'>$data->current_qty<input type='hidden' name='updateId[$i]' id='updateId[$i]' value='$data->id' /></td>" 
                        . "<td style='text-align: center;'>$data->inserted_date</td>"
                        . "<td style='text-align: center;'><input type='text' class='assign_qty' name='assign_qty[$i]' id='assign_qty[$i]' value=''  /></td>"
                        . "<td style='text-align: center;' id='assign_qty[$i]_error'></td> " 
                        . "</tr>";
             $i++; }
             echo $print;
    }
    
    public function saveMaker(Request $request){
        $requestData = $request->all();
      //  echo "<pre>";print_r($requestData);exit;
        $i=1;$total_assign = 0;
        foreach($requestData['updateId'] as $data){
            $update = 0;
            $total_assign = $total_assign + $requestData['assign_qty'][$i];
            $storage = \App\StorageLocation::where(['id'=>$data])->first();
//            echo "<pre>";print_r($storage);exit;
            $update = $storage->current_qty - $requestData['assign_qty'][$i];
            \App\StorageLocation::where(['id'=>$data])->update(['current_qty' => $update]);
            if($update == 0){
                \App\StorageLocation::where(['id'=>$data])->delete();
    		$up_data = \App\StorageLocation::where(['master_id'=>$storage->master_id])->get();
                if(count($up_data)>0){

                }else{
                    \App\StorageLocationSubMaster::where(['id'=>$storage->master_id])->update(['is_active'=>0]);
                }
            }
            $i++;
        }
        $id = $requestData['order_id1']; //exit;
        $order_details = \App\OrderList::select('*')->where(['id'=>$id])->first();
//        echo "<pre>";print_r($order_details);exit; 
        $stock_qty= \App\ItemList::select('qty')->where(['item_no'=>$order_details->item_no])->first();
        if(!empty($order_details)){
            $data1['order_id'] = $order_details->id;
            $data1['item_no'] = $order_details->item_no;
            $data1['item_desc'] = $order_details->item_name;
            $data1['order_qty']= $order_details->qty;
            $data1['received_qty'] = $total_assign;
            $data1['remaning_qty'] = $total_assign;
            $data1['user_id'] = $order_details->user_id;
            $data1['branch_name'] = $order_details->branch_name;
            $data1['depart_name'] = $order_details->depart_name;
            $data1['received_date'] = date("Y-m-d");
            \App\ApprovedOrder::create($data1);
//            DB::table('tbl_order')->where('id', $id)->delete();
        }
            
//        \App\ItemList::where('item_no', $order_details->item_no)->update([
//            'qty' => $stock_qty->qty - $total_assign
//        ]);

//        \App\StorageLocation::where('item_no', $order_details->item_no)->update([
//            'current_qty' => $stock_qty->qty-$order_details->qty
//        ]);
        
        \App\OrderList::where('id', $id)->update([
            'given_quntity' => $total_assign,'purchase_status'=>1
        ]);
        
        return redirect('order_list');
    }
 

    public function update_checker_po_dept($id)
    {
            $users = \App\PurchaseOrder::findorfail($id);
            $requestData['checker_date'] = date("Y-m-d");
            $requestData['checker_status'] ="1";
            $users->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
            return redirect('vendor_to_po_dept');
    }
    
    
    public function save_purchase_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $requestData = $request->all(); 
        $user_comp_id = Auth::user()->comp_id;
      //  echo "<pre>";print_r(($requestData));exit;
//        if(($requestData['item_name'][0])){
//            echo "if";
//        }else{
//            echo "else";
//        }
//        exit;
        for($i=0;$i<count($requestData['type']);$i++){
            if($requestData['item_name'][$i] != "" && $requestData['price'][$i] != "" && $requestData['qty'] != ""){
                $data["type"]= @$requestData["type"][$i];
                $data["product_grp"]= @$requestData["product_grp"][$i];
                $data["vendor_id"]= @$requestData["vendor_grp"][$i];
                $data["item_desc"]= @$requestData["item_name"][$i];
                $data["price"]= @$requestData["price"][$i];
                $data["qty"]= @$requestData["qty"][$i];
                $data["remark"]= @$requestData["remark"][$i];
                $data["inserted_date"]= date("Y-m-d");
                $data["user_id"]= $user_id;
                $data['comp_id'] = $user_comp_id;
//                echo "<pre>";print_r(($data));//exit;
                \App\PurchaseOrder::create($data);
            }
        }
//        exit;
        Session::flash('alert-success', 'Generated Successfully.');
        return redirect('vendor_to_po_dept');
        
//        $po_data['item_name']=$requestData["item_name"];
//        $po_data['qty']=$requestData["qty"];
//        $po_data['price']=$requestData["price"];
//        
//        $po_id = \App\PurchaseOrder::orderBy('id', 'desc')->limit('1')->first();
//        $vendor_list= \App\VendorList::select('*')->where(['id'=>$requestData["vendor_name"]])->first();
////        Session::flash('alert-success', 'Generated Successfully.');
//        return view('order.purchase_form',['vendor_list'=>$vendor_list,'po_data'=>$po_data,'po_id'=>$po_id]); 
    }
    
    public function generatePO($id){
//        echo $id;
        $po_detail = DB::table('tbl_purchase_order')//\App\PurchaseOrder::where(['id'=>$id])->first();
                    ->select('tbl_purchase_order.*','tbl_vendor.vendor_name','tbl_vendor.gst_no','tbl_vendor.mob_no','tbl_vendor.address')
                    ->leftjoin('tbl_vendor','tbl_vendor.id','=','tbl_purchase_order.vendor_id')
                    ->where(['tbl_purchase_order.id'=>$id])
                    ->first();
        return view('order.purchase_form',['po_detail'=>$po_detail]); 
//        $po_id = \App\PurchaseOrder::orderBy('id', 'desc')->limit('1')->first();
        
    }

        // Storage Location
    
    

    public function storage_location()
    {
        $user_comp_id = Auth::user()->comp_id;
        $item_list = \App\ItemList::select('item_no','item_desc')
//                   ->where(['comp_id'=>$user_comp_id])
                    ->orderBy('id', 'desc')
                    ->get();
        //$get_location= \App\StorageLocation::select('location')->groupBy('location')->get();
//        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0,'comp_id'=>$user_comp_id])->get();
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        return view('order.storage_location',['get_location'=>$location]); 
    }
    
    
    public function show_storage_location_form($l_name)
    {
        $user_comp_id = Auth::user()->comp_id;
        $item_list = \App\ItemList::select('item_no','item_desc')
//                    ->where(['comp_id'=>$user_comp_id])
                    ->orderBy('id', 'desc')
                    ->get();
//        $st_loc = \App\StorageLocation::select('rank_no',DB::raw('group_concat(section_no ORDER BY section_no ASC) AS sec_no'),'item_no',DB::raw('group_concat(status ORDER BY section_no ASC) AS status'))->where(['location'=>$l_name])->groupBy('rank_no')->orderBy('rank_no', 'asc')->get();
//        $st_loc = DB::table('tbl_sub_master_storage_location as t1')
//                ->select('t1.section_no','rank_no','location')
//                ->leftjoin('tbl_master_storage_loc','tbl_master_storage_loc.id','=','t1.master_id')
//                ->where(['location'=>$l_name])
//                ->get();
        $st_loc = DB::table('tbl_master_storage_loc')
                 ->select('rank_no','location','loc_name','id')
                 ->leftjoin('tbl_location','tbl_location.loc_id','=','tbl_master_storage_loc.location')
                 ->where(['location'=>$l_name])
//                 ->where(['location'=>$l_name,'tbl_master_storage_loc.comp_id'=>$user_comp_id])
                 ->get();
//        echo "<pre>";print_r($st_loc);exit;
//        $sec_no= array();
//        $status=array();
//        $rack=array();
//        $f_data=array();
//        $split_data=array();
//        if($st_loc)
//        {
//        for($i=0;$i<count($st_loc);$i++)
//        {
//            $sec_no[]= explode(",", $st_loc[$i]->sec_no);
////            $item_no[]= explode(",", $st_loc[$i]->item_no);
////            $current_qty[]= explode(",", $st_loc[$i]->current_qty);
//            $status[]= explode(",", $st_loc[$i]->status);
//            $rack[]= explode(",", $st_loc[$i]->rank_no);
//        }
//        
//        for ($j = 0; $j < count($sec_no); $j++) {
//            for ($k = 0; $k < count($sec_no[$j]); $k++) {
//                //$f_data[$j][] = $sec_no[$j][$k] . "," . $item_no[$j][$k] . "," . $current_qty[$j][$k];
//                $f_data[$j][] = $sec_no[$j][$k] . "," . $status[$j][$k]. "," . $l_name;
//            }
//        }
//
//        for ($l = 0; $l < count($f_data); $l++) {
//
//            $split_data[] = array_chunk($f_data[$l], 3);
//        }
//        }
$rack = 1;

       return view('order.show_storage_location_form',['item_list'=>$item_list,'rack_data'=>$st_loc,'rack_no'=>$rack,'location_name'=>$l_name]);   
    }
    
    public function show_storage_location_modal($id)
    {
//        echo $id;exit;
        $split_data = explode(",", $id);
//        echo "<pre>";print_r($split_data);exit;
        $get_data = \App\StorageLocation::select('item_no','current_qty','id')->where(['master_id'=>$split_data[4]])->get();
//                ->where(['rank_no' => $split_data[0],'section_no' => $split_data[1],'location' => $split_data[3]])->first();
//        echo "<pre>";print_r($get_data);exit;
        $print = '';
        if(count($get_data)>0)
        {
           $swipe_data=$split_data[0].",".$split_data[1].",".$split_data[3];
            
           $print .="<h4>Rack No :- $split_data[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slot No :- $split_data[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location :- $split_data[3]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h4>";//<button class='btn btn-foursquare swipe_items' value='$swipe_data'>SWIPE</button></h4>";
           $print .= "<form id='save_item_sl'>".csrf_field()."<table class='table table-bordered'><tr><th>#</th>"
                    . "<th style='text-align: center;'>Select Item Name / No.</th>"
                    . "<th style='text-align: center;'>Current Qty</th>"
                    . "<th style='text-align: center;'>Action</th>"
                    . "</tr>"; 
           
//           $item_decode= json_decode($get_data->item_no);
//           $qty_decode= json_decode($get_data->current_qty);
             $i=1;
             foreach($get_data as $data){
                 $get_item_name = \App\ItemList::select('item_desc')->where(['item_no' => $data->item_no])->first();
                 $print .= "<tr class='item_count'><td><button type='button' class=''>&times;</button></td>"
                        . "<td style='display:none;'><input type='text' class='form-control item_no' name='item_no1[$i][0]' style=' width:500px; text-align: center;' value='$data->item_no'>"
                        . "<td style='text-align: center;'>$get_item_name->item_desc / $data->item_no</td>"
                        . "<td style='text-align: center;'><input type='text' class='form-control c_qty' name='item_no1[$i][1]' style=' width:100px; text-align: center;' value='".$data->current_qty."' required='' readonly></td>"
                        . "<td style='text-align: center;'><input type='hidden' name='item_no1[$i][2]' value='$data->id' /><a href='#' id='".$data->id."' class='btn btn-foursquare swipe_items1' >Transfer</a></h4></td></tr>";
             $i++; }
//           for ($i = 0; $i < count($item_decode); $i++) {
//                $get_item_name = \App\ItemList::select('item_desc')->where(['item_no' => $item_decode[$i][0]])->first();
//                $print .= "<tr><td><button type='button' class='close_tr'>&times;</button></td><td style='display:none;'><input type='text' class='form-control item_no' name='item_no[]' style=' width:500px; text-align: center;' value='$item_decode[$i]'>"
//                        . "<td style='text-align: center;'>$get_item_name->item_desc / $item_decode[$i]<input type='hidden' class='item_code' value='".$item_decode[$i]."'</td>"
//                        . "<td style='text-align: center;'><input type='text' class='form-control c_qty' name='c_qty[]' style=' width:100px; text-align: center;' value='$qty_decode[$i]' required=''></td>"
//                        . "<td><a href='#' id='".$item_decode[$i].','.$qty_decode[$i]."' class='btn btn-foursquare swipe_items1' >SWIPE</a></h4></td></tr>";
//            }
            $print .= "<tr>"
                    . "<td style=' display:none;'><input type='text' class='form-control rack_no' value='$split_data[0]' name='rack_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control section_no' value='$split_data[1]' name='section_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control location' value='$split_data[3]' name='location'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control location' value='$split_data[4]' name='sub_master_id'></td>"
                    . "</tr>";
            
            $print .= "<tbody id='append_items'></tbody>";


            $print .= "</table></form>";
           
        }
        else{
            $print .= "<h4>Rack No :- $split_data[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slot No :- $split_data[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location :- $split_data[3]</h4>";
            $print .= "<form id='save_item_sl'>" . csrf_field() . "<table class='table table-bordered'><tr><th>#</th>"
                    . "<th style='text-align: center;'>Select Item Name / No.</th>"
                    . "<th style='text-align: center;'>Current Qty</th>"
                    . "</tr>";

            $print .= "<tr>"
                    . "<td style=' display:none;'><input type='text' class='form-control rack_no' value='$split_data[0]' name='rack_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control section_no' value='$split_data[1]' name='section_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control location' value='$split_data[3]' name='location'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control location' value='$split_data[4]' name='sub_master_id'></td>"
                    . "</tr>";
            $print .= "<tbody id='append_items'></tbody>";


            $print .= "</table></form>";
        }
        echo $print;
    }
    
    
    public function update_storage_details(Request $request)
    {
        $requestData = $request->all();
   //     echo "<pre>";print_r($requestData);exit;
        $user_comp_id = Auth::user()->comp_id;
        if(isset($requestData['item_no1'])){
            foreach($requestData['item_no1'] as $item){
                \App\StorageLocation::where(['id' => $item[2]])->update(['item_no'=>$item[0],'current_qty'=>$item[1]]);
            }
        }
        $i =1;
        if(isset($requestData['item_no'])){
            foreach($requestData['item_no'] as $row){
                if($row[0] != "" && $row[1] != ""){
                        $storage['master_id'] = $requestData['sub_master_id'];
                        $storage['item_no'] = $row[0];
                        $storage['current_qty'] = $row[1];
                        $storage['status'] = 1;
                        $storage['inserted_date'] = date('Y-m-d');
                        $storage['comp_id'] = $user_comp_id;
                        \App\StorageLocation::create($storage);
                        if($i == 1){
                                \App\StorageLocationSubMaster::where(['id' => $requestData['sub_master_id']])->update(['is_active'=>1]);
                        }
                }
            $i++;
            }
            
        }
          
    }
    
    public function swipe_items_storage($id)
    {
//        echo $id;exit;
        $get_location= \App\StorageLocation::select('location')->groupBy('location')->get();
        $split_data = explode(",", $id);
        $print = '';
        $print .= "<h4>Rack No :- $split_data[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slot No :- $split_data[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location :- $split_data[2]</h4>";

        $print .= "<form id='update_swipe_data'>" . csrf_field() . "<table class='table table-bordered'>";
        $print .= "<tr><th>Location Name</th><th>Rack No.</th><th>Slot No.</th></tr>";
        $print .= "<tr><th><select class='form-control select2' style=' width: 500px;' name='location_swipe' id='location_swipe'><option>Select Location</option>";
        foreach ($get_location as $row) {
            $print .= "<option value='$row->location'>$row->location</option>";
        }
        $print .= "</select></th><th><select class='form-control select2' name='rack_no_swipe' id='rack_no_swipe' style='width:100px;'><option> Select </option></select></th><th><select class='form-control select2' name='slot_no_swipe' id='slot_no_swipe' style='width:100px;'><option> Select </option></select></th></tr>";
        $print .= "<input type='text' class='form-control' name='from_swipe_data' id='from_swipe_data' style='width:100px; display:none;' value='$id'>";
        $print .= "</form></table>";
        echo $print;
    }
    
    public function swipe_items_storage1()
    {
//        echo "<pre>";print_r($_GET);exit;
//        $id = $_GET['swap'];
        $id1 = $_GET['href'];
        $user_comp_id = Auth::user()->comp_id;
        $get_location = \App\Location::select('loc_id','loc_name')
//                     ->where(['comp_id'=>$user_comp_id])
                     ->where(['is_active'=>0])->get();
//        $get_location= \App\StorageLocation::select('location')->groupBy('location')->get();
//        $split_data = explode(",", $id);
        $print = '';
//        $print .= "<h4>Rack No :- $split_data[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slot No :- $split_data[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location :- $split_data[2]</h4>";

        $print .= "<form id='update_swipe_data'>" . csrf_field() . "<table class='table table-bordered'>";
        $print .= "<tr><th>Location Name</th><th>Rack No.</th><th>Slot No.</th></tr>";
        $print .= "<tr><th><select class='form-control select2' style=' width: 500px;' name='location_swipe' id='location_swipe'><option>Select Location</option>";
        foreach ($get_location as $row) {
            $print .= "<option value='$row->loc_id'>$row->loc_name</option>";
        }
        $print .= "</select></th><th><select class='form-control select2' name='rack_no_swipe' id='rack_no_swipe' style='width:100px;'><option> Select </option></select></th><th><select class='form-control select2' name='slot_no_swipe' id='slot_no_swipe' style='width:100px;'><option> Select </option></select></th></tr>";
//        $print .= "<input type='hidden' class='form-control' name='from_swipe_data' id='from_swipe_data' style='width:100px;' value='$id'>";
        $print .= "<input type='hidden' class='form-control' name='update_item_id' id='update_item_id' style='width:100px;' value='$id1'>";
        $print .= "</form></table>";
        echo $print;
    }
    
    
    public function getRackslot($id){
        $rack_data = "";
        $user_comp_id = Auth::user()->comp_id;
//        $data = \App\StorageLocationMaster::select('rank_no','id')->where(['location'=>$id,'comp_id'=>$user_comp_id])->get();
        $data = \App\StorageLocationMaster::select('rank_no','id')->where(['location'=>$id])->get();
        $rack_data.='<option value="">Select Rack</option>';
        foreach($data as $row){
            $rack_data.='<option value='.$row->id.'>'.$row->rank_no.'<option>';
        }
        echo $rack_data;
    }
    
    public function getSlot(){
        $rack_data = "";
//        $loc_id = $_GET['loc_id'];
        $user_comp_id = Auth::user()->comp_id;
        $rack_id = $_GET['rack_id'];
//        $data = \App\StorageLocationSubMaster::select('id','section_no')->where(['master_id'=>$rack_id,'comp_id'=>$user_comp_id])->get();
        $data = \App\StorageLocationSubMaster::select('id','section_no')->where(['master_id'=>$rack_id])->get();
        $rack_data.='<option value="">Select Slot</option>';
        foreach($data as $row){
            $rack_data.='<option value='.$row->id.'>'.$row->section_no.'<option>';
        }
        echo $rack_data;
    }

    public function update_swipe_data()
    {
        $from_swipe_data= explode(",", $_POST['from_swipe_data']);        
        $get_item_details= \App\StorageLocation::select('item_no','current_qty')->where(['rank_no' => $from_swipe_data[0],'section_no' => $from_swipe_data[1],'location' => $from_swipe_data[2]])->first();
        
        \App\StorageLocation::where(['rank_no' => $_POST['rack_no_swipe'], 'id' => $_POST['slot_no_swipe'],'location' => $_POST['location_swipe']])->update([
            'item_no' => $get_item_details->item_no, 'current_qty' => $get_item_details->current_qty, 'status' => '1'
        ]);  

        \App\StorageLocation::where(['rank_no' => $from_swipe_data[0],'section_no' => $from_swipe_data[1],'location' => $from_swipe_data[2]])->update([
            'item_no' => "", 'current_qty' => "", 'status' => '0'
        ]);  
    }

    
    public function update_swipe_data1()
    {
        //Add value
//        $from_swipe_data= explode(",", $_POST['from_swipe_data']);
//        echo "<pre>";print_r($_POST); exit;
        $item1 = $qty1 = array();
        $get_item_details = \App\StorageLocation::select('item_no','current_qty','master_id')->where(['id' => $_POST['update_item_id']])->first();
        
        $m_id = $get_item_details->master_id;
       
        $new_item['master_id'] = $_POST['slot_no_swipe'];
        $new_item['item_no'] = $get_item_details->item_no;
        $new_item['current_qty'] = $get_item_details->current_qty;
        $new_item['status'] = 1;
        $new_item['inserted_date'] = date('Y-m-d');
        \App\StorageLocation::create($new_item);
        
        \App\StorageLocation::destroy($_POST['update_item_id']);
         $total = \App\StorageLocation::where(['master_id'=>$m_id])->get();
        if(count($total)>0){
            
        }else{
            \App\StorageLocationSubMaster::where(['id'=>$m_id])->update(['is_active'=>0]);
        }
        //echo "<pre>";print_r($total); exit;
        \App\StorageLocationSubMaster::where(['master_id' => $_POST['rack_no_swipe'],'id'=>$_POST['slot_no_swipe']])->update(['is_active'=>1]);
//        if()

    }
    
    public function save_storage_location(Request $request)
    {
	//	echo "<pre>";print_r($request->all());exit;
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        $requestData = $request->all(); 
        
        $requestData["inserted_date"]=date("Y-m-d");
        $requestData['comp_id'] = $user_comp_id;
        \App\StorageLocation::create($requestData);
        Session::flash('alert-success', 'Inserted Successfully.');
        return redirect('storage_location');
    }

    public function showStorage(){
        $user_comp_id = Auth::user()->comp_id;
        $data = DB::table('tbl_master_storage_loc')
              ->select(DB::raw('COUNT(rank_no) as rank_no'),DB::raw('COUNT(section_no) as section_no'),'tbl_location.loc_name','location')
              ->leftjoin('tbl_location','tbl_location.loc_id','tbl_master_storage_loc.location')
//              ->where(['tbl_master_storage_loc.is_active'=>0,'tbl_master_storage_loc.comp_id'=>$user_comp_id])
                ->where(['tbl_master_storage_loc.is_active'=>0])
              ->groupBy('location')
              ->get();
//        echo "<pre>";print_r($data);exit;
//        $data = \App\StorageLocationMaster::where(['is_active'=>0])->get();
        return view('order.storage_list',['data'=>$data]);
    }
    
    public function add_storage_location()
    {
       $user_comp_id = Auth::user()->comp_id;
//       $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0,'comp_id'=>$user_comp_id])->get();
       $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
       return view('order.add_storage_location',['location'=>$location]);  
    }
    
    
    public function save_storage(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        $requestData = $request->all(); 
        
        $rack_no = \App\StorageLocationMaster::select('rank_no')->where(['location'=>$requestData['location']])->orderBy('id', 'DESC')->first();
//        echo "<pre>";print_r($rack_no);exit;
        for($j=1;$j<$requestData["rank_no1"]+1;$j++){
           // echo $j;
            if(!empty($rack_no)){
                if($rack_no->rank_no != ""){
                    $requestData['rank_no'] = $rack_no->rank_no + $j;
                }
            }else{
                $requestData['rank_no'] = $j;
            }
            $requestData['comp_id'] = $user_comp_id;
            $master = \App\StorageLocationMaster::create($requestData);
//            
            for($i=1;$i<$requestData["section_no"]+1;$i++)
            {
        //        $data["rank_no"]= $requestData["rank_no"];
                $data["section_no"]= $i;
        //        $data["location"]= $requestData["location"];
                $data['master_id'] = $master->id;
                $data["inserted_date"]= date("Y-m-d");
                $data['comp_id'] = $user_comp_id;
                \App\StorageLocationSubMaster::create($data);
            }
        }
        
//        exit;
        Session::flash('alert-success', 'Inserted Successfully.');
        return redirect('storage_list');
        
    }
    

    public function editStorage(){
        $id = $_GET['id'];
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        $storage = DB::table('tbl_master_storage_loc')
              ->select(DB::raw('COUNT(rank_no) as rank_no'),'section_no','location')
//              ->leftjoin('tbl_location','tbl_location.loc_id','tbl_master_storage_loc.location')
              ->where(['tbl_master_storage_loc.is_active'=>0])
              //->where(['id'=>$id])
              ->groupBy('location')
              ->first();
      //  echo "<pre>";print_r($storage);exit;
//        $storage = \App\StorageLocationMaster::where(['id'=>$id])->first();
        return view('order.edit_storage_location',['storage'=>$storage,'location'=>$location]);
    }
    
    public function updateStorage(Request $request){
        $requestData = $request->all();
     //  echo "<pre>";print_r($requestData);exit;
        
//        $rack_val = $requestData['rank_no'] - $requestData['prev_val_rack'];
//        $section_val = $requestData['section_no'] - 
        for($j=$requestData['prev_val_rack']+1;$j<$requestData['rank_no1']+1;$j++){
           // echo $j;
            $requestData['rank_no'] = $j;
            $requestData['location'] = $requestData['id'];
            $master = \App\StorageLocationMaster::create($requestData);
//            
            for($i=1;$i<$requestData["section_no"]+1;$i++)
            {
        //        $data["rank_no"]= $requestData["rank_no"];
                $data["section_no"]= $i;
        //        $data["location"]= $requestData["location"];
                $data['master_id'] = $master->id;
                $data["inserted_date"]= date("Y-m-d");
                \App\StorageLocationSubMaster::create($data);
            }
        }
        
//        $master = \App\StorageLocationMaster::findorfail($requestData['id']);
//        $new_val = $requestData['section_no'] - $master->section_no;
//        for($i=1;$i<$new_val+1;$i++)
//        {
//        $data["rank_no"]= $requestData["rank_no"];
//        $data["section_no"]= $master->section_no + $i;
//        $data["location"]= $requestData["location"];
//        $data['master_id'] = $master->id;
//        $data["inserted_date"]= date("Y-m-d");
//        \App\StorageLocation::create($data);
//        }
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('storage_list');
    }
    
    public function deleteStorage($id){
//        \App\StorageLocation::destroy($id);
        $query= \App\StorageLocation::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('storage_list');
    }

    
    public function getTlapproveorder(){
        $id = Auth::user()->id;
        $approved_order = \App\ApprovedOrder::where(['user_id'=>$id])->get();
        return view('order.approved_order',['approved_order'=>$approved_order]);
    }


    public function saveChecker(Request $request){
        $requestData = $request->all();
        $id = explode(",",$requestData['order_id']);
        $requestData['approve_id'] = $id[0];
        $requestData['order_id'] = $id[1];
        $requestData['comp_id'] = Auth::user()->comp_id;
        $requestData['tl_id'] = Auth::user()->id;
        \App\Checker::create($requestData);
        $order_detil = \App\ApprovedOrder::select('remaning_qty','return_qty','id')->where(['order_id'=>$requestData['order_id']])->first();
         if($order_detil->remaning_qty != ""){
            $remining_qty = $order_detil->remaning_qty - $requestData['return_qty'];
         }
         if($order_detil->return_qty != ""){
            $return_qty = $order_detil->return_qty + $requestData['return_qty'];
         }else{
             $return_qty = $requestData['return_qty'];
         }
         \App\OrderList::where(['id'=>$requestData['order_id']])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
         \App\ApprovedOrder::where(['id'=>$order_detil->id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
//        \App\OrderList::where(['id'=>$requestData['order_id']])->update(['return_qty'=>$requestData['return_qty']]);
//        \App\ApprovedOrder::where(['id'=>$requestData['approve_id']])->update(['return_qty'=>$requestData['return_qty']]);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('order_list_to_tl');
//        $requestData['']
//        echo "<pre>";print_r($requestData);exit;
    }
    
 /*  public function checkerList(){
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('return_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->return_permission,true);
       // echo "<pre>";print_r($cmp_json);exit;
//        if(count($cmp_json)>0){
         $orde_det = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id');
                    //  ->where('tbl_checker.sm_status','=',1)
                    //  ->where('tbl_checker.status','=',0)
                        if(@in_array("1", $cmp_json)){
//                            $checker_data = $orde_det->where(['tbl_checker.gm_status'=>1,'tbl_checker.status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                            $checker_data = $orde_det->where(['tbl_checker.gm_status'=>1,'tbl_checker.status'=>0]);
                        }else if(@in_array("2", $cmp_json)){
//                            $checker_data = $orde_det->where(['tbl_checker.sm_status'=>1,'tbl_checker.status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                            $checker_data = $orde_det->where(['tbl_checker.sm_status'=>1,'tbl_checker.status'=>0]);
                        }else{
//                            $checker_data = $orde_det->where(['tbl_checker.status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                            $checker_data = $orde_det->where(['tbl_checker.status'=>0]);
                        }
                      $checker_data = $orde_det->get();
        // echo "<pre>";print_r($cmp_json);exit;
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
//        echo "<pre>";print_r($checker_data);exit;
        return view('order.checker_list',['checker_data'=>$checker_data,'location'=>$location]);
    }
    */
    
    public function checkerList()
    {
        $user_comp_id = Auth::user()->comp_id;
        $company = \App\Company::select('level_permission','company_id')->get();
      //  echo "<pre>";print_r($company);exit;
         $order_arr = array();
        foreach($company as $c){
            $cmp_json = json_decode($c->level_permission,true);
            //  echo "<pre>";print_r($cmp_json);
                $orde_det = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id');
                    if(@in_array("1", $cmp_json)){
                            $checker_data = $orde_det->where(['tbl_checker.gm_status'=>1,'tbl_checker.status'=>0,'tbl_checker.comp_id'=>$c->company_id]);
//                        $checker_data = $orde_det->where(['tbl_checker.gm_status'=>1,'tbl_checker.status'=>0]);
                    }else if(@in_array("2", $cmp_json)){
                            $checker_data = $orde_det->where(['tbl_checker.sm_status'=>1,'tbl_checker.status'=>0,'tbl_checker.comp_id'=>$c->company_id]);
//                        $checker_data = $orde_det->where(['tbl_checker.sm_status'=>1,'tbl_checker.status'=>0]);
                    }else{
                            $checker_data = $orde_det->where(['tbl_checker.status'=>0,'tbl_checker.comp_id'=>$c->company_id]);
//                        $checker_data = $orde_det->where(['tbl_checker.status'=>0]);
                    }
                $checker_data = $orde_det->get();
                $order_arr[] = $checker_data;
        }
      //  echo "<pre>";print_r($order_arr);exit;
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        return view('order.checker_list',['checker_data'=>$order_arr,'location'=>$location]);
    }
    
    public function checkGMApproveList(){
        $depart_name = Auth::user()->depart_name;
        $user_comp_id = Auth::user()->comp_id;
        $checker_data = array();
        $company = \App\Company::select('return_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->return_permission,true);
        
        if(@in_array("1", $cmp_json)){
        $orde_det = DB::table('tbl_checker')
                 ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                 ->leftjoin('users','users.id','tbl_checker.tl_id')
                 ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id');
                  if(@in_array("2", $cmp_json)){
//                      $checker_data = $orde_det->where(['users.depart_name'=>$depart_name,'tbl_checker.sm_status'=>1,'tbl_checker.gm_status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                      $checker_data = $orde_det->where(['tbl_checker.sm_status'=>1,'tbl_checker.gm_status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                  }else{
//                      $checker_data = $orde_det->where(['users.depart_name'=>$depart_name,'tbl_checker.gm_status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                      $checker_data = $orde_det->where(['tbl_checker.gm_status'=>0,'tbl_checker.comp_id'=>$user_comp_id]);
                  }
                $checker_data = $orde_det->get();
               // echo "<pre>";print_r($checker_data);exit;
        }      
         $approve_data = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id')
//                      ->where(['tbl_checker.gm_status'=>1,'users.depart_name'=>$depart_name])
                      ->where(['tbl_checker.gm_status'=>1,'tbl_checker.comp_id'=>$user_comp_id])
                      ->get();
         $decline_data = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id')
//                      ->where(['tbl_checker.gm_status'=>2,'users.depart_name'=>$depart_name])
                      ->where(['tbl_checker.gm_status'=>2,'tbl_checker.comp_id'=>$user_comp_id])
                      ->get();
//        echo "<pre>";print_r($checker_data);exit;
        return view('order.gm_checker_list',['checker_data'=>$checker_data,'approve_data'=>$approve_data,'decline_data'=>$decline_data]);
    }
    
    public function check_list_status_by_gm($id,$remark,$status)
    {
        $users = \App\Checker::findorfail($id);
        if ($status == "Approve") { 
            $requestData['gm_status'] = "1";
        } else {
            $requestData['gm_status'] = "2";
            $order_detil = \App\ApprovedOrder::select('remaning_qty','return_qty','id')->where(['order_id'=>$users->order_id])->first();
             if($order_detil->remaning_qty != ""){
                $remining_qty = $order_detil->remaning_qty + $users->return_qty;
             }
             if($order_detil->return_qty != ""){
                $return_qty = $order_detil->return_qty - $users->return_qty;
             }else{
                 $return_qty = $users->return_qty;
             }
             \App\OrderList::where(['id'=>$users->order_id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
             \App\ApprovedOrder::where(['id'=>$order_detil->id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
        }
        $requestData['gm_date'] = date('Y-m-d');
        $requestData['gm_remark'] =$remark;
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('gm_check_list');
    }
    
    
    public function checkSMApproveList(){
        $user_comp_id = Auth::user()->comp_id;
        $checker_data = array();
        $company = \App\Company::select('return_permission')->where(['company_id'=>$user_comp_id])->first();
        $cmp_json = json_decode($company->return_permission,true);
        
       
        $depart_name = Auth::user()->depart_name;
        
        
        if(@in_array("2", $cmp_json)){
         $checker_data = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id')
                      ->where('tbl_checker.sm_status','=',0)
                      ->where(['users.depart_name'=>$depart_name,'tbl_checker.comp_id'=>$user_comp_id])
                      ->get();
        }
         $approve_data = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id')
                      ->where('tbl_checker.sm_status','=',1)
                      ->where(['users.depart_name'=>$depart_name,'tbl_checker.comp_id'=>$user_comp_id])
                      ->get();
         $decline_data = DB::table('tbl_checker')
                      ->select('tbl_checker.*','users.name','tbl_approved_order.item_no','tbl_approved_order.item_desc','tbl_approved_order.branch_name','tbl_approved_order.depart_name')
                      ->leftjoin('users','users.id','tbl_checker.tl_id')
                      ->leftjoin('tbl_approved_order','tbl_approved_order.id','tbl_checker.approve_id')
                      ->where('tbl_checker.sm_status','=',2)
                      ->where(['users.depart_name'=>$depart_name,'tbl_checker.comp_id'=>$user_comp_id])
                      ->get();
//        echo "<pre>";print_r($checker_data);exit;
        return view('order.tl_checker_list',['checker_data'=>$checker_data,'approve_data'=>$approve_data,'decline_data'=>$decline_data]);
    }
    
    public function check_list_status_by_dm($id,$remark,$status)
    {
        $users = \App\Checker::findorfail($id);
        if ($status == "Approve") { 
            $requestData['sm_status'] = "1";
        } else {
            $requestData['sm_status'] = "2";
            
             $order_detil = \App\ApprovedOrder::select('remaning_qty','return_qty','id')->where(['order_id'=>$users->order_id])->first();
             if($order_detil->remaning_qty != ""){
                $remining_qty = $order_detil->remaning_qty + $users->return_qty;
             }
             if($order_detil->return_qty != ""){
                $return_qty = $order_detil->return_qty - $users->return_qty;
             }else{
                 $return_qty = $users->return_qty;
             }
             \App\OrderList::where(['id'=>$users->order_id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
             \App\ApprovedOrder::where(['id'=>$order_detil->id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
        }
        $requestData['sm_date'] = date('Y-m-d');
        $requestData['remark'] =$remark;
        $users->update($requestData);
        
       
        
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('tl_check_list');
    }

    public function checker_list_save(Request $request){
        $requestData = $request->all();
      //  echo "<pre>";print_r($requestData);exit;
        $item1 = explode(",", $requestData['id']);
//        $get_item_details = \App\StorageLocation::select('item_no','current_qty','master_id')->where(['id' => $_POST['update_item_id']])->first();
//        
//        $m_id = $get_item_details->master_id;
        foreach($requestData['slot_no_swipe'] as $row){
//            echo $row;exit;
            if($row != ""){
                $new_item['master_id'] = $row;
                $new_item['item_no'] = $item1[2];
                $new_item['current_qty'] = $item1[1];
                $new_item['status'] = 1;
                $new_item['inserted_date'] = date('Y-m-d');
                \App\StorageLocation::create($new_item);
                $total = \App\StorageLocation::where(['master_id'=>$row])->get();
                if(count($total)>0){
                    \App\StorageLocationSubMaster::where(['id'=>$row])->update(['is_active'=>1]);
                }else{
                    \App\StorageLocationSubMaster::where(['id'=>$row])->update(['is_active'=>0]);
                }
                //echo "<pre>";print_r($total); exit;
                $checker = \App\Checker::select('order_id')->where(['id' => $item1[0]])->first();
                 \App\Checker::where(['id' => $item1[0]])->update(['status'=>1]);
                //  $order_detil = \App\ApprovedOrder::select('remaning_qty','return_qty','id')->where(['order_id'=>$checker->order_id])->first();
                //  if($order_detil->remaning_qty != ""){
                //     $remining_qty = $order_detil->remaning_qty - $item1[1];
                //  }
                //  if($order_detil->return_qty != ""){
                //     $return_qty = $order_detil->return_qty + $item1[1];
                //  }else{
                //      $return_qty = $item1[1];
                //  }
                //  \App\OrderList::where(['id'=>$checker->order_id])->update(['return_qty'=>$item1[1],'remaning_qty'=>$remining_qty]);
                //  \App\ApprovedOrder::where(['id'=>$order_detil->id])->update(['return_qty'=>$return_qty,'remaning_qty'=>$remining_qty]);
            }
        }
        return redirect('checker_list');
    }
    
    public function vendar_list_save(Request $request){
        $requestData = $request->all();
      //  echo "<pre>";print_r($requestData);exit;
        $item1 = explode(",", $requestData['id']);
//        $get_item_details = \App\StorageLocation::select('item_no','current_qty','master_id')->where(['id' => $_POST['update_item_id']])->first();
//        
//        $m_id = $get_item_details->master_id;
        foreach($requestData['slot_no_swipe'] as $row){
//            echo $row;exit;
            if($row != ""){
                $new_item['master_id'] = $row;
                $new_item['item_no'] = $item1[2];
                $new_item['current_qty'] = $requestData['qty'][0];//$item1[1];
                $new_item['status'] = 1;
                $new_item['inserted_date'] = date('Y-m-d');
                \App\StorageLocation::create($new_item);
                $total = \App\StorageLocation::where(['master_id'=>$row])->get();
                if(count($total)>0){
                    \App\StorageLocationSubMaster::where(['id'=>$row])->update(['is_active'=>1]);
                }else{
                    \App\StorageLocationSubMaster::where(['id'=>$row])->update(['is_active'=>0]);
                }
                //echo "<pre>";print_r($total); exit;
                $purchase_details = \App\PurchaseOrder::where(['id' => $item1[0]])->first();
                $storage_add_qty = $purchase_details->storage_add_qty;
                $storage_add_qty = $storage_add_qty + $requestData['qty'][0];
                \App\PurchaseOrder::where(['id' => $item1[0]])->update(['storage_status'=>1,'storage_add_qty'=>$storage_add_qty]);
                
            }
        }
        
        return redirect('vendor_to_po_dept');
    }

    // END
    
    public function editPurchase(){
		$id = $_GET['id'];
		$po_detail = DB::table('tbl_purchase_order')//\App\PurchaseOrder::where(['id'=>$id])->first();
                          ->select('tbl_purchase_order.*','tbl_vendor.vendor_name')
                          ->leftjoin('tbl_vendor','tbl_vendor.id','=','tbl_purchase_order.vendor_id')
                          ->where(['tbl_purchase_order.id'=>$id])
                          ->first();
//		echo "<pre>";print_r($po_detail);exit;
		return view('order.update_purchase_form',['po_detail'=>$po_detail]);
	}
    
	public function updatePurchase($id,Request $request){
		$requestData = $request->all();
                $user_comp_id = Auth::user()->comp_id;
		//echo "<pre>";print_r($requestData);exit;
		$po_data = \App\PurchaseOrder::where(['id'=>$id])->first();
                if(isset($requestData['file_upload'])){
                    $design = $requestData['file_upload'];
                    $filename = $design->getClientOriginalName();
                    $destination= "vendor_invoice/";
                    $design->move($destination,$filename);
                }
            //    echo $filename;exit;
		$requestData['file_upload'] = $filename;
		$requestData['received_qty'] = $po_data->received_qty  + $requestData['received_qty'];
//		$requestData1['received_remark'] = json_encode($requestData['remark']);
		$requestData['received_date'] = date('Y-m-d');
                $requestData['update_status'] = 1;
                $requestData['comp_id'] = $user_comp_id;
		//echo "<pre>";print_r($requestData1);exit;
		$po_data->update($requestData);
		Session::flash('alert-success',"Updated Successfully");
		return redirect('vendor_to_po_dept');
	}
	
	public function tl_checker_update(){
		$id = $_GET['id'];
		\App\ApprovedOrder::where(['order_id'=>$id])->update(['cheker_flag'=>1]);
		\App\OrderList::where(['id'=>$id])->update(['cheker_flag'=>1]);
		return redirect('order_list_to_tl');
	}
	
	public function getItemprice(){
	    $id_data = explode("/",$_GET['id']);
	    $data = \App\ItemList::select('price')->where(['item_no'=>$id_data[1],'item_desc'=>$id_data[0]])->first();
	    echo $data->price;
	}

}
