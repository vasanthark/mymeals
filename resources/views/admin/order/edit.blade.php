@extends('admin.layout')

@section('title') Edit Order @stop

@section('content')

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
                            {{ implode(" , ", $order->meal->item()->lists("items.name")->toArray()) }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('qty', 'Qty:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-lg-1">                              
                            <input type='number' value="{{ $order->qty }}" data-dayid="{{ $order->day_id }}" name='qty' id="qtyclck" class='form-control qtyclk' min="1">
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Price:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5">   
                            Rs {{ $order->subtotal }}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Grandtotal:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-sm-5" id="gtotal">   
                            Rs {{ $order->grandtotal }}
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('status', 'Status:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-lg-2">
                            {!! Form::select('status', ['Progress','Delivered','Not Delivered','Cancel'], $order->status,['class' => 'form-control']) !!}
                        </div>
                    </div> 
                    
                     <div class="form-group">
                        {!! Form::label('meal_id', 'Delivery Date:', ['class' => 'col-sm-2 control-label']) !!}               
                        <div class="col-lg-4">   
                            {{ $order->meal_date }}
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
                <input type="hidden" value="{{ $order->grandtotal }}" name="grandtotal" id="grandtotal">
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>   
    <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
$(function () {
     $(".qtyclk").live('keyup mouseup', function () {
        var dayid = $(this).data("dayid");
        var qty = $(this).val();
        get_details(dayid, qty);
    });
    
     function get_details(id, qty) {
        if (id != '' && qty > 0) {
            $.ajax({
                url: '/admin/orders/price/{id}/{qty}',
                type: 'GET',
                dataType: "json",
                data: {id: id, qty: qty},
                success: function (data) {
                    var grandtotal = data[0];
                    var id = data[1];
                    $('#gtotal').html("Rs "+grandtotal);
                    $('input[name="grandtotal"]').val(grandtotal);
                },
            });
        }
    }
});
</script>
@stop