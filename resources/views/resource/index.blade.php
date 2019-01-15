@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Resources',
        'items' => [
            'Dashboard' => route('index'),
            'View All Resources' => '',
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
            </div>
            <div class="box-body">
                <table class="table table-bordered tablePaging tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 30%">Name</th>
                            <th style="width: 40%">Description</th>
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
            </div> 
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> 
    </div> 
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush
