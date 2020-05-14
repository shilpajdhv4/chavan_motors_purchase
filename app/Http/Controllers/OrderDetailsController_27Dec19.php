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

class OrderDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $product_grp_list = \App\ProductCategory::select('product_type')->groupBy('product_type')->get();
        return view('order.order_form',['prod_type'=>$product_grp_list]);
    }
    
    
    
    public function nofi_page(){
        
        $noti_data=DB::table('tbl_order')
            ->leftjoin('tbl_item', 'tbl_order.item_no', '=', 'tbl_item.item_no')
            ->select('tbl_item.item_no', 'tbl_item.item_desc','tbl_item.qty AS stock_qty','tbl_item.threshold_qty',DB::raw('SUM(tbl_order.qty) AS order_qty'))
            ->groupBy('tbl_item.item_no')
                ->groupBy('tbl_item.item_desc')
                ->groupBy('tbl_item.qty')
                ->groupBy('tbl_item.threshold_qty')
                ->get();
//        echo "<pre>";print_r($noti_data);
//        exit();
        return view('order.nofi_page',['list'=>$noti_data]);
    }
    
    
    public function get_product_grp($type_item)
    {
        $type_item = trim($type_item);
        $product_grp_list = \App\ProductCategory::select('product_name','product_type')->where(['product_type'=>$type_item])->groupBy('product_type')->groupBy('product_name')->get();
        
        echo json_encode($product_grp_list,true);
    }
    
    public function get_product_type_order_form()
    {
        
        $product_grp_list = \App\ProductCategory::select('product_type')->groupBy('product_type')->get();
       
        echo json_encode($product_grp_list,true);
    }
    
    public function get_item_name($product_type,$type_item)
    {
       
        $type_item = trim($type_item);
        $product_grp_list = \App\ItemList::select('item_desc','item_no')->where(['prod_type'=>$type_item,'product_grp'=>$product_type])->get();
        echo json_encode($product_grp_list,true);
    }
    
    public function save_order_list(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        
       $requestData = $request->all();
       
//       if (!empty($requestData['type'])) {
           for($i=0;$i< count($requestData['type']);$i++)
           {
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
             \App\OrderList::create($data);
           }
           Session::flash('alert-success', 'Saved Successfully.');
            return redirect('order_form');
//        }
       
    }
    
    public function purchase_form()
    {
        $id = $_GET['id'];
        $order_details = \App\OrderList::select('*')->where(['id'=>$id])->first();       
        $get_price= \App\ItemList::select('price')->where(['item_no'=>$order_details->item_no])->first();
        return view('order.purchase_form',['order_list'=>$order_details,'price'=>$get_price]); 
    }
    
    public function order_tl_today_dm()
    {
        $current_date=date("Y-m-d");
        $depart_name = Auth::user()->depart_name;
        $details=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')->where(['users.depart_name'=>$depart_name])->whereIn('tbl_order.status_approved_by_dm',array(0))->get();
        
        
        $details_gm=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>1])->get();
        
        
        $details_decline=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>3])->get();
        
        $details_hold=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*')->where(['users.depart_name'=>$depart_name])->whereIn('tbl_order.status_approved_by_dm',array(2))->get();

       

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
            
            $requestData['status_remark_by_dm'] =$remark;
            $users->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
            return redirect('order_tl_today_dm');
    }
    
    
    
    public function order_tl_today_gm()
    {
        $current_date=date("Y-m-d");
        $depart_name = Auth::user()->depart_name;
        $details=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->select('users.name','tbl_order.*',DB::raw('group_concat(tbl_order.id) AS order_ids'),DB::raw('SUM(tbl_order.qty) AS order_qty'))
            ->where(['users.depart_name'=>$depart_name,'tbl_order.status_approved_by_dm'=>1,'tbl_order.status_approved_by_gm'=>0])
//            ->groupBy('users.name')
            ->groupBy('tbl_order.item_no')
//            ->groupBy('tbl_order.id')
            ->get();
        
//        echo "<pre>";print_r($details);
//        exit();

        return view('order.order_tl_today_gm',['order_list_to_dm'=>$details]);
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
            $requestData['status_approved_by_gm'] = "2";
            }
            $requestData['status_remark_by_gm'] =$remark;
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
       $order_details = \App\OrderList::select('*')->where(['user_id'=>$id])->get();   
       $check_order_from_po = \App\ApprovedOrder::select('*')->where(['user_id'=>$id])->get();   
       return view('order.order_list_to_tl',['order_details'=>$order_details,'order_from_po'=>$check_order_from_po]);
    }
    
    public function order_utilize_form()
    {
      $id = Auth::user()->id;   
      $check_order_from_po = \App\ApprovedOrder::select('*')->where(['user_id'=>$id])->get();     
      return view('order.order_utilize_form',['order_from_po'=>$check_order_from_po]);  
    }
    
    public function get_order_utilize_qty_tl($id)
    {
        $orderutilize = \App\OrderUtilize::select('*')->where(['order_id'=>$id])->first(); 
        if(empty($orderutilize))
        {
         $check_order_from_po = \App\ApprovedOrder::select('*')->where(['order_id'=>$id])->first(); 
         $actual_data['actual_qty']=$check_order_from_po->qty;
         $actual_data['stock_qty']=$check_order_from_po->qty;
        }
        else{
            $actual_data['actual_qty']=$orderutilize->actual_qty;
            $actual_data['stock_qty']=$orderutilize->stock_qty;
        }
        echo json_encode($actual_data,true);
    }
    
    public function save_order_utilize(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $requestData = $request->all();
        for ($i = 0; $i < count($requestData['used_qty']); $i++) {
            $data['order_id'] = $requestData['order_id'];
//            $data['actual_qty']=$requestData['actual_qty'][$i];
            $data['used_qty'] = $requestData['used_qty'][$i];
            $data['user_id'] = $user_id;
            $data['remark'] = $requestData['remark'][$i];
            $data['inserted_date'] = date("Y-m-d");
            \App\OrderUtilize::create($data);
        }
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
               . "<td>$stock_qty</td>"
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
    
    public function order_list()
    {
//        $order_details = \App\OrderList::orderBy('id','asc')->get();
        
        $details=DB::table('tbl_order')
            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
            ->leftjoin('tbl_item', 'tbl_order.item_no', '=', 'tbl_item.item_no')    
            ->select('users.name','tbl_order.*','users.branch_name','users.depart_name','tbl_item.qty as stock_qty')
            ->where(['tbl_order.status_approved_by_gm'=>1])->groupBy('tbl_order.id')
            ->get();
        
        return view('order.order_list',['order_list'=>$details]); 
    }
    
    public function create_purchase_form()
    {
        $current_date=date("Y-m-d");
        $depart_name = Auth::user()->depart_name;
//        $details=DB::table('tbl_order')
//            ->leftjoin('users', 'tbl_order.user_id', '=', 'users.id')
//            ->select('users.name','tbl_order.*',DB::raw('group_concat(tbl_order.id) AS order_ids'),DB::raw('SUM(tbl_order.qty) AS order_qty'))
//            ->where(['tbl_order.status_approved_by_gm'=>1])
//            ->groupBy('tbl_order.item_no')
//            ->get();
        $vendor_list= \App\VendorList::orderBy('id','asc')->get();
        
        $product_grp_list = \App\ProductCategory::select('product_type')->groupBy('product_type')->get();
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
       $details=DB::table('tbl_purchase_order')
            ->leftjoin('users', 'tbl_purchase_order.tl_ids', '=', 'users.id')
            ->select('users.name','tbl_purchase_order.*')
            ->where('maker_status', '0')
            ->get();
       return view('order.vendor_to_po_dept',['po_list'=>$details]); 
    }
    
    public function update_maker_po_dept($id)
    {
//            $users = \App\PurchaseOrder::findorfail($id);
//            $requestData['maker_date'] = date("Y-m-d");
//            $requestData['maker_status'] ="1";
//            $users->update($requestData);
//            Session::flash('alert-success', 'Updated Successfully.');
//            return redirect('vendor_to_po_dept');
        
            $order_details= \App\OrderList::select('*')->where(['id'=>$id])->first();
            $stock_qty= \App\ItemList::select('qty')->where(['item_no'=>$order_details->item_no])->first();
            
            $data['order_id']=$order_details->id;
            $data['item_no']=$order_details->item_no;
            $data['item_desc']=$order_details->item_name;
            $data['order_qty']=$order_details->qty;
            $data['received_qty']=$order_details->qty;
            $data['user_id']=$order_details->user_id;
            $data['branch_name']=$order_details->branch_name;
            $data['depart_name']=$order_details->depart_name;
            $data['received_date']=date("Y-m-d");
            \App\ApprovedOrder::create($data);
            DB::table('tbl_order')->where('id', $id)->delete();
            

            
        \App\ItemList::where('item_no', $order_details->item_no)->update([
'qty' => $stock_qty->qty-$order_details->qty
]);
        
\App\StorageLocation::where('item_no', $order_details->item_no)->update([
'current_qty' => $stock_qty->qty-$order_details->qty
]);
        
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
       
        $data["type"]= json_encode($requestData["type"],true);
        $data["product_grp"]= json_encode($requestData["product_grp"],true);
        $data["vendor_id"]= $requestData["vendor_name"];
        $data["item_desc"]= json_encode($requestData["item_name"],true);
        $data["price"]= json_encode($requestData["qty"],true);
        $data["qty"]= json_encode($requestData["price"],true);
        $data["remark"]= json_encode($requestData["remark"],true);
        $data["inserted_date"]= date("Y-m-d");
        $data["user_id"]= $user_id;
        
        \App\PurchaseOrder::create($data);
//        return redirect('create_purchase_form');
        
        $po_data['item_name']=$requestData["item_name"];
        $po_data['qty']=$requestData["qty"];
        $po_data['price']=$requestData["price"];
        
        $po_id = \App\PurchaseOrder::orderBy('id', 'desc')->limit('1')->first();
        $vendor_list= \App\VendorList::select('*')->where(['id'=>$requestData["vendor_name"]])->first();
        
        return view('order.purchase_form',['vendor_list'=>$vendor_list,'po_data'=>$po_data,'po_id'=>$po_id]); 
    }
    
    
    
    
    
    // Storage Location
    
    public function add_storage_location()
    {
       return view('order.add_storage_location');  
    }
    
    
    public function save_storage(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $requestData = $request->all(); 
        
//        echo "<pre>";print_r($requestData);
//        exit;
        $master = \App\StorageLocationMaster::create($requestData);
        
        for($i=1;$i<$requestData["section_no"]+1;$i++)
        {
        $data["rank_no"]= $requestData["rank_no"];
        $data["section_no"]= $i;
        $data["location"]= $requestData["location"];
        $data['master_id'] = $master->id;
        $data["inserted_date"]= date("Y-m-d");
        \App\StorageLocation::create($data);
        }
        Session::flash('alert-success', 'Inserted Successfully.');
            return redirect('add_storage_location');
        
    }

    public function storage_location()
    {
        $item_list = \App\ItemList::select('item_no','item_desc')->orderBy('id', 'desc')->get();
        $get_location= \App\StorageLocation::select('location')->groupBy('location')->get();
        
        return view('order.storage_location',['get_location'=>$get_location]); 
    }
    
    
    public function show_storage_location_form($l_name)
    {
        $item_list = \App\ItemList::select('item_no','item_desc')->orderBy('id', 'desc')->get();
        $st_loc = \App\StorageLocation::select('rank_no',DB::raw('group_concat(section_no ORDER BY section_no ASC) AS sec_no'),'item_no',DB::raw('group_concat(status ORDER BY section_no ASC) AS status'))->where(['location'=>$l_name])->groupBy('rank_no')->orderBy('rank_no', 'asc')->get();
        $sec_no= array();
        $status=array();
        $rack=array();
        $f_data=array();
        $split_data=array();
        if($st_loc)
        {
        for($i=0;$i<count($st_loc);$i++)
        {
            $sec_no[]= explode(",", $st_loc[$i]->sec_no);
//            $item_no[]= explode(",", $st_loc[$i]->item_no);
//            $current_qty[]= explode(",", $st_loc[$i]->current_qty);
            $status[]= explode(",", $st_loc[$i]->status);
            $rack[]= explode(",", $st_loc[$i]->rank_no);
        }
        
        for ($j = 0; $j < count($sec_no); $j++) {
            for ($k = 0; $k < count($sec_no[$j]); $k++) {
                //$f_data[$j][] = $sec_no[$j][$k] . "," . $item_no[$j][$k] . "," . $current_qty[$j][$k];
                $f_data[$j][] = $sec_no[$j][$k] . "," . $status[$j][$k]. "," . $l_name;
            }
        }

        for ($l = 0; $l < count($f_data); $l++) {

            $split_data[] = array_chunk($f_data[$l], 3);
        }
        }

       return view('order.show_storage_location_form',['item_list'=>$item_list,'rack_data'=>$split_data,'rack_no'=>$rack,'location_name'=>$l_name]);   
    }


    
    
    public function show_storage_location_modal($id)
    {
        $split_data = explode(",", $id);
        $get_data = \App\StorageLocation::select('item_no','current_qty')->where(['rank_no' => $split_data[0],'section_no' => $split_data[1],'location' => $split_data[3]])->first();
        $print = '';
        if($get_data->item_no)
        {
           $swipe_data=$split_data[0].",".$split_data[1].",".$split_data[3];
            
           $print .="<h4>Rack No :- $split_data[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slot No :- $split_data[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location :- $split_data[3]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button class='btn btn-foursquare swipe_items' value='$swipe_data'>SWIPE</h4>";
           $print .= "<form id='save_item_sl'>".csrf_field()."<table class='table table-bordered'><tr><th>#</th>"
                    . "<th style='text-align: center;'>Select Item Name / No.</th>"
                    . "<th style='text-align: center;'>Current Qty</th>"
                    . "<th style='text-align: center;'>Action</th>"
                    . "</tr>"; 
           
           $item_decode= json_decode($get_data->item_no);
           $qty_decode= json_decode($get_data->current_qty);
           
           for ($i = 0; $i < count($item_decode); $i++) {
                $get_item_name = \App\ItemList::select('item_desc')->where(['item_no' => $item_decode[$i][0]])->first();
                $print .= "<tr><td><button type='button' class='close_tr'>&times;</button></td><td style='display:none;'><input type='text' class='form-control item_no' name='item_no[]' style=' width:500px; text-align: center;' value='$item_decode[$i]'>"
                        . "<td style='text-align: center;'>$get_item_name->item_desc / $item_decode[$i]<input type='hidden' class='item_code' value='".$item_decode[$i]."'</td>"
                        . "<td style='text-align: center;'><input type='text' class='form-control c_qty' name='c_qty[]' style=' width:100px; text-align: center;' value='$qty_decode[$i]' required=''></td>"
                        . "<td><a href='#' id='".$item_decode[$i].','.$qty_decode[$i]."' class='btn btn-foursquare swipe_items1' >SWIPE</a></h4></td></tr>";
            }
            $print .= "<tr>"
                    . "<td style=' display:none;'><input type='text' class='form-control rack_no' value='$split_data[0]' name='rack_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control section_no' value='$split_data[1]' name='section_no'></td>"
                    . "<td style=' display:none;'><input type='text' class='form-control location' value='$split_data[3]' name='location'></td>"
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
                    . "</tr>";
            $print .= "<tbody id='append_items'></tbody>";


            $print .= "</table></form>";
        }
        echo $print;
    }
    
    
    public function update_storage_details()
    {
//        echo "<pre>";print_r($_POST);exit;
        if (@$_POST['item_no']) {
            \App\StorageLocation::where(['rank_no' => $_POST['rack_no'], 'section_no' => $_POST['section_no'],'location' => $_POST['location']])->update([
                'item_no' => json_encode($_POST['item_no'], true), 'current_qty' => json_encode($_POST['c_qty'], true), 'status' => '1'
            ]);

            for ($i = 0; $i < count($_POST['item_no']); $i++) {
                \App\ItemList::where(['item_no' => $_POST['item_no'][$i]])->update([
                    'qty' => $_POST['c_qty'][$i]
                ]);
            }
        } else {
            
            \App\StorageLocation::where(['rank_no' => $_POST['rack_no'], 'section_no' => $_POST['section_no'],'location' => $_POST['location']])->update([
                'item_no' => "", 'current_qty' => "", 'status' => '0'
            ]);

//            for ($i = 0; $i < count($_POST['item_no']); $i++) {
//                \App\ItemList::where(['item_no' => $_POST['item_no'][$i]])->update([
//                    'qty' => $_POST['c_qty'][$i]
//                ]);
//            }
            
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
        $id = $_GET['swap'];
        $id1 = $_GET['href'];
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
        $print .= "<input type='hidden' class='form-control' name='from_swipe_data' id='from_swipe_data' style='width:100px;' value='$id'>";
        $print .= "<input type='hidden' class='form-control' name='item_qty_val' id='from_swipe_data' style='width:100px;' value='$id1'>";
        $print .= "</form></table>";
        echo $print;
    }
    
    
    public function getRackslot($id){
        $rack_data = "";
        $data = \App\StorageLocation::select('rank_no','id')->where(['location'=>$id])->groupBy('rank_no')->get();
        $rack_data.='<option>Select Rack</option>';
        foreach($data as $row){
            $rack_data.='<option value='.$row->id.'>'.$row->rank_no.'<option>';
        }
        echo $rack_data;
    }
    
    public function getSlot(){
        $rack_data = "";
        $loc_id = $_GET['loc_id'];
        $rack_id = $_GET['rack_id'];
        $data = \App\StorageLocation::select('id','section_no')->where(['location'=>$loc_id,'rank_no'=>$rack_id])->get();
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
        $from_swipe_data= explode(",", $_POST['from_swipe_data']);
//        echo "<pre>";print_r($_POST); exit;
        $item1 = $qty1 = array();
        $get_item_details = \App\StorageLocation::select('id','item_no','current_qty')->where(['rank_no' => $from_swipe_data[0],'section_no' => $from_swipe_data[1],'location' => $from_swipe_data[2]])->first();
        if(isset($_POST['item_qty_val'])){
             $item_qty_val = explode(",", $_POST['item_qty_val']);
        } 
        
        $storage_update_item = $storage_update_qty = array();
        $storage_update = \App\StorageLocation::select('item_no','current_qty')->where(['rank_no' => $_POST['rack_no_swipe'], 'id' => $_POST['slot_no_swipe'],'location' => $_POST['location_swipe']])->first();
        if($storage_update->item_no != ""){
            $storage_update_item = json_decode($storage_update->item_no,true);
        }
        array_push($storage_update_item, $item_qty_val[0]);
        
        if($storage_update->current_qty != "")   {
            $storage_update_qty = json_decode($storage_update->current_qty,true);
        }
        array_push($storage_update_qty, $item_qty_val[1]);
        
        $update_data['item_no'] = json_encode($storage_update_item);
        $update_data['current_qty'] = json_encode($storage_update_qty);
        \App\StorageLocation::where(['rank_no'=>$_POST['rack_no_swipe'],'location'=>$_POST['location_swipe'],'id' => $_POST['slot_no_swipe']])->update([
            'item_no' => $update_data['item_no'], 'current_qty' => $update_data['current_qty'], 'status' => '1']); 
        //remove value
        if($get_item_details->item_no){
            $item = json_decode($get_item_details->item_no,true);
            if (($key = array_search($item_qty_val[0], $item)) !== false) {
                unset($item[$key]);
            }
            if(!empty($item)){
                foreach($item as $a){
                    $item1[] = $a;
                }
                $remove_data['item_no'] = json_encode($item1,true);
            }else{
                $remove_data['item_no'] = NULL;
            }
            
        }
        
        if($get_item_details->current_qty){
            $qty = json_decode($get_item_details->current_qty,true);
            if (($key = array_search($item_qty_val[1], $qty)) !== false) {
                unset($qty[$key]);
            }
            if(!empty($qty)){
                foreach($qty as $a){
                    $qty1[] = $a;
                }
                $remove_data['current_qty'] = json_encode($qty1,true);
            }else{
                $remove_data['current_qty'] = NULL;
            }
        }
        
        if($remove_data['item_no'] != "")
            $status = 1;
        else
            $status = 0;
        
        \App\StorageLocation::where(['id' => $get_item_details->id])->update([
            'item_no' => $remove_data['item_no'], 'current_qty' => $remove_data['current_qty'], 'status' => $status]); 
    }
    
    public function save_storage_location(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_name = Auth::user()->branch_name;
        $depart_name = Auth::user()->depart_name;
        $requestData = $request->all(); 
        
        $requestData["inserted_date"]=date("Y-m-d");
        \App\StorageLocation::create($requestData);
        Session::flash('alert-success', 'Inserted Successfully.');
        return redirect('storage_location');
    }

    public function showStorage(){
        return view();
    }


    // END
    

    

}
