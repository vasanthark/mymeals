@extends('admin.layout')

@section('title') Change Password @stop

@section('content')
<!-- Main content -->
<section class="content">
    @include('admin.partials.flash_message')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                 @include('admin.partials.errors')
                   {!! Form::open(['class' => 'form-horizontal','role' => 'form']) !!}
                    <div class="box-body">
                        <div class="form-group">
                             {!! Form::label('old_password', 'Old Password', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                               {!! Form::password('old_password', array('class'=>'form-control', 'placeholder'=>'Old Password')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                             {!! Form::label('new_password', 'New Password', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                               {!! Form::password('new_password', array('class'=>'form-control', 'placeholder'=>'New Password')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                             {!! Form::label('new_password_confirmation', 'Confirm New Password', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-5">
                               {!! Form::password('new_password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm New Password')) !!}
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        {!! Form::submit(trans('Submit'), ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>   
    <!-- /.row -->
</section>
<!-- /.content -->
@stop