@extends('layouts.app')
@section('title', 'Order List')
@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Order List
        
    </h1>
</section>

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<?php $x = 1; ?>
<section class="content">
    <div class="box">
        <div class="box-body" >
<table id="example1" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
           <th>No</th>
           <th>Item No.</th>
           <th>Item Description</th>
           <th>Order Qty</th>
           <th>Name</th>
           <th>Branch Name</th>
           <th>Company Name</th>
           <th>Department Name</th>
           <th>Stock Qty</th>
           <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($order_list as $order){
            foreach($order as $row){
        $stock_count = App\StorageLocation::select(DB::raw('sum(current_qty) as stock_qty'))->where(['item_no'=>$row->item_no])->first(); 
//        echo "<pre>";print_r($stock_count);exit;
        ?>
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_name}}</td>
            <td>{{$row->qty}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->branch_name}}</td>
            <td>{{$row->company_name}}</td>
            <td>{{$row->depart_name }}</td>
            <td>{{$stock_count->stock_qty }}</td>
            <td><button class=" btn btn-success maker_status" value="<?php echo $row->item_no.",".$row->item_name.",".$row->qty.",".$row->id.",".$row->name;?>">Maker</button></td>
        </tr>
        <?php } } ?>
    </tbody>
            </table>
        </div>
    </div>   
</section>

<div class="modal" id="modal-danger">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="design-form" action="{{url('save_maker')}}" method="post" >
                {{ csrf_field() }}
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Order Details <button type="button" class="close" data-dismiss="modal">&times;</button></h3>
            
            <div class="form-group row">
                <label class="col-md-2"></label>
                <select class="form-control select2 select_location" id="loc_id" style=" width: 500px;"><option>Select Location</option>
                       @foreach($location as $row)
                       <option value="{{$row->loc_id}}">{{$row->loc_name}}</option>
                       @endforeach
                </select>
                <input type="hidden" id="maker_val" value="" />
            </div>
            </div>
            <h4><span id="error_model" style="color:red"></span></h4>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="show_data">
                    
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <!--<button class="btn btn-success add_more_items pull-left" type="button">ADD</button>-->
                <button type="submit" class="btn btn-success save_data" style="display: none;">Save</button>
                <button type="button" class="btn btn-danger my-modal" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
    
    $('#modal-danger').on('hidden.bs.modal', function () {
       location.reload();
      });
//    $(document).on('change', '#location_swipe', function (e) {
//        var loc_id = $(this).val();
//        $.ajax({
//            url: 'get_rack_slot/' + loc_id,
//            type: 'GET',
//            success: function (response) {
//                $("#rack_no_swipe").html(response);
//                
//            }
//        })
//    })
//
//    $(document).on('change', '#rack_no_swipe', function (e) {
//        var rack_id = $(this).val();
//        $.ajax({
//            url: 'get_slot',
//            type: 'GET',
//            data: {rack_id: rack_id},
//            success: function (response) {
//                $("#slot_no_swipe").html(response);
//                $('.select2').select2();
//            }
//        })
//    })
    
    $(document).on('change', '#loc_id', function (e) {
// $("#loc_id").on("change",function () {
        var loc_id = $(this).val();
//        alert(loc_id);
        var id = $("#maker_val").val();
        $.ajax({
            url: 'update_maker_po_dept/' + id + '/' + loc_id,
            type: "GET",
            success: function (response) {
                $("#show_data").html(response);
                $('#modal-danger').modal('show');
//               location.reload();
               
            }
        });
   });  
    
//    $(document).on('focusout', '.assign_qty', function (e) {
//        
//    })
    
    $(document).on('focusout', '.assign_qty', function (e) {
        var sum = 0;
        $(".assign_qty").each(function(){
          sum += +$(this).val();
        });
        var require_val = $("#required_qty").val();
        if(sum>require_val){
            $("#error_model").text("Your assign quntity is more than TL requested quntity.");
        }
        if(sum < require_val || sum == require_val){
            if(sum == 0){
                    $(".save_data").css("display","none");
            }else{
                var c_val = $(this).val();
                var trid = $(this).closest('tr').attr('id');
                if(parseInt(c_val)>parseInt(trid)){
                    $(".save_data").css("display","none");
                    $("#error_model").text("Please Assign value less then Qty.");
                }else{
                    $("#error_model").text("");
                        $(".save_data").css("display","block");
                }
//                $(".save_data").css("display","block");
            }
        }else{
             $(".save_data").css("display","none");
        }
        
//        
    })
    
});

$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})

    

$(".maker_status").click(function () {
        var id = $(this).val();
        $("#maker_val").val(id);
        $('#modal-danger').modal('show');
//        alert(id);
 }); 
 
 
</script>
@endsection