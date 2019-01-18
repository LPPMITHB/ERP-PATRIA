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
                <div class="col-sm-4">
                    <table>
                        <thead>
                            <th colspan="2">Resource Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td><b>{{$resource->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><b>{{$resource->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td class="tdEllipsis" data-toggle="tooltip" title="{{ $resource->description }}"><b>{{ isset($resource->description) ? $resource->description : '-' }}</b></td>
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