@extends('admin.layout')

@section('title') Edit Order @stop

@section('content')

@section('link')
<link href="{{ URL::asset('css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script_files')
<script type="text/javascript" src="{{ URL::asset('js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.js') }}"></script>
@stop
<!-- Main content -->
<section class="content">
    
    @include('admin.partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                
                <!-- form start -->
                {!! Form::model($order, ['class' => 'form-horizontal','method' => 'PATCH', 'role' => 'form','route'=>['admin.orders.update',$order->order_id]]) !!}
                <div class="box-body">                    
                     
                    <div class="form-group">
                        {!! Form::label('user_id', 'User:', ['class' => 'col-sm-2 control-label']) !!}                      
                        <div class="col-sm-5">   
                            {{ $order->user->userinfo->first_name }} {{ $order->user->userinfo->last_name }}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('meal_id', 'Meal:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            {{ $order->meal->title }}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('meal_id', 'Items:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            {{ $items }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('qty', 'Qty:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            {{ $order->qty }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Subtotal:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            Rs {{ $order->subtotal }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Offer:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            Rs {{ $order->offer_price }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Grandtotal:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            Rs {{ $order->grandtotal }}
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('status', 'Status:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::select('status', ['Progress','Delivered','Not Delivered','Cancel'], $order->status,['class' => 'form-control']) !!}
                        </div>
                    </div> 
                </div>

                    <div class="box-footer">
                        <div class="col-sm-0 col-sm-offset-2">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ URL::to('/admin/orders') }}" class="btn btn-info">
                                Back
                            </a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>   
    <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
$(function () {

    $('.date').datepicker({format: 'dd-mm-yyyy', autoclose: true});

});
</script>
@stop