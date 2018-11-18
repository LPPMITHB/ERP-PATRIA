@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [   
        'title' => 'Release Work Order » '.$modelProject->name.' » Select WO',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('production_order.selectProjectRelease'),
            'Select Work Order' => ''
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelProject->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelProject->ship->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelProject->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-body p-t-0">
                <h4 class="box-title no-padding">Work Orders</h4>
                <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Number</th>
                            <th style="width: 30%">Work</th>
                            <th style="width: 20%">Created By</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPO as $po)
                            <tr>
                                <td class="p-l-10">{{ $loop->iteration }}</td>
                                <td class="tdEllipsis p-l-10">{{ $po->number }}</td>
                                <td class="tdEllipsis p-l-10">{{ $po->work->code }} - {{ $po->work->name }}</td>
                                <td class="p-l-10">{{ $po->user->name }}</td>
                                @if($po->status == 1)
                                    <td class="p-l-10">{{ 'UNRELEASED' }}</td>
                                @endif
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" href="{{ route('production_order.release', ['id'=>$po->id]) }}">
                                        SELECT
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#wbs-table').DataTable({
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
