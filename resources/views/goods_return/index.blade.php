@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Return',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Returns' => route('goods_return.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered tableFixed tablePaging" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="15%">GR Number</th>
                            <th width="15%">PO Number</th>
                            <th width="25%">Description</th>
                            <th width="12%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td>{{ $modelGI->goodsReceipt != null ? $modelGI->goodsReceipt->number : "-" }}</td>
                                <td>{{ $modelGI->purchaseOrder != null ? $modelGI->purchaseOrder->number : "-" }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->description}}">{{ $modelGI->description }}</td>
                                @if($modelGI->status == 1)
                                <td>OPEN</td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($menu == "repair")
                                        <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
                                @elseif($modelGI->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 0 || $modelGI->status == 7)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 3)
                                    <td>NEEDS REVISION</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 6)
                                    <td>CONSOLIDATED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();        
    });

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
