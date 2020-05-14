@extends('layouts.app')
@section('title', 'Order List')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<?php $x = 1; ?>
<section class="content-header">
    <h1>
        Order List
        
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <table id="example1" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
           <th>No</th>
           <th>Item No.</th>
           <th>Item Description</th>
           <th>Qty</th>
<!--           <th>Vendor Name</th>-->
           <th>Branch Name</th>
           <th>Date</th>
<!--           <th>Status from Manager</th>-->
           <th>Remark from Manager</th>
<!--           <th>Status from GM</th>-->
           <th>Remark from GM</th>
		   <th>Action</th>
           
        </tr>
    </thead>
    <tbody>
        @foreach($order_details as $row)
        
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_name}}</td>
            <td>{{$row->qty}}</td>
<!--            <td>{{$row->vendor_name }}</td>-->
            <td>{{$row->branch_name }}</td>
            <td>{{$row->inserted_date }}</td>
<!--            <td>
                <?php if($row->status_approved_by_dm=="1") { ?>
                <button class="btn btn-success" type="button" value="{{$row->id}}">Approved</button> 
                <?php } else if($row->status_approved_by_dm=="0") { ?>
                <button class="btn btn-danger" type="button" value="{{$row->id}}">Declined</button> <?php } else {?>
                    
                    <?php } ?>
                
                
            </td>-->
            <td>{{$row->status_remark_by_dm }}</td>
<!--           <td>
                <?php if($row->status_approved_by_gm=="1") { ?>
                <button class="btn btn-success" type="button" value="{{$row->id}}">Approved</button> 
                <?php } else if($row->status_approved_by_gm=="0") { ?>
                <button class="btn btn-danger" type="button" value="{{$row->id}}">Declined</button> <?php } else {?>
                    
                    <?php } ?>
                
                
            </td>-->
            <td>{{$row->status_remark_by_gm }}</td>
			<td><?php if($row->purchase_status=="1" && $row->cheker_flag=="0"){ ?><a href="{{url('tl_checker_update?id='.$row->id)}}"> <button class="btn btn-success" type="button" value="Checker">Receiver</button> </a> <?php } ?></td>
        </tr>
        @endforeach
    
</tbody>
            </table>
        
            </div>
        </div>
    </div>
</div>
</div>
        </div>
    </div>
</section>
            <?php $y= 1; ?>
<section class="content-header">
    <h1>
        Received Order List
        
    </h1>
</section>

<section class="content">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <table id="example2" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
           <th>No</th>
           <th>Item No.</th>
           <th>Item Description</th>
           <th>Required Qty</th>
           <th>Received Qty</th>
           <th>Used Qty</th>
           <th>Return Qty</th>
           <th>Remaining Qty</th>
           <th>Maker Date</th>
           <th>Action</th>
           
        </tr>
    </thead>
    <tbody>
        @foreach($order_from_po as $row)
        <?php $orderutilize = \App\OrderUtilize::select(DB::raw('sum(used_qty) as used_qty'))->where(['order_id'=>$row->order_id])->first(); 
     //   echo "<pre>";print_r($orderutilize);exit; ?>
        <tr>
            <td>{{$y++}}</td>
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_desc}}</td>
            <td>{{$row->order_qty}}</td>
            <td>{{$row->received_qty}}</td>
            <td>{{@$orderutilize->used_qty}}</td>
            <td>{{$row->return_qty}}</td>
            <td>{{$row->remaning_qty}}</td>
            <td>{{$row->received_date }}</td>
            <?php if($row->remaning_qty != 0) { ?>
            <td><button class=" btn btn-danger checker_status" id="{{$row->remaning_qty}}" value="<?php echo $row->id.','.$row->order_id; ?>">Return To Storage</button></td>
            <?php } else { ?><td></td></td><?php } ?>
        </tr>
        @endforeach
    </tbody>
            </table>
        
            </div>
        </div>
    </div>
</div>
</div>
</section>
            
<div class="modal" id="modal-danger">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="design-form" action="{{url('save_checker')}}" method="post" >
                {{ csrf_field() }}
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Return To Storage <button type="button" class="close" data-dismiss="modal">&times;</button></h3>
            </div>
            <!-- Modal body -->
            <h4><span id="error_model" style="color:red"></span></h4>
            <div class="modal-body">
                <div id="show_data">
                    <div class="form-group row">
                        <label class="col-md-3">Enter Return Quantity</label>
                        <div class="input-group date col-md-4">
                            <input type="number" class=" form-control assign_qty number" name="return_qty" id="return_qty" value="" required >&nbsp;<span id="errmsg" style='color: red;'></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Remark</label>
                        <div class="input-group date col-md-4">
                            <textarea class=" form-control" name="tl_remark" id="tl_remark" required></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="order_id" value="" />
                    <input type="hidden" id="remaning" value="" />
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <!--<button class="btn btn-success add_more_items pull-left" type="button">ADD</button>-->
                <button type="submit" class="btn btn-success save_data" style="display: none;">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
    $('#example1').DataTable()
    

    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
  
  $(document).on('focusout', '.assign_qty', function (e) {
        var sum = $(".assign_qty").val();
      //  alert(sum);
        var require_val = $("#remaning").val();
      //  alert(require_val);
        var val1 = parseInt(sum);
        var val2 = parseInt(require_val);
        if(val1 > val2){
            $(".save_data").css("display","none");
            $(".assign_qty").val("");
            $("#error_model").text("Your returned quantity is more than required quantity.");
        }
        else{
            $("#error_model").text("");
            $(".save_data").css("display","block");
        }
        
//        
    })
  
  $(".checker_status").click(function () {
      var id = $(this).val();
      var thisid = $(this).attr('id');
      
//    alert(thisid);
      $("#order_id").val(id);
      $("#remaning").val(thisid);
       $('#modal-danger').modal('show');
        
//        $.ajax({
//            url: 'update_maker_po_dept/' + id,
//            type: "GET",
//            success: function (response) {
//                $("#show_data").html(response);
//                $('#modal-danger').modal('show');
////               location.reload();
//               
//            }
//        });
    }); 

   $(document).ready(function () {
      //called when key is pressed in textbox
      $(".number").keypress(function (e) {
          var num1 = parseInt(e, 10);
         // $("#return_qty").val(num1);
         //if the letter is not digit then display error and don't type anything
         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57 || e.replace(/^0+/, ''))) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
                   return false;
        }
       });
   });

        </script>






        
@endsection