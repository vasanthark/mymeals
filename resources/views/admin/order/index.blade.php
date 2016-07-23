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
<?php
     $username    = isset($search_infos['order_username'])?$search_infos['order_username']:"";
    $date_of_day  = isset($search_infos['meal_date'])?$search_infos['meal_date']:"";
    $order_status = isset($search_infos['status'])?$search_infos['status']:"";
    
    $categories = array('Progress','Delivered','Not Delivered','Cancel');
?>
    @include('admin.partials.flash_message')

    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-search"></i>  Search
                    </h3>
                    <div class="clearfix"></div>
                </div>

                <section class="content">
                    <div class="row">
                        {!! Form::open(['class' => '','role' => 'form','url'=>['admin/orders/index']]) !!}                       
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                {!! Form::label('order_username', 'Search by Name:', ['class' => 'control-label']) !!}
                                {!! Form::text('order_username', $username , ['placeholder' => 'First name , Last name', 'class' => 'form-control']) !!}
                            </div>
                        </div> 

                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                 {!! Form::label('meal_date', 'Delivery Date:', ['class' => 'control-label']) !!}
                                 <div class="input-group">
                                    <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>            
                                    <input type='text' class='form-control date' value="{{ $date_of_day }}" name="meal_date">
                                </div> 
                            </div>
                        </div> 
                        
                        <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
                                    {!! Form::select('status', array_merge(['' => 'ALL'], $categories), $order_status,['class' => 'form-control']) !!}
                                </div>
                        </div>
                        
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>                              
                                  {!! Form::submit('Filter', ['class' => 'btn btn-primary form-control',"id" => "search_stud"]) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>  
                        <div class="col-lg-3 col-md-3">
                            <p id="disp_error" class="errorMessage" style="display: none;">Please enter atleast one value for searching.</p>
                        </div>              
                         {!! Form::close() !!}
                    </div>
                </section>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <ul class="order-status">
                        <li><i class="fa fa-circle text-blue"></i> - Progress</li>
                        <li><i class="fa fa-circle text-green"></i> - Delivered</li>
                        <li><i class="fa fa-circle text-red"></i> - Not Delivered</li>
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
                                <th>Phone</th>
                                <th>Meals</th>  
                                <th>Qty</th>  
                                <th>Sub Total</th>  
                                <th>Offer Price</th>  
                                <th>Grand Total</th>
                                <th>Delivery Date</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $order->user->userinfo->first_name }} {{ $order->user->userinfo->last_name }}</td>
                                <td>{{ $order->user->userinfo->phone }} </td>
                                <td>{{ $order->meal->title }}</td> 
                                <td>{{ $order->qty }}</td>   
                                <td>{{ $order->subtotal }}</td>    
                                <td>{{ $order->offer_price }}</td>   
                                <td>{{ $order->grandtotal }}</td> 
                                <td>{{ date('d-m-Y', strtotime($order->meal_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                <td align="center">
                                    @if($order->status == 0)         
                                    <i class="fa fa-circle text-blue"></i>                                        
                                    @elseif($order->status == 1)
                                    <i class="fa fa-circle text-green"></i>
                                    @elseif($order->status == 2)
                                    <i class="fa fa-circle text-red"></i>
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

