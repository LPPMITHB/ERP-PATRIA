@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Branches',
        'items' => [
            'Dashboard' => route('index'),
            'View All Branches' => '',
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
                        <a href="{{ route('branch.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div>
                <table id="branch-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 25%">Name</th>
                            <th style="width: 30%">Address</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($branchs as $branch)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $branch->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$branch->name}}">{{ $branch->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$branch->address}}">{{ $branch->address }}</td>
                                <td> {{ $branch->status == "1" ? "Active": "Non Active" }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('branch.show', ['id'=>$branch->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('branch.edit',['id'=>$branch->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#branch-table').DataTable({
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
