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
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif<!-- end .flash-message -->
                {!! Form::model( ['role' => 'form']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('old_password', 'Old Password') !!}
                            {!! Form::password('old_password', array('class'=>'form-control', 'placeholder'=>'Old Password')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('new_password', 'New Password') !!}
                            {!! Form::password('new_password', array('class'=>'form-control', 'placeholder'=>'New Password')) !!}
                        </div>
                         <div class="form-group">
                            {!! Form::label('new_password_confirmation', 'Confirm New Password') !!}
                            {!! Form::password('new_password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm New Password')) !!}
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        {!! Form::submit(trans('Submits'), ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>   
    <!-- /.row -->
</section>
<!-- /.content -->
@stop