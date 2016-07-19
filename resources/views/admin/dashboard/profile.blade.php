@extends('admin.layout')

@section('title') {{ trans('profile.heading') }} @stop

@section('content')
<!-- Main content -->
<section class="content">
    @include('admin.partials.flash_message')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('profile.heading') }}</h3>
                </div><!-- /.box-header -->
                @include('admin.partials.errors')
                <!-- form start -->
                {!! Form::model( ['role' => 'form']) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('username', 'Username:*')!!}
                        {!! Form::text('username', $user->username, ['placeholder' => 'Username', 'class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email:*') !!}
                        {!! Form::text('email',$user->email, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name:*') !!}
                        {!! Form::text('first_name',$userinfo->first_name, ['placeholder' => 'First Name', 'class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('last_name', 'Last Name') !!}
                        {!! Form::text('last_name', $userinfo->last_name, ['placeholder' => 'Last Name', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', 'Address:*') !!}
                        {!! Form::text('address', $userinfo->address, ['placeholder' => 'Address', 'class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Phone:*') !!}
                        {!! Form::text('phone', $userinfo->phone, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                    </div>

                </div><!-- /.box-body -->

                <div class="box-footer">
                    {!! Form::submit(trans('profile.button'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>   
    <!-- /.row -->
</section>
<!-- /.content -->
@stop