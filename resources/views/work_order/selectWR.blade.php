@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Work Order » Select Work Request',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Work Request' => route('purchase_order.selectPR'),
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
                <table class="table table-bordered table-hover tableFixed" id="wo-table">
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
                        @foreach($modelWRs as $modelWR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWR->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelWR->description}}">{{ isset($modelWR->description) ? $modelWR->description : '-'}}</td>
                                <td>{{ isset($modelWR->project) ? $modelWR->project->name : '-' }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('work_order.selectWRD', ['id'=>$modelWR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a href="{{ route('work_order_repair.selectWRD', ['id'=>$modelWR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
