@extends('admin.layout')

@section('title') Orders @stop

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
                    <ul class="order-status">
                        <li><i class="fa fa-circle text-red"></i> - Progress</li>
                        <li><i class="fa fa-circle text-green"></i> - Delivery</li>
                        <li><i class="fa fa-circle text-blue"></i> - Not Delivered</li>
                        <li><i class="fa fa-circle text-block"></i> - Cancel</li>                        
                    </ul>
                    <a href="{{URL::to('admin/orders/create')}}" class="btn btn-primary btn-link pull-right">
                        Add Order
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User</th>
                                <th>Meals</th>                                
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $order->user->userinfo->first_name }} {{ $order->user->userinfo->last_name }}</td>
                                <td>{{ $order->meal->title }}</td>                               
                                <td align="center">
                                    @if($order->status == 0)         
                                        <i class="fa fa-circle text-red"></i>                                        
                                    @elseif($order->status == 1)
                                        <i class="fa fa-circle text-green"></i>
                                    @elseif($order->status == 2)
                                    <i class="fa fa-circle text-blue"></i>
                                    @elseif($order->status == 3)
                                        <i class="fa fa-circle text-block"></i>
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="{{route('admin.orders.edit',$order->order_id)}}" >
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                     <a href="{{URL::to('admin/orders/destroy',array($order->order_id))}}" onclick="return confirm('Are you sure you want to delete?')" >
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

