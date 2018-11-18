@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Yard',
        'subtitle' => 'Show',
        'items' => [
            'Dashboard' => route('index'),
            'View All Yards' => route('yard.index'),
            $yard->name => route('yard.show',$yard->id),
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

                @can('edit-yard')
                    <a href="{{ route('yard.edit',['id'=>$yard->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
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
                            <td>{{ $yard->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $yard->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Area (m<sup>2</sup>)</td>
                            <td>{{ $yard->area }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Description</td>
                            <td>{{ $yard->description }}</td>
                        </tr>
                            <td>5</td>
                            <td>Status</td>
                            @if ($yard->status == 2)
                                <td>Not Available</td>
                            @elseif ($yard->status == 1)
                                <td>Available</td>
                            @else
                                <td>Not Active</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection