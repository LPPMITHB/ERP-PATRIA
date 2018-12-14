@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Material » Select Project',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => '',
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
                <h3 class="box-title">List of Projects</h3>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Project Name</th>
                            <th width="40%">Customer</th>
                            <th width="25%">Ship</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->ship->name }}</td>
                                <td align="center">
                                    @if($menu == '/bom')
                                        <a class="btn btn-primary btn-xs" href="{{ route('bom.indexBom', ['id'=>$project->id,'menu'=>$menu]) }}">SELECT</a>
                                    @elseif($menu == '/bom_repair')
                                        <a class="btn btn-primary btn-xs" href="{{ route('bom_repair.indexBom', ['id'=>$project->id,'menu'=>$menu]) }}">SELECT</a>
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
