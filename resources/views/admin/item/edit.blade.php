@extends('admin.layout')

@section('title') Edit Item @stop

@section('content')
<!-- Main content -->
<section class="content">
    
    @include('admin.partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                
                <!-- form start -->
                {!! Form::model($item, ['class' => 'form-horizontal','method' => 'PATCH','files'=>'true', 'role' => 'form','route'=>['admin.items.update',$item->item_id]]) !!}
                <div class="box-body">    
                    <div class="form-group">
                        {!! Form::label('item_type_id', 'Item Type:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">                                   
                            {!! Form::select('item_type_id', $itemtypes, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', 'Item Name :*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('name', null, ['placeholder' => 'Item Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                     <div class="form-group">
                        {!! Form::label('item_image', 'Item Image:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::file('item_image') !!}
                            @if($old_file!=null)
                                {!! Html::image('uploads/items/'.$old_file, 'Item', array('width' => 70, 'height' => 70 ,'class' => 'thumb')) !!}
                            @endif
                        </div>
                    </div>
                </div>

                    <div class="box-footer">
                        <div class="col-sm-0 col-sm-offset-2">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ URL::to('/admin/items') }}" class="btn btn-info">
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