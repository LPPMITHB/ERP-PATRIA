@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Company',
        'items' => [
            'Dashboard' => route('index'),
            'Companies' => route('company.index'), 
            $company->name => route('company.show',$company->id),
            // 'View' => route('company.show', ['id' => $company->id]),
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

                @can('edit-company')
                    <a href="{{ route('company.edit',['id'=>$company->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                @endcan

            </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $company->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $company->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Address</td>
                            <td>{{ $company->address }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Phone Number</td>
                            <td>{{ $company->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Fax</td>
                            <td>{{ $company->fax }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Email</td>
                            <td>{{ $company->email }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($company->status == 1)
                                    <i class="fa fa-check"></i>
                                @elseif ($company->status == 0)
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