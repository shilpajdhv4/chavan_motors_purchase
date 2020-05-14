@extends('layouts.app')
@section('title', 'Upload File')
@section('content')


<!--<div class="flash-message">
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
    @endif
  @endforeach
</div>-->
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
        Order Form
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
            <form class="form-horizontal" id="design-form" action="{{url('save_order_list')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
<!--                    <div class="form-group row">
                        <label class="col-md-2">Type</label>
                        <div class="input-group date col-md-4">
                            
                            <select class="form-control " id="item_type" name="type">
                                <option value="">Select</option>
                                <option value="1">Perishable Type</option>
                                <option value="0">Non Perishable Type</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Product Group</label>
                        <div class="input-group date col-md-4">
                            
                            <select class=" form-control " id="product_grp" name="product_grp">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Item Name / No. / Vendor Name</label>
                        <div class="input-group date col-md-4">
                            
                            <select class=" form-control " id="item_name" name="item_name">
                             
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Qty</label>
                        <div class="input-group date col-md-4">
                            <input type="text" class="form-control" name="qty" name="qty">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Remark</label>
                        <div class="input-group date col-md-4">
                            <textarea  class="form-control" name="remark"></textarea>
                        </div>
                    </div>-->
                    
                    <div id="cover-spin"></div>
<!--                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('order_form')}}" class="btn btn-danger" >Cancel</a>
                        </div>
                    </div>-->
                </div> 
                
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Product Group</th>
                        <th>Item Name / No.</th>
                        <th>Qty</th>
                        <th>Remark</th>
                    </tr>
                    <tbody id="append_data">
                        
                    </tbody>
                </table>
                                    
<br><br>
<button type="button" class="btn btn-danger add_data">ADD</button>
<br><br>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('order_form')}}" class="btn btn-danger" >Cancel</a>
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
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
<script>

//var jvalidate = $("#design-form").validate({
//        rules: {
//            location: {required: true},
//            rank_no1: {required: true},
//            section_no: {required: true},
//        }
//    }); 
 
    $('#btnsubmit').on('click', function () {
        //$("#design-form").validate();
    });

$(document).ready(function () {
    $('.select2').select2();
    
 
i=1;
$(".add_data").click(function () {
   
    var data2='<tr><td>'+i+'.</td><td><select class="form-control item_type select2" id="append_product_type_'+i+'" name="type[]" required>\n\
    <option value="">Select</option><?php
    foreach($prod_type as $row) {?><option value="<?php echo $row->product_type;?>"><?php echo $row->product_type;?></option><?php } ?>\n\</select></td>\n\
    <td><select class=" form-control product_grp select2 append_product_grp_'+i+'" id="product_grp" name="product_grp[]" required></select></td>\n\
    <td><select class=" form-control item_name select2 append_item_name_'+i+'" id="item_name" name="item_name[]" required></select></td>\n\
    <td><input type="text" class="form-control number2"  name="qty[]" required></td>\n\
    <td><textarea  class="form-control" name="remark[]" required></textarea></td><td style="display:none;"><input type="text" class="id_no" value="'+i+'" required></tr>';
    //    append_product_type(i);   
        $('#append_data').append(data2);

    i++;
});
    
    
    
    
    $(document).on('change', '.item_type', function () {
        var closest_val=$(this).closest('tr').find("input.id_no").val();
        var type_item = $(this).val();
        $.ajax({
            url: 'get_product_grp/' + type_item,
            type: "GET",
            success: function (response) {
               
                var data = JSON.parse(response); 
//                console.log(data);
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data.length;i++)
                {
                    append_data+='<option value="'+data[i].product_name+'">'+data[i].product_name+'</option>';
                }
                $('.append_product_grp_'+closest_val).html(append_data);
               
            }
        });
    }); 
    
    
    $(document).on('change', '.product_grp', function () {
        var product_grp = $(this).val();
//        var type_item = $("#item_type").val();
        var closest_val=$(this).closest('tr').find("input.id_no").val();
        var type_item=$(this).closest('tr').find("select.item_type").val();

        $.ajax({
            url: 'get_item_name/' + product_grp + '/' + type_item,
            type: "GET",
            success: function (response) {

                var data = JSON.parse(response); 
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data.length;i++)
                {
                    append_data+='<option value="'+data[i].item_desc+"/"+data[i].item_no+'">'+data[i].item_desc+" / "+data[i].item_no+'</option>';
                }
                $('.append_item_name_'+closest_val).html(append_data);
               
            }
        });
    }); 


});

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