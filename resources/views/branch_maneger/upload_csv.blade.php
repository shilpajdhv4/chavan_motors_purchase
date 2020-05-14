@extends('layouts.app')
@section('title', 'Upload File')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

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
            <form class="form-horizontal" id="design-form" action="{{url('upload_csv')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    <div class="form-group row">
                        <label class="col-md-2">Date</label>
                        <div class="input-group date col-md-4">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                            <input type="text" name="upload_date" id="upload_date" class="form-control datepicker" placeholder="DD-MM-YYYY" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Upload File</label>
                        <div class="col-md-4">
                            <input type="file" name="sample_file" id="design_file"  class="form-control" >
                        </div>
                    </div>
                    <span id="file_validate" style="color:red"></span>
                    <span id="max_file_upload" style="color:red"></span>
                    <div id="cover-spin"></div>
                    <input type="hidden" name="up_id" id="up_id" value="1" />
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-info" value="Submit"  >
                        <a href="{{url('design_upload')}}" class="btn btn-danger" >Cancel</a>
                        </div>
                    </div>
                </div>    
            </form>
        
            </div>
        </div>
    </div>
</div>
</div>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">

$(document).on("click",".img_model", function () {
        $('#Modal2').modal({backdrop: 'static', keyboard: false});
        var detail_id = $(this).closest('td').find('.imgName').val();//$(this).siblings('.imgName').val();
//    alert(detail_id);
        $.ajax({
            url: 'upload_design_det/' + detail_id,
            type: "GET",
            success: function (response) {
                var data = JSON.parse(response);
                console.log(data);
                $("#detail_no").val(data.detail_no);
                $("#item_desc").val(data.item_desc);
                $("#item_type").val(data.item_type);
                $("#material_type").val(data.material_type);
                $("#finish_size").val(data.finish_size);
                $("#qty").val(data.qty);
                $("#id").val(data.id);
                var url = "Fixture_Design/" + data.fixture_no + "/" + data.upload_file;
                $('.pdf_img').attr('src', url);
//            $('#myModal1').modal('hide');
            }
        });
    });
  
$(document).ready(function () {   
   $("form#design-upload").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#cover-spin").show();
        $.ajax({
            url: 'upload_design_det',
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#cover-spin").hide();
                fileInput = document.getElementById('upload_file');
                fileInput.value = '';
                $('#Modal2').modal('hide');
                swal({type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Submitted Successfully", confirmButtonText: "Ok"});
                
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }); 
    
 
    
$("#order_id").on("change",function(){
    var order_id = $(this).val();
    $.ajax({
        url: 'detail_no/' + order_id,
        type: "GET",
        success: function(response) {
            var data = JSON.parse(response);
            console.log(data[0]);
            $("#detail_no").empty();
            $("#detail_no").append('<option value="">-- Select Detail No. --</option>');
            $.each(data, function(key, value) {
                $("#detail_no").append('<option value="' + value.id + '">' + value.detail_no + '</option>');
            });
        }
   });
}); 


$("#btnsubmit").click(function(){
    $("#design-form").validate({
        rules: {  
                order_id: {required: true},
            }                                        
        });
})

//$('#btnsubmit').on('click', function() {
//    $("#design-form").valid();
//});

$('#upload_pdf').on('click', function() {
    var order_id = $("#order_id").val();
    if(order_id == ""){
        $("#order_id-error").html('This field is required.');
        return false;
    }else{
        $("#order_id-error").html('');
    }
    var fileInput = document.getElementById('design_file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
    if(!allowedExtensions.exec(filePath)){
        $("#file_validate").html('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
    $("#file_validate").html('');    
//    var file_data = $('#design_file').prop('files')[0];   
    var form_data = new FormData();  
    var ins = document.getElementById('design_file').files.length;
    for (var x = 0; x < ins; x++) {
        form_data.append("design_file[]", document.getElementById('design_file').files[x]);
    }
    var $fileUpload = $("input[type='file']");
    if (parseInt($fileUpload.get(0).files.length) > 35){
           $("#max_file_upload").html("You are only allowed to upload a maximum of 10 files");
    }else{
        form_data.append('order_id', $("#order_id").val());
        form_data.append('up_id', 0);
//        $("#cover-spin").show();                         
        $.ajax({
            url: 'detail_no', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,    
            type: 'post',
            beforeSend:function(){
            $("#cover-spin").show();
           },
           complete:function(data){
            $("#cover-spin").hide();
           },
            success: function(response){
                $("#btnsubmit").attr("disabled",false);
                var $el = $('#design_file');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
                
                $("#img_div").html(response); // display response from the PHP script, if any
            }
        });
    }
    }
});

});
    


function fileValidation(){
    var fileInput = document.getElementById('design_file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
    if(!allowedExtensions.exec(filePath)){
        $("#file_validate").html('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        $("#file_validate").html('');
    }
}

</script>
        
@endsection