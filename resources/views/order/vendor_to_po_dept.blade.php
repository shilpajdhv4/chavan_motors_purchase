@extends('layouts.app')
@section('title', 'Received Orders from Vendors')

@section('content')
<?php 
$user_comp_id = Auth::user()->comp_id;
//$location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0,'comp_id'=>$user_comp_id])->get();
$location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Received Orders from Vendors
        <div class="pull-right">
            
            <a href="{{url('create_purchase_form')}}" class="btn btn-success" > Create Purchase Form</a>
        </div>
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
           <!-- <th>PO.No.</th> -->
           <th>Type</th>
           <th>Product Group</th> 
           <th>Item Name</th>
           <th>Order Qty</th>
           <th>Received Qty</th> 
           <th>Storage Add Qty</th>
           <th>Remark</th>
           <th>Download File</th>
           <th>Action</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($po_list as $row)
        <?php
        $total = $row->qty/2;
        if($row->qty == $row->received_qty){ ?>
            <tr style="background-color: green; color: white;">
        <?php } else if($row->received_qty <= $total){ ?>
            <tr style="background-color: red; color: white;">
        <?php } else if($row->received_qty >= $total) { ?>
            <tr style="background-color: yellow; color: black;">
        <?php } ?>
            <td>{{$x++}}</td>
            <td>{{$row->type}}</td>
            <td>{{$row->product_grp}}</td> 
            <td>{{$row->item_desc}}</td>
            <td>{{$row->qty}}</td>
            <td>{{$row->received_qty}}</td>
            <td>{{$row->storage_add_qty}}</td>
            <td>{{$row->remark}}</td>
            <td><a href="{{url('download_invoice/'.$row->file_upload)}}" target="_blank">Download</a></a></td>
            <td>
                <a href="{{url('generate_po/'.$row->id)}}" class=" btn btn-bitbucket " value="<?php echo $row->id;?>">Generate PO</a>
                <a href="{{url('edit_purchase?id='.$row->id)}}" class="btn btn-primary " ><span class="fa fa-edit"></span></a>
                <?php if($row->qty != $row->storage_add_qty) { ?>
                <button class="btn btn-success maker_status" id="{{($row->qty - @$row->storage_add_qty)}}" value="<?php $id = explode("/",$row->item_desc); echo $row->id.",".$row->received_qty.",".$id[1]; ?>">Add To Storage</button>
                <?php } ?>
                
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>   
</section>
<div class="modal" id="modal-danger">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="design-form" action="{{url('vendar_list_save')}}" method="post" >
                {{ csrf_field() }}
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Order Details <button type="button" class="close" data-dismiss="modal">&times;</button></h3>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="show_data">
                        <table class='table table-bordered' id='tbl_checker'>
                        <tr>
                            <th>Location Name</th>
                            <th>Rack No.</th>
                            <th>Slot No.</th>
                            <th>Qty</th>
                        </tr>
                        <tr>
                            <th>
                                <select class='form-control select2' style=' width: 500px;' name='location_swipe[]' id='location_swipe' required >
                                    <option value="">Select Location</option>";
                                    @foreach($location as $row)
                                        <option value="{{$row->loc_id}}">{{$row->loc_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class='form-control select2' name='rack_no_swipe[]' id='rack_no_swipe' style='width:100px;' required>
                                    
                                    <option value=""> Select </option>
                                </select>
                            </th>
                            <th>
                                <select class='form-control select2' name='slot_no_swipe[]' id='slot_no_swipe' style='width:100px;' required>
                                    <option value=""> Select </option>
                                </select>
                            </th>
                            <th>
                                <input type="text" class="form-control assign_qty" name='qty[]' id='qty' value="" />
                            </th>
                        <input type="hidden" name="id" id='id' value="" />
                        <input type="hidden" id="remaining_val" value="" />
                        </tr>
                        </table>
                </div>
                </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_data">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
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
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
    
    $(".maker_status").click(function () {
        var id = $(this).val();
        var qty_val = $(this).attr('id');
      //  alert(item_id);
       // alert(qty_val);
        $("#remaining_val").val(qty_val);
        $("#id").val(id);
        $("#qty").val(qty_val);
        $('#modal-danger').modal('show');
    });
    
    $(document).on('focusout', '.assign_qty', function (e) {
   //     alert();
        var sum = 0;
        
      //  $(".assign_qty").each(function(){
        sum = $(this).val();
       //   alert(sum);
       // });
        var require_val = $("#remaining_val").val();
      //  alert(require_val);
       // alert(require_val);
        if(sum > require_val){
            alert('Your assign quantity is more than received quantity.');
            $(this).val("");
          //  $("#error_model").text("Your assign quntity is more than TL requested quntity.");
        }
        
    })
    
    
    $(document).on('change', '#location_swipe', function (e) {
        var loc_id = $(this).val();
        $.ajax({
            url: 'get_rack_slot/' + loc_id,
            type: 'GET',
            success: function (response) {
                $("#rack_no_swipe").html(response);
                $('.select2').select2();
            }
        })
    })

    
    
    $(document).on('change', '#rack_no_swipe', function (e) {
//        var loc_id = $("#location_swipe").val();
        var rack_id = $(this).val();
        $.ajax({
            url: 'get_slot/',
            type: 'GET',
            data: {rack_id: rack_id},
            success: function (response) {
                $("#slot_no_swipe").html(response);
                $('.select2').select2();
            }
        })
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
});

//$(".maker_status").click(function () {
//        var id = $(this).val();
//       
//        $.ajax({
//            url: 'update_maker_po_dept/' + id,
//            type: "GET",
//            success: function (response) {
//
//               location.reload();
//               
//            }
//        });
//    }); 
</script>
@endsection