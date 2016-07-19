@extends('admin.layout')

@section('title') Dashboard @stop

@section('link') 
<!-- Morris chart -->
<link href="{{ URL::asset('css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="{{ URL::asset('css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="{{ URL::asset('css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="{{ URL::asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="{{ URL::asset('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script_files')
<!-- Morris.js charts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ URL::asset('js/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('js/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{ URL::asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::asset('js/plugins/jqueryKnob/jquery.knob.js') }}" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="{{ URL::asset('js/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<!-- datepicker -->
<script src="{{ URL::asset('js/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::asset('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ URL::asset('js/AdminLTE/dashboard.js') }}" type="text/javascript"></script>-->
@stop

@section('content')
<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        {{ $user_count }}
                    </h3>
                    <p>
                        Users
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-ios7-people"></i>
                </div>
                <a href="{{ URL::to('/admin/users') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
               <div class="inner">
                    <h3>
                        {{ $item_count }}
                    </h3>
                    <p>
                        Items
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-pizza"></i>
                </div>
                <a href="{{ URL::to('/admin/items') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        65
                    </h3>
                    <p>
                        Order
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios7-compose"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
<!--             small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        {{ $offer_count }}
                    </h3>
                    <p>
                        Offers
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-fork"></i>
                </div>
                <a href="{{ URL::to('/admin/offers') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>  <!--./col--> 
    </div><!-- /.row -->

</section>
<!-- /.content -->
@stop