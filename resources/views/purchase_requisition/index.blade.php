@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Purchase Requisitions',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Requisitions' => '',
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
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th class="tdBreakWord" width="6%">No</th>
                            <th class="tdBreakWord" width="10%">Type</th>
                            <th class="tdBreakWord" width="10%">Number</th>
                            <th class="tdBreakWord" width="35%">Description</th>
                            <th class="tdBreakWord" width="13%">Status</th>
                            <th class="tdBreakWord" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($modelPR->type == 1)
                                    <td class="tdEllipsis">Material</td>
                                @elseif($modelPR->type == 2)
                                    <td class="tdEllipsis">Resource</td>
                                @elseif($modelPR->type == 3)
                                    <td class="tdEllipsis">Subcon</td>
                                @endif
                                <td class="tdEllipsis">{{ $modelPR->number }}</td>
                                <td class="tdEllipsis">{{ isset($modelPR->description) ? $modelPR->description : '-' }}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 0 || $modelPR->status == 7)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 3)
                                    <td>NEEDS REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 6)
                                    <td>CONSOLIDATED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
