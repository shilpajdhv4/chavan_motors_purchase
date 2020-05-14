@extends('layouts.app')
@section('title', 'User-List')
@section('content')
<style>
     .error{
        outline: 1px solid red;
    } 
</style>

<section class="content-header">
<h1>Generate Purcahse Order</h1>
</section>
    <!--<div class="flash-message alert alert-success alert-block" ></div>-->
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<?php $x = 1; ?>
<section class="content">
    <div class="box">
        <div class="box-body" >
            <div id="print_div">
                <table class="table table-bordered table-striped" border="1">
                    <tr style="">
                        <th style=" text-align: center;" colspan="6"><h2>Purchase Order</h2></th>
                    </tr>
                    <tr>
                        <th>Date :- <?php echo $po_detail->inserted_date;//echo date("Y-m-d");?></th>
                    </tr>
                    <tr>
                        <th>PO.No :- {{$po_detail->id}}</th>
                    </tr>
                    <tr>
                        <th>Vendor Name :- {{$po_detail->vendor_name}}</th>
                    </tr>
                    <tr>
                        <th>GST No. :- {{$po_detail->gst_no}}</th>
                    </tr>
                    <tr>
                        <th>Mobile No. :- {{$po_detail->mob_no}}</th>
                    </tr>
                    <tr>
                        <th>Address :- {{$po_detail->address}}</th>
                    </tr>
                </table>
                <table class="table table-bordered table-striped" border="1">
                    <tr>
                        <th>Sr.No</th>
                        <th>Item Description / Item No.</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                   
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$po_detail->item_desc}}</td>
                        <td>{{$po_detail->qty}}</td>
                        <td>{{$po_detail->price}}</td>
                        <td>{{$total_arr[]=$po_detail->price * $po_detail->qty}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <th>Total</th>
                        <th><?php echo array_sum($total_arr);?></th>
                    </tr>

                    <tr>
                        <th>Terms & Conditions</th>

                    </tr>
                    <tr>
                        <th>Tax: Extra as applicable</th>

                    </tr>
                    <tr>

                        <th>Payment: 100% After installation & setup</th>

                    </tr>
                    <tr>

                        <th>Warranty As specified by OEM</th>

                    </tr>
                    <tr>
                        <th>Invoice: Please raise the invoice on the below name</th>

                    </tr>
                    <tr>

                        <th>Chavan Motors</th>
                    </tr>
                    <tr>

                        <th>GST Number:-</th>
                    </tr>
                </table>
            </div>
        
        <a href="#" target="_blank" class="btn btn-default pull-right" onclick="printDiv()"><i class="fa fa-print"></i> Print</a>
    </div>  
</div>
</section>

<!--<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" id="cmd">
            <i class="fa fa-download"></i> Generate PDF
</button>-->
<div id="editor"></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js" type="text/javascript"></script>

<script>
function printDiv() {
     var printContents = document.getElementById('print_div').innerHTML;
     var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#print_div').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('chavan_motor_po.pdf');
});


</script>
@endsection