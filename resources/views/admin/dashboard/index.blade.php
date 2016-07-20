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
                        0
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