@extends('layouts.app')
@section('title', 'Approve Order List')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Approve Order List
        
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
           <th>Branch Name</th>
           <th>Department Name</th>
           <th>Order Qty</th>
           <th>Received Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($approved_order as $row)
        <tr>
            <td>{{$x++}}</td>            
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_desc}}</td>
            <td>{{$row->branch_name}}</td>
            <td>{{$row->depart_name}}</td>
            <td>{{$row->order_qty}}</td>
            <td>{{$row->received_qty }}</td>
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
            <form class="form-horizontal" id="design-form" action="{{url('save_maker')}}" method="post" >
                {{ csrf_field() }}
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Order Details <button type="button" class="close" data-dismiss="modal">&times;</button></h3>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="show_data">
                    
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--<button class="btn btn-success add_more_items pull-left" type="button">ADD</button>-->
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
    $('.select2').select2();
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
    
    $(document).on('change', '#location_swipe', function (e) {
        var loc_id = $(this).val();
        $.ajax({
            url: 'get_rack_slot/' + loc_id,
            type: 'GET',
            success: function (response) {
                $("#rack_no_swipe").html(response);
                
            }
        })
    })

    $(document).on('change', '#rack_no_swipe', function (e) {
        var rack_id = $(this).val();
        $.ajax({
            url: 'get_slot',
            type: 'GET',
            data: {rack_id: rack_id},
            success: function (response) {
                $("#slot_no_swipe").html(response);
                $('.select2').select2();
            }
        })
    })
    
    $(document).on('focusout', '#assign_qty', function (e) {
        var assig_val = $("#assign_qty").val();
        var require_val = $("#required_qty").val();
        var id = $(this).attr('id');
        alert(id);
        if(assig_val>require_val){
            $("#"+id+"_error").html("Your assign quntity is more than TL requestes quntity.");
        }
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
//        alert(id);
        
        $.ajax({
            url: 'update_maker_po_dept/' + id,
            type: "GET",
            success: function (response) {
                $("#show_data").html(response);
                $('#modal-danger').modal('show');
//               location.reload();
               
            }
        });
    }); 
</script>
@endsection