@extends('admin.layout')

@section('title') Edit Info @stop

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
                {!! Form::model($day, ['class' => 'form-horizontal','method' => 'PATCH', 'role' => 'form','route'=>['admin.days.update',$day->day_id]]) !!}
                <div class="box-body">   
                    <div class="form-group">
                        {!! Form::label('title', 'Day:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {{ $day->name }}
                        </div>
                    </div>                  
                    
                    <div class="form-group">
                        {!! Form::label('meal_id', 'Meal:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">  
                            {!! Form::select('meal_id', $meal, null, ['class' => 'form-control selectpicker', 'data-live-search'=>'true']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('offer_id', 'Offer:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">  
                            {!! Form::select('offer_id', $offers, null, ['class' => 'form-control selectpicker', 'data-live-search'=>'true']) !!}
                        </div>
                    </div>
                    
                     <div class="form-group">
                        {!! Form::label('price', 'Price:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('price', null, ['placeholder' => 'Price', 'class' => 'form-control']) !!}
                        </div>
                    </div>  
                    
                    <div class="form-group">
                            {!! Form::label('status', 'Status:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::radio('status', '1', true) !!} Enable
                            {!! Form::radio('status', '0', null) !!} Disable
                        </div>
                    </div> 
                </div>

                    <div class="box-footer">
                        <div class="col-sm-0 col-sm-offset-2">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ URL::to('/admin/days') }}" class="btn btn-info">
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
@stop