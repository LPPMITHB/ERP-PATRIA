@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Customer',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => route('customer.index'),
            $customer->name => route('customer.show',$customer->id),
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

                @can('edit-customer')
                    <a href="{{ route('customer.edit',['id'=>$customer->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                @endcan

                {{-- @can('destroy-customer')
                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $customer->id }}').submit();">DELETE</button>
                @endcan

                <form id="delete-form-{{ $customer->id }}" action="{{ route('customer.destroy', ['id' => $customer->id]) }}" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                </form> --}}
            </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Attribute</th>
                            <th width="65%">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $customer->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Address</td>
                            <td>{{ $customer->address }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Contact Person Name</td>
                            <td>{{ $customer->contact_person_name }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Contact Person E-Mail</td>
                            <td>{{ $customer->contact_person_email }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Contact Person Phone</td>
                            <td>{{ $customer->contact_person_phone }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Business Unit</td>
                            <td>{{ $business_unit }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($customer->status == 1)
                                    <i class="fa fa-check"></i></td>
                                @elseif ($customer->status == 0)
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