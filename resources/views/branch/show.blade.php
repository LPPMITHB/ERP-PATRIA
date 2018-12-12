@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Branch',
        'items' => [
            'Dashboard' => route('index'),
            'View All Branches' => route('branch.index'),
            $branch->name => route('branch.show',$branch->id),
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

                    @can('edit-branch')
                        <a href="{{ route('branch.edit',['id'=>$branch->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan

                    <!-- @can('destroy-branch')
                        <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $branch->id }}').submit();">DELETE</button>
                    @endcan

                    <form id="delete-form-{{ $branch->id }}" action="{{ route('branch.destroy', ['id' => $branch->id]) }}" method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                    </form> -->
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
                            <td>{{ $branch->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $branch->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Address</td>
                            <td class="tdEllipsis" data-toggle="tooltip" title="{{ $branch->address }}">{{ $branch->address }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Phone Number</td>
                            <td>{{ $branch->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Fax</td>
                            <td>{{ $branch->fax }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Email</td>
                            <td>{{ $branch->email }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Company</td>
                            <td>{{ $branch->company->name }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($branch->status == 1)
                                        <i class="fa fa-check"></i>
                                @elseif ($branch->status == 0)
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