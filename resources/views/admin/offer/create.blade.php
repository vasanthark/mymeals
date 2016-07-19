@extends('admin.layout')

@section('title') Add Offer @stop

@section('content')
<!-- Main content -->
<section class="content">
    
    @include('admin.partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                
                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','role' => 'form','url'=>['admin/offers/store'],'files'=>'true']) !!}
                
                <div class="box-body">     
                    {!! Form::hidden('offer_type','1') !!}
                    <div class="form-group">
                        {!! Form::label('offer_name', 'Offer Name:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('offer_name', null, ['placeholder' => 'Offer Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('offer_price', 'Offer Price:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('offer_price', null, ['placeholder' => 'Offer Price', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('offer_image', 'Offer Image:*', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::file('offer_image') !!}
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
                            <a href="{{ URL::to('/admin/offers') }}" class="btn btn-info">
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