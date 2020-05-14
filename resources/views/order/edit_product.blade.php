@extends('layouts.app')
@section('title', 'Edit Product Category')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content-header">
    <h1>
        Edit Product Category
        
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
            <form class="form-horizontal" id="design-form" action="{{url('edit_product_cate/'.$data->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    
                    <div class="form-group row">
                        <label class="col-md-2">Product Category</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" list="cars" class="form control" value="{{$data->product_type}}" name="product_type" required>
                            <datalist id="cars" class="form control select" >
                                <option>Select Type</option>
                                @foreach($type as $row)
                                <option value="{{$row->product_type}}" <?php //if($row->product_type == $data->product_type) echo "selected"; ?>>{{$row->product_type}}</option>
                                @endforeach
                            </datalist>
                             
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Product Sub Category</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control" name="product_name" value="{{$data->product_name}}" required >
                             
                            </select>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    <div id="cover-spin"></div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('product_list')}}" class="btn btn-danger" >Cancel</a>
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