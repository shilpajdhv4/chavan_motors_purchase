@extends('layouts.app')
@section('title', 'Vendor Form')
@section('content')

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
<section class="content-header">
    <h1>
        Vendor Form
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <form class="form-horizontal" id="design-form" action="{{url('save_vendor')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    
                    
                    <div class="form-group row">
                        <label class="col-md-2">Vendor Name <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class="form-control " name="vendor_name" required >
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Contact Name <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control alpha" name="contact_name" required>
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Product Type <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <select class=" form-control select2" name="product_type[]" multiple="" data-placeholder="-- Select Product Type --" required>
                                <!--<option> -- Select Type --</option>-->   
                            @foreach($product_type as $row)
                            <option value="{{$row->product_type}}">{{$row->product_type}}</option>
                            @endforeach
                             </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Mobile No. <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control" onkeypress="return phoneno(event)" name="mob_no" id="mob_no" pattern="[789][0-9]{9}" required>
                             
                        </div>
                    </div>
                    <div class="form-group"  style="color:red;">
                            <label for="company" class="col-sm-2 control-label"></label>
                            <code id="mob_validate"></code>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Pan Card No. <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control" name="pan_card_no" id="pan_card_no" required>
                             
                        </div>
                    </div>
                     <div class="form-group"  style="color:red;">
                            <label for="company" class="col-sm-2 control-label"></label>
                            <code id="pan_validate"></code>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">GST NO. <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control" name="gst_no" id="gst_no" required>
                             
                        </div>
                    </div>
                    <div class="form-group"  style="color:red;">
                            <label for="company" class="col-sm-2 control-label"></label>
                            <code id="gst_validate"></code>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Address <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <textarea class="form-control" name="address" required></textarea>
                             
                        </div>
                    </div>
                     <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('vendor_list')}}" class="btn btn-danger" >Cancel</a>
                        </div>
                    </div>
                </div>    
            </form>
        
            </div>
        </div>
    </div>
</div>
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

	
        $("#gst_no").focusout(function () {
            var gst = $(this).val();
//            alert(mobile);
            $.ajax({
                url: 'gstValidate/' + gst,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#gst_validate").html(data);
                    if (data != "") {
                        $("#gst_no").val("");
                    }
                }
            });
        });
        
        
        $("#mob_no").focusout(function () {
            var mobile = $(this).val();
//            alert(mobile);
            $.ajax({
                url: 'mobValidate/' + mobile,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#mob_validate").html(data);
                    if (data != "") {
                        $("#mob_no").val("");
                    }
                }
            });
        });
        
        $("#pan_card_no").focusout(function () {
            var pan_no = $(this).val();
//            alert(mobile);
            $.ajax({
                url: 'panValidate/' + pan_no,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $("#pan_validate").html(data);
                    if (data != "") {
                        $("#pan_card_no").val("");
                    }
                }
            });
        });
    
    })
  
    jQuery.validator.addMethod("pan_card_no", function(value, element)
    {
        return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
    }, "Please enter a valid PAN Example : AAAPL1234C");
    
    jQuery.validator.addMethod("mob_no", function(value, element)
    {
        return this.optional(element) || /^[6-9]{1}[0-9]{9}$/.test(value);
    }, "Please enter a valid Mobile");
    
    jQuery("#design-form").validate({
        rules: {
            "pan_card_no": {pan_card_no: true},
            "mob_no": {mob_no: true},
        },
    });
    var jvalidate = $("#design-form").validate({
        rules: {
            name: {required: true},
            email: {required: true},
            password: {required: true},
            dept_id: {required: true},
            pan_card_no: {required: true},
        }
    }); 
 
    $('#btnsubmit').on('click', function () {
        $("#design-form").valid();
    });
 
    

$("#item_type").change(function () {
        var type_item = $(this).val();
        
//        $('#city').html('');
//        $('#city').html('<option value="">Select City</option>');
        $.ajax({
            url: 'get_product_grp/' + type_item,
            type: "GET",
            success: function (response) {
               
//                alert(response);
//                return;
                var data = JSON.parse(response); 
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data.length;i++)
                {
                    append_data+='<option value='+data[i].product_grp+'>'+data[i].product_grp+'</option>';
                }
                $('#product_grp').html(append_data);
               
            }
        });
    }); 
    
    
    $("#product_grp").change(function () {
        var product_grp = $(this).val();
        var type_item = $("#item_type").val();
        
//        $('#city').html('');
//        $('#city').html('<option value="">Select City</option>');
        $.ajax({
            url: 'get_item_name/' + product_grp + '/' + type_item,
            type: "GET",
            success: function (response) {
               
//                alert(response);
//                return;
                var data = JSON.parse(response); 
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data.length;i++)
                {
                    append_data+='<option value='+data[i].item_desc+'>'+data[i].item_desc+'</option>';
                }
                $('#item_name').html(append_data);
               
            }
        });
    }); 
    
 

i=1;
$(".add_data").click(function () {
    
    var data='<tr><td>'+i+'.</td><td><input type="text" class=" form-control" name="item_no[]"></td>\n\
                <td><textarea class=" form-control" name="item_desc[]"></textarea></td>\n\
<td><input type="text" class="form-control" name="price[]"></td>\n\
<td><input type="text" class="form-control" name="qty[]"></td></tr>';
    
    $('#append_data').append(data);
    i++;

    }); 

function phoneno(){          
            $('#mob_no').keypress(function(e) {
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