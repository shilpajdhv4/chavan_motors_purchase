@extends('layouts.app')
@section('title', 'User-List')

@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Users Management
        <div class="pull-right">
             @can('user-create')
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            @endcan
        </div>
    </h1>
</section>

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
<section class="content">
    <div class="box">
<!--        <div class="box-header">
            <a href="{{ route('users.create') }}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Create New User</a>
        </div>-->
<?php $i = 0; ?>
        <div class="box-body" >
            <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Company Name</th>
                        <th>Department</th>
                        
                        <th>Branch Name</th>
                        @can('user-edit','user-delete')
                        <th width="280px">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    <?php 
                    $comp_name = \App\Company::select('company_name')->where(['company_id'=>$user->comp_id])->first(); 
                    ?>
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
						<td>{{ $user->mobile_no }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                             <small class="label label-success">{{ $v }}</small>
                            @endforeach
                          @endif
                        </td>
                        <td><?php echo @$comp_name->company_name;?></td>
                        <td>{{$user->depart_name}}</td>
                        <td>{{$user->branch_name}}</td>
                        <td>
                           <!--<a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>-->
                           @can('user-edit')
                           <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"><span class="fa fa-edit"></span></a>
                           @endcan
                           @can('user-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline','class'=>'delete']) !!}
                                {!! Form::submit('Deactivate', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                           @endcan 
                        </td>
                      </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>   
</section>
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
});
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
</script>
@endsection