@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Materials » Select Project',
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
            <div class="box-body">
                <table class="table table-bordered tablePaging tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Project Number</th>
                            <th width="30%">Customer</th>
                            <th width="20%">Ship Name</th>
                            <th width="20%">Ship Type</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="tdEllipsis">{{ $project->number }}</td>
                                <td class="tdEllipsis">{{ $project->customer->name }}</td>
                                <td class="tdEllipsis">{{ $project->name }}</td>
                                <td class="tdEllipsis">{{ $project->ship->type }}</td>
                                <td align="center">
                                    @if($route == '/bom')
                                        <a class="btn btn-primary btn-xs" href="{{ route('bom.indexBom', ['id'=>$project->id]) }}">SELECT</a>
                                    @elseif($route == '/bom_repair')
                                        <a class="btn btn-primary btn-xs" href="{{ route('bom_repair.show', ['id'=>$project->id]) }}">SELECT</a>
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