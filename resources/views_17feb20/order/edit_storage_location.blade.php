@extends('layouts.app')
@section('title', 'Edit Storage Location')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content-header">
    <h1>
        Edit Storage Location Form
        
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
            <form class="form-horizontal" id="design-form" action="{{url('update_storage')}}" method="post" >
                {{ csrf_field() }}
                <div class="card-body"> 
                    <input type="hidden" name="id" value="{{$storage->location}}" />
                    <input type="hidden" name="prev_val" id='prev_val' value="{{$storage->section_no}}" />
                    <input type="hidden" name="prev_val_rack" id='prev_val_rack' value="{{$storage->rank_no}}" />
                    <div class="form-group row">
                        <label class="col-md-2">Location Name</label>
                        <div class="input-group date col-md-4">
                            <select class="form-control select2  col-md-4" name="location" id="location" disabled>
                                <option>Select Location</option>
                                @foreach($location as $row)
                                <option value="{{$row->loc_id}}" <?php if($row->loc_id == $storage->location) echo "selected"; ?>>{{$row->loc_name}}</option>
                                @endforeach
                           </select>
                            <!--<input type="text" class="form-control" value="{{$storage->location}}" name="location" readonly >-->
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Rack No</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class="form-control" value="{{$storage->rank_no}}" name="rank_no1" id='rank_no' required>
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Total Slots</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control number" value="{{$storage->section_no}}" id="section_no" name="section_no"   readonly>
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-8 abc" style="color:red"></label>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" class="btn btn-info " value="Update"  >
                        <a href="{{url('storage_list')}}" class="btn btn-danger" >Cancel</a>
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
    
    $("#rank_no").on("focusout",function(){
        var current = $("#rank_no").val();
        //alert(current);
        var prev_val = $("#prev_val_rack").val();
//        alert(prev_val);
        if(current < prev_val){
            $("#rank_no").val("");
            $(".abc").html("Please Enter Value Greater Than Prevoius value.");
        }else{
            $(".abc").html("")
        }
    })
    
	$('.number').keypress(function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      
});
$('.number').bind("paste", function(e) {
var text = e.originalEvent.clipboardData.getData('Text');
if ($.isNumeric(text)) {
    if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
        e.preventDefault();
        $(this).val(text.substring(0, text.indexOf('.') + 3));
   }
}
else {
        e.preventDefault();
     }
});

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




</script>
        
@endsection