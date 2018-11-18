@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Storage Location',
        'subtitle' => 'Show',
        'items' => [
            'Dashboard' => route('index'),
            'View All Storage Locations' => route('storage_location.index'),
            $storage_location->name => route('storage_location.show',$storage_location->id),
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

                @can('edit-storage-location')
                    <a href="{{ route('storage_location.edit',['id'=>$storage_location->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                @endcan

            </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 35%">Attribute</th>
                            <th style="width: 60%">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $storage_location->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $storage_location->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Area (m<sup>2</sup>)</td>
                            <td>{{ $storage_location->area }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Description</td>
                            <td>{{ $storage_location->description }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Warehouse</td>
                            <td>{{ $storage_location->warehouse->name }}</td>
                            </tr>
                        <tr>
                            <td>6</td>
                            <td>Status</td>
                            @if ($storage_location->status == 1)
                                <td class ="iconTd"><i class="fa fa-check"></i></td>
                            @elseif ($storage_location->status == 0)
                                <td class ="iconTd"><i class="fa fa-times"></i></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection