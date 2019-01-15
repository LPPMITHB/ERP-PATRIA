@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Work Request » Select Work Request',
        'items' => [
            'Dashboard' => route('index'),
            'Select Work Request' => route('work_request.indexApprove'),
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
                            <th width="20%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWRs as $modelWR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWR->number }}</td>
                                <td>{{ $modelWR->description }}</td>
                                <td>{{ isset($modelWR->project) ? $modelWR->project->name : '-'}}</td>
                                @if($modelWR->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelWR->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelWR->status == 0)
                                    <td>ORDERED</td>
                                @elseif($modelWR->status == 3)
                                    <td>NEEDS REVISION</td>
                                @elseif($modelWR->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelWR->status == 5)
                                    <td>REJECTED</td>
                                @endif
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('work_request.showApprove', ['id'=>$modelWR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a href="{{ route('work_request_repair.showApprove', ['id'=>$modelWR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
