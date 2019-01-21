@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Return',
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
            <div class="box-body">
                <table class="table table-bordered tableFixed tablePaging" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="17%">Number</th>
                            <th width="17%">GR Number</th>
                            <th width="17%">PO Number</th>
                            <th width="25%">Description</th>
                            <th width="12%">Type</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td>{{ $modelGI->goodsReceipt != null ? $modelGI->goodsReceipt->number : "-" }}</td>
                                <td>{{ $modelGI->purchaseOrder != null ? $modelGI->purchaseOrder->number : "-" }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->description}}">{{ $modelGI->description }}</td>
                                <td>
                                    @if($modelGI->type == 4)
                                        Goods Return
                                    @else
                                    @endif
                                </td>
                                <td align="center">
                                    @if($menu == "building")
                                        <a href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @else
                                        <a href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        $('div.overlay').hide();        
    });
</script>
@endpush
