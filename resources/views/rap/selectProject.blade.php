@extends('layouts.main')

@section('content-header')
    @if($menu == "view_rap")
        @breadcrumb(
            [
                'title' => 'View RAP » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => '',
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "create_cost")
        @breadcrumb(
            [
                'title' => 'Create Other Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => '',
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "input_actual_other_cost")
        @breadcrumb(
            [
                'title' => 'Input Actual Other Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => '',
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "view_planned_cost")
        @breadcrumb(
            [
                'title' => 'View Planned Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => '',
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "view_rm")
        @breadcrumb(
            [
                'title' => 'View Remaining Material » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered tablePaging tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Project Number</th>
                            <th width="30%">Customer</th>
                            <th width="20%">Ship Name</th>
                            <th width="20%">Ship Type</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->number}}">{{ $project->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}">{{ $project->customer->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->name}}">{{ $project->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->ship->type}}">{{ $project->ship->type }}</td>
                                @if($route == '/rap')
                                    @if($menu == "view_rap")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap.index', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "create_cost")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap.createCost', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "input_actual_other_cost")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap.inputActualOtherCost', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                    @elseif($menu == "view_planned_cost")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap.viewPlannedCost', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "view_rm")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap.selectWBS', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @endif
                                @elseif($route == '/rap_repair')
                                    @if($menu == "view_rap")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.index', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "create_cost")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.createCost', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "input_actual_other_cost")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.inputActualOtherCost', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                    @elseif($menu == "view_planned_cost")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.viewPlannedCost', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @elseif($menu == "view_rm")
                                        <td class="p-l-5 p-r-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.showMaterialEvaluation', ['id'=>$project->id]) }}">SELECT</a>
                                        </td>
                                    @endif
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
