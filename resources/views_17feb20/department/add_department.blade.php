@extends('layouts.app')
@section('title', 'Add New Location')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>
        Add New Department
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('list-department') }}"> Back</a>
        </div>
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
@if (Session::has('alert-danger'))
<div class="alert alert-danger alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Error!</h4>
    {{ Session::get('alert-danger') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('save-department') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Department Name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control alpha"  placeholder="Department Name" value="" id="depart_name" name="depart_name"  required >
                            </div>
                           
                        </div>
                        <div class="form-group"  style="color:red;">
                            <label for="company" class="col-sm-6 control-label"></label>
                            <code id="email_validate"></code>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-info">Save</button>
                        <a href="{{url('add-department')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>
$(document).ready(function () {
        $('.select2').select2();
        
         $('.alpha').keypress(function (e) {
                var regex = new RegExp("^[a-zA-Z ]+$");
            var strigChar = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(strigChar)) {
                return true;
            }
            return false

            });
        
        $("#depart_name").focusout(function () {
            var mobile = $(this).val();
//            alert(mobile);
            $.ajax({
                url: 'departmentValidate/' + mobile,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#email_validate").html(data);
                    if (data != "") {
                        $("#depart_name").val("");
                    }
                }
            });
        });
});
var jvalidate = $("#userForm").validate({
        rules: {
            name: {required: true},
            email: {required: true},
            password: {required: true},
            dept_id: {required: true},
            role: {required: true},
        }
    }); 
 
    $('#btnsubmit').on('click', function () {
        $("#userForm").valid();
    });
    </script>
@endsection
