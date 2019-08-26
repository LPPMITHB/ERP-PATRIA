@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Return » Select PO',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select PO' => '',
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
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="45%">Description</th>
                            <th width="20%">Project Name</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOs as $modelPO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b><a href= "{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="text-primary">{{ $modelPO->number }}</a></b></td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPO->description}}">{{ $modelPO->description }}</td>
                                <td>{{ isset($modelPO->project) ? $modelPO->project->name : '-'}}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('goods_return.createGoodsReturnPO', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($menu == "repair")
                                        <a href="{{ route('goods_return_repair.createGoodsReturnPO', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
