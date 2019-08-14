@extends('layouts.main')

@section('content-header')
@if($route == "/estimator")
    @breadcrumb(
        [
            'title' => 'View Cost Standard',
            'items' => [
                'Dashboard' => route('index'),
                'View All Cost Standards' => route('estimator.indexEstimatorCostStandard'),
                $cost_standard->name => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/estimator_repair")
    @breadcrumb(
        [
            'title' => 'View Cost Standard',
            'items' => [
                'Dashboard' => route('index'),
                'View All Cost Standards' => route('estimator_repair.indexEstimatorCostStandard'),
                $cost_standard->name => '',
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
                <div class="box-title"></div>
                <div class="box-tools pull-right p-t-5">
                    @if($route == "/estimator")
                        <a href="{{ route('estimator.editCostStandard',['id'=>$cost_standard->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @elseif($route == "/estimator_repair")
                        <a href="{{ route('estimator_repair.editCostStandard',['id'=>$cost_standard->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endif                        
                    <a onClick="confirmation({!! $cost_standard->id !!})" class="btn btn-danger btn-sm">DELETE</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered width100 showTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 40%">Attribute</th>
                            <th style="width: 55%">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $cost_standard->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $cost_standard->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-toggle="tooltip" title="{{ $cost_standard->description }}">{{ $cost_standard->description }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Unit of Measurement</td>
                            <td>{{ $cost_standard->uom->unit }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Value</td>
                            <td>Rp.{{ number_format($cost_standard->value) }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>WBS Cost Estimation</td>
                            <td>{{ $cost_standard->estimatorWbs->name }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Status</td>
                            <td class="iconTd">
                                @if ($cost_standard->status == 1)
                                        <i class="fa fa-check"></i>
                                @elseif ($cost_standard->status == 0)
                                    <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
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