@extends('layouts.main')

@section('content-header')
@if($route == "/estimator")
    @breadcrumb(
        [
            'title' => 'View Estimator Profile » '.$profile->ship->type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator.indexEstimatorProfile'),
                $profile->ship->type => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/estimator_repair")
    @breadcrumb(
        [
            'title' => 'View Estimator Profile » '.$profile->ship->type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator_repair.indexEstimatorProfile'),
                $profile->ship->type => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6 no-padding">
                    <div class="col-sm-12">
                        <b>Estimator Profile Information</b>
                    </div>
                    <div class="col-sm-3">
                        <b>Code</b>
                    </div>
                    <div class="col-sm-9">
                       : {{ $profile->code }}
                    </div>
                    <div class="col-sm-3">
                        <b>Ship Type</b>
                    </div>
                    <div class="col-sm-9">
                       : {{ $profile->ship->type }}
                    </div>
                    <div class="col-sm-3">
                        <b>Description</b>
                    </div>
                    <div class="col-sm-9">
                       : {{ $profile->description ? $profile->description : '-' }}
                    </div>
                    <div class="col-sm-3">
                        <b>Status</b>
                    </div>
                    <div class="col-sm-9">
                       : {{ $profile->status == 1 ? 'Active' : 'Non Active' }}
                    </div>
                </div>
                <div class="col-sm-6 no-padding">
                    <div class="box-tools pull-right p-t-5">
                        <a class="btn btn-primary btn-sm" href="#visualize" data-toggle="modal">VISUALIZE</a>
                        @if($route == "/estimator")
                            <a href="{{ route('estimator.editProfile',['id'=>$profile->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                        @elseif($route == "/estimator_repair")
                            <a href="{{ route('estimator_repair.editProfile',['id'=>$profile->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                        @endif                        
                        <a onClick="confirmation({!! $profile->id !!})" class="btn btn-danger btn-sm">DELETE</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered width100 showTable tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">WBS Cost Estimation</th>
                            <th width="25%">Cost Standard</th>
                            <th width="20%">Value</th>
                            <th width="15%">Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profile->estimatorProfileDetails as $pd)
                            <tr>
                                <td class="tdEllipsis">{{$loop->iteration}}</td>
                                <td class="tdEllipsis">{{$pd->estimatorCostStandard->estimatorWbs->name}}</td>
                                <td class="tdEllipsis">{{$pd->estimatorCostStandard->name}}</td>
                                <td class="tdEllipsis">{{$pd->estimatorCostStandard->uom->unit}}</td>
                                <td class="tdEllipsis">Rp.{{ number_format($pd->estimatorCostStandard->value) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="visualize">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Estimator Profile Visualization</h4>
                    </div>
                    <div class="modal-body">
                        <div id="treeview">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
     $(document).ready(function(){
        var data = @json($tree);

        $('#treeview').jstree({
            "core": {
                "data": data,
                "check_callback": true,
                "animation": 200,
                "dblclick_toggle": false,
                "keep_selected_style": false
            },
            "plugins": ["dnd", "contextmenu"],
            "contextmenu": {
                "select_node": false, 
                "show_at_node": false,
            }
        }).bind("changed.jstree", function (e, data) {
            if(data.node) {
                document.location = data.node.a_attr.href;
            }
        }).bind("loaded.jstree", function (event, data) {
            $(this).jstree("open_all");
        });
        $('div.overlay').hide();
    });

    $('#treeview').on("select_node.jstree", function (e, data) {
        if(data.node.a_attr.href != '#'){
            $('div.overlay').show();
        }
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
            message: 'Are you sure you want to delete this Estimator Profile?',
            position: 'center',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    let route = @json($route);
                    if(route == "/estimator"){
                        document.location.href = "/estimator/deleteProfile/"+id;
                    }else if(route == "/estimator_repair"){
                        document.location.href = "/estimator_repair/deleteProfile/"+id;
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