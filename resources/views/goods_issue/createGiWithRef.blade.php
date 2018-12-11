@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Issue » Select Material Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'Select Material Requisition' => route('goods_issue.createGiWithRef'),
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
                <table class="table table-bordered table-hover" id="mr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="40%">Description</th>
                            <th width="25%">Project Name</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelMRs as $modelMR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelMR->number }}</td>
                                <td>{{ $modelMR->description }}</td>
                                <td>{{ $modelMR->project->name }} - {{$modelMR->project->number}}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    <a href="{{ route('goods_issue.selectMR', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#mr-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
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
