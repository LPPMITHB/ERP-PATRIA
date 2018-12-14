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
        <div class="box">
            <div class="box-header">
                <div class="box-title"></div>
                <div class="box-tools pull-right p-t-5">

                    @can('edit-vendor')
                        <a href="{{ route('vendor.edit',['id'=>$vendor->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan

                    <!-- @can('destroy-vendor')
                        <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $vendor->id }}').submit();">DELETE</button>
                    @endcan

                    <form id="delete-form-{{ $vendor->id }}" action="{{ route('vendor.destroy', ['id' => $vendor->id]) }}" method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                    </form> -->
                </div>
            </div>
            <div class="box-body">
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
                            <td>Address</td>
                            <td class="tdEllipsis" data-toggle="tooltip" data-container="body" title="{{ $vendor->address }}">{{ $vendor->address }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Phone Number</td>
                            <td>{{ $vendor->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Email</td>
                            <td>{{ $vendor->email }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
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
    </div>
</div>

@endsection