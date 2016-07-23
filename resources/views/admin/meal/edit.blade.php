@extends('admin.layout')

@section('title') Edit Meal @stop

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
                {!! Form::model($meal, ['class' => 'form-horizontal','method' => 'PATCH', 'role' => 'form','route'=>['admin.meals.update',$meal->meal_id]]) !!}
                <div class="box-body">   
                    <div class="form-group">
                        {!! Form::label('title', 'Title:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('title', null, ['placeholder' => 'Title', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('item_id', 'Items:*', ['class' => 'col-sm-2 control-label']) !!}
                        
                        <div class="col-sm-5">   
                            <select class="form-control selectpicker" multiple data-live-search="true" name="item_id[]">
                                @foreach ($items as $key => $item)
                                    @if (in_array($item->item_id,$mealsitems))
                                        <option value="{{ $item->item_id }}" data-tokens="{{ $item->name }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->item_id }}" data-tokens="{{ $item->name }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
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
                            <a href="{{ URL::to('/admin/meals') }}" class="btn btn-info">
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