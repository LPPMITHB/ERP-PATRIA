@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Warehouse',
        'items' => [
            'Dashboard' => route('index'),
            'View All Warehouses' => route('warehouse.index'),
            $warehouse->name => route('warehouse.show',$warehouse->id),
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

                    @can('edit-warehouse')
                        <a href="{{ route('warehouse.edit',['id'=>$warehouse->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered width100 showTable tableFixed">
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
                            <td>{{ $warehouse->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $warehouse->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td>{{ $warehouse->description }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Person In-Charge</td>
                            <td>{{ $pic->name }}
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($warehouse->status == 1)
                                        <i class="fa fa-check"></i>
                                @elseif ($warehouse->status == 0)
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

@push('script')
<script>
     $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush
