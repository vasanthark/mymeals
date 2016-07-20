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
                            <select class="selectpicker" data-live-search="true" name="user_id"> 
                                <option value="" data-tokens="">Nothing selected</option>
                                @foreach ($users as $key => $user)
                                <option value="{{ $user->id }}" <?php if($user->id == $existin_user){ echo 'selected="selected"';}?> data-tokens="{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }}">{{ $user->userinfo->first_name }} {{ $user->userinfo->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('meal_id', 'Meal:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">  
                            {!! Form::select('meal_id', $meal, null, ['class' => 'form-control mealids']) !!}
                        </div>
                    </div>
                    <div class='form-group' id='price' style="display: none">
                        <label class='col-sm-2 control-label'>Price:</label>
                        <div class='col-sm-5 price-cont'>                            
                        </div>
                    </div>
                    <div class='form-group' id='offer-price' style="display: none">
                        <label class='col-sm-2 control-label'>Offer:</label>
                        <div class='col-sm-5 offer-cont'>                            
                        </div>
                    </div>
                    <div class='form-group' id='grand' style="display: none">
                        <label class='col-sm-2 control-label'>Grandtotal:</label>
                        <div class='col-sm-5 grand-cont'>                            
                        </div>
                    </div>
                    <div class='form-group' id='items' style="display: none">
                        <label class='col-sm-2 control-label'>Items:</label>
                        <div class='col-sm-5 items-cont'>                            
                        </div>
                    </div>
                    {!! Form::hidden('subtotal', '', ['id' => 'subtotal']) !!}
                    {!! Form::hidden('offer', '', ['id' => 'offer']) !!}
                    {!! Form::hidden('grandtotal', '', ['id' => 'grandtotal']) !!}
                    <div class="form-group">
                            {!! Form::label('status', 'Status:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::select('status', ['Progress','Delivery','Not Delivered','Cancel'], 0,['class' => 'form-control']) !!}
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
    var mealids=$('.mealids option:selected').val();         
    get_details(mealids);
     
    function get_details(id){
        if(id != ''){
            $.ajax({
               url: '/admin/orders/price/{id}',
               type: 'GET',            
               data: { id: id },
               success: function(data) {
                   var str = data;
                   var res = str.split("++");
                   $('.price-cont').empty();
                   $('.price-cont').text(res[0]);
                   $('#price').show();

                   $('.offer-cont').empty();
                   $('.offer-cont').text(res[1]);
                   $('#offer-price').show();

                   $('.grand-cont').empty();
                   $('.grand-cont').text(res[2]);
                   $('#grand').show();

                   $('.items-cont').empty();
                   $('.items-cont').text(res[3]);
                   $('#items').show();
                   
                   $('#subtotal').val(res[0]);
                   $('#offer').val(res[1]);
                   $('#grandtotal').val(res[2]);

               },            
           });
        }else{
                   $('.price-cont').empty();                   
                   $('#price').hide();

                   $('.offer-cont').empty();                   
                   $('#offer-price').hide();

                   $('.grand-cont').empty();                   
                   $('#grand').hide();


                   $('.items-cont').empty();                   
                   $('#items').hide();
                   
                   $('#subtotal').val('0');
                   $('#offer').val('0');
                   $('#grandtotal').val('0');
        }
    }
    $('.mealids').change(function () {
         var id=$('.mealids option:selected').val();     
         get_details(id);
         
     });
     
});
</script>
@stop
