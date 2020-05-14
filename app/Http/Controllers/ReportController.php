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

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('permission:get_report');
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
    
    public function getReport(){
       return view('report.report');
    }
    
    public function downloadReport(Request $request)
    {
       $requestData = $request->all();
       $user_comp_id = Auth::user()->comp_id;
//       echo "<pre>";print_r($requestData);exit;
       $data = DB::table('tbl_approved_order')
             ->select('tbl_approved_order.*','users.name')
             ->leftjoin('users','users.id','tbl_approved_order.user_id')
            // ->where(['comp_id'=>$user_comp_id])
             ->whereBetween('received_date',array($requestData['from_date'],$requestData['to_date']))
             ->get();
//       echo "<pre>";print_r($data);exit;
       $i = 1;
       $print = "";
       $print .='<table class="table table-bordered table-striped" border="1"><tr>'
               . '<td>#</td>'
               . '<td>Item No</td>'
               . '<td>Item Desc</td>'
               . '<td>Order Qty</td>'
               . '<td>Received Qty'
               . '<td>TL Name</td>'
               . '<td>Branch Name</td>'
               . '<td>Department Name</td>'
               . '</tr>'; 
       foreach($data as $row){
           $print .='<tr>'
                   . '<td>'.$i++.'</td>'
                   . '<td>'.$row->item_no.'</td>'
                   . '<td>'.$row->item_desc.'</td>'
                   . '<td>'.$row->order_qty.'</td>'
                   . '<td>'.$row->received_qty.'</td>'
                   . '<td>'.$row->name.'</td>'
                   . '<td>'.$row->branch_name.'</td>'
                   . '<td>'.$row->depart_name.'</td>'
                   . '</tr>';
       }
       echo $print;
       
    }
    
    
    
  

}
