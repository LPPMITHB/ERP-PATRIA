@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Material Requisitions',
        'items' => [
            'Dashboard' => route('index'),
            'View All Material Requisitions' => route('material_requisition.index'),
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
                <table class="table table-bordered tableFixed tablePaging" id="mr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelMRs as $modelMR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelMR->number }}</td>
                                <td>{{ $modelMR->description }}</td>
                                <td>{{ $modelMR->project->name }}</td>
                                <td>
                                    @if($modelMR->status == 0)
                                        ISSUED
                                    @elseif($modelMR->status == 1)
                                        OPEN
                                    @elseif($modelMR->status == 2)
                                        APPROVED
                                    @elseif($modelMR->status == 3)
                                        NEED REVISION
                                    @elseif($modelMR->status == 4)
                                        REVISED
                                    @elseif($modelMR->status == 4)
                                        REJECTED
                                    @else

                                    @endif
                                </td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('material_requisition.show', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @else
                                        <a href="{{ route('material_requisition_repair.show', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                    @if($modelMR->status == 1 || $modelMR->status == 3 )
                                        @if($menu == "building")
                                            <a href="{{ route('material_requisition.edit', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        @else
                                            <a href="{{ route('material_requisition_repair.edit', ['id'=>$modelMR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        @endif
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
