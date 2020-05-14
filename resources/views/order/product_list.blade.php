@extends('layouts.app')
@section('title', 'Product Category List')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Product Category List
        <div class="pull-right">
            
            <a href="{{url('add_product')}}" class="btn btn-success" > Add New Product</a>
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
           <th>Product Category</th>
           <th>Product Sub Category</th>
           @can('edit_product_list')
           <th>Action</th>
           @endcan
        </tr>
    </thead>
    <tbody>
        @foreach($list as $row)
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->product_type}}</td>
            <td>{{$row->product_name}}</td>
            @can('edit_product_list')
            <td><a  href="{{url('edit_product_list?id='.$row->id)}}">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                        </a></td>
                        @endcan
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