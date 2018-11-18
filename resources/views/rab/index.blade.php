@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View RAP » Select Project » Select RAP',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rab.indexSelectProject'),
            'Select RAP' => route('rab.index',$rabs[0]->project_id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Rencana Anggaran Pembangungan</h3>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="50%">Doc. Number</th>
                            <th width="40%">Total Price</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rabs as $rab)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rab->number }}</td>
                                <td>Rp.{{ number_format($rab->total_price) }}</td>
                                <td class="p-l-5 p-r-5" align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('rab.edit', ['id'=>$rab->id]) }}">EDIT</a>
                                    <a class="btn btn-primary btn-xs" href="{{ route('rab.show', ['id'=>$rab->id]) }}">SELECT</a>
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
        $('#boms-table').DataTable({
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
