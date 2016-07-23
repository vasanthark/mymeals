@extends('admin.layout')

@section('title') Add Order @stop

@section('content')
<!-- Main content -->
<section class="content">

    @include('admin.partials.errors')
    <?php
    $existin_user = !empty(old('user_id')) ? old('user_id') : '';
    $existin_day = !empty(old('day_id')) ? old('day_id') : array();
    $post_meal_id = !empty(old('meal_id')) ? old('meal_id') : array();
    $post_meal_title = !empty(old('meal_title')) ? old('meal_title') : array();
    $post_meal_item = !empty(old('meal_item')) ? old('meal_item') : array();
    $post_qty = !empty(old('qty')) ? old('qty') : array();
    $post_grandtotal = !empty(old('grandtotal')) ? old('grandtotal') : array();
    $post_subtotal = !empty(old('subtotal')) ? old('subtotal') : array();
    $post_meal_date = !empty(old('meal_date')) ? old('meal_date') : array();
    ?>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','role' => 'form','route'=>['admin.orders.store']]) !!}
                <div class="box-body">                                             
                    <div class="form-group">
                        {!! Form::label('user_id', 'User:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">                            
                            <select class="selectpicker" data-live-search="true" id="user_id" name="user_id"> 
                                <option value="" data-tokens="">Nothing selected</option>
                                <option value="-1" <?php
                                if ($existin_user == '-1') {
                                    echo 'selected="selected"';
                                }
                                ?> data-tokens="">Add User</option>
                                @foreach ($users as $key => $user)
                                <option value="{{ $user->id }}" <?php
                                if ($user->id == $existin_user) {
                                    echo 'selected="selected"';
                                }
                                ?> data-tokens="{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }} {{$user->userinfo->phone}}">{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }} ( {{ $user->userinfo->phone }} )</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="add-users" style="display: none">
                        <div class="form-group">
                            {!! Form::label('email', 'Email:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('username', 'Username:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Password:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('first_name', 'First Name:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('first_name', null, ['placeholder' => 'First Name', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name', 'Last name:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('last_name', null, ['placeholder' => 'Last name', 'class' => 'form-control']) !!}
                            </div>
                        </div>  
                        <div class="form-group">
                            {!! Form::label('address', 'Address:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('address', null, ['placeholder' => 'Address', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone', 'Phone:*', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::text('phone', null, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('day_id', 'Days:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">                              
                            <select class='form-control selectpicker day_pick' data-live-search="true" multiple="multiple" name="day_id[]" id="day_id">
                                @foreach($dayinfos as $akey => $ainfos)
                                <option value="{{$akey}}" <?php
                                if (!empty($existin_day) && in_array($akey, $existin_day)) {
                                    echo 'selected="selected"';
                                }
                                ?>>{{$ainfos}}</option>
                                @endforeach                          
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-8">
                            <table class="table table-bordered table-condensed" id="website_course">   
                                <tbody> 
                                    @if(!empty($existin_day))
                                    <tr>
                                        <th style="width: 20%">Meal Title</th>
                                        <th style="width: 35%">Items</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 5%">Price</th>
                                        <th style="width: 5%">Grand Total</th>  
                                        <th style="width: 25%">Delivery date</th>
                                    </tr>                                    
                                    @foreach ($existin_day as  $dayid)                                   
                                    <tr class="nmeal">                               
                                        <td><input type="hidden" value="{{ $post_meal_title[$dayid] }}" name="meal_title[{{$dayid}}]">{{ $post_meal_title[$dayid] }}</td>
                                        <td><input type="hidden" value="{{ $post_meal_item[$dayid] }}" name="meal_item[{{$dayid}}]">{{ $post_meal_item[$dayid] }}</td>
                                        <td><input type='number' value="{{ $post_qty[$dayid] }}" name='qty[{{$dayid}}]' data-dayid="{{ $dayid }}"  class='form-control qtyclk' min="1"></td>    
                                        <td id="price_{{$dayid}}">{{ $post_subtotal[$dayid] }}</td> 
                                        <td id="gtotal_{{$dayid}}">{{ $post_grandtotal[$dayid] }}</td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>            
                                                <input type='text' class='form-control date' value="{{ $post_meal_date[$dayid] }}" name="meal_date[{{$dayid}}]">
                                            </div>                     
                                        </td>    
                                        <input type="hidden" value="{{ $post_subtotal[$dayid] }}" name="subtotal[{{$dayid}}]">
                                        <input type="hidden" value="{{ $post_grandtotal[$dayid] }}" name="grandtotal[{{$dayid}}]">
                                        <input type="hidden" value="{{ $post_meal_id[$dayid] }} " name="meal_id[{{$dayid}}]">
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>                         
                </div>

                <div class="box-footer">
                    <div class="col-sm-0 col-sm-offset-2">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
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
    /* New user select form */
    var user_id = $('#user_id option:selected').val();
    add_user(user_id);
    $('#user_id').change(function () {
        var id = $('#user_id option:selected').val();
        add_user(id);
    });
    function add_user(id) {
        if (id == '-1') {
            $('#add-users').show();
        } else {
            $('#add-users').hide();
        }
    }

    ////

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
                    var subtotal = data[0];
                    var id = data[1];
                    $('#gtotal_' + id).html(subtotal);
                    $('input[name="grandtotal[' + id + ']"]').val(subtotal);
                },
            });
        }
    }


    $('.mealids').change(function () {
        var id = $('.mealids option:selected').val();
        var qty = $("#qty").val();

        get_details(id, qty);

        if (id > 0)
            $('#infodisp').show();
        else
            $('#infodisp').hide();
    });


    function get_meal_details(day_ids) {
        $_token = "{{ csrf_token() }}";
        if (day_ids != '') {
            $.ajax({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                url: "{{ url('/admin/orders/mealdetails') }}",
                type: 'POST',
                cache: false,
                data: {'day_ids': day_ids, '_token': $_token}, //see the $_token
                datatype: 'html',
                success: function (data) {
                    //  $("#website_course > tbody:last").children().remove();
                    // $("#website_course tbody").html(data.html);
                    $('#website_course tbody').html(data.html);
                    $('.date').datepicker({format: 'yyyy-mm-dd', autoclose: true});
                }
            });
        }
    }

    $('.day_pick').change(function () {
        var day_ids = $(this).val();
        get_meal_details(day_ids);
        return false;
    });

});
</script>
@stop
