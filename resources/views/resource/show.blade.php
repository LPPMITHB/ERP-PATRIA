@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Resource',
        'items' => [
            'Dashboard' => route('index'),
            'View All Resources' => route('resource.index'),
            $resource->name => route('resource.show',$resource->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">Resource Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->brand}}</b></td>
                            </tr>
                            @if($resource->category == 0 || $resource->category == 1 ||$resource->category == 3)
                            <tr>
                                <td>Quantity</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->quantity}}</b></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Category</td>
                                <td>:</td>
                                @if($resource->category_id == 0)
                                    <td>&ensp;<b>{{ 'EXTERNAL' }}</b></td>
                                @else
                                    <td>&ensp;<b>{{ 'INTERNAL' }}</b></td>
                                @endif
                            </tr>
                            <tr>
                                <td>Machine Type</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->type}}</b></td>
                            </tr>
                            <tr>
                                <td>Manufactured Date</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->manufactured_date}}</b></td>
                            </tr>
                            <tr>
                                <td>Purchasing Date</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->purchasing_date}}</b></td>
                            </tr>
                            <tr>
                                <td>Purchasing Price</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->purchasing_price}}</b></td>
                            </tr>
                            <tr>
                                <td>Lifetime</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->lifetime}}</b></td>
                            </tr>
                            <tr>
                                <td>Depreciation Method</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->depreciation_method}}</b></td>
                            </tr>
                            <tr>
                                <td>Accumulated Depreciation</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->accumulated_depreciation}}</b></td>
                            </tr>
                            <tr>
                                <td>Running Hours</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->running_hours}}</b></td>
                            </tr>
                            <tr>
                                <td>Cost / Hours</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->cost/hour}}</b></td>
                            </tr>
                            <tr>
                                <td>Performance</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->performance}}</b></td>
                            </tr>
                            <tr>
                                <td>Productivity</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->productivity}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td class="tdEllipsis" data-toggle="tooltip" title="{{ $resource->description }}">&ensp;<b>{{ $resource->description }}</b></td>
                            </tr>
                            {{-- <tr>
                                <td>Unit Of Measurement</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->uom->name}}</b></td>
                            </tr> --}}
                            <tr>
                                <td>Category</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$resource->category->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                @if ($resource->status == 1)
                                    <td>&ensp;<b>{{'AVAILABLE'}}</b></td>
                                @elseif ($resource->status == 0)
                                    <td>&ensp;<b>{{'NOT AVAILABLE'}}</b></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="box-body">
                <h4 class="m-t-0">Resource Utilization</h4>
                <table class="table table-bordered width100 showTable tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 25%">PO Number</th>
                            <th style="width: 25%">Created At</th>
                            <th style="width: 15%">Planned</th>
                            <th style="width: 15%">Actual</th>
                            <th style="width: 15%">Utilization</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOD as $pod)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pod->purchaseOrder->number }}</td>
                                <td>{{ $pod->purchaseOrder->created_at }}</td>
                                <td>{{ $pod->quantity }} {{ $pod->resource->uom->name }}</td>
                                <td>{{ 50 }} {{ $pod->resource->uom->name }}</td>
                                <td>{{ (50/$pod->quantity )*100 }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
    </div>
</div>

@endsection