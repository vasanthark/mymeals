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
                @include('admin.partials.errors')
                <!-- form start -->
                 {!! Form::open(['class' => 'form-horizontal','role' => 'form']) !!}
                <div class="box-body">
                    <div class="form-group">
                         {!! Form::label('username', 'Username:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {!! Form::text('username', $user->username, ['placeholder' => 'Username', 'class' => 'form-control']) !!}  
                        </div>
                    </div>
                    <div class="form-group">
                         {!! Form::label('email', 'Email:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {!! Form::text('email',$user->email, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                         {!! Form::label('first_name', 'First Name:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {!! Form::text('first_name',$userinfo->first_name, ['placeholder' => 'First Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                         {!! Form::label('last_name', 'Last Name', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {!! Form::text('last_name', $userinfo->last_name, ['placeholder' => 'Last Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                          {!! Form::label('address', 'Address:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                           {!! Form::text('address', $userinfo->address, ['placeholder' => 'Address', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                         {!! Form::label('phone', 'Phone:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                          {!! Form::text('phone', $userinfo->phone, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                        </div>
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