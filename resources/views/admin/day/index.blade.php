@extends('admin.layout')

@section('title') Days @stop

@section('content')
<!-- Main content -->
<section class="content">

    @include('admin.partials.flash_message')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">               
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Meal Title</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($days as $key => $dayinfo)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $dayinfo->name }}</td>
                                <td>{{ ($dayinfo->meal_id>0)?$dayinfo->meal->title:"-" }}</td>     
                                 <td>{{ $dayinfo->price }}</td>
                                <td align="center">
                                    @if($dayinfo->status == 1)                               
                                        <i class="fa fa-circle text-green"></i>
                                    @else
                                        <i class="fa fa-circle text-red"></i>
                                    @endif
                                </td>
                                <td>{{ $dayinfo->updated_at }}</td>
                                <td align="center">
                                    <a href="{{route('admin.days.edit',$dayinfo->day_id)}}" >
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@stop

