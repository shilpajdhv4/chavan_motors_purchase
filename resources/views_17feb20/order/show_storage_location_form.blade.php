<style>
    .btn-success{
        color: #000000;background-color: #ffffff;border-color: 00C999;
    }
    .btn-danger{
        color: #000000;background-color: #39fec3;border-color: 00C999;
    }
    
    .btn-success,.btn-success:hover,.btn-success:active:focus {
         color: #000000;background-color: #ffffff;border-color: 00C999;
    }
    .btn-danger,.btn-danger:hover,.btn-danger:active:focus {
       color: #000000;background-color: #39fec3;border-color: 00C999;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-horizontal" id="design-form" action="{{url('save_storage_location')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body"> 
                        <div class="row">
                            <?php //for ($j = 0; $j < count($rack_data); $j++) { 
                            foreach($rack_data as $rack) { ?>
                                <div class="col-lg-4 col-xs-6">
                                    <table class="" id="myTable">
                                        <tr><th colspan="3" style=" text-align: center;">RACK <?php echo $rack->rank_no; ?></th></tr>
                                        <tr>
                                        <?php 
                                            $i = 0;
                                            $section = \App\StorageLocationSubMaster::select('section_no','is_active','master_id','id')->where(['master_id'=>$rack->id])->get();
                                            foreach($section as $s){ 
                                                if($i == 3){ 
                                                    $i = 0;?>
                                                </tr><tr>
                                                <?php }
                                                $combine_data = $rack->rank_no.','.$s->section_no.','.$s->is_active.','.$rack->loc_name.','.$s->id;
                                                ?>
                                            
                                                <th style=" width: 100px; " ><button style=" width: 100px; " class="show_data btn <?php if ($s->is_active == "0") { ?>btn-success<?php } else { ?> btn-danger <?php } ?> " type="button" value="{{$combine_data}}">{{$s->section_no}}</button></th>
                                            <?php $i++; } ?>
                                            </tr>
                                        <?php // } ?>
                                    </table>
                                </div>
                            <?php } ?>          




                            <!-- ./col -->
                        </div>
                        <!-- /.row -->





                        <div class="border-top">
                            <!--                        <div class="card-body">
                                                        <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                                                    <a href="{{url('storage_location')}}" class="btn btn-danger" >Cancel</a>
                                                    </div>-->
                        </div>
                    </div>    
                </form>

            </div>
        </div>
    </div>
</div>
</div>

<!--            <div class="modal modal-default fade" id="modal-danger">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enter Storage Details</h4>
              </div>
              <div class="modal-body">
                  <div id="show_data"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </div>
        </div>-->


<div class="modal" id="modal-danger">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Storage Details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="show_data"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-success add_more_items pull-left" type="button" style="background-color: #39fec3;">ADD</button>
                <button type="button" class="btn btn-success save_data" style="background-color: #39fec3;">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal" style="background-color: #000000;color:#ffffff;">Close</button>

            </div>

        </div>
    </div>
</div>


<div class="modal" id="modal-swipe">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Swipe Data&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="append_swipe_data"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success save_swipe_data">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal-swipe1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Swipe Data1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="append_swipe_data1"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success save_swipe_data1">Save</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>

<input type="text" value="{{$location_name}}" style="display:none;" class="location_name">

<!--<button type="button" onclick="PrintPage();"></button>


<div id="print_div" style="display: none;">
    <h1>Abhishek Vaidya</h1>
    
</div>-->

<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->

<script>

    $(document).ready(function () {
        $('.select2').select2();
    })




    $(document).on('click', '.show_data', function () {
        var id = $(this).val();
//      alert(id);
        $.ajax({
            url: 'show_storage_location_modal/' + id,
            type: "GET",
            success: function (response) {
                $('#modal-danger').modal('show');
                $('#show_data').html(response);
                $('.select2').select2();
            }
        });
    });

    $(document).on('click', '.save_data', function () {
		//alert();
        $.ajax({
            url: 'update_storage_details',
            type: "POST",
            data: $("#save_item_sl").serialize(),
            success: function (response) {
                location.reload();
            }
        });
    });

    $(document).ready(function () {
        var i = 0;
        var rowCount = $('#myTable tr').length;
        var i = rowCount + 1;
        $(document).on('click', '.add_more_items', function () {
//            alert();
            var count_al = $(".item_count").length;
//            alert(count_al);
            if(count_al > 10){
                alert("Items value are greate than 10 in this slots.");
            }
            var data = "<tr class='item_count'><td><button type='button' class=''>&times;</button></td><td style='text-align: center;'>\n\
                <select class='form-control select2 item_no' name='item_no["+i+"][0]' style=' width:500px;' required=''>\n\
                    <option value=''>Select Item</option><?php foreach ($item_list as $row) { ?><option value='<?php echo $row->item_no; ?>'><?php echo $row->item_desc . " / " . $row->item_no; ?></option> <?php } ?></td>\n\
    <td style='text-align: center;'><input type='text' class='form-control c_qty number2' name='item_no["+i+"][1]' style=' width:100px; text-align: center;' required=''></td></tr>";

            $("#append_items").append(data);
            $('.select2').select2();
            i++;
        });
    });

    $(document).on('click', '.close_tr', function (e) {
        var whichtr = $(this).closest("tr");
        whichtr.remove();
    });



    $(document).on('click', '.swipe_items', function (e) {
        var this_data = $(this).val();
//alert(this_data);
        $.ajax({
            url: 'swipe_items_storage/' + this_data,
            type: "GET",
            success: function (response) {
                $('#modal-swipe').modal('show');
//return false;
                $('#append_swipe_data').html(response);
                $('.select2').select2();

            }
        });
    });

    $(document).on('click', '.swipe_items1', function (e) {
        var id = $(this).attr('id');
//        var swap = $(".swipe_items").val();
//        alert(swap);
        
        
        $.ajax({
            url: 'swipe_items_storage1',
            type: "GET",
            data : {href:id},
            success: function (response) {
                $('#modal-swipe1').modal('show');
//return false;
                $('#append_swipe_data1').html(response);
                $('.select2').select2();

            }
        });
    });

    $(document).on('click', '.save_swipe_data', function (e) {
        $.ajax({
            url: 'update_swipe_data',
            type: "POST",
            data: $("#update_swipe_data").serialize(),
            success: function (response) {
               location.reload();
               // call_again();
            }
        });
    });

    $(document).on('click', '.save_swipe_data1', function (e) {
        $.ajax({
            url: 'update_swipe_data1',
            type: "POST",
            data: $("#update_swipe_data").serialize(),
            success: function (response) {
              location.reload();
               // call_again();
            }
        });
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

    $(document).on('change', '#rack_no_swipe', function (e) {
        var rack_id = $(this).val();
       // alert(rack_id);
    })

    function call_again()
    {
        var location_name = $(".location_name").val();
        $.ajax({
            url: 'show_storage_location_form/' + location_name,
            type: "GET",
            success: function (response) {
                $("#append_form_data").html(response);

            }
        });
    }





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
