@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Repeat Order',
        'items' => [
            'Dashboard' => route('index'),
            'Repeat Order' => '',
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
            @csrf
            @verbatim
                <div id="pr">
                    <div class="box-header no-padding">
                        <div class="col-xs-12 col-md-4">
                            <label>Select Existing Purchase Requisition to Repeat</label>
                            <selectize v-model="selectedPR_id">
                                <option v-for="(modelPR, index) in modelPRs" :value="modelPR.id">{{ modelPR.number }} - {{ modelPR.description }}</option>
                            </selectize>
                        </div>
                    </div>
                    <div v-if="selectedPR.length > 0" >
                        <div class="box-body no-padding">
                            <span class="info-box-text">PR Number</span>
                            <span class="info-box-number">{{ selectedPR.length > 0 ? selectedPR[0].number : "-"}}</span>
                        </div>
                        <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                            <div class="row" v-if="selectedPR.length > 0">
                                <div class="col-xs-4 col-md-4">
                                    Created By
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    : <b>{{ selectedPR[0].user.name }}</b>
                                </div>
                                <div class="col-xs-4 col-md-4">
                                    Created At
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    : <b>{{ selectedPR[0].new_created }}</b>
                                </div>
								<div class="col-xs-4 cold-md-4">
									Type
								</div>
								<div class="col-xs-8 col-md-8" v-if="selectedPR[0].type == 1">
									: <b>Material</b>
								</div>
								<div class="col-xs-8 col-md-8" v-else-if="selectedPR[0].type == 2">
									: <b>Resource</b>
								</div>
								<div class="col-xs-8 col-md-8" v-else-if="selectedPR[0].type == 3">
									: <b>Subcon</b>
								</div>
                                <div class="col-xs-4 col-md-4">
                                    Description
                                </div>
                                <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="">
                                    : <b>{{ selectedPR[0].description }}</b>
                                </div>
                            </div>
                        </div>
                        <div>
                            <table class="table table-bordered tableFixed showTable" id="pr-table">
                                <thead>
									<!-- Type Material -->
									<tr v-if="selectedPR[0].type == 1">
                                        <th width="4%">No</th>
                                        <th width="76%">Material</th>
                                        <th width="12%">Request Quantity</th>
                                        <th width="8%">Unit</th>
                                    </tr>
									<!-- Type Resource -->
									<tr v-else-if="selectedPR[0].type == 2">
                                        <th width="4%">No</th>
                                        <th width="16%">Resource Number</th>
                                        <th width="66%">Resource Description</th>
										<th width="14%">Request Quantity</th>
                                    </tr>
									<!-- Type Subcon -->
                                    <tr v-else-if="selectedPR[0].type == 3">
                                        <th width="4%">No</th>
                                        <th width="16%">Project Number</th>
                                        <th width="46%">WBS</th>
                                        <th width="38%">Job Order</th>
                                    </tr>
									<tr v-else>
										<th>Invalid</th>
									</tr>
                                </thead>
                                <tbody>
									<!-- Type Material -->
									<template v-for="(selectedPRD,index) in selectedPR[0].purchase_requisition_details" v-if="selectedPR[0].type == 1">
										<tr>
											<td>{{ index + 1 }}</td>
                                            <td>{{ selectedPRD.material.code }} - {{ selectedPRD.material.description }}</td>
                                            <td>{{ selectedPRD.quantity }}</td>
                                            <td>{{ selectedPRD.material.uom.unit }}</td>
										</tr>
									</template>
									<!-- Type Resource -->
                                    <template v-for="(selectedPRD,index) in selectedPR[0].purchase_requisition_details" v-else-if="selectedPR[0].type == 2">
                                        <tr>
                                            <td>{{ index + 1}}</td>
                                            <td>{{ selectedPRD.resource.code }}</td>
                                            <td>{{ selectedPRD.resource.name }}</td>
											<td>{{ selectedPRD.quantity }}</td>
                                        </tr>
                                    </template>
									<!-- Type Subcon -->
                                    <template v-for="(selectedPRD,index) in selectedPR[0].purchase_requisition_details" v-else-if="selectedPR[0].type == 3">
                                        <tr>
											<td>{{ index + 1 }}</td>
                                            <td>{{ selectedPRD.wbs.project.number }}</td>
                                            <td>{{ selectedPRD.wbs.number }}-{{ selectedPRD.wbs.description }}</td>
                                            <td>{{ selectedPRD.job_order }}</td>
                                        </tr>
                                    </template>
									<template v-else>
										<!-- blank -->
									</template>
                                </tbody>
                            </table>
                        </div>
    					<a class="col-xs-12 col-md-2 btn btn-primary pull-right m-r-5">CREATE</a>
                    </div>
                </div>
            @endverbatim
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
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

    var data = {
        selectedPR : [],
        selectedPR_id : "",
        modelPRs : @json($modelPRs),
        dataInput : {
            pr_id :"",
        },
		editInput : {
            material_id : "",
            old_material_id : "",
            material_code : "",
            material_name : "",
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            unit : "",
            project_id : "",
            project_number : "",
            required_date : "",
            alocation : "",
            is_decimal : "",
            material_ok : ""
        },
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        methods : {
			create(){

		        form.submit();
		    },
			openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.resource_id = data.resource_id;
                this.editInput.resource_code = data.resource_code;
                this.editInput.resource_name = data.resource_name;
                this.editInput.quantity = data.quantity;
                this.editInput.unit = data.unit;
                this.editInput.project_id = data.project_id;
                this.editInput.project_number = data.project_number;
                this.editInput.required_date = data.required_date;
                this.editInput.alocation = data.alocation;
                this.editInput.index = index;
                this.editInput.is_decimal = data.is_decimal;
            },
        },
        watch : {
            'selectedPR_id' : function(newValue){
                //this.dataInput.wbs_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getRepeatPR/'+newValue).then(({ data }) => {
                        this.selectedPR = [];
                        this.selectedPR.push(data);
                        this.selectedPR.forEach(data => {
                            var date_planned = data.planned_start_date;
                            var date_ended = data.planned_end_date;
                        });
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.selectedProject = [];
                }
            },
        },
    });
</script>
@endpush
