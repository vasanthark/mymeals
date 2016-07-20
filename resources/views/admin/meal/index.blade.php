@extends('admin.layout')

@section('title') Meals @stop

@section('link')
<link href="{{ URL::asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script_files')
<script src="{{ URL::asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
@stop

@section('scripts')
<script>
$(function () {
    $("#example1").dataTable();
});
</script>
@stop

@section('content')
<!-- Main content -->
<section class="content">

    @include('admin.partials.flash_message')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{URL::to('admin/meals/create')}}" class="btn btn-primary btn-link pull-right">
                        Add Meal
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Items</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meals as $key => $meal)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $meal->title }}</td>
                                <td style="width: 60%">{{ implode(" , ",$meal->item()->lists("items.name")->toArray()) }}</td>                                                      
                                <td align="center">
                                    @if($meal->status == 1)                               
                                        <i class="fa fa-circle text-green"></i>
                                    @else
                                        <i class="fa fa-circle text-red"></i>
                                    @endif
                                </td>
                                <td>{{ $meal->updated_at }}</td>
                                <td align="center">
                                    <a href="{{route('admin.meals.edit',$meal->meal_id)}}" >
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                     <a href="{{URL::to('admin/meals/destroy',array($meal->meal_id))}}" onclick="return confirm('Are you sure you want to delete?')" >
                                        <i class="glyphicon glyphicon-trash"></i>
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

