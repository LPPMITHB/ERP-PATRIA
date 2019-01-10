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
                <table class="table table-bordered tablePagingVue" id="resource-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 10%">Name</th>
                            <th style="width: 9%">Category</th>
                            {{-- <th style="width: 9%">Type</th> --}}
                            <th style="width: 10%">Utilization</th>
                            <th style="width: 12%">Performance</th>
                            <th style="width: 11%">Productivity</th>
                            <th style="width: 13%">Description</th>
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
                                
                                {{-- @if( $resource->machine_type == 2)
                                    <td> Material </td>
                                @elseif( $resource->machine_type == 1)
                                    <td> Resource </td>
                                @else
                                    <td> Subcon </td>
                                @endif
                                 --}}

                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->categoryName}}">{{ $resource->categoryName }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->utilization}}">{{ $resource->utilization }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->performance}}">{{ $resource->performance }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->productivity}}">{{ $resource->productivity }}</td>
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
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == ""){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            fixedHeader     : true,
            paging          : true,
            autoWidth       : true,
            lengthChange    : false,
        });
        $('div.overlay').hide();
    });
</script>
@endpush
