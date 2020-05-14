@extends('layouts.app')
@section('title', 'Edit Location')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>
        Edit Location
        <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('enq_location_list') }}"> Back</a>
    </div>
    </h1>
</section>
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
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('branch_update') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="branch_id" value="{{$branch->branch_id}}" />
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Branch Name<span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Branch Name" value="{{$branch->branch_name}}" id="branch_name" name="branch_name"  required >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Location Name<span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <?php $arr = explode(",", $branch->loc_id); ?>
                                 <select class="form-control select2" multiple="multiple" style="width: 100%;" name="loc_id[]" id="loc_id">
                                    <option value="">-- Select Location --</option>
                                    @foreach($location as $loc)
                                    <option value="{{$loc->loc_id}}" <?php if(in_array($loc->loc_id,$arr)) echo "selected"; ?>>{{$loc->loc_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Brand Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Brand Name" value="{{$branch->brand_name}}" id="brand_name" name="brand_name"  required >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Mobile No.</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Mobile No." value="{{$branch->mobile_no}}" id="mobile_no" name="mobile_no"  required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Branch Head</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" name="brand_head_id" id="brand_head_id">
                                    <option value="">-- Select Branch Head --</option>
                                    @foreach($users as $u)
                                    <option value="{{$u->id}}" <?php if($branch->brand_head_id == $u->id) echo "selected"; ?>>{{$u->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Branch Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Branch Address" value="{{$branch->branch_address}}" id="branch_address" name="branch_address"  required >
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Save</button>
                        <a href="{{url('branch_list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
    $('select').select2();
});
</script>
@endsection
