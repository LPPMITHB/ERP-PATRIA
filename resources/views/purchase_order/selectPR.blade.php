@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Order » Select Purchase Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => route('purchase_order.selectPR'),
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
                <table class="table table-bordered table-hover" id="po-table">
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
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPR->number }}</td>
                                <td>{{ $modelPR->description }}</td>
                                <td>{{ $modelPR->project->name }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    <a href="{{ route('purchase_order.selectPRD', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#po-table').DataTable({
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
