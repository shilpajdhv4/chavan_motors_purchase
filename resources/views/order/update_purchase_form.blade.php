@extends('layouts.app')
@section('title', 'Update Purchase Detail')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content-header">
    <h1>
        Update Purchase Detail
        
    </h1>
</section>
<?php //echo "<pre>";print_r($po_detail);exit; ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-horizontal" id="design-form" action="{{ url('update_purchase/'.$po_detail->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    <table class="table table-hover">
                        <tr>
                            <th>Type</th>
                            <th>Vendor</th>
                            <th>Product Group</th>
                            <th>Item Name/No.</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <?php if($po_detail->received_qty != NULL) { ?>
                            <th>Previous Received</th>
                            <?php } ?>
                            <th>Received Qty</th>
                            <th>Remark</th>
                        </tr>
                        <tr>
                            <td>{{$po_detail->type}}</td>
                            <td>{{$po_detail->vendor_name}}</td>
                            <td>{{$po_detail->product_grp}}</td>
                            <td>{{$po_detail->item_desc}}</td>
                            <td>{{$po_detail->qty}}</td>
                            <td>{{$po_detail->price}}</td>
                             <?php if($po_detail->received_qty != NULL) { ?>
                            <th>{{$po_detail->received_qty}}</th>
                            <?php } ?>
                            <td><input type='text' class="form-control number2 assign_qty" name="received_qty" id="received_qty" value="" required /></td>
                            <td><textarea class="form-control" name="received_remark" required <?php if($po_detail->received_remark != ""){ ?><?php } ?>></textarea></td>
                        </tr>
                    </table>
                    <div class="form-group" >
                             <label for="userName" class="col-sm-3 control-label">Upload File</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control"  value="" id="file_upload" onchange="return fileValidation()" name="file_upload" required>
                            </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('vendor_to_po_dept')}}" class="btn btn-danger" >Cancel</a>
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
</div>
</section>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>

$(document).ready(function () {
    $('.select2').select2();
    
    $(document).on('focusout', '.assign_qty', function (e) {
        
        var sum = 0;
      //  $(".assign_qty").each(function(){
          sum = $(this).val();
          
       // });
        var require_val = <?php echo ($po_detail->qty - @$po_detail->received_qty); ?>;
       // alert(require_val);
        if(sum > require_val){
            alert('Your assign quantity is more than orderd quantity.');
            $(this).val("");
          //  $("#error_model").text("Your assign quntity is more than TL requested quntity.");
        }
        
    })
    
    })
  
var jvalidate = $("#design-form").validate({
        rules: {
            name: {required: true},
            email: {required: true},
            password: {required: true},
            dept_id: {required: true},
            role: {required: true},
        }
    }); 
 
    $('#btnsubmit').on('click', function () {
        $("#design-form").valid();
    });
    
 
    

$("#prod_type").change(function () {
        var prod_type = $(this).val();

        $.ajax({
            url: 'get_product_grp/' + prod_type,
            type: "GET",
            success: function (response) {
//               alert(response);
//               return;
               
                var data = JSON.parse(response); 
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data.length;i++)
                {
                    append_data+='<option value='+data[i].product_name+'>'+data[i].product_name+'</option>';
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
    
    
//    function weird(x) {
//var tmp = 3;
//return function(y) {
//return x + y + ++tmp;
//}
//}
//var funny = weird(2);
////var final_answer = funny(10);
//
//alert(funny);

$(document).on('keypress','.number2',function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 5) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 3) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      
});


</script>
        
@endsection