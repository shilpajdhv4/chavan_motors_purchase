@extends('layouts.app')
@section('title', 'Home')
@section('content')
<?php 
$user_comp_id = Auth::user()->comp_id;
//$stock_qty = App\StorageLocation::select('current_qty')->where(['item_no'=>$itemitem_no])
$items = \App\ItemList::select('item_no','item_desc','threshold_qty')
//        ->where(['comp_id'=>$user_comp_id])
        ->get();
//echo "<pre>";print_r($items);exit;
$x=1;

//exit;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{Auth::user()->name}}
                    You are logged in!
                </div>
                <br/>
                <?php 
                $user = \Auth::user();
                foreach($user->getRoleNames() as $v){ 
                    if($v == "Purchase Department"){ ?>
    
                <div class="box box-primary">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                      <!--<i class="ion ion-clipboard"></i>-->
                      <h3 class="box-title btn btn-success">Please refill the following items in your storage</h3>

                      <div class="box-tools pull-right">
                        
                      </div>
                    </div>
            <!-- /.box-header -->
                    <div class="box-body">
                      <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                      <ul class="todo-list ui-sortable">
                          
                        <?php 
                            foreach($items as $item){
                                $stock_qty = DB::table('tbl_storage_location')
                                        ->select(DB::raw("SUM(current_qty) as stock_qty"),'tbl_item.item_no','tbl_item.item_desc','tbl_item.threshold_qty')
                                        ->leftjoin('tbl_item','tbl_item.item_no','tbl_storage_location.item_no')
                                        ->where(['tbl_storage_location.item_no'=>$item->item_no])
                                        ->havingRaw('stock_qty <= '.$item->threshold_qty)
                                        ->first(); 
                                if(!empty($stock_qty)){
                        ?>
                        <li>
                          <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                          </span>
                          <span class="text"><?php echo "Item Name : ".$stock_qty->item_desc.' | Treshold Quantity : <small class="label label-danger">'.$stock_qty->threshold_qty.'</small> | Storage Quantity : <small class="label label-danger">'.$stock_qty->stock_qty.'</small>'; ?></span>
                        </li>
                            <?php } } ?>
                      </ul>
                    </div>
                </div>
                <?php                    
            }else if($v == "Admin"){
                $i = 0;
                $color_array = array("bg-aqua", "bg-green", "bg-yellow", "bg-red");
                $company_list = \App\Company::where(['is_active'=>0])->get(); 
         //   echo "<pre>";print_r($company_list);exit;
                ?>
                <div class="row">
                @foreach($company_list as $row)   
                <?php if($i == 3){ $i=0; } ?>
                <div class="col-lg-3 col-xs-6">
                  <div class="small-box <?php echo $color_array[$i]; ?>">
                    <div class="inner">
                      <p>{{$row->company_name}}</p>
                    </div>
                    <a href="{{url('company_sales/'.$row->company_id)}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <?php $i++; ?>
                @endforeach
                </div>
            <?php } 
        }
    ?>
            </div>
        </div>
        
    </div>
</div>
@endsection
