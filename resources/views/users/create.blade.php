@extends('layouts.app')
@section('title', 'Create New User')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>Create New User
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

{!! Form::open(array('route' => 'users.store','method'=>'POST','class'=>'form-horizontal','id'=> 'orderForm')) !!}
<div class="box-body">
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control"  placeholder="Name" value="" id="name" name="name"  required >
        </div>
        <label for="userName" class="col-sm-2 control-label">Email<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="email" class="form-control"  placeholder="Email" value="" id="email" name="email"  required >
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="password" class="form-control"  placeholder="Password" value="" id="password" name="password"  required >
        </div>
        <label for="userName" class="col-sm-2 control-label">Confirm Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="password" class="form-control"  placeholder="Confirm Password" value="" id="confirm-password" name="confirm-password"  required >
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Role<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control select2','multiple')) !!}
        </div>
        <label for="userName" class="col-sm-2 control-label">Mobile No.<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" onkeypress="return phoneno(event)" pattern="[789][0-9]{9}"  placeholder="Mobile No" value="" id="mobile_no" name="mobile_no"  required >
        </div>
    </div>
    <div class="form-group"  style="color:red;">
        <label for="company" class="col-sm-8 control-label"></label>
        <code id="email_validate"></code>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Branch Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select class=" form-control select2" name="branch_name" id="branch_name" required>
                <option value="">Select Branch</option>
                @foreach($branch_details as $row)
                <option value="{{$row->loc_name}}">{{$row->loc_name}}</option> 
               @endforeach
            </select>
        </div>
        <label for="userName" class="col-sm-2 control-label">Company Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select class=" form-control select2" name="comp_id" id="comp_id" required>
                <option value="">Select Company</option>
                @foreach($company_det as $row)
                <option value="{{$row->company_id}}">{{$row->company_name}}</option>
               @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Department Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select class=" form-control select2" name="depart_name" id="depart_name" required>
                <option value="">Select Department</option>
                
            </select>
        </div>
    </div>
</div>
<div class="box-footer">
    <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
    <a href="{{route('users.create')}}" class="btn btn-danger" >Cancel</a>
</div>
{!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->
<script src="../js/jquery.min.js"></script>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();
        
        $("#roles").on("change",function(){
            var r_name = $(this).val();
            if(r_name == "Purchase Department"){
             //   $("#branch_name").trigger()
             $("#branch_name").val("All").attr("selected", "selected");
             $("#branch_name").trigger('change.select2');
            // $('#branch_name').attr('readonly', true);
             
             $("#comp_id").val(1).attr("selected", "selected");
             $("#comp_id").trigger('change.select2');
             $('#comp_id').val(1).trigger('change');
            }else{
               // alert();
                $("#branch_name").val("").attr("selected", "selected");
                $("#branch_name").trigger('change.select2');
                $("#comp_id").val("").attr("selected", "selected");
                $("#comp_id").trigger('change.select2');
                $("#depart_name").val('').attr("selected", "selected");
                $("#depart_name").trigger('change.select2');
            }
        })
        
        
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
        
        $("#comp_id").change(function () {
            var comp_id = $(this).val();
         //   alert(comp_id);
            $.ajax({
                url: 'get_dept/' + comp_id,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#depart_name").html(data);
                    if(comp_id == 1){
                        $("#depart_name").val('All').attr("selected", "selected");
                        $("#depart_name").trigger('change.select2');
                    }
                }
            });
        });
      //  $("#comp_id").trigger('change');
        
   });
    
   
    jQuery.validator.addMethod("mobile_no", function(value, element)
    {
        return this.optional(element) || /^[6-9]{1}[0-9]{9}$/.test(value);
    }, "Please enter a valid Mobile No");
    
    jQuery("#orderForm").validate({
        rules: {
            "mobile_no": {mobile_no: true},
        },
    });
    var jvalidate = $("#orderForm").validate({
        rules: {
            name: {required: true},
            email: {required: true},
            password: {required: true},
            mobile_no: {required: true},
            pan_card_no: {required: true},
        }
    }); 
 
    $('#btnsubmit').on('click', function () {
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