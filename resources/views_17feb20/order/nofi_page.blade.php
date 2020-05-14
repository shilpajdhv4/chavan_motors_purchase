@extends('layouts.app')
@section('title', 'Upload File')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<?php $x = 1; ?>
<section class="content-header">
    <h1>
        Stock Qty
        
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
            <table id="example1" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
           <th>No</th>
           <th>Item No.</th>
           <th>Item Description</th>
           <th>Stock Qty</th>
           <!--<th>Ordered Qty</th>-->
           <th>Threshold Qty</th>
           
        </tr>
    </thead>
    <tbody>
        <?php 
        $x =1;
            $items = \App\ItemList::select('*')->get();
            foreach($items as $row){
                $stock_qty = DB::table('tbl_storage_location')
                        ->select(DB::raw("SUM(current_qty) as stock_qty"))
                      //  ->leftjoin('tbl_item','tbl_item.item_no','tbl_storage_location.item_no')
                        ->where(['tbl_storage_location.item_no'=>$row->item_no])
                       // ->havingRaw('stock_qty <= '.$row->threshold_qty)
                        ->first(); 
        ?>
        <tr>
            <td>{{$x++}}</td>
            <td>{{$row->item_no}}</td>
            <td>{{$row->item_desc}}</td>
            <td>{{$stock_qty->stock_qty}}</td>
            <!--<td>{{$row->order_qty}}</td>-->
            <td>{{$row->threshold_qty}}</td>
                       
        </tr>
            <?php } ?>
    
</tbody>
            </table>
        
            </div>
        </div>
    </div>
</div>
</div>
        </div>
    </div>
</section>
<!--            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">
                Launch Danger Modal
              </button>-->
            <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Danger Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </div>
        </div>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
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
        </script>






        
@endsection