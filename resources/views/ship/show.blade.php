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
                            <td>Type</td>
                            <td>{{ $ship->type }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Hull Number</td>
                            @if($ship->hull_number != '')
                                <td>{{ $ship->hull_number }}</td>
                            @else
                                <td>-</td>
                            @endif
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            @if($ship->description != '')
                                <td>{{ $ship->description }}</td>
                            @else
                                <td>-</td>
                            @endif
                        </tr>
                        <tr>
                            <td>4</td>
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

@push('script')
<script>
     $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush