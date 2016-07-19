@extends('admin.layout')

@section('title') Add User @stop

@section('content')
<!-- Main content -->
<section class="content">

    @include('admin.partials.errors')

    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','role' => 'form','route'=>['admin.users.store']]) !!}

                <div class="box-body">  
                    <div class="form-group">
                        {!! Form::label('email', 'Email:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('username', 'Username:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('first_name', null, ['placeholder' => 'First Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', 'Last name:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('last_name', null, ['placeholder' => 'Last name', 'class' => 'form-control']) !!}
                        </div>
                    </div>  
                    <div class="form-group">
                        {!! Form::label('address', 'Address:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('address', null, ['placeholder' => 'Address', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', 'Phone:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('phone', null, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
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
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ URL::to('/admin/users') }}" class="btn btn-info">
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