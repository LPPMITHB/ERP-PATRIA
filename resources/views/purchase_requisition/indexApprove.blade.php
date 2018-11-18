@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Purchase Requisition » Select Purchase Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => route('purchase_requisition.indexApprove'),
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
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('purchase_requisition.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" id="permissions-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="40%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPR->number }}</td>
                                <td>{{ $modelPR->description }}</td>
                                <td>{{ $modelPR->project->name }}</td>
                                <td>OPEN</td>
                                <td class="textCenter">
                                    <a href="{{ route('purchase_requisition.showApprove', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#permissions-table').DataTable({
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
