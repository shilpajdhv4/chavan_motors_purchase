@extends('layouts.app')
@section('title', 'Vendor List')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Vendor List 
        <div class="pull-right">
            <a href="add_vendor" class="btn btn-success right-align ">Add Vendor</a>
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
           <th>Vendor Name</th>
           <th>Mob No.</th>
           <th>Pan Card No.</th>
           <th>GST No.</th>
           <th>Product Type</th>
        </tr>
    </thead>
    <tbody>
@foreach($vendor_list as $row)
<?php
$product_type=implode(",", json_decode($row->product_type));?>
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->vendor_name}}</td>
            <td>{{$row->mob_no}}</td>
            <td>{{$row->pan_card_no}}</td>
            <td>{{$row->gst_no}}</td>
            <td>{{$product_type}}</td>
        </tr>
@endforeach
    
</tbody>
            </table>
        </div>
    </div>   
</section>


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
</script>
@endsection