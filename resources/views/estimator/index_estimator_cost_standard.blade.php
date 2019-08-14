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
                            <th width=15%>Code</th>
                            <th width=20%>Name</th>
                            <th width=25%>Description</th>
                            <th width=20%>WBS Name</th>
                            <th width=15%></th>
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
                                </td>
                                @if($route == "/estimator")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator.showCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{ route('estimator.editCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="confirmation({!! $costStandard->id !!})" class="btn btn-danger btn-xs">DELETE</a>
                                    </td>
                                @elseif($route == "/estimator_repair")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator_repair.showCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{ route('estimator_repair.editCostStandard', ['id'=>$costStandard->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="confirmation({!! $costStandard->id !!})" class="btn btn-danger btn-xs">DELETE</a>
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

    function confirmation(id){
        iziToast.show({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to delete this Cost Standard?',
            position: 'center',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    let route = @json($route);
                    if(route == "/estimator"){
                        document.location.href = "/estimator/deleteCostStandard/"+id;
                    }else if(route == "/estimator_repair"){
                        document.location.href = "/estimator_repair/deleteCostStandard/"+id;
                    }
                }, true], 
                ['<button>CANCEL</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                    }, toast, 'buttonName');
                }]
            ],
        });
    }
</script>
@endpush