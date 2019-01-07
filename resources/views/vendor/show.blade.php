@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Vendor',
        'items' => [
            'Dashboard' => route('index'),
            'View All Vendors' => route('vendor.index'),
            $vendor->name => route('vendor.show',$vendor->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#personal-info" data-toggle="tab">Personal Information</a></li>
                    <li><a href="#po-list" data-toggle="tab">PO History</a></li>
                    <div class="box-tools pull-right p-t-5 p-r-10">
                        @can('edit-vendor')
                            <a href="{{ route('vendor.edit',['id'=>$vendor->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                        @endcan
                    </div>
                </div>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="personal-info">
                        <div class="box-body p-t-0">
                            <table class="table table-bordered showTable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 20%">Attribute</th>
                                        <th style="width: 65%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Code</td>
                                        <td>{{ $vendor->code }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Name</td>
                                        <td>{{ $vendor->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Type</td>
                                        <td>{{ $vendor->type }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Address</td>
                                        <td class="tdEllipsis" data-toggle="tooltip" data-container="body" title="{{ $vendor->address }}">{{ $vendor->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Phone Number</td>
                                        <td>{{ $vendor->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Email</td>
                                        <td>{{ $vendor->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Competence</td>
                                        <td>{{ $vendor->competence }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Status</td>
                                        <td class="iconTd">
                                            @if ($vendor->status == 1)
                                                <i class="fa fa-check"></i>
                                            @elseif ($vendor->status == 0)
                                                <i class="fa fa-times"></i>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="po-list">
                        <div class="box-body p-t-0">
                            <table class="table table-bordered showTable tablePaging">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Number</th>
                                        <th width="40%">Description</th>
                                        <th width="15%">Project Number</th>
                                        <th width="20%">Ship Name</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modelPOs as $modelPO)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('purchase_order.show',$modelPO->id) }}" class="text-primary">{{$modelPO->number}}</a>
                                            </td>
                                            <td>{{ $modelPO->description }}</td>
                                            <td>{{ $modelPO->project->number }}</td>
                                            <td>{{ $modelPO->project->name }}</td>
                                            @if($modelPO->status == 1)
                                                <td>OPEN</td>
                                            @elseif($modelPO->status == 2)
                                                <td>APPROVED</td>
                                            @elseif($modelPO->status == 3)
                                                <td>NEED REVISION</td>
                                            @elseif($modelPO->status == 4)
                                                <td>REVISED</td>
                                            @elseif($modelPO->status == 5)
                                                <td>REJECTED</td>
                                            @elseif($modelPO->status == 0)
                                                <td>RECEIVED</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection