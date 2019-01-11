@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Purchase Requisition » Select Purchase Requisition',
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
            {{-- <div class="box-header p-b-20">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('purchase_requisition.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Type</th>
                            <th width="10%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%">Status</th>
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
                                <td>{{ $modelPR->description }}</td>
                                <td>{{ isset($modelPR->project) ? $modelPR->project->name : '-'}}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelPR->status == 0)
                                    <td>ORDERED</td>
                                @elseif($modelPR->status == 3)
                                    <td>NEEDS REVISION</td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                @endif
                                <td class="textCenter">
                                    @if($route == "/purchase_requisition")
                                        <a href="{{ route('purchase_requisition.showApprove', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/purchase_requisition_repair")
                                        <a href="{{ route('purchase_requisition_repair.showApprove', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
