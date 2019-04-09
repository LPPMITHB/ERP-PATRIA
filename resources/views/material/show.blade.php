@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Material',
        'subtitle' => 'Show',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            $material->description => route('material.show',$material->id),
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
                            <td>Item Number</td>
                            <td>{{ $material->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $material->description }}">{{ $material->description }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Cost Standard Price Material</td>
                            <td>Rp {{ number_format($material->cost_standard_price,2) }}</td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Cost Standard Price Service</td>
                            <td>Rp {{ number_format($material->cost_standard_price_service,2) }}</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Unit Of Measurement</td>
                            <td>{{ $material->uom->name }}</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Material Family</td>
                            <td>{{ $arrayFamily != null ? $arrayFamily : "-"  }}</td>
                        </tr>

                        <tr>
                            <td>7</td>
                            <td>Density</td>
                            <td>{{ $nameDensity != null ? $nameDensity : "-" }}</td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>Latest Price</td>
                            <td>Rp {{ number_format($material->latest_price,2) }}</td>
                        </tr>

                        <tr>
                            <td>9</td>
                            <td>Average Price</td>
                            <td>Rp {{ number_format($material->average_price,2) }}</td>
                        </tr>

                        <tr>
                            <td>10</td>
                            <td>Min</td>
                            <td>{{ number_format($material->min) }}</td>
                        </tr>

                        <tr>
                            <td>11</td>
                            <td>Max</td>
                            <td>{{ number_format($material->max) }}</td>
                        </tr>

                        <tr>
                            <td>12</td>
                            <td>Weight</td>
                            <td>{{ number_format($material->weight) }} {{$uoms->where('id',$material->weight_uom_id)->first() != null ? $uoms->where('id',$material->weight_uom_id)->first()->unit : ""}}</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Height</td>
                            <td>{{ number_format($material->height) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Length</td>
                            <td>{{ number_format($material->length) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Width</td>
                            <td>{{ number_format($material->width) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                        </tr>
                        <tr>
                            <td>16</td>
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
                            <td>17</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($material->status == 1)
                                    <i class="fa fa-check"></i>
                                @elseif ($material->status == 0)
                                    <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top">17</td>
                            <td style="vertical-align:top">Image</td>
                            <td class="iconTd">
                                @if($material->image != null)
                                    <a target="_blank" href="{{ URL::to('/') }}/app/documents/material/{{$material->image}}">
                                        <img style="width:100%; height:500px" src="{{ URL::to('/') }}/app/documents/material/{{$material->image}}">
                                    </a>
                                @else
                                    -
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