@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Issue',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Issue' => route('goods_issue.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header p-b-20">
                {{-- <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('goods_issue.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div> --}}
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="45%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td>{{ $modelGI->description }}</td>
                                <td>{{ $modelGI->materialRequisition->project->name }}</td>
                                <td align="center">
                                    <a href="{{ route('goods_issue.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        $('#gi-table').DataTable({
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
