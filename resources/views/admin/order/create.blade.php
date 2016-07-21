@extends('admin.layout')

@section('title') Add Order @stop

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
    <?php 
          $existin_user = !empty(old('user_id'))?old('user_id'):'';          
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
                                <option value="-1" <?php if($existin_user == '-1'){ echo 'selected="selected"';}?> data-tokens="">Add User</option>
                                @foreach ($users as $key => $user)
                                <option value="{{ $user->id }}" <?php if($user->id == $existin_user){ echo 'selected="selected"';}?> data-tokens="{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }}">{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }}</option>
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
                        {!! Form::label('meal_id', 'Meal:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">  
                            {!! Form::select('meal_id', $meal, null, ['class' => 'form-control mealids']) !!}
                        </div>
                    </div>
                    
                    <div id='infodisp' style="display:none;">
                        <div class="form-group">
                            {!! Form::label('qty', 'Qty:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-lg-1">  
                                 {!! Form::input('number', 'qty', 1, ['class' => 'form-control','min'=>"1"]) !!}
                            </div>
                        </div>

                        <div class='form-group' id='items'>
                            <label class='col-sm-2 control-label'>Items:</label>
                            <div class='col-sm-5 items-cont'>                            
                            </div>
                        </div>
                        <div class='form-group' id='price'>
                            <label class='col-sm-2 control-label'>Price:</label>
                            <div class='col-sm-5 price-cont'>                            
                            </div>
                        </div>
                        <div class='form-group' id='offer-price'>
                            <label class='col-sm-2 control-label'>Offer:</label>
                            <div class='col-sm-5 offer-cont'>                            
                            </div>
                        </div>
                        <div class='form-group' id='grand'>
                            <label class='col-sm-2 control-label'>Grandtotal:</label>
                            <div class='col-sm-5 grand-cont'>                            
                            </div>
                        </div>
                    </div>    
                    {!! Form::hidden('subtotal', '', ['id' => 'subtotal']) !!}
                    {!! Form::hidden('offer', '', ['id' => 'offer']) !!}
                    {!! Form::hidden('grandtotal', '', ['id' => 'grandtotal']) !!}
                    <div class="form-group">
                            {!! Form::label('status', 'Status:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::select('status', ['Progress','Delivered','Not Delivered','Cancel'], 0,['class' => 'form-control']) !!}
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
    $('.date').datepicker({format: 'dd-mm-yyyy', autoclose: true});
    var qty = $("#qty").val();
    var mealids=$('#meal_id').val();  
    
    get_details(mealids,qty);
    
    $("#qty").bind('keyup mouseup', function () {
        var mealids=$('#meal_id').val();  
        if(mealids=="")
        {
            return false;
        }    
        var qty = $(this).val();
        get_details(mealids,qty);
    });
    
    var mealids=$('.mealids option:selected').val();         
    get_details(mealids);
     
    var user_id=$('#user_id option:selected').val(); 
    add_user(user_id);
    $('#user_id').change(function () {
        var id=$('#user_id option:selected').val();    
        add_user(id);
    });
    function add_user(id){
         if(id == '-1'){
             $('#add-users').show();
         }else{
            $('#add-users').hide();
        }
    }

    function get_details(id,qty){
        if(id != '' && qty>0){
            $.ajax({
               url: '/admin/orders/price/{id}/{qty}',
               type: 'GET',            
               data: { id: id, qty:qty },
               success: function(data) {
                   var str = data;
                   var res = str.split("++");
                   $('.price-cont').empty();
                   $('.price-cont').text(res[0]);
                   
                   $('.offer-cont').empty();
                   $('.offer-cont').text(res[1]);
                  
                   $('.grand-cont').empty();
                   $('.grand-cont').text(res[2]);
                  
                   $('.items-cont').empty();
                   $('.items-cont').text(res[3]);
                                      
                   $('#subtotal').val(res[0]);
                   $('#offer').val(res[1]);
                   $('#grandtotal').val(res[2]);

               },            
           });
        }else{
                   $('.price-cont').empty();  
                   $('.offer-cont').empty(); 
                   $('.grand-cont').empty(); 
                   $('.items-cont').empty(); 
                   $('#subtotal').val('0');
                   $('#offer').val('0');
                   $('#grandtotal').val('0');
        }
    }

    $('.mealids').change(function () {
        var id  = $('.mealids option:selected').val();  
        var qty = $("#qty").val();
        
        get_details(id,qty);
        
        if(id>0)
            $('#infodisp').show();
        else
            $('#infodisp').hide();    
     });
     
});
</script>
@stop
