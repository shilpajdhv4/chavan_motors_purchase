@extends('layouts.app')
@section('title', 'Upload File')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content-header">
    <h1>
        Edit Item
        
    </h1>
</section>

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
            <form class="form-horizontal" id="design-form" action="{{ url('update_item_list/'.$data->id) }}" method="post" >
                {{ csrf_field() }}
                <div class="card-body"> 
                    <div class="form-group row">
                        <label class="col-md-2">Product Type <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <select class="form-control " id="prod_type" name="prod_type" required >
                                <option value="">Select</option>
                                @foreach($prod_list as $row)
                                <option value="{{$row->product_type}}" <?php if ($data->prod_type == $row->product_type) echo "selected"; ?>>{{$row->product_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Product Category <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <select class=" form-control select" name="product_grp" id="product_grp" required>
                                <option value="">Select</option>
                                @foreach($list as $row)
                                <option value="{{$row->product_name}}" <?php if ($data->product_grp == $row->product_name) echo "selected"; ?>>{{$row->product_name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Item No <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control" name="item_no" value="{{$data->item_no}}" readonly>
                            
                             
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Item Description <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            
<!--                            <input type="text" class=" form-control" name="item_desc" value="">-->
                            <textarea class=" form-control" name="item_desc" required>{{$data->item_desc}}</textarea>
                             
                            </select>
                        </div>
                    </div>
<!--                    <div class="form-group row">
                        <label class="col-md-2">Qty <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <input type="text" class="form-control number2" name="qty" value="{{$data->qty}}" required>
                        </div>
                    </div>-->
                    <div class="form-group row">
                        <label class="col-md-2">Price <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <input type="text" class="form-control number2" name="price" value="{{$data->price}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Threshold Qty <span style="color:red"> * </span></label>
                        <div class="input-group date col-md-4">
                            <input type="text" class="form-control number2" name="threshold_qty" value="{{$data->threshold_qty}}" required>
                        </div>
                    </div>
                    
                    
                    <div id="cover-spin"></div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('item_list')}}" class="btn btn-danger" >Cancel</a>
                        </div>
                    </div>
                </div>    
            </form>
        
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>

$(document).ready(function () {
    $('.select2').select2();
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
    
    $('.number2').keypress(function(event) {
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




</script>
        
@endsection