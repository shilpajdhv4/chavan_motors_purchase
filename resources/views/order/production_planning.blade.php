@extends('layouts.app')
@section('title', 'Production Planning and Control Department')
@section('content')
<?php $expload_id = explode(",", $id); ?>
<style>
    /*    .wizard > .content {
    background: #fff;}*/
    span .select2-selection__rendered {
        width: 308.063px;
    }

    i {
        font-style: normal;
        width: 35px;
        line-height: 25px;
        font-size: 23px;
        display: inline-block;
        text-align: center;
    }

    .remove_field {
        color: red;
    }
</style>
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Production Planning and Control Department</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">BOM</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Production Planning and Control Department</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif
    <!-- END BREADCRUMB -->
    <!-- PAGE CONTENT WRAPPER -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <!--<h4 class="card-title">Design Department</h4>-->
                <h6 class="card-subtitle"></h6>
                <form class="m-t-40" id="design-form" method="post" action="{{ url('production_planning') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div>
                        <h3>st Tab</h3>
                        <fieldset>
                            <div class="form-group row">
                                <label for="fixture" class="col-sm-2">Fixture Number</label>
                                <div class="col-sm-4">
                                    <select class="select2 required form-control custom-select" name="order_id" id="order_id">
                                        <option value="">-- Select Fixture No. --</option>
                                        @foreach($fixture_detail as $fixture)
                                        <option value="{{$fixture->order_id}}" <?php if (isset($expload_id[0])) {
                                                                                    if ($expload_id[0] == $fixture->order_id) echo "selected";
                                                                                } ?>>{{$fixture->fixture_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="fixture" class="col-sm-2">Detail Number</label>
                                <div class="col-sm-4">
                                    <select class="select2 required form-control custom-select" name="detail_no" id="detail_no">
                                        <option value="">-- Select Detail No. --</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <h3>nd Tab</h3>
                        <fieldset>
                            <div class="form-group row" style="height:400px;">
                                <iframe class="pdf_img" src="" width="100%"></iframe>
                            </div>
                        </fieldset>
                        <h3>rd Tab</h3>
                        <fieldset>
                            <div class="form-group row" style="margin-bottom: 2rem;">
                                <label class="col-md-2">Select Option</label>
                                <div class="col-md-5">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="critical" id="ppc_operation1">
                                        <label class="custom-control-label" for="ppc_operation1">Critical</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="in_house_process_sheet" id="ppc_operation2" checked="checked">
                                        <label class="custom-control-label" for="ppc_operation2">In House Process Sheet</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="out_source_process_sheet" id="ppc_operation6">
                                        <label class="custom-control-label" for="ppc_operation6">Out Source Process Sheet</label>
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="job_card" id="ppc_operation3">
                                        <label class="custom-control-label" for="ppc_operation3">Job Card</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="quality" id="ppc_operation4">
                                        <label class="custom-control-label" for="ppc_operation4">Quality</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input ppc" name="ppc_operation[]" value="outsource" id="ppc_operation5">
                                        <label class="custom-control-label" for="ppc_operation5">Outsource Machine</label>
                                    </div>
                                </div>
                            </div>
                            <div id="in_house_process_sheet">
                                <div style="width: 100%;height: 0px;border-bottom: 20px solid #27a9e3;text-align: center;margin-bottom: 1rem;">
                                    <span style="font-size: 13px;background-color: #27a9e3;padding: 0 19px;color: white;">
                                        In House Process Sheet
                                    </span>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Select Plant</th>
                                                        <th>Machine Type</th>
                                                        <th>Assign Operation</th>
                                                        <th>Select Machine</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="in_house_h_lost">
                                                    <tr class="in_house_input_fields_wrap">
                                                        <td>
                                                            <i class="fas fa-plus-circle in_house_add_field_button" style="color: #0c8a54;"></i>
                                                        </td>
                                                        <td>
                                                            <select class="select2 required form-control custom-select cls_plant_name" name="in_house_plant_name[1][]" style="width:100%;">
                                                                <option value="">-- Select Plant--</option>
                                                                <option value="M 168 PLANT">M 168 PLANT</option>
                                                                <option value="M 61 PLANT">M 61 PLANT</option>
                                                                <option value="M 64 PLANT">M 64 PLANT</option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <select class="select2 required form-control custom-select cls_machine_type" name="in_house_machine_type[1][]" multiple="multiple" style="height: 36px;width: 100%;">
                                                                <option value="">-- Select Machine Type--</option>
                                                                @foreach($machine_types as $machine_type)
                                                                <option value="{{$machine_type->id}}">{{$machine_type->text}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="select2 required form-control custom-select cls_assign_operation" name="in_house_assign_operation[1][]" multiple="multiple" style="height: 36px;width: 100%;">
                                                                <option value="">-- Select Operation--</option>
                                                                @foreach($assign_operations as $assign_operation)
                                                                <option value="{{$assign_operation->id}}">{{$assign_operation->text}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="select2 required form-control custom-select cls_machine_name" name="in_house_machine_name[1][]" multiple="multiple" style="height: 36px;width: 100%;">
                                                                <option value="">-- Select Machine--</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="form-group row">
                                    <label for="fixture" class="col-sm-2">Select Plant</label>
                                    <div class="col-sm-4">
                                        <select class="select2 required form-control custom-select" name="plant_name" id="plant_name">
                                            <option value="">-- Select Plant--</option>
                                            <option value="M 168 PLANT">M 168 PLANT</option>
                                            <option value="M 61 PLANT">M 61 PLANT</option>
                                            <option value="M 64 PLANT">M 64 PLANT</option>
                                        </select>
                                    </div>
                                    <label for="fixture" class="col-sm-2 ">Select Machine</label>
                                    <div class="col-sm-4">
                                        <select class="select2 required form-control custom-select" name="machine_name[]" id="machine_name" multiple="multiple" style="height: 36px;width: 100%;">
                                            <option value="">-- Select Machine--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <?php
                                    foreach ($ppc_operation as $ppc) { ?>
                                        <div class="custom-control custom-checkbox  col-md-3">
                                            <input type="checkbox" class="custom-control-input" name="process_sheet_op[]" value="{{$ppc->id}}" id="{{$ppc->name}}" checked="checked">
                                            <label class="custom-control-label" for="{{$ppc->name}}">{{$ppc->name}}</label>
                                        </div>
                                    <?php
                                    } ?>
                                </div>-->
                            </div>
                            <div id="out_source_process_sheet" style="display: none">
                                <div style="width: 100%;height: 0px;border-bottom: 20px solid #27a9e3;text-align: center;margin-bottom: 1rem;">
                                    <span style="font-size: 13px;background-color: #27a9e3;padding: 0 19px;color: white;">
                                        Out Source Process Sheet
                                    </span>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Select Process</th>
                                                        <th>Select Plant</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="out_house_h_lost">
                                                    <tr class="out_house_input_fields_wrap">
                                                        <td>
                                                            <i class="fas fa-plus-circle out_house_add_field_button" style="color: #0c8a54;"></i>
                                                        </td>
                                                        <td>
                                                            <select class="select2  form-control custom-select out_cls_process" name="out_process[1][]" multiple="multiple" style="height: 36px;width: 100%;">
                                                                <option value="">-- Select Machine Type--</option>
                                                                @foreach($outsource_process as $process)
                                                                <option value="{{$process->id}}">{{$process->text}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="select2  form-control custom-select out_cls_plant_name" name="out_plant_name[1][]" style="width:100%;">
                                                                <option value="">-- Select Plant--</option>
                                                                <option value="M 168 PLANT">M 168 PLANT</option>
                                                                <option value="M 61 PLANT">M 61 PLANT</option>
                                                                <option value="M 64 PLANT">M 64 PLANT</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="job_card" style="display:none">
                                <div style="width: 100%;height: 0px;border-bottom: 20px solid #27a9e3;text-align: center;margin-bottom: 1rem;">
                                    <span style="font-size: 13px;background-color: #27a9e3;padding: 0 19px;color: white;">
                                        Job Card
                                    </span>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2">Job Card No.</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="job_card_no" id="job_card_no" value="" class="form-control" />
                                    </div>
                                    <label for="name" class="col-sm-2">Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="job_card_date" id="job_card_date" placeholder="mm/dd/yyyy" value="" class="datepicker-autoclose form-control" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2">Detail No.</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="job_card_detail_no" id="job_card_detail_no" value="" class="form-control" readonly />
                                    </div>
                                    <label for="name" class="col-sm-2">Detail Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="job_card_detail_name" id="job_card_detail_name" value="" class="form-control" />
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Sr. No.</th>
                                                        <th>Process</th>
                                                        <th>Responsibility</th>
                                                        <th>Date</th>
                                                        <th>Start Time</th>
                                                        <th>Finish Time</th>
                                                        <th>Handover To</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="h_lost">
                                                    <tr class="input_fields_wrap">
                                                        <td><i class="fas fa-plus-circle add_field_button" style="color: #0c8a54;"></i></td>
                                                        <td>1</td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control" value=" " style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control" value=" " style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control datepicker-autoclose" placeholder="mm/dd/yyyy" style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" placeholder="hh:mm" class="form-control" onkeypress="return isNumber(event,this)" style="width: 100px;"></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" placeholder="hh:mm" class="form-control" onkeypress="return isNumber(event,this)" style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control" value=" " style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control datepicker-autoclose" placeholder="mm/dd/yyyy" style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control" value=" " style="width: 100px;" /></td>
                                                        <td><input type="text" name="job_card_dtail[1][]" class="form-control" value=" " style="width: 150px;" /></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="quality" style="display:none">
                                <div style="width: 100%;height: 0px;border-bottom: 20px solid #27a9e3;text-align: center;margin-bottom: 1rem;">
                                    <span style="font-size: 13px;background-color: #27a9e3;padding: 0 19px;color: white;">
                                        Quality
                                    </span>
                                </div>
                                <div class="form-group row">
                                    @foreach($quality_operation as $quality)
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" value="{{$quality->id}}" name="quality_op[]" id="{{$quality->quality_operation}}">
                                            <label class="custom-control-label" for="{{$quality->quality_operation}}">{{$quality->quality_operation}}</label>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div id="outsource" style="display:none">
                                <div style="width: 100%;height: 0px;border-bottom: 20px solid #27a9e3;text-align: center;margin-bottom: 1rem;">
                                    <span style="font-size: 13px;background-color: #27a9e3;padding: 0 19px;color: white;">
                                        Outsource Machine
                                    </span>
                                </div>
                                <div class="form-group row">
                                    <label for="fixture" class="col-sm-2">Select Option</label>
                                    <div class="col-sm-4">
                                        <select class="select2 form-control custom-select" name="outsocurce_op" id="outsocurce">
                                            <option value="">-- Select --</option>
                                            <option value="finished_at_outsource">Finished at Outsource</option>
                                            <option value="semi_finished">Semi finished</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2">Vendor Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="vendor_name" id="vendor_name" value="" class="form-control" />
                                    </div>
                                    <label for="name" class="col-sm-2">Given Date</label>
                                    <div class="input-group col-sm-4">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-pink"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="given_date" class="form-control datepicker-autoclose" id="given_date" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2">Expected Date</label>
                                    <div class="input-group col-sm-4">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-pink"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="expected_date" class="form-control datepicker-autoclose" id="expected_date" placeholder="mm/dd/yyyy">
                                    </div>
                                    <label for="name" class="col-sm-2">Received Date</label>
                                    <div class="input-group col-sm-4">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-pink"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="received_date" class="form-control datepicker-autoclose" id="received_date" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                                <div id="semi_finished" style="display:none">
                                    <div class="form-group row">
                                        @foreach($semifinished as $semi)
                                        <div class="custom-control custom-checkbox col-md-3">
                                            <input type="checkbox" class="custom-control-input" value="{{$semi->id}}" name="semi_finished_op[]" id="{{$semi->semi_finished_op}}{{$semi->id}}">
                                            <label class="custom-control-label" for="{{$semi->semi_finished_op}}{{$semi->id}}">{{$semi->semi_finished_op}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ppc').on('click', function() {
            $.each($(".ppc"), function() {
                var a = $(this).val();
                if ($(this).is(':checked')) {
                    if ($(this).val() == "job_card") {
                        var detail_no = $("#detail_no option:selected").text();
                        //var detail_no = $("#detail_no").val();
                        $("#job_card_detail_no").val(detail_no);
                    }
                    $("#" + a).css("display", "block");
                } else {
                    $("#" + a).css("display", "none");
                }
            });
        });

        $("#detail_no").on("change", function() {
            var detail_id = $(this).val();
            $.ajax({
                url: 'upload_design_det/' + detail_id,
                type: "GET",
                success: function(response) {
                    var data = JSON.parse(response);
                    // console.log(data);
                    if (data) {
                        var url = "Fixture_Design/" + data.fixture_no + "/" + data.upload_file;
                        $('.pdf_img').attr('src', url);
                    }
                }
            });
        });

        $("#outsocurce").on("change", function() {
            var outsource_val = $(this).val();
            if (outsource_val === "semi_finished") {
                $("#semi_finished").css("display", "block");
            } else {
                $("#semi_finished").css("display", "none");
            }
        })

        $("#order_id").change(function() {
            var order_id = $(this).val();
            $.ajax({
                url: 'detail_no/' + order_id,
                type: "GET",
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data[0]);
                    var a = "";
                    a = <?php if (isset($expload_id[1])) {
                            echo $expload_id[1];
                        } else echo "0"; ?>;
                    $("#detail_no").empty();
                    $("#detail_no").append('<option value="">-- Select Detail No. --</option>');

                    $.each(data, function(key, value) {
                        $("#detail_no").append('<option value="' + value.id + '" >' + value.detail_no + '</option>');
                    });
                    $("#detail_no").val(a).attr("selected", "selected");
                    $("#detail_no").trigger('change.select2');
                    $('#detail_no').trigger('change');
                }
            });
        });
        $('#order_id').trigger('change');
        //! This is my code


        //    var max_fields      = 6; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var i = 0;
        var x = 1; //initlal text box count
        var s = 14;
        $(add_button).click(function() {
            var i = $('.input_fields_wrap').length;
            //        alert(i);
            i++;
            $("#h_lost").append('<tr class="input_fields_wrap">\n\
            <td><i class="fas fa-minus-circle remove_field" style="color: red;"></i></td>\n\
            <td>' + i + '</td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" value=" " style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" value=" " style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control datepicker-autoclose"  name="job_card_dtail[' + i + '][]" placeholder="mm/dd/yyyy" style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" style="width: 100px;" onkeypress="return isNumber(event,this)" placeholder="hh:mm" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" style="width: 100px;" onkeypress="return isNumber(event,this)" placeholder="hh:mm" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" value=" " style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control datepicker-autoclose"  name="job_card_dtail[' + i + '][]" placeholder="mm/dd/yyyy" style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" value=" " style="width: 100px;" /></td>\n\
            <td><input type="text" class="form-control" name="job_card_dtail[' + i + '][]" value=" " style="width: 150px;" /></td>\n\
        </tr>'); //add input box
            $('select').select2();
            $('.datepicker-autoclose').datepicker();
            //$('.timepicker1').timepicker();
            $("#h_lost").on('click', '.remove_field', function() {
                $(this).parent().parent().remove();
            });
        });

        var j = 0;
        $(".in_house_add_field_button").click(function() {
            var j = $('.in_house_input_fields_wrap').length;
            j++;
            var content = '<tr class="in_house_input_fields_wrap"> <td> <i class="fas fa-minus-circle in_house_remove_field_button" style="color: red;"></i> </td><td> <select class="select2 required form-control custom-select cls_plant_name" name="in_house_plant_name[' + j + '][]" style="width:100%;"> <option value="">-- Select Plant--</option> <option value="M 168 PLANT">M 168 PLANT</option> <option value="M 61 PLANT">M 61 PLANT</option> <option value="M 64 PLANT">M 64 PLANT</option> </select></td><td> <select class="select2 required form-control custom-select cls_machine_type" name="in_house_machine_type[' + j + '][]" multiple="multiple" style="height: 36px;width: 100%;"> <option value="">-- Select Machine Type--</option> @foreach($machine_types as $machine_type) <option value="{{$machine_type->id}}">{{$machine_type->text}}</option> @endforeach </select> </td><td> <select class="select2 required form-control custom-select cls_assign_operation" name="in_house_assign_operation[' + j + '][]" multiple="multiple" style="height: 36px;width: 100%;"> <option value="">-- Select Operation--</option> @foreach($assign_operations as $assign_operation) <option value="{{$assign_operation->id}}"> {{$assign_operation->text}} </option> @endforeach </select> </td><td> <select class="select2 required form-control custom-select cls_machine_name" name="in_house_machine_name[' + j + '][]" multiple="multiple" style="height: 36px;width: 100%;"> <option value="">-- Select Machine--</option> </select> </td></tr>';
            $("#in_house_h_lost").append(content);
            $('select').select2();
            $("#in_house_h_lost").on('click', '.in_house_remove_field_button', function() {
                $(this).parent().parent().remove();
            });
        });
        var k = 0;
        $(".out_house_add_field_button").click(function() {
            var k = $('.out_house_input_fields_wrap').length;
            k++;
            var content = '<tr class="out_house_input_fields_wrap"> <td> <i class="fas fa-minus-circle out_house_remove_field_button" style="color: red;"></i> </td><td> <select class="select2 required form-control custom-select out_cls_process" name="out_process[' + k + '][]" multiple="multiple" style="height: 36px;width: 100%;"> <option value="">-- Select Machine Type--</option> @foreach($outsource_process as $process) <option value="{{$process->id}}">{{$process->text}}</option> @endforeach </select> </td><td> <select class="select2 required form-control custom-select out_cls_plant_name" name="out_plant_name[' + k + '][]" style="width:100%;"> <option value="">-- Select Plant--</option> <option value="M 168 PLANT">M 168 PLANT</option> <option value="M 61 PLANT">M 61 PLANT</option> <option value="M 64 PLANT">M 64 PLANT</option> </select> </td></tr>';
            $("#out_house_h_lost").append(content);
            $('select').select2();
            $("#out_house_h_lost").on('click', '.out_house_remove_field_button', function() {
                $(this).parent().parent().remove();
            });
        });
        $("#in_house_h_lost").on("change", ".cls_plant_name", function() {
            // e.preventDefault();
            var machine_plant = $(this).val();
            var container = $(this).parent().parent().find(".cls_machine_name");
            $(container).select2("destroy");
            if (machine_plant != "") {
                $.ajax({
                    url: 'machine_name/' + machine_plant,
                    type: "GET",
                    success: function(response) {
                        var data = JSON.parse(response);
                        // console.log(data[0]);
                        $(container).empty();
                        $(container).append('<option value="">-- Select Machine --</option>');
                        $.each(data, function(key, value) {
                            $(container).append('<option value="' + value.machine_id + '">' + value.machine_no + '</option>');
                        });
                        $(container).select2();
                    }
                });
            } else {
                $(container).empty();
                $(container).append('<option value="">-- Select Machine --</option>');
                $(container).select2();
            }
        });
    });


    var form = $("#design-form").show();
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex > newIndex) {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function(event, currentIndex, priorIndex) {
            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
                form.steps("next");
            }
            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3) {
                form.steps("previous");
            }
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            //       alert("Submitted!");
            $("#design-form").submit();
        }
    });


    function isNumber(evt, num) {
        // get keyboard event and then look its keyCode
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        //check the event is numeric
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 186) {

            return false;
        }

        // Check accordingly every new number must include regular date format

        if (num.value.length == 0 && (charCode == 48 || charCode == 49 || charCode == 50)) {
            return true;
        } else if (num.value.length == 1 && (charCode >= 48 && charCode <= 57)) {
            return true;
        } else if (num.value.length == 2 && (charCode >= 48 && charCode <= 53)) {
            num.value = num.value + ":";
            return true;
        } else if (num.value.length == 3 && (charCode >= 48 && charCode <= 53)) {
            //alert("Bingo");
            return true;
        } else if (num.value.length == 4 && (charCode >= 48 && charCode <= 57)) {
            return true;
        } else {
            return false;
        }

        return true;
    }
</script>
@endsection