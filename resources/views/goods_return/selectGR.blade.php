@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Return » Select Goods Receipt',
        'items' => [
            'Dashboard' => route('index'),
            'Select Goods Receipt' => "",
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
                <table class="table table-bordered tableFixed" id="gr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">GR Number</th>
                            <th width="15%">PO Number</th>
                            <th width="15%">WO Number</th>
                            <th width="20%">Description</th>
                            <th width="20%">Vendor</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGRs as $modelGR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->number }}">{{ $modelGR->number }}</td>
                                @if($modelGR->purchase_order_id != null)
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->purchaseOrder->number }}">{{ $modelGR->purchaseOrder->number }}</td>
                                @else
                                <td>-</td>
                                @endif
                                @if($modelGR->work_order_id != null)
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->workOrder->number }}">{{ $modelGR->workOrder->number }}</td>
                                @else
                                <td>-</td>
                                @endif
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->description }}">{{ $modelGR->description }}</td>
                                @if($modelGR->purchase_order_id != null)
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->purchaseOrder->vendor->name }}">{{ $modelGR->purchaseOrder->vendor->name }}</td>
                                @elseif($modelGR->work_order_id != null)
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $modelGR->workOrder->vendor->name }}">{{ $modelGR->workOrder->vendor->name }}</td>
                                @endif
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($menu == 'building')
                                        <a onClick="loading()" href="{{ route('goods_return.createGoodsReturnGR', ['id'=>$modelGR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a onClick="loading()" href="{{ route('goods_return_repair.createGoodsReturnGR', ['id'=>$modelGR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#gr-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });   
    });

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
