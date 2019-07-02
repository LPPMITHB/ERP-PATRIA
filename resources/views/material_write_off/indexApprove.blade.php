@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Material Write Off » Select Material Write Off',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Material Write Off' => route('material_write_off.indexApprove'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header p-b-20">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('material_write_off.selectPR') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <table class="table tableFixed table-bordered" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="40%">Description</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelGI->description}}">{{ $modelGI->description }}</td>
                                @if($modelGI->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelGI->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelGI->status == 0)
                                    <td>RECEIVED</td>
                                @elseif($modelGI->status == 3)
                                    <td>NEEDS REVISION</td>
                                @elseif($modelGI->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelGI->status == 5)
                                    <td>REJECTED</td>
                                @endif
                                <td class="textCenter">
                                    @if($route == "/material_write_off")
                                        <a href="{{ route('material_write_off.showApprove', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/material_write_off_repair")
                                        <a href="{{ route('material_write_off_repair.showApprove', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
