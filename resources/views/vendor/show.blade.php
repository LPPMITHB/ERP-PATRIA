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
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="personal-info">
                    <div class="row m-l-15">
                        <div class="col-xs-12 col-lg-4 col-md-12">    
                                <div class="col-md-4 col-xs-6 no-padding">Code</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->number}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Name</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->name}}</b></div>
        
                                <div class="col-md-4 col-xs-6 no-padding">Type</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->type}}</b></div>
        
                                <div class="col-md-4 col-xs-6 no-padding">Address</div>
                                <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $vendor->address }}"><b>: {{ $vendor->address }}</b></div>
        
                                <div class="col-md-4 col-xs-6 no-padding">Phone Number 1</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_1}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Phone Number 2</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_2}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Contact Name</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->contact_name}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Email</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->email}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Description</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->description}}</b></div>
                                
                                <div class="col-md-4 col-xs-6 no-padding">Status</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: @if ($vendor->status == 1)
                                        <i class="fa fa-check"></i>
                                    @elseif ($vendor->status == 0)
                                        <i class="fa fa-times"></i>
                                    @endif</b></div>
        
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-sm-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#quality" data-toggle="tab">Quality</a></li>
                                    <li><a href="#cost" data-toggle="tab">Cost</a></li>
                                    <li><a href="#delivery" data-toggle="tab">Delivery</a></li>
                                    <li><a href="#safety" data-toggle="tab">Safety</a></li>
                                    <li><a href="#morale" data-toggle="tab">Morale</a></li>
                                    <li><a href="#productivity" data-toggle="tab">Productivity</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="quality">
                                <div class="box-body p-t-0">
                                    <table class="table table-bordered showTable tablePaging tableFixed">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">GI Number</th>
                                                <th width="40%">Description</th>
                                                <th width="15%">Project Number</th>
                                                <th width="20%">Ship Name</th>
                                                <th width="10%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="cost">
                                cost
                            </div>
                            <div class="tab-pane" id="delivery">
                                delivery
                            </div>
                            <div class="tab-pane" id="safety">
                                safety
                            </div>
                            <div class="tab-pane" id="morale">
                                morale
                            </div>
                            <div class="tab-pane" id="productivity">
                                productivity
                            </div>
                        </div>
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

@endsection