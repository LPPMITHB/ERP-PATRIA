@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Vendors',
        'items' => [
            'Dashboard' => route('index'),
            'View All Vendors' => route('vendor.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        <a href="{{ route('vendor.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div> 
                <table class="table table-bordered tableFixed" id="vendor-table">
                    <thead>
                        <tr>
                            <th width=5%>No</th>
                            <th width=7%>Code</th>
                            <th width=20%>Name</th>
                            <th width=30%>Address</th>
                            <th width=20%>Description</th>
                            <th width=8%>Status</th>
                            <th width=10%></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$vendor->code}}">{{ $vendor->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$vendor->name}}">{{ $vendor->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$vendor->address}}">{{ $vendor->address }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$vendor->description}}">{{ $vendor->description }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$vendor->status}}"> {{ $vendor->status == "1" ? "Active": "Non Active" }}</td>
                                </td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('vendor.show', ['id'=>$vendor->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('vendor.edit', ['id'=>$vendor->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#vendor-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush