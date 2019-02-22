@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Goods Return » Select Goods Return',
        'items' => [
            'Dashboard' => route('index'),
            'Select Goods Return' => route('goods_return.indexApprove'),
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
                <table class="table table-bordered tableFixed" id="goods-return-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="45%">Description</th>
                            <th width="20%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGoodsReturns as $modelGoodsReturn)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGoodsReturn->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip"  title="{{$modelGoodsReturn->description}}">{{ $modelGoodsReturn->description }}</td>
                                <td>{{ $modelGoodsReturn->project->name }}</td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('goods_return.showApprove', ['id'=>$modelGoodsReturn->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a href="{{ route('goods_return_repair.showApprove', ['id'=>$modelGoodsReturn->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#goods-return-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush