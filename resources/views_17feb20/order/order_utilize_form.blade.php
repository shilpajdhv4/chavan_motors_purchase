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
        Order Utilize 
<!--        <button type="button" class="btn btn-success" id="stock_qty">0</button>-->
        
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
            <form class="form-horizontal" id="design-form" action="{{url('save_order_utilize')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    <div class="form-group row">
                        <label class="col-md-2">Select Item Name / No.</label>
                        <div class="col-md-4">
                            
                            <select class="form-control select2" id="item_name" name="order_id" required="">
                                <option value="">Select</option>
                                @foreach($order_from_po as $row)
                                <option value="{{$row->order_id}}">{{$row->item_desc}} / {{$row->item_no}}</option>
                                @endforeach
                            </select>
                            
                        </div>
<!--                        <input type="text" id="stock_qty1" style="display: none;">-->
                        
                    </div>
                    <table class="table table-bordered" id="myTable">
                        <tr>
                        <th>#</th>
<!--                        <th>Actual Qty</th>-->
<!--                        <th>Stock Qty</th>-->
                        <th>Used Qty</th>
                        <th>Remark</th></tr>
                        <tbody id="append_data">
                            
                        </tbody>
                    </table>
                    <br>
                    <button type="button" class="btn btn-success add_data">ADD</button>  
                    <br><br/>
                    <div id="cover-spin"></div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('order_utilize_form')}}" class="btn btn-danger" >Cancel</a>
                        </div>
                    </div>
                </div>    
            </form>
        
            </div>
        </div>
    </div>
</div>
</div>
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title">List</h3>
                </div>
            <table id="" class="table table-bordered table-striped" border="1">
                <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No.</th>
                            <th>Item No.</th>
                            <th>Item Name</th>
                            <th>Actual Qty</th>
                            <th>Stock Qty</th>
                            <th>Used Qty</th>
                            <th>Date</th>
                            <th>Remark</th>
                        </tr>
                </thead>
                <tbody id="append_list"></tbody>
                    </table>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>

$(document).ready(function () {
    $('.select2').select2();
    
  

    
 
    

$("#item_name").change(function () {
        var id = $(this).val();
        tl_order_utilize_status(id);
        $.ajax({
            url: 'get_order_utilize_qty_tl/' + id,
            type: "GET",
            success: function (response) {
                
var parse_data = JSON.parse(response); 
$("#stock_qty").html(parse_data['stock_qty']);
$("#stock_qty").val(parse_data['stock_qty']);
$("#stock_qty1").val(parse_data['stock_qty']);
//var data="<tr><td><button class='btn btn-success add_data' type='button'>ADD</button></td>\n\
//<td><input type='text' class='used_qty form-control' name='used_qty[]' required=''></td>\n\
//<td><textarea class='remark form-control'  name='remark[]' required=''></textarea></td>\n\
//</tr>";
//
//$("#append_data").append(data);
               
            }
        });
    }); 
    
    
   
 $(document).on('click', '.add_data', function () {   
 var rowCount = $('#myTable tr').length;
//        var actual_qty=$(this).closest('tr').find("input.actual_qty").val();
//        var stock_qty=$(this).closest('tr').find("input.stock_qty").val();
var data="<tr><td>"+rowCount+"</td>\n\
<td><input type='text' class='used_qty form-control' name='used_qty[]' required=''></td>\n\
<td><textarea class='remark form-control' name='remark[]' required=''></textarea></td>\n\
</tr>";
    
//    var data="<tr><td><button class='btn btn-success add_data' type='button'>ADD</button></td>\n\
//<td><input type='text' class='used_qty form-control' name='used_qty[]' required=''></td>\n\
//<td><textarea class='remark form-control' name='remark[]' required=''></textarea></td>\n\
//</tr>";

$("#append_data").append(data);
          
    }); 
    
    $(document).on('keyup', '.used_qty', function () { 
    
//    var used_qty=$(this).val();
//    var stock_qty=$("#stock_qty").val();
//    
//    var ac_val=parseInt(stock_qty) - parseInt(used_qty);
//    $("#stock_qty").html(ac_val);
//    $("#stock_qty").val(ac_val);
    
    
//    alert(used_qty);
    
});
});

function tl_order_utilize_status(val)
{
  $.ajax({
            url: 'tl_order_utilize_status/' + val,
            type: "GET",
            success: function (response) {
        $("#append_list").html(response);
        $('#example1').DataTable();
               
            }
        });  
    
}
    
    
     
    
    
    
    
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

$(function () {
    $('#example1').DataTable()
    

    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})


</script>
        
@endsection