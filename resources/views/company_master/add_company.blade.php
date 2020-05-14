@extends('layouts.app')
@section('title', 'Add New Company')
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
        Add New Company
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('list-company') }}"> Back</a>
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
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('save-company') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Company name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control alpha"  placeholder="Company Name" value="" id="company_name" name="company_name"  required >
                            </div>
                           
                        </div>
                        <div class="form-group"  style="color:red;">
                            <label for="company" class="col-sm-6 control-label"></label>
                            <code id="email_validate"></code>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Approval Level</label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="approval_level[]" value="1" > <label>GM</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" name="approval_level[]" value="2" > <label>SM</label>
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Return To Storage Level</label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="return_level[]" value="1" > <label>GM</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" name="return_level[]" value="2" > <label>SM</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-info">Save</button>
                        <a href="{{url('add-company')}}" class="btn btn-danger" >Cancel</a>
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
        
        $("#company_name").focusout(function () {
            var loc_name = $(this).val();
          //  alert(loc_name);
            $.ajax({
                url: 'validatecompany/' + loc_name,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#email_validate").html(data);
                    if (data != "") {
                        $("#company_name").val("");
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
