@extends('layouts.app')
@section('title', 'Generate Purchase Order')
@section('content')
<style>
     .error{
        outline: 1px solid red;
    } 
</style>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<form class="form-horizontal" id="design-form" action="{{url('save_purchase_order')}}" method="post" >
    {{ csrf_field() }}
<!--<table class="table">
    <tr> 
        <th>Select Vendor</th>
        <th><select class=" form-control select2" name="vendor_name" id="vendor_name" required>
                <option value="">-- Select Vendor --</option>
                @foreach($vendor_list as $row)
                <option value="{{$row->id}}">{{$row->vendor_name}}</option>
                @endforeach
            </select></th>
        <th><button class=" btn btn-bitbucket gen_po" type="button">Generate PO</button></th>
    </tr>
    <tr><td colspan="2" id='vendor_validate' style="color: red;"></td></tr>
</table>-->
<section class="content-header">
    <h1>
        Generate Purchase Order
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('vendor_to_po_dept') }}"> Back</a>
        </div>
    </h1>
</section>

    <!--<div class="flash-message alert alert-success alert-block" ></div>-->
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<br><br>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>

              <div class="box-tools">
<!--                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>-->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                      <th>#</th>
                      <th>Type</th>
                      <th>Vendor</th>
                      <th>Product Group</th>
                      <th>Item Name / No.</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Remark</th>
                  </tr>
                  <tbody id="append_data"></tbody>
                </table>
               
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
<br><br>
<button type="button" class="btn btn-danger add_data">ADD</button>
<button class=" btn btn-bitbucket pull-right show_po_form" type="submit">Save</button>
</form>
<br><br>
<div id="append_po_details"></div>
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    });
});

$(document).ready(function () {
$('.select2').select2();



    
$(document).ready(function() {
$(".gen_po").click(function(){
var orders_ids_array = [];
$.each($("input[name='get_multi_order_ids']:checked"), function(){
orders_ids_array.push($(this).val());
});
var multi_order_ids=orders_ids_array.join("-");
var vendor_name = $("#vendor_name").val();
        $.ajax({
            url: 'create_purchase/' + vendor_name + "/" + multi_order_ids,
            type: "GET",
            success: function (response) {
            $("#append_po_details").html(response);

               
            }
        });

});
});



i=1;
$(".add_data").click(function () {
var data2='<tr><td>'+i+'.</td><td><select class="form-control item_type select2" id="append_product_type_'+i+'" name="type[]" required>\n\
<option value="">Select</option><?php
foreach($product_grp_list as $row) {?><option value="<?php echo $row->product_type;?>"><?php echo $row->product_type;?></option><?php } ?>\n\</select></td>\n\
\n\<td><select class=" form-control vendor_grp select append_vendor_grp_'+i+'" id="vendor_grp" name="vendor_grp[]" required></select></td>\n\
<td><select class=" form-control product_grp select append_product_grp_'+i+'" id="product_grp" name="product_grp[]" required></select></td>\n\
<td><select class=" form-control item_name select append_item_name_'+i+'" id="item_name" name="item_name[]" required></select></td>\n\
<td><input type="text" class="form-control qty_cal number2 append_qty_'+i+'"  name="qty[]" required ></td>\n\
<td><input type="text" class="form-control  number2 append_price_'+i+'"  name="price[]" required readonly ></td><td><textarea  class="form-control" name="remark[]"></textarea></td><td style="display:none;"><input type="text" class="id_no" value="'+i+'"></tr>';
// <td><input type="text" class="form-control  number2 append_price_'+i+'"  name="price[]" required ></td><input type="hidden" class="actual_price_'+i+'" value="" /><td><textarea  class="form-control" name="remark[]"></textarea></td><td style="display:none;"><input type="text" class="id_no" value="'+i+'"></tr>';
    
    $('#append_data').append(data2);
//    $('.select2').select2();
    
i++;
});

$(document).on('change', '.item_type', function () {
        var closest_val=$(this).closest('tr').find("input.id_no").val();
        var type_item = $(this).val();
        $.ajax({
            url: 'get_product_grp1/' + type_item,
            type: "GET",
            success: function (response) {
            //   console.log(response);
                var data = JSON.parse(response); 
              //  console.log(data['product']);
                var append_data='<option value="">Select</option>';
                for(var i=0; i<data['product'].length;i++)
                {
                    append_data+='<option value="'+data['product'][i].product_name+'">'+data['product'][i].product_name+'</option>';
                }
                $('.append_product_grp_'+closest_val).html(append_data);
                
                var append_data1='<option value="">Select</option>';
                for(var j=0; j<data['vendor'].length;j++)
                {
                    append_data1+='<option value="'+data['vendor'][j].id+'">'+data['vendor'][j].vendor_name+'</option>';
                }
                $('.append_vendor_grp_'+closest_val).html(append_data1);
//                 $('.select2').select2();
               
            }
        });
}); 
    
    
$(document).on('change', '.product_grp', function () {
        var product_grp = $(this).val();
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
//                 $('.select2').select2();
               
            }
        });
    }); 
    
$(document).on('change', '.item_name', function () {
    var item_name = $(this).val();
    var closest_val=$(this).closest('tr').find("input.id_no").val();
    $.ajax({
        url: 'item_price?id=' + item_name,
        type: "GET",
        success: function (data) {
            // alert(data);
         //   var qty_val = new_val = 0;
       //     var qty_val = $('.append_qty_'+closest_val).val();
        //    new_val = qty_val * data;
       //     $('.actual_price_'+closest_val).val(data);
            $('.append_price_'+closest_val).val(data);
        }
    });
}); 
    
    // $('.qty_cal').on('change', function(){
// $(document).on('change', '.qty_cal', function () {
//         var subtotal = 0;
//         var closest_val=$(this).closest('tr').find("input.id_no").val();
//         // alert(closest_val);
//      //   $('.qty_cal').each(function(){
//             var $this = $(this);
//             var quantity = parseInt($this.val());
//       //    alert(quantity);
//             var price = parseFloat($(this).closest('tr').find('.actual_price_'+closest_val).val());//$this.siblings('.price').val())
//       //     alert(price);
//             subtotal=quantity*price;
//      //   })
//         $('.append_price_'+closest_val).val(subtotal);
    
//     })
    
//    $(document).on('click', '.show_po_form', function () {
////		var vendor_n = $("#vendor_name").val();
////		if(vendor_n == ""){
////                    $("#vendor_validate").html("Please Select Vendor Name");
////		}else{
////                    $("#vendor_validate").html("");
//                    $.ajax({
//                        url: 'save_purchase_order',
//                        type: "POST",
//                        data:$("#design-form").serialize(),
//                        success: function (response) {
//                           $("#append_po_details").html(response);
////                           $('div.flash-message').html("Generated Successfully.");
//                        }
//                    });
////		}
//        
//    });
    
    


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