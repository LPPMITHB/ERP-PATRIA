@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Purchase Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Order' => '',
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
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Number</th>
                            <th width="15%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOs as $modelPO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPO->number }}</td>
                                <td>{{ $modelPO->description }}</td>
                                <td>{{ isset($modelPO->project) ? $modelPO->project->number : '-' }}</td>
                                @if($modelPO->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 3)
                                    <td>NEED REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @else
                                    <td>RECEIVED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @endif
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
