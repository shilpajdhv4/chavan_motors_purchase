@extends('layouts.app')
@section('title', 'Storage Location')
@section('content')

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content-header">
    <h1>
        Storage Location   
        
    </h1>
    
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"><select class="form-control select2 select_location" style=" width: 500px;"><option>Select Location</option>
                         @foreach($get_location as $row)
                            <option value="{{$row->loc_id}}">{{$row->loc_name}}</option>
                            @endforeach
                        </select></h3>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            <div class="card-body">
                                <div id="append_form_data"></div>
                            </div>    


                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</section>
            

            
            



<!--<button type="button" onclick="PrintPage();"></button>


<div id="print_div" style="display: none;">
    <h1>Abhishek Vaidya</h1>
    
</div>-->
            
<script type="text/javascript" src="js/jquery.min.js"></script>

<script>

$(document).ready(function () {
    $('.select2').select2();
    })

$(document).ready(function () {
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
});





</script>
        
@endsection