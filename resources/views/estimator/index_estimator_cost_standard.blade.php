@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Cost Standards',
        'items' => [
            'Dashboard' => route('index'),
            'View All Cost Standards' => '',
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
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        @if($route == "/estimator")
                            <a href="{{ route('estimator.createCostStandard') }}" class="btn btn-primary btn-sm">CREATE</a>
                        @elseif($route == "/estimator_repair")
                            <a href="{{ route('estimator_repair.createCostStandard') }}" class="btn btn-primary btn-sm">CREATE</a>
                        @endif
                    </div>
                </div> 
                <table class="table table-bordered tableFixed" id="estimator-cost-standard-table">
                    <thead>
                        <tr>
                            <th width=5%>No</th>
                            <th width=12%>Code</th>
                            <th width=17%>Name</th>
                            <th width=24%>Description</th>
                            <th width=17%>WBS Name</th>
                            <th width=15%>Status</th>
                            <th width=10%></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($modelCostStandard as $costStandard)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$costStandard->code}}">{{ $costStandard->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$costStandard->name}}">{{ $costStandard->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$costStandard->description}}">{{ $costStandard->description }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$costStandard->estimatorWbs->name}}">{{ $costStandard->estimatorWbs->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $costStandard->status == "1" ? "Active": "Non Active" }}"> {{ $costStandard->status == "1" ? "Active": "Non Active" }}</td>
                                </td>
                                @if($route == "/estimator")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator.showCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{ route('estimator.editCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                    </td>
                                @elseif($route == "/estimator_repair")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator_repair.showCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{ route('estimator_repair.editCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#estimator-cost-standard-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush