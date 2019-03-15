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
            <div class="box-header">
                <div class="box-tools pull-right">
                    <a href="{{ route('service.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body p-b-0 p-t-15">
                <table class="table table-bordered tablePaging tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 25%">Ship Type</th>
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
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$service->ship_id != '' ? $service->ship->type : 'General'}}">{{ $service->ship_id != '' ? $service->ship->type : 'General' }}</td>
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
        $('div.overlay').hide();
    });
</script>
@endpush
