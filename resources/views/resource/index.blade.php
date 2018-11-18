@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Resources',
        'items' => [
            'Dashboard' => route('index'),
            'View All Resources' => route('resource.index'),
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
                    <a href="{{ route('resource.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
            {{-- <div style ="overflow:scroll"> --}}
                <table class="table table-bordered table-hover tableFixed" id="resource-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 25%">Name</th>
                            <th style="width: 45%">Description</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($resources as $resource)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $resource->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->name}}">{{ $resource->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->description}}">{{ $resource->description }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('resource.show', ['id'=>$resource->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('resource.edit',['id'=>$resource->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#resource-table').DataTable({
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
