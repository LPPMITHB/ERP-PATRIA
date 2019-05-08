@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Unit Of Measurement',
        'items' => [
            'Dashboard' => route('index'),
            'View All Unit Of Measurement' => route('unit_of_measurement.index'),
            $uom->name => route('unit_of_measurement.show',$uom->id),
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

                    @can('edit-unit-of-measurement')
                        <a href="{{ route('unit_of_measurement.edit',['id'=>$uom->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan

                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered width100 showTable">
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
                            <td>{{ $uom->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $uom->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Unit</td>
                            <td>{{ $uom->unit }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($uom->status == 1)
                                        <i class="fa fa-check text-success"></i>
                                @elseif ($uom->status == 0)
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Decimal</td>
                            <td class="iconTd">
                                @if ($uom->is_decimal == 1)
                                    <i class="fa fa-check text-success"></i>
                                @elseif ($uom->is_decimal == 0)
                                    <i class="fa fa-times text-danger"></i>
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