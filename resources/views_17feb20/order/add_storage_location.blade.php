@extends('layouts.app')
@section('title', 'Add Storage Location')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
@if (Session::has('alert-danger'))
<div class="alert alert-danger alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Error!</h4>
    {{ Session::get('alert-danger') }}
</div>
@endif
<style>
    #loading-img {
    background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
    height: 100%;
    z-index: 20;
}

.overlay {
    background: #e9e9e9;
    display: none;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
}
</style>
<section class="content-header">
    <h1>
        Add Storage Detail 
        
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
            <form class="form-horizontal" id="design-form" action="{{url('save_storage')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body"> 
                    
                    <div class="overlay">
    <div id="loading-img"></div>
</div>
                    <div class="form-group row">
                        <label class="col-md-2">Location Name</label>
                        <div class="input-group date col-md-4">
                            <select class="form-control select2 " id="location" name="location"  required="required" >
                                <option value="">Select Location</option>
                                @foreach($location as $row)
                                <option value="{{$row->loc_id}}">{{$row->loc_name}}</option>
                                @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Rack No</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control number" name="rank_no1" required>
                             
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Total Slots</label>
                        <div class="input-group date col-md-4">
                            
                            <input type="text" class=" form-control number" name="section_no" required>
                             
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" id="btnsubmit" class="btn btn-info " value="Submit"  >
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
//    $("#btnsubmit").click(function () {
//        $(".overlay").show();
//    });
    $('.select2').select2();
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

    
    })
  
  $("#design-form" ).validate({
    rules: {
        location: {required: true},
        rank_no1: {required: true},
        section_no: {required: true},
    },
  submitHandler: function() { $(".overlay").show(); $('#design-form').submit();}
});
  
// var jvalidate = $("#design-form").validate({
//        rules: {
//            location: {required: true},
//            rank_no1: {required: true},
//            section_no: {required: true},
//        }
//    });
// 
//    $('#btnsubmit').on('click', function () {
//        $("#design-form").valid();
//    });
 




</script>
        
@endsection