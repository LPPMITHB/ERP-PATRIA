@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Receipt',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Receipt' => route('goods_receipt.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header p-b-20">
                {{-- <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('goods_receipt.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div> --}}
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="po-table">
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
                                    <a href="{{ route('goods_receipt.show', ['id'=>$GR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        $('#po-table').DataTable({
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
