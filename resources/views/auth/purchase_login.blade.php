@extends('layouts.login')
@section('content')
<style>
    .error{
        color: red;
    }
</style>
<div class="login-box">
  <div class="login-logo">
    <a href="http://chavanautowheels.com/chavan_motors_purchase/public/purchase-login" style="color:white;"><b>Chavan </b>Motors</a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Purchase Log in to start your session</p>
                        @isset($url)
                        <form method="POST" action='{{ url("purchase-login/$url") }}' id="register_form" aria-label="{{ __('Login') }}">
                        @else
                        <form method="POST" action="{{ route('purchase-login') }}" id="register_form"  aria-label="{{ __('Login') }}">
                        @endisset
                            @csrf
<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="text" id="mobile_no" name="mobile_no" onkeypress="return phoneno(event)" pattern="[789][0-9]{9}" class="form-control" placeholder="Mobile No" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
        <div class="row">
<!--        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>-->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){

            jQuery.validator.addMethod("mobile_no", function(value, element)
            {
                return this.optional(element) || /^[6-9]{1}[0-9]{9}$/.test(value);
            }, "Please enter a valid Mobile No");
            jQuery("#register_form").validate({
                rules: {
                    "mobile_no": {mobile_no: true},
                },
            });
            var jvalidate = $("#register_form").validate({
                rules: {   
                        email: {required: true},
                        password : {required: true},
                    },
                     messages: {
                         email: "Please Enter Email Address",
                         password: "Please Enter Password"
                       }  
                });
                
                $('#btnsubmit').on('click', function() {
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