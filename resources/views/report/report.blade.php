@extends('layouts.app')
@section('title', 'Report')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Approved Order List
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
            <form class="form-horizontal" id="userForm" method="post" action="{{ url('get_report') }}">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">From Date<span style="color:red"> * </span></label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                            <input type="text" name="from_date" id="upload_date" class="form-control datepicker" placeholder="DD-MM-YYYY" required >
                        </div>
                        </div>
                        <label for="userName" class="col-sm-2 control-label">To Date<span style="color:red"> * </span></label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                            <input type="text" name="to_date" id="upload_date" class="form-control datepicker" placeholder="DD-MM-YYYY" required >
                        </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="button"  id="btnsubmit" class="btn btn-info">View</button>
                    <a href="{{url('get_report')}}" class="btn btn-danger" >Cancel</a>
                </div>
            </form>
            <div class="col-md-12" id="report_data">
                
            </div>
        </div>
    </div>   
</section>


<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
    $('#btnsubmit').on('click',function () {
        $.ajax({
            url: 'get_report',
            type: 'POST',
            data: $("#userForm").serialize(),
            success: function (response) {
                $("#report_data").html(response);
                
            }
        })
    })
});
 
</script>
@endsection