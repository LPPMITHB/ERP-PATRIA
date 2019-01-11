@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Purchase Requisitions',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Requisitions' => route('purchase_requisition.index'),
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
                                <td class="tdEllipsis">{{ isset($modelPR->description) ? $modelPR->description : '-' }}</td>
                                <td class="tdEllipsis">{{ isset($modelPR->project) ? $modelPR->project->name : '-'}}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 0 || $modelPR->status == 7)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 3)
                                    <td>NEEDS REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 6)
                                    <td>CONSOLIDATED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
