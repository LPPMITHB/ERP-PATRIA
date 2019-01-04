@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Issue',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Issue' => route('goods_issue.index'),
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
                <table class="table table-bordered tableFixed tablePaging" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="25%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="12%">Type</th>
                            <th width="8%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td>{{ $modelGI->description }}</td>
                                <td>{{ isset ($modelGI->materialRequisition) ? $modelGI->materialRequisition->project->name : '-'}}</td>
                                <td>
                                    @if($modelGI->materialRequisition)
                                        {{ $modelGI->materialRequisition->type == 1 ? 'Manual' : 'Automatic' }}
                                    @else
                                        {{ 'Material Write Off' }}
                                    @endif
                                </td>
                                <td>
                                    @if($modelGI->status == 0)
                                        Issued
                                    @elseif($modelGI->status == 1)
                                        Open
                                    @elseif($modelGI->status == 2)
                                        Approved
                                    @elseif($modelGI->status == 3)
                                        Need Revision
                                    @elseif($modelGI->status == 4)
                                        Rejected
                                    @else
                                    @endif
                                </td>
                                <td align="center">
                                @if($modelGI->type == 2 && $modelGI->status == 1 || $modelGI->status == 3)
                                    <a href="{{ route('goods_issue.showApprove', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                @else
                                    <a href="{{ route('goods_issue.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
