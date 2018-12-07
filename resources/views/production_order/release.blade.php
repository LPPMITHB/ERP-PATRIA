@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Release Production Order » '.$modelPO->number,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('production_order.selectProject'),
            'Select WBS' => route('production_order.selectWBS', ['id' => $project->id]),
            'Add Additional Material & Resource' => ''
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <form id="release-wo" class="form-horizontal" method="POST" action="{{ route('production_order.storeRelease') }}">
            <input type="hidden" name="_method" value="PATCH">
            @csrf
            @verbatim
            <div id="work_order">
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
                                    <tr v-for="(data,index) in materials">
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
    const form = document.querySelector('form#release-wo');

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
        modelPOD : @json($modelPOD),
        boms : @json($boms),
        resourceDetails : @json($resources),
        materials : [],
        resources : [],
        submittedForm : {}
    };

    var vm = new Vue({
        el: '#work_order',
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

                this.submittedForm.modelPOD = this.modelPOD;
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

            this.modelPOD.forEach(WOD => {
                if(WOD.material_id != null){
                    var status = 0;
                    this.materials.forEach(material => {
                        if(material.material_id == WOD.material_id){
                            material.quantity += WOD.quantity;
                            status = 1;
                        }
                    });
                    if(status == 0){
                        this.materials.push(WOD);
                    }
                }else if(WOD.resource_id != null){
                    this.resources.push(WOD);
                }
            });
            
            this.materials.forEach(material => {
                window.axios.get('/api/getStockWO/'+material.material_id).then(({ data }) => {
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
