@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Unit Of Measurements',
        'items' => [
            'Dashboard' => route('index'),
            'View All Unit Of Measurements' => route('unit_of_measurement.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('unit_of_measurement.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
            {{-- <div style ="overflow:scroll"> --}}
                <table class="table table-bordered table-hover" id="uom-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 25%">Name</th>
                            <th style="width: 45%">Unit</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($uoms as $uom)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $uom->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$uom->name}}">{{ $uom->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$uom->unit}}">{{ $uom->unit }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('unit_of_measurement.show', ['id'=>$uom->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('unit_of_measurement.edit',['id'=>$uom->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#uom-table').DataTable({
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
