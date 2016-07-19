@extends('admin.layout')

@section('title') Add Meals Items @stop

@section('content')

<!-- Main content -->
<section class="content">
    
    @include('admin.partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                
                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','role' => 'form','route'=>['admin.mealsitems.store']]) !!}
                <div class="box-body">     
                    <div class="form-group">
                        {!! Form::label('item_id', 'Item:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::select('item_id', $item, null, ['class' => 'form-control']) !!}                                                            
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('meal_id', 'Meal:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::select('meal_id', $meal, null, ['class' => 'form-control']) !!}                                                            
                        </div>
                    </div>
                </div>

                    <div class="box-footer">
                        <div class="col-sm-0 col-sm-offset-2">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ URL::to('/admin/mealsitems') }}" class="btn btn-info">
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