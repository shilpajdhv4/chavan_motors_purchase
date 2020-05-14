@extends('layouts.app')
@section('title', 'Edit New User')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>
<section class="content-header">
    <h1>Edit New User
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
    </div></h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif



@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
{!! Form::model($user, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'orderForm','route' => ['users.update', $user->id]]) !!}
<div class="box-body">
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required' => 'required')) !!}
        </div>
        <label for="userName" class="col-sm-2 control-label">Email<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','required' => 'required')) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
        <label for="userName" class="col-sm-2 control-label">Confirm Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Role<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control select2','required' => 'required')) !!}
        </div>
       <label for="userName" class="col-sm-2 control-label">Mobile No.<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" onkeypress="return phoneno(event)"  placeholder="Mobile No" value="{{$user->mobile_no}}" id="mobile_no" name="mobile_no" required >
        </div>
    </div>
    <div class="form-group"  style="color:red;">
        <label for="company" class="col-sm-8 control-label"></label>
        <code id="email_validate"></code>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Branch Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select class=" form-control select2" name="branch_name" required >
                <option>Select Branch</option>
                @foreach($branch_details as $row)
                <option value="{{$row->branch_name}}" <?php if($row->branch_name == $user->branch_name) echo "selected"; ?>>{{$row->branch_name}}</option>
               @endforeach
            </select>
        </div>
        <label for="userName" class="col-sm-2 control-label">Department Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select class=" form-control select2" name="depart_name" required>
                <option>Select Branch</option>
                @foreach($depart_details as $row)
                <option value="{{$row->depart_name}}" <?php if($row->depart_name == $user->depart_name) echo "selected"; ?>>{{$row->depart_name}}</option>
               @endforeach
            </select>
        </div>
    </div>
</div>
<div class="box-footer">
    <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
    <a href="{{url('users/'.$user->id.'/edit')}}" class="btn btn-danger" >Cancel</a>
</div>
{!! Form::close() !!}

 </div>
        </div>
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="../../js/jquery.min.js"></script>
<script type='text/javascript' src='../../js/jquery.validate.js'></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
    $("#mobile_no").focusout(function () {
            var mobile = $(this).val();
//            alert(mobile);
            $.ajax({
                url: 'mobile-validate/' + mobile,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#email_validate").html(data);
                    if (data != "") {
                        $("#mobile_no").val("");
                    }
                }
            });
        });
    })
    
     var jvalidate = $("#orderForm").validate({
        rules: {
            name: {required: true},
            email: {required: true},
//            password: {required: true},
            dept_id: {required: true},
            role: {required: true},
        }
    });
    
    $('#btnsubmit').on('click', function () {
        //alert();
        $("#orderForm").valid();
    });
    
    function phoneno(){          
            $('#mobile_no').keypress(function(e) {
                var length = jQuery(this).val().length;
       if(length > 9) {
            return false;
       } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
       } else if((length == 0) && (e.which == 48)) {
            return false;
       }
            });
        }
    </script>
@endsection