@extends('admin.layout')

@section('title') Users @stop

@section('link')
<link href="{{ URL::asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script_files')
<script src="{{ URL::asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
@stop

@section('scripts')
<script>
$(function () {
    $("#example1").dataTable();
});
</script>
@stop

@section('content')
<!-- Main content -->
<section class="content">

    @include('admin.partials.flash_message')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{URL::to('admin/users/create')}}" class="btn btn-primary btn-link pull-right">
                        Add user
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>                                
                                <th>Email</th>   
                                <th>Phone</th>
                                <th>Status</th>                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>                                
                                <td>{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->userinfo->phone }}</td>                              
                                <td align="center">
                                    @if($user->status == 1)                               
                                        <i class="fa fa-circle text-green"></i>
                                    @else
                                        <i class="fa fa-circle text-red"></i>
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="{{route('admin.users.edit',$user->id)}}" >
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                     <a href="{{URL::to('admin/users/destroy',array($user->id))}}" onclick="return confirm('Are you sure you want to delete?')" >
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@stop

