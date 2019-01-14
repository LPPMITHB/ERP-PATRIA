@extends('layouts.main')

@section('content-header')
@if($route == "/goods_receipt")
    @breadcrumb(
        [
            'title' => 'View All Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipt' => route('goods_receipt.index'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'View All Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipt' => route('goods_receipt_repair.index'),
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">GR Code</th>
                            <th width="45%">Description</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGRs as $GR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $GR->number }}</td>
                                <td>{{ $GR->description }}</td>
                                <td class="textCenter p-l-0 p-r-0">
                                    @if($route == "/goods_receipt")
                                        <a href="{{ route('goods_receipt.show', ['id'=>$GR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($route == "/goods_receipt_repair")
                                        <a href="{{ route('goods_receipt_repair.show', ['id'=>$GR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
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
</script>
@endpush
