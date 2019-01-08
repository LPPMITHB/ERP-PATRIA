@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Production Order',
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
                                <td>Number</td>
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

                <div class="col-sm-6">
                    <table class="tableFixed width100">
                        <thead>
                            <th style="width: 25%">WBS Information</th>
                            <th style="width: 3%"></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="">Name</td>
                                <td>:</td>
                                <td><b>{{$wbs->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Description</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->description}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Deliverables</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_deadline);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td><b>{{$wbs->progress}} %</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box-body p-t-0 p-b-5">
                    <h4>Material</h4>
                <table class="table table-bordered showTable" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelBOM->bomDetails as $BOMD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $BOMD->material->name }}</td>
                                <td>{{ number_format($BOMD->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            <div class="box-body p-t-0 p-b-5">
                <h4>Resource</h4>
                <table class="table table-bordered showTable" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Resource Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelRD as $RD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $RD->resource->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            <form id="create-wo" class="form-horizontal" method="POST" action="{{ route('production_order.store') }}">
                @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body">
                    <h4 class="box-title m-t-0">Add Additional Material / Resource</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Type</th>
                                <th style="width: 25%">Name</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 20%">Quantity</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in datas">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.type }}</td>
                                <td class="tdEllipsis">{{ data.code }} - {{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">{{ data.quantity }}</td>
                                <td class="p-l-0 textCenter">
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="">
                                        EDIT
                                    </a>
                                    <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                        DELETE
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0 textLeft">
                                    <selectize v-model="dataInput.type" :settings="typeSettings">
                                        <option value="Material">Material</option>
                                        <option value="Resource">Resource</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == 'Material'">
                                    <selectize v-model="dataInput.id" :settings="materialSettings" >
                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == 'Resource'">
                                    <selectize v-model="dataInput.id" :settings="resourceSettings" >
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == ''">
                                    <selectize v-model="dataInput.id" :settings="nullSettings" disabled>
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0">
                                    <input class="form-control" v-model="dataInput.description" placeholder="-" disabled>
                                </td>
                                <td class="p-l-0" v-if = "dataInput.type == 'Material'">
                                    <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity"> 
                                </td>
                                <td class="p-l-0" v-else = "dataInput.type == 'Resource'">
                                    <input class="form-control" v-model="dataInput.quantity" disabled>
                                </td>
                                <td class="p-l-0 textCenter">
                                    <button @click.prevent="add"  class="btn btn-primary btn-xs" :disabled ="dataOk">ADD</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
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
    const form = document.querySelector('form#create-wo');
    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        dataInput : {
            id : "",
            type :"",
            code : "",
            name : "",
            description : "",
            quantity : "",
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        nullSettings:{
            placeholder: 'Please Select Type First !'
        },
        datas : [],
        project_id :@json($project->id),
        wbs_id :@json($wbs->id),
        materials : @json($materials),
        resources : @json($resources),
        bom : @json($modelBOM->bomDetails),
        assignedResource : @json($modelRD),
        newIndex : "",
        submittedForm : {},
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        computed : {
            dataOk: function(){
                let isOk = false;

                if(this.dataInput.id == "" || this.dataInput.quantity == "" || parseInt(this.dataInput.quantity.replace(/,/g , '')) < 1){
                    if(this.dataInput.type == 'Material' || this.dataInput.name ==""){
                        isOk = true;
                    }else if(this.dataInput.type == "" ){
                        isOk = true;
                    }
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.materials.length < 1 && this.resources.length < 1){
                    isOk = true;
                }
                return isOk;
            }
        },
        methods: {
            add(){
                var data = JSON.stringify(this.dataInput);
                data = JSON.parse(data);
                this.datas.push(data);
                this.newIndex = this.datas.length + 1;

                this.dataInput.id = "";
                this.dataInput.type = "";
                this.dataInput.code = "";
                this.dataInput.name = "";
                this.dataInput.description = "";
                this.dataInput.quantity = "";
            },
            removeRow: function(index) {
                this.datas.splice(index, 1);
                this.newIndex = this.datas.length + 1;
            },
            submitForm() {
                var datas = this.datas;
                datas = JSON.stringify(datas);
                datas = JSON.parse(datas);

                datas.forEach(data => {
                    data.quantity = data.quantity.replace(/,/g , '');      
                });

                this.submittedForm.datas = datas;
                this.submittedForm.materials = this.bom;
                this.submittedForm.resources = this.assignedResource;
                this.submittedForm.project_id = this.project_id;
                this.submittedForm.wbs_id = this.wbs_id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch: {
            'dataInput.id': function(newValue){
                if(newValue != ""){
                    if(this.dataInput.type == "Resource"){
                        window.axios.get('/api/getResourcePrO/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.dataInput.description = '-';
                            }else{
                                this.dataInput.description = data.description;
                            }
                            this.dataInput.name = data.name;
                            this.dataInput.code = data.code;
                        });
                    }else if(this.dataInput.type == "Material"){
                        window.axios.get('/api/getMaterialPrO/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.dataInput.description = '-';
                            }else{
                                this.dataInput.description = data.description;
                            }
                            this.dataInput.name = data.name;
                            this.dataInput.code = data.code;
                        });
                    }
                }
            },
            'dataInput.type': function(newValue){
                this.dataInput.id = "";
                this.dataInput.description = "";
            },
            'dataInput.quantity' : function(newvalue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            }
        },
        created: function() {
            this.newIndex = Object.keys(this.datas).length+1;
        },
    });
</script>
@endpush
