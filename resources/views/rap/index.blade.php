@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View RAP » Select Project » Select RAP',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.indexSelectProject'),
            'Select RAP' => route('rap.index',$raps[0]->project_id),
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
                <table class="table table-bordered tablePaging" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Doc. Number</th>
                            <th width="25%">WBS</th>
                            <th width="25%">BOM</th>
                            <th width="25%">Total Price</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($raps as $rap)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rap->number }}</td>
                                <td>{{ $rap->bom->wbs->code }}</td>
                                <td>{{ $rap->bom->code }}</td>
                                <td>Rp.{{ number_format($rap->total_price) }}</td>
                                <td class="p-l-5 p-r-5" align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('rap.edit', ['id'=>$rap->id]) }}">EDIT</a>
                                    <a class="btn btn-primary btn-xs" href="{{ route('rap.show', ['id'=>$rap->id]) }}">SELECT</a>
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
