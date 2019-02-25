@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Work Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Work Order' => route('work_order.index'),
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
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Number</th>
                            <th width="15%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWOs as $modelWO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWO->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelWO->description}}">{{ $modelWO->description }}</td>
                                <td>{{ isset($modelWO->project) ? $modelWO->project->number : '-' }}</td>
                                @if($modelWO->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 3)
                                    <td>NEED REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @else
                                    <td>RECEIVED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
