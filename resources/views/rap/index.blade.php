@extends('layouts.main')

@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'View RAP » Select RAP',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.indexSelectProject'),
                'Select RAP' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'View RAP » Select RAP',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.indexSelectProject'),
                'Select RAP' => '',
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
                <table class="table table-bordered tablePaging">
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
                                    @if($route == "/rap")
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap.edit', ['id'=>$rap->id]) }}">EDIT</a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap.show', ['id'=>$rap->id]) }}">SELECT</a>
                                    @elseif($route == "/rap_repair")
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.edit', ['id'=>$rap->id]) }}">EDIT</a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('rap_repair.show', ['id'=>$rap->id]) }}">SELECT</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
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
