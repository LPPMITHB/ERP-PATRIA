@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Material Requisition » Select Material Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'Select Material Requisition' => route('material_requisition.indexApprove'),
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
                <table class="table table-bordered tableFixed" id="mr-table">
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
                        @foreach($modelMRs as $modelMR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelMR->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip"  title="{{$modelMR->description}}">{{ $modelMR->description }}</td>
                                <td>{{ $modelMR->project->name }}</td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('material_requisition.showApprove', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a href="{{ route('material_requisition_repair.showApprove', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#mr-table').DataTable({
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
