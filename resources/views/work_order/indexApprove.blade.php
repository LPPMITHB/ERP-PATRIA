@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Work Order » Select Work Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Work Order' => route('work_order.indexApprove'),
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
                    <a href="{{ route('work_order.selectPR') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <table class="table table-bordered tableFixed" id="wo-table">
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
                        @foreach($modelWOs as $modelWO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWO->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelWO->description}}">{{ $modelWO->description }}</td>
                                <td>{{ isset($modelWO->project) ? $modelWO->project->name : '-'}}</td>
                                @if($modelWO->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelWO->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelWO->status == 0)
                                    <td>RECEIVED</td>
                                @elseif($modelWO->status == 3)
                                    <td>NEEDS REVISION</td>
                                @elseif($modelWO->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelWO->status == 5)
                                    <td>REJECTED</td>
                                @endif
                                <td class="textCenter">
                                    @if($route == "/work_order")
                                        <a href="{{ route('work_order.showApprove', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/work_order_repair")
                                        <a href="{{ route('work_order_repair.showApprove', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#wo-table').DataTable({
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
