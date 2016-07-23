@extends('admin.layout')

@section('title') Dashboard @stop

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
                        {{ $meal_count }}
                    </h3>
                    <p>
                        Meals
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-pizza"></i>
                </div>
                <a href="{{ URL::to('/admin/meals') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        {{ $order_count }}
                    </h3>
                    <p>
                        Order
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios7-compose"></i>
                </div>
                <a href="{{ URL::to('/admin/orders') }}" class="small-box-footer">
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
        <div class="clearfix"></div>
        <div class="col-md-4">
            <!-- Info box -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Today Orders</h3>
                    <div class="box-tools pull-right">
                        <div class="label bg-aqua">{{ date("d-m-Y") }}</div>
                    </div>
                </div>
                <div class="box-body">  
                    <p> Total Orders : {{ $today_order_count }} </p>
                    <p> Total Amount: Rs {{ $today_total_sales }} </p>
                    <p> Pending Orders : {{ $today_porder_count }} </p>
                </div><!-- /.box-body -->
<!--                <div class="box-footer">
                    <a href="javascript:void(0);}" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>-->
            </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-4">
            <!-- Info box -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Tomorrow Orders</h3>
                    <div class="box-tools pull-right">
                        <div class="label bg-aqua"><?php echo date("d-m-Y", strtotime("+1 day")); ?></div>
                    </div>
                </div>
                <div class="box-body">  
                    <p> Total Orders : {{ $tommorow_order_count }} </p>
                    <p> Total Amount: Rs {{ $tommorow_total_sales }} </p>
                    <p> Pending Orders : {{ $tommorow_porder_count }} </p>
                </div><!-- /.box-body -->  
<!--                <div class="box-footer">
                    <a href="javascript:void(0);" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>-->
            </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-4">
            <!-- Info box -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Day after tomorrow Orders</h3>
                    <div class="box-tools pull-right">
                        <div class="label bg-aqua"><?php echo date("d-m-Y", strtotime("+2 days")); ?></div>
                    </div>
                </div>
                <div class="box-body">       
                    <p> Total Orders : {{ $dat_order_count }} </p>
                    <p> Total Amount: Rs {{ $dat_total_sales }} </p>
                    <p> Pending Orders : {{ $dat_porder_count }} </p>
                </div><!-- /.box-body -->    
<!--                <div class="box-footer">
                    <a href="javascript:void(0);" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>-->
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div><!-- /.row -->



</section>
<!-- /.content -->
@stop