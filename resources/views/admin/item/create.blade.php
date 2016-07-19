@extends('admin.layout')

@section('title') Add Item @stop

@section('content')
<!-- Main content -->
<section class="content">
    
    @include('admin.partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                
                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','role' => 'form','route'=>['admin.items.store']]) !!}
                <div class="box-body">                    
                    <div class="form-group">
                        {!! Form::label('name', 'Item Name:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('name', null, ['placeholder' => 'Item Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                    <div class="box-footer">
                        <div class="col-sm-0 col-sm-offset-2">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
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