@extends('layouts.app')
@section('title', 'User-List')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Return From User
        
    </h1>
</section>

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<?php $x = 1; ?>
<section class="content">
    <div class="box">
        <div class="box-body" >
<table id="example1" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
           <th>No</th>
           <th>Item No.</th>
           <th>Item Description</th>
           <th>Return Qty</th>
           <th>Name</th>
           <th>Branch Name</th>
           <th>Department Name</th>
           <th>Action</th>
           
        </tr>
    </thead>
    <tbody>
        @foreach($checker_data as $row)
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_desc}}</td>
            <td>{{$row->return_qty}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->branch_name}}</td>
            <td>{{$row->depart_name }}</td>
            <!--<td><a href="{{url('storage_location')}}" class="btn btn-success maker_status" value="<?php echo $row->id.",".$row->return_qty;?>">Add To Storage</button></td>-->
            <td><button class="btn btn-success maker_status" id="{{$row->return_qty}}" value="<?php echo $row->id.",".$row->return_qty.",".$row->item_no;?>">Add To Storage</button></td>
        </tr>
        @endforeach
    </tbody>
            </table>
        </div>
    </div>   
</section>

<div class="modal" id="modal-danger">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="design-form" action="{{url('checker_list_save')}}" method="post" >
                {{ csrf_field() }}
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Order Details <button type="button" class="close" data-dismiss="modal">&times;</button></h3>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="show_data">
                        <table class='table table-bordered' id='tbl_checker'>
                        <tr>
                            <th>Location Name</th>
                            <th>Rack No.</th>
                            <th>Slot No.</th>
                            <th>Qty</th>
                        </tr>
                        <tr>
                            <th>
                                <select class='form-control select2' style=' width: 500px;' name='location_swipe[]' id='location_swipe'>
                                    <option>Select Location</option>";
                                    @foreach($location as $row)
                                        <option value="{{$row->loc_id}}">{{$row->loc_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class='form-control select2' name='rack_no_swipe[]' id='rack_no_swipe' style='width:100px;'>
                                    
                                    <option value=""> Select </option>
                                </select>
                            </th>
                            <th>
                                <select class='form-control select2' name='slot_no_swipe[]' id='slot_no_swipe' style='width:100px;'>
                                    <option value=""> Select </option>
                                </select>
                            </th>
                            <th>
                                <input type="text" class="form-control" name='qty[]' id='qty' value="" readonly/>
                            </th>
                        <input type="hidden" name="id" id='id' value="" />
                        </tr>
                        </table>
                </div>
                </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_data">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();

    
    $(document).on('change', '.select_location', function(e) {
        $("#append_form_data").html('');
        var location_name = $(this).val();
            $.ajax({
                url: 'show_storage_location_form/' + location_name,
                type: "GET",
                success: function (response) {
                    $("#append_form_data").html(response);
                }
            });
    });
    

    $(".maker_status").click(function () {
        var id = $(this).val();
        var qty_val = $(this).attr('id');
//        alert(id);
        $("#qty").val(qty_val);
        $("#id").val(id);
        $('#modal-danger').modal('show');
    }); 
    
    $(document).on('change', '#location_swipe', function (e) {
        var loc_id = $(this).val();
        $.ajax({
            url: 'get_rack_slot/' + loc_id,
            type: 'GET',
            success: function (response) {
                $("#rack_no_swipe").html(response);
                $('.select2').select2();
            }
        })
    })

    $(document).on('change', '#rack_no_swipe', function (e) {
//        var loc_id = $("#location_swipe").val();
        var rack_id = $(this).val();
        $.ajax({
            url: 'get_slot/',
            type: 'GET',
            data: {rack_id: rack_id},
            success: function (response) {
                $("#slot_no_swipe").html(response);
                $('.select2').select2();
            }
        })
    })
    
    });
</script>
@endsection