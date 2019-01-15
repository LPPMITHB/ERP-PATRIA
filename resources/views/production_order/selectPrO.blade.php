@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [   
            'title' => 'Release Production Order » '.$modelProject->name.' » Select PrO',
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('production_order.selectProjectRelease'),
                'Select Production Order' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [   
            'title' => 'Release Production Order » '.$modelProject->name.' » Select PrO',
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('production_order_repair.selectProjectRelease'),
                'Select Production Order' => ''
            ]
        ]
    )
    @endbreadcrumb
@endif
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
                                <td>Number</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelProject->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelProject->ship->type}}</b></td>
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
                <h4 class="box-title no-padding">Production Orders</h4>
                <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Number</th>
                            <th style="width: 30%">WBS</th>
                            <th style="width: 20%">Created By</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPrO as $pro)
                            <tr>
                                <td class="p-l-10">{{ $loop->iteration }}</td>
                                <td class="tdEllipsis p-l-10">{{ $pro->number }}</td>
                                <td class="tdEllipsis p-l-10">{{ $pro->wbs->code }} - {{ $pro->wbs->name }}</td>
                                <td class="p-l-10">{{ $pro->user->name }}</td>
                                @if($pro->status == 1)
                                    <td class="p-l-10">{{ 'UNRELEASED' }}</td>
                                @endif
                                <td class="textCenter">
                                    @if($route == "/production_order")
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order.release', ['id'=>$pro->id]) }}">
                                            SELECT
                                        </a>
                                    @elseif($route == "/production_order_repair")
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.release', ['id'=>$pro->id]) }}">
                                            SELECT
                                        </a>
                                    @endif
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
