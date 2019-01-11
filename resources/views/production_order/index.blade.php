@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Production Orders',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Production Orders' => route('production_order.index'),
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
                <table class="table table-bordered tableFixed tablePaging" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Number</th>
                            <th width="25%">Project Name</th>
                            <th width="25%">Work Name</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOs as $modelPO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPO->number }}</td>
                                <td>{{ $modelPO->project->name }}</td>
                                <td>{{ $modelPO->wbs->name}}</td>
                                <td align="center">
                                    <a href="{{ route('production_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
