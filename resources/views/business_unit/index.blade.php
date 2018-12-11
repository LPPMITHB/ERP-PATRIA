@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Business Unit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Business Units' => route('business_unit.index'),
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
                    <a href="{{ route('business_unit.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
            {{-- <div style ="overflow:scroll"> --}}
                <table class="table table-bordered tableFixed" id="business_unit-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 25%">Name</th>
                            <th style="width: 45%">Description</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($business_units as $business_unit)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$business_unit->name}}">{{ $business_unit->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$business_unit->description}}">{{ $business_unit->description }}</td>
                                <td>
                                    @if ($business_unit->status == 1)
                                        <i class="fa fa-check"></i>
                                    @elseif ($business_unit->status == 0)
                                        <i class="fa fa-times"></i>
                                    @endif
                                </td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('business_unit.edit',['id'=>$business_unit->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#business_unit-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush
