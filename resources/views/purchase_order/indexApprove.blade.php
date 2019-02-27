@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Purchase Order » Select Purchase Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Order' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header p-b-20">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('purchase_order.selectPR') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <table class="table tableFixed table-bordered tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="40%">Description</th>
                            <th width="15%">Status</th>
                            <th width="15%">Created By</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOs as $modelPO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPO->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPO->description}}">{{ $modelPO->description }}</td>
                                @if($modelPO->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelPO->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelPO->status == 0)
                                    <td>RECEIVED</td>
                                @elseif($modelPO->status == 3)
                                    <td>NEEDS REVISION</td>
                                @elseif($modelPO->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelPO->status == 5)
                                    <td>REJECTED</td>
                                @endif
                                <td>{{ $modelPO->user->name }}</td>
                                <td class="textCenter">
                                    @if($route == "/purchase_order")
                                        <a onClick="loading()" href="{{ route('purchase_order.showApprove', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/purchase_order_repair")
                                        <a onClick="loading()" href="{{ route('purchase_order_repair.showApprove', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
