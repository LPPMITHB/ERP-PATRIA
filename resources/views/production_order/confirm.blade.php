@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Confirm Production Order » '.$modelPO->number,
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
                <div class="col-sm-4 p-l-0">
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
                                <td>&ensp;<b>{{$project->ship->type}}</b></td>
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

                <div class="col-sm-4 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">WBS Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPO->work->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPO->work->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPO->work->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Deliverable</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPO->work->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPO->work->progress}}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-4 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">Work Order Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Actual Start Date</td>
                                <td>:</td>
                                <td>
                                    <input autocomplete="off" type="text"  class="form-control datepicker" name="actual_start_date" id="actual_start_date" placeholder="Insert Actual Start Date here...">                                                                                            
                                </td>
                            </tr>
                            <tr>
                                <td>Actual End Date</td>
                                <td>:</td>
                                <td>
                                    <input autocomplete="off" type="text"  class="form-control datepicker" name="actual_end_date" id="actual_end_date" placeholder="Insert Actual End Date here...">                                                                                            
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
                                <h4 class="box-title m-t-0">Activities</h4>
                                <table id="activity-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 38%">Activity</th>
                                            <th style="width: 38%">Description</th>
                                            <th style="width: 15%">Percentage</th>
                                            <th style="width: 4%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in activities">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ data.code }} - {{ data.name }}</td>
                                            <td class="tdEllipsis">{{ data.description }}</td>
                                            <td class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="data.progress" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="no-padding p-t-2 p-b-2" align="center">
                                                <input type="checkbox" v-icheck="" v-model="checkedActivities" :value="data.id">                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                        <th style="width: 15%">Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in materials">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.material.code }}</td>
                                        <td class="tdEllipsis">{{ data.material.name }}</td>
                                        <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                        <td class="tdEllipsis no-padding ">
                                            <input class="form-control width100" v-model="data.quantity" placeholder="Please Input Quantity">
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
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CONFIRM</button>
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
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose : true,
        });
        $('#material-table,#resource-table,#activity-table').DataTable({
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
        activities : @json($modelPO->work->activities),
        materials : [],
        resources : [],
        checkedActivities : [],
        submittedForm : {
        }
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
        directives: {
            icheck: {
                inserted: function(el, b, vnode) {
                    var vdirective = vnode.data.directives,
                    vModel;
                    for (var i = 0, vDirLength = vdirective.length; i < vDirLength; i++) {
                        if (vdirective[i].name == "model") {
                            vModel = vdirective[i].expression;
                            break;
                        }
                    }
                    jQuery(el).iCheck({
                        checkboxClass: "icheckbox_square-blue",
                        radioClass: "iradio_square-blue",
                        increaseArea: "20%" // optional
                    });
                    jQuery(el).on("ifChanged", function(e) {
                        if ($(el).attr("type") == "radio") {
                            vm.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = vm.$data[vModel];

                            $(el).prop("checked")
                            ? vm.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
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
        watch : {
            checkedActivities : function (newValue){
                this.activities.forEach(activity => {
                    if(newValue.indexOf(""+activity.id)!= -1){
                        activity.progress = 100;
                    }else{
                        activity.progress = 0;

                    }
                });
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

            this.modelPOD.forEach(POD => {
                if(POD.material_id != null){
                    var status = 0;
                    this.materials.forEach(material => {
                        if(material.material_id == POD.material_id){
                            material.quantity += POD.quantity;
                            status = 1;
                        }
                    });
                    if(status == 0){
                        this.materials.push(POD);
                    }
                }else if(POD.resource_id != null){
                    this.resources.push(POD);
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
