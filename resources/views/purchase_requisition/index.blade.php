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
                <table class="table table-bordered" id="permissions-table">
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
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPR->number }}</td>
                                <td>{{ $modelPR->description }}</td>
                                <td>{{ $modelPR->project->name }}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        <a href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    </td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVE</td>
                                    <td class="textCenter">
                                        <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    </td>
                                @elseif($modelPR->status == 0)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    </td>
                                @elseif($modelPR->status == 3)
                                    <td>NOT APPROVE</td>
                                    <td class="textCenter">
                                        <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    </td>
                                @elseif($modelPR->status == 4)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        <a href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        $('#permissions-table').DataTable({
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
