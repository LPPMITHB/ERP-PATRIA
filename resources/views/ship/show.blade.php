@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Ship',
        'items' => [
            'Dashboard' => route('index'),
            'View All Ships' => route('ship.index'),
            $ship->type => route('ship.show',$ship->id),
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

                @can('edit-ship')
                    <a href="{{ route('ship.edit',['id'=>$ship->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                @endcan

                {{-- @can('destroy-ship')
                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $ship->id }}').submit();">DELETE</button>
                @endcan

                <form id="delete-form-{{ $ship->id }}" action="{{ route('ship.destroy', ['id' => $ship->id]) }}" method="POST" style="display: none;">
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
                        {{-- <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $ship->code }}</td>
                        </tr> --}}
                        {{-- <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $ship->name }}</td>
                        </tr> --}}
                        <tr>
                            <td>1</td>
                            <td>Type</td>
                            <td>{{ $ship->type }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Description</td>
                            <td>{{ $ship->description }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($ship->status == 1)
                                    <i class="fa fa-check no-padding"></i>
                                @elseif ($ship->status == 0)
                                    <i class="fa fa-times no-padding"></i>
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