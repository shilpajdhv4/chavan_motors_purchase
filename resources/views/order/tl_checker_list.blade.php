@extends('layouts.app')
@section('title', 'Return From User')
@section('content')
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Return From User
    </h1>
</section>
<?php $x = 1; ?>
<section class="content">
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
                   <th>Return Qty</th>
                   <th>Name</th>
                   <th>Branch Name</th>
                   <th>Department Name</th>
                   <th>Status</th>
                   <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checker_data as $row)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$row->item_no}}</td>
                    <td>{{$row->item_desc}}</td>
                    <td>{{$row->return_qty}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->branch_name}}</td>
                    <td>{{$row->depart_name }}</td>
                    <td>
                        <button type="button" class="btn btn-success approved_status_a" value="{{$row->id}}">Approve</button>
                        <button type="button" class="btn btn-danger approved_status_d" value="{{$row->id}}">Decline</button>
                    </td>
                    <td><textarea class=" form-control remark" ></textarea></td>
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

<section class="content-header">
    <h1>
        Approve Orders
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
                    <table id="example3" class="table table-bordered table-striped" border="1">
                        <thead>
                            <tr>
                               <th>No</th>
                               <th>Item No.</th>
                               <th>Item Description</th>
                               <th>Return Qty</th>
                               <th>Name</th>
                               <th>Branch Name</th>
                               <th>Department Name</th>
                               <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approve_data as $row)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$row->item_no}}</td>
                                <td>{{$row->item_desc}}</td>
                                <td>{{$row->return_qty}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->branch_name}}</td>
                                <td>{{$row->depart_name }}</td>
                                <td>{{$row->remark}}</td>
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

<section class="content-header">
    <h1>
        Declined Orders
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
                    <table id="example4" class="table table-bordered table-striped" border="1">
                        <thead>
                            <tr>
                               <th>No</th>
                               <th>Item No.</th>
                               <th>Item Description</th>
                               <th>Return Qty</th>
                               <th>Name</th>
                               <th>Branch Name</th>
                               <th>Department Name</th>
                               <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($decline_data as $row)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$row->item_no}}</td>
                                <td>{{$row->item_desc}}</td>
                                <td>{{$row->return_qty}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->branch_name}}</td>
                                <td>{{$row->depart_name }}</td>
                                <td>{{$row->remark}}</td>
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

<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
    $('#example1').DataTable();


    $('#example2').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })

    $('#example3').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
    
    $('#example4').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
$(document).ready(function () {
    $('.select2').select2();

    
    $(document).on('click', '.approved_status_a', function () {
        var id = $(this).val();
        var status = "Approve";
        var remark = $(this).closest('tr').find("textarea.remark").val();
        if (remark == '' || remark == null)
        {
            alert("Please fill remark");
            return;
        }
        $.ajax({
            url: 'check_list_status_by_dm/' + id + '/' + remark + '/' + status,
            type: "GET",
            success: function (response) {
                alert("Updated Successfully");
                location.reload();
            }
        });
    });
    
    $(document).on('click', '.approved_status_d', function () {
        var id = $(this).val();
        var status = "Decline";
        var remark = $(this).closest('tr').find("textarea.remark").val();
        if (remark == '' || remark == null)
        {
            alert("Please fill remark");
            return;
        }
        $.ajax({
            url: 'check_list_status_by_dm/' + id + '/' + remark + '/' + status,
            type: "GET",
            success: function (response) {
                alert("Updated Successfully");
                location.reload();
            }
        });
    });
    
});
</script>
@endsection