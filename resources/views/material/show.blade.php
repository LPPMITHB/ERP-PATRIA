@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Material',
        'subtitle' => 'Show',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            $material->name => route('material.show',$material->id),
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
                    @can('edit-material')
                        <a href="{{ route('material.edit',['id'=>$material->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan
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
                            <td>{{ $material->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $material->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $material->description }}">{{ $material->description }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Cost Standard Price</td>
                            <td>{{ number_format($material->cost_standard_price) }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Weight</td>
                            <td>{{ $material->weight }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Height</td>
                            <td>{{ $material->height }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Length</td>
                            <td>{{ $material->length }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Width</td>
                            <td>{{ $material->width }}</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Volume</td>
                            <td>{{ $material->volume }}</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Type</td>
                            @if ($material->type == 3)
                                <td>Bulk part</td>
                            @elseif ($material->type == 2)
                                <td>Component</td>
                            @elseif ($material->type == 1)
                                <td>Consumable</td>
                            @elseif ($material->type == 0)
                                <td>Raw</td>
                            @endif
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($material->status == 1)
                                    <i class="fa fa-check"></i>
                                @elseif ($material->status == 0)
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