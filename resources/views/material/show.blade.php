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
            <div class="box-body">
                <div class="box-tools pull-right p-t-5">
                    @can('edit-material')
                        <a href="{{ route('material.edit',['id'=>$material->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#general_info" data-toggle="tab" aria-expanded="true">General Information</a></li>
                        <li class=""><a href="#transaction_history" data-toggle="tab" aria-expanded="false">Transaction History</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="general_info">
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
                                        <td>Cost Standard Price / Kg</td>
                                        <td>Rp {{ number_format($material->cost_standard_price_kg,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>5</td>
                                        <td>Cost Standard Price Service</td>
                                        <td>Rp {{ number_format($material->cost_standard_price_service,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>6</td>
                                        <td>Unit Of Measurement</td>
                                        <td>{{ $material->uom->name }}</td>
                                    </tr>

                                    <tr>
                                        <td>7</td>
                                        <td>Material Family</td>
                                        <td>{{ $arrayFamily != null ? $arrayFamily : "-"  }}</td>
                                    </tr>

                                    <tr>
                                        <td>8</td>
                                        <td>Density Type</td>
                                        <td>{{ $nameDensity != null ? $nameDensity : "-" }}</td>
                                    </tr>

                                    <tr>
                                        <td>9</td>
                                        <td>Latest Price</td>
                                        <td>Rp {{ number_format($material->latest_price,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>10</td>
                                        <td>Average Price per {{ $material->uom->name }}</td>
                                        <td>Rp {{ number_format($material->average_price,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>11</td>
                                        <td>Min</td>
                                        <td>{{ number_format($material->min) }}</td>
                                    </tr>

                                    <tr>
                                        <td>12</td>
                                        <td>Max</td>
                                        <td>{{ number_format($material->max) }}</td>
                                    </tr>
                                    @php
                                        $index = 12;
                                    @endphp
                                    @foreach ($dimensions as $dimension)
                                        <tr>
                                            <td>{{++$index}}</td>
                                            <td>{{$dimension->name}}</td>
                                            @if ($dimension->uom->is_decimal == 1)
                                                <td>{{ number_format($dimension->value,2) }} {{$dimension->uom->unit}}</td>
                                            @else
                                                <td>{{ number_format($dimension->value) }} {{$dimension->uom->unit}}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    {{-- <tr>
                                        <td>14</td>
                                        <td>Height</td>
                                        <td>{{ number_format($material->height) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>Length</td>
                                        <td>{{ number_format($material->length) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>Width</td>
                                        <td>{{ number_format($material->width) }} {{$uoms->where('id',$material->dimension_uom_id)->first() != null ? $uoms->where('id',$material->dimension_uom_id)->first()->unit : ""}}</td>
                                    </tr> --}}
                                    <tr>
                                        <td>{{++$index}}</td>
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
                                        <td>{{++$index}}</td>
                                        <td>Status</td>
                                        <td class="iconTd">
                                            @if ($material->status == 1)
                                                <i class="fa fa-check"></i>
                                            @elseif ($material->status == 0)
                                                <i class="fa fa-times"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($is_pami)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>Location Detail</td>
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $material->location_detail }}">{{ $material->location_detail }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="vertical-align:top">{{++$index}}</td>
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
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="transaction_history">
                            <table id="pr-table" class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th class="tdBreakWord" width="3%">No</th>
                                        <th class="tdBreakWord" width="10%">Type</th>
                                        <th class="tdBreakWord" width="10%">Number</th>
                                        <th class="tdBreakWord" width="13%">Document Date</th>
                                        <th class="tdBreakWord" width="13%">Created By</th>
                                        <th class="tdBreakWord" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="tdEllipsis">{{ $document->type_doc }}</td>
                                            <td class="tdEllipsis">{{ isset($document->number) ? $document->number : $document->code }}</td>
                                            <td class="tdEllipsis">{{ $document->created_at->format('d-m-Y') }}</td>
                                            <td class="tdEllipsis">{{ $document->user->name }}</td>
                                            <td class="textCenter">
                                                @if($route == "/material")
                                                    @if ($document->type_doc == "Purchase Requisition")
                                                        <a href="{{ route('purchase_requisition.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Purchase Order")
                                                        <a href="{{ route('purchase_order.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Receipt")
                                                        <a href="{{ route('goods_receipt.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Material Requisition")
                                                        <a href="{{ route('material_requisition.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Issue")
                                                        <a href="{{ route('goods_issue.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Return")
                                                        <a href="{{ route('goods_return.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Physical Inventory")
                                                        <a href="{{ route('physical_inventory.showCountStock', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Material Write Off")
                                                        <a href="{{ route('material_write_off.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Movement")
                                                        <a href="{{ route('goods_movement.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @endif
                                                @elseif($route == "/material_repair")
                                                    @if ($document->type_doc == "Purchase Requisition")
                                                        <a href="{{ route('purchase_requisition_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Purchase Order")
                                                        <a href="{{ route('purchase_order_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Receipt")
                                                        <a href="{{ route('goods_receipt_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Material Requisition")
                                                        <a href="{{ route('material_requisition_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Issue")
                                                        <a href="{{ route('goods_issue_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Return")
                                                        <a href="{{ route('goods_return_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Physical Inventory")
                                                        <a href="{{ route('physical_inventory_repair.showCountStock', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Material Write Off")
                                                        <a href="{{ route('material_write_off_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @elseif($document->type_doc == "Goods Movement")
                                                        <a href="{{ route('goods_movement_repair.show', ['id'=>$document->id]) }}" class="btn btn-primary btn-xs" target="_blank">VIEW</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
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
