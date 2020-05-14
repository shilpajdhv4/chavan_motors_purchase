@extends('layouts.app')
@section('title', 'Create New Role')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>Create New Role
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
    </div></h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
{!! Form::open(array('route' => 'roles.store','method'=>'POST','class'=>'form-horizontal')) !!}
<div class="box-body">
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
        
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Permission</label>
        <div class="col-sm-10">
        @foreach($permission as $value)
            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
            {{ $value->name }}</label>
        @endforeach
        </div>
    </div>
    <div class="box-footer">
    <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
    <a href="{{route('roles.index')}}" class="btn btn-danger" >Cancel</a>
</div>
{!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection