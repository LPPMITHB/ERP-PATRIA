@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Order » Select Purchase Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => '',
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
                <table class="table tableFixed table-bordered table-hover" id="po-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Type</th>
                            <th width="10%">Number</th>
                            <th width="35%">Description</th>
                            <th width="17%">Project Name</th>
                            <th width="13%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($modelPR->type == 1)
                                    <td>Material</td>
                                @else
                                    <td>Resource</td>
                                @endif
                                <td>{{ $modelPR->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPR->description}}">{{ isset($modelPR->description) ? $modelPR->description : '-'}}</td>
                                <td>{{ isset($modelPR->project) ? $modelPR->project->name : '-' }}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelPR->status == 0 || $modelPR->status == 7)
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="ORDERED PARTIALLY">ORDERED PARTIALLY</td>
                                @elseif($modelPR->status == 3)
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="NEEDS REVISION">NEEDS REVISION</td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                @elseif($modelPR->status == 6)
                                    <td>CONSOLIDATED</td>
                                @endif
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($route == "/purchase_order")
                                        <a href="{{ route('purchase_order.selectPRD', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/purchase_order_repair")
                                        <a href="{{ route('purchase_order_repair.selectPRD', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @endif
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
