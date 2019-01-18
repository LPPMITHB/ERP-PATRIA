@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'Release Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProject'),
                'Select WBS' => route('production_order.selectWBS', ['id' => $project->id]),
                'Add Additional Material & Resource' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
            [
                'title' => 'Release Production Order » '.$modelPrO->number,
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('production_order_repair.selectProject'),
                    'Select WBS' => route('production_order_repair.selectWBS', ['id' => $project->id]),
                    'Add Additional Material & Resource' => ''
                ]
            ]
        )
        @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            @if($route == "/production_order")
                <form id="release-pro" class="form-horizontal" method="POST" action="{{ route('production_order.storeRelease') }}">
            @elseif($route == "/production_order_repair")
                <form id="release-pro" class="form-horizontal" method="POST" action="{{ route('production_order_repair.storeRelease') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Material</h4>
                            <table id="material-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 15%">Quantity</th>
                                        <th style="width: 15%">Available</th>
                                        <th style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in boms">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.material.code }}</td>
                                        <td class="tdEllipsis">{{ data.material.name }}</td>
                                        <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                        <td class="tdEllipsis">{{ data.quantity }}</td>
                                        <td class="tdEllipsis" v-if="data.sugQuantity < data.quantity">
                                            <i class="fa fa-check text-success"></i>
                                        </td>
                                        <td class="tdEllipsis" v-else>
                                            <i class="fa fa-times text-danger"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Service</h4>
                            <table id="service-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 15%">Quantity</th>
                                        <th style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in services">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.service.code }}</td>
                                        <td class="tdEllipsis">{{ data.service.name }}</td>
                                        <td class="tdEllipsis">{{ data.quantity }}</td>
                                        <td class="tdEllipsis">
                                            <i class="fa fa-check text-success"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Resource</h4>
                            <table id="resource-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 15%">Available</th>
                                        <th style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in resources">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.resource.code }}</td>
                                        <td class="tdEllipsis">{{ data.resource.name }}</td>
                                        <template v-if="data.resource.status == 1">
                                            <td class="tdEllipsis" >
                                                {{ 'YES' }}
                                            </td>
                                            <td class="tdEllipsis">
                                                <i class="fa fa-check text-success"></i>
                                            </td> 
                                        </template>
                                        <template v-else>
                                            <td class="tdEllipsis">
                                                {{ 'NO' }}
                                            </td>
                                            <td class="tdEllipsis">
                                                <i class="fa fa-times text-danger"></i>
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">RELEASE</button>
                    </div>
                </div>
            </div>
            @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#release-pro');

    $(document).ready(function(){
        $('#material-table,#resource-table').DataTable({
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

    var data = {
        modelPrOD : @json($modelPrOD),
        boms : @json($boms),
        services : @json($services),
        resourceDetails : @json($resources),
        materials : [],
        resources : [],
        submittedForm : {}
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        computed : {
            createOk: function(){
                let isOk = false;

                return isOk;
            }
        },
        methods: {
            submitForm() {
                // var data = this.PRDetail;
                // data = JSON.stringify(data);
                // data = JSON.parse(data);

                // data.forEach(PRD => {
                //     PRD.quantity = PRD.quantity.replace(/,/g , '');      
                // });

                this.submittedForm.modelPrOD = this.modelPrOD;
                this.submittedForm.boms = this.boms;
                this.submittedForm.resourceDetails = this.resourceDetails;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        created: function() {
            $('div.overlay').show();
            this.boms.forEach(bom => {
                this.materials.push(bom);
            });

            this.resourceDetails.forEach(resource=> {
                this.resources.push(resource);
            });

            this.modelPrOD.forEach(PrOD => {
                if(PrOD.material_id != null){
                    this.materials.push(PrOD);
                }else if(PrOD.resource_id != null){
                    this.resources.push(PrOD);
                }
            });
            
            this.materials.forEach(material => {
                window.axios.get('/api/getStockPrO/'+material.material_id).then(({ data }) => {
                    if(data.length == 0){
                        material.sugQuantity = material.quantity;
                        material.quantity = 0;
                    }else{
                        if(data.reserved > data.quantity){
                            material.sugQuantity = material.quantity;
                            material.quantity = 0;
                        }else{
                            material.sugQuantity = material.quantity;
                            material.quantity = data.quantity;
                        }
                    }
                });
            });


        },
    });
</script>
@endpush
