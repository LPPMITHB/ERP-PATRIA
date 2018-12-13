@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Services',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('service.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="service-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 30%">Description</th>
                            <th style="width: 25%">Cost Standard Price</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $service->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$service->name}}">{{ $service->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$service->description}}">{{ $service->description }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$service->cost_standard_price}}">{{ $service->cost_standard_price }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('service.show', ['id'=>$service->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('service.edit',['id'=>$service->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#service-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
