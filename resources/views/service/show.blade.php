@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Service',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
            $service->name => route('service.show',$service->id),
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
                <div class="box-title"></div>
                <div class="box-tools pull-right p-t-5">

                    @can('edit-service')
                        <a href="{{ route('service.edit',['id'=>$service->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan

                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered width100 showTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 40%">Attribute</th>
                            <th style="width: 55%">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $service->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $service->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-toggle="tooltip" title="{{ $service->description }}">{{ $service->description }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Cost Standard Price</td>
                            <td>{{ $service->cost_standard_price }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($service->status == 1)
                                        <i class="fa fa-check"></i>
                                @elseif ($service->status == 0)
                                    <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection