@extends('layouts.app')
@section('title', 'Pending Orders')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<?php $x = 1;
$x1 = 1;
$x2 = 1; ?>
<section class="content-header">
    <h1>
        Pending Orders</h1>
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
                                <table id="example1" class="table table-bordered table-striped" border="1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Item No.</th>
                                            <th>Item Description</th>
                                            <th>Qty</th>
                                            <th>Branch Name</th>
                                            <th>TL Name</th>
                                            <th>Status</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order_list_to_dm as $row)

                                        <tr>
                                            <td>{{$x++}}</td>
                                            <td>{{$row->item_no}}</td>
                                            <td>{{$row->item_name}}</td>
                                            <td>{{$row->qty}}</td>
                                            <td>{{$row->branch_name }}</td>
                                            <td>{{$row->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success approved_status_a" value="{{$row->id}}">Approve</button>
                                                <button type="button" class="btn btn-warning approved_status_h" value="{{$row->id}}">Hold</button>
                                                <button type="button" class="btn btn-danger approved_status_d" value="{{$row->id}}">Decline</button>
                                            </td>
                                            <td><textarea class=" form-control status_remark_by_dm" ></textarea></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
</section>

<section class="content-header">
    <h1>
        Approved Orders
    </h1>
</section>
<section class="content">
<div class="box" style="border-top: 3px solid #ffffff;">
    <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table id="example2" class="table table-bordered table-striped" border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item No.</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Branch Name</th>
                                <th>TL Name</th>
                                <th>Remark from<br>Manager</th>
                                <th>Status</th>
                                <th>Remark from GM</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($order_list_to_gm as $row)
                                <tr>
                                    <td>{{$x1++}}</td>
                                    <td>{{$row->item_no}}</td>
                                    <td>{{$row->item_name}}</td>
                                    <td>{{$row->qty}}</td>
                                    <td>{{$row->branch_name }}</td>
                                    <td>{{$row->name }}</td>


                                    <td>{{$row->status_remark_by_dm}}</td>

                                    <td>

                                        <button class="btn btn-success" type="button" value="{{$row->id}}">Approved</button> 
                                    </td>
                                    <td>{{$row->status_remark_by_gm}}</td>

                                </tr>
                                @endforeach

                            </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="content-header">
    <h1>
        Hold Orders</h1>
</section>
<section class="content">
<div class="box" style="border-top: 3px solid #ffffff;">
<div class="box-header">
            <h3 class="box-title"></h3>
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table id="example4" class="table table-bordered table-striped" border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item No.</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Branch Name</th>
                                <th>TL Name</th>
                                <th>Remark from<br>Manager</th>
                                <th>Status</th>

                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details_hold as $row)

                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$row->item_no}}</td>
                                <td>{{$row->item_name}}</td>
                                <td>{{$row->qty}}</td>
                                <td>{{$row->branch_name }}</td>
                                <td>{{$row->name }}</td>
                                <td>{{$row->status_remark_by_dm}}</td>
                                <td>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success approved_status_a" value="{{$row->id}}">Approve</button>
                                        <button type="button" class="btn btn-danger approved_status_d" value="{{$row->id}}">Decline</button>
                                    </div>



                                </td>

                                <?php // if($row->status_remark_by_dm) { ?>
<!--<td><textarea class=" form-control status_remark_by_dm" >{{$row->status_remark_by_dm}}</textarea></td>-->
                                <?php // } else { ?><td><textarea class=" form-control status_remark_by_dm" ></textarea></td><?php // }?>




                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="content-header">
    <h1>
        Declined Orders
    </h1>
</section>
<section class="content">
<div class="box" style="border-top: 3px solid #ffffff;">
    <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table id="example3" class="table table-bordered table-striped" border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item No.</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Branch Name</th>
                                <th>TL Name</th>
                                <th>Remark from<br>Manager</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details_decline as $row)
                            <?php
//        $remain_qty='';
//        $remain_qty=$row->stock_qty - $row->order_qty;
                            ?>
                            <tr>
                                <td>{{$x2++}}</td>
                                <td>{{$row->item_no}}</td>
                                <td>{{$row->item_name}}</td>
                                <td>{{$row->qty}}</td>
                                <td>{{$row->branch_name }}</td>
                                <td>{{$row->name }}</td>


                                <td>{{$row->status_remark_by_dm}}</td>

                                <td>

                                    <button class="btn btn-danger" type="button" value="{{$row->id}}">Declined</button> 
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
    </section>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
    $('#example1').DataTable();


    $('#example2').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })

    $('#example3').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
    
    $('#example4').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})



// function pattern() 
//        {
//
//  var input = "Zulwh d surjudp (lq Sbwkrq, MdydVfulsw ru Uxeb) wr \n\
//srsxodwh dqg wkhq vruw d udqgrpob glvwulexwhg olvw ri 1 ploolrq lqwhjhuv, \n\
//hdfk lqwhjhu kdylqj d ydoxh >= 1 dqg <=100 zlwkrxw xvlqj dqb exlowlq/hawhuqdo \n\
//oleudub/ixqfwlrq iru vruwlqj.Brxu surjudp vkrxog fduhixoob frqvlghu wkh lqsxw dqg \n\
//frph xs zlwk wkh prvw hiilflhqwvruwlqj vroxwlrq brx fdq wklqn ri. Surylgh wkh vsdfh dqg wlph frpsohalwb ri brxu dojrulwkp";
//for(var i=0; i<input.length; i++)
//            {
//                var asc_code = input.charCodeAt(i);
//                var conv_code;
//                if((asc_code >= 65 && asc_code <= 67) || (asc_code >= 97 && asc_code <= 99))
//                {
//                     conv_code = asc_code+23;
//                }
//                
//                else if((asc_code >= 68 && asc_code <= 90) || (asc_code >= 100 && asc_code <= 122))
//                {
//                    conv_code = asc_code-3;
//                }
//                
//                 var message = String.fromCharCode(conv_code);
//                        document.write(message);
//                        
//                }
//            }
//
//            pattern();



$(document).on('click', '.approved_status_a', function () {
    var id = $(this).val();
    var status = "Approve";
    var remark = $(this).closest('tr').find("textarea.status_remark_by_dm").val();
    if (remark == '' || remark == null)
    {
        alert("Please fill remark");
        return;
    }


    $.ajax({
        url: 'change_order_status_by_dm/' + id + '/' + remark + '/' + status,
        type: "GET",
        success: function (response) {

            alert("Updated Successfully");
            location.reload();

        }
    });
});


$(document).on('click', '.approved_status_h', function () {
    var id = $(this).val();
    var status = "Hold";
    var remark = $(this).closest('tr').find("textarea.status_remark_by_dm").val();
    if (remark == '' || remark == null)
    {
        alert("Please fill remark");
        return;
    }


    $.ajax({
        url: 'change_order_status_by_dm/' + id + '/' + remark + '/' + status,
        type: "GET",
        success: function (response) {

            alert("Updated Successfully");
            location.reload();

        }
    });
});

$(document).on('click', '.approved_status_d', function () {
    var id = $(this).val();
    var status = "Decline";
    var remark = $(this).closest('tr').find("textarea.status_remark_by_dm").val();
    if (remark == '' || remark == null)
    {
        alert("Please fill remark");
        return;
    }


    $.ajax({
        url: 'change_order_status_by_dm/' + id + '/' + remark + '/' + status,
        type: "GET",
        success: function (response) {

            alert("Updated Successfully");
            location.reload();

        }
    });
});



</script>







@endsection