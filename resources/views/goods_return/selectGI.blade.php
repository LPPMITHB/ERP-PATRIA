@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Return » Select Goods Issue',
        'items' => [
            'Dashboard' => route('index'),
            'Select Goods Issue' => "",
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
                <table class="table table-bordered tableFixed" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">GI Number</th>
                            <th width="15%">MR Number</th>
                            <th width="20%">Description</th>
                            <th width="20%">Created By</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGI as $GI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $GI->number }}">{{ $GI->number }}</td>
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $GI->materialRequisition->number }}">{{ $GI->materialRequisition->number }}</td>
                                <td class ="tdEllipsis" data-container="body" data-toogle="tooltip" title="{{ $GI->description }}">{{ $GI->description }}</td>
                                <td class ="tdEllipsis">{{ $GI->user->name }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($menu == '/goods_return')
                                        <a onClick="loading()" href="{{ route('goods_return.createGoodsReturnGI', ['id'=>$GI->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($menu == '/goods_return_repair')
                                        <a onClick="loading()" href="{{ route('goods_return_repair.createGoodsReturnGI', ['id'=>$GI->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#gi-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });   
    });

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
