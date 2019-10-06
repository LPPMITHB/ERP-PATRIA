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
                                    <tr v-if="selectedPR[0].type == 3">
                                        <th width="4%">No</th>
                                        <th width="76%">Project Number</th>
                                        <th width="12%">WBS</th>
                                        <th width="8%">Job Order</th>
                                    </tr>
                                    <tr v-else-if="selectedPR[0].type == 1">
                                        <th width="4%">No</th>
                                        <th width="76%">Material</th>
                                        <th width="12%">Request Quantity</th>
                                        <th width="8%">Unit</th>
                                    </tr>
                                    <tr v-else>
                                        <th width="4%">No</th>
                                        <th width="41%">Resource Number</th>
                                        <th width="55%">Resource Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(selectedPRD,index) in selectedPR[0].purchase_requisition_details" v-if="selectedPR[0].type == 3">
                                        <tr>
                                            <td>{{ index + 1 }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    <template v-for="(selectedPRD,index) in selectedPR[0].purchase_requisition_details" v-if="selectedPR[0].type != 3">
                                        <tr>
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ selectedPRD.material.code }} - {{ selectedPRD.material.description }}</td>
                                            <td>{{ selectedPRD.quantity }}</td>
                                            <td>{{ selectedPRD.material.uom.unit }}</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
    					<a class="col-xs-12 col-md-2 btn btn-primary pull-right m-r-5" onclick="">CREATE</a>
						<div class="modal fade" id="create-repeat-order">
							<div class="modal-dialog modalFull">
								<form>
				                    <div class="modal-content">
				                        <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                                <span aria-hidden="true">×</span>
				                            </button>
				                            <h4 class="modal-title">Create Repeat Order</h4>
										</div>
										<div class="modal-body">
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="create">CREATE</button>
										</div>
									</div>
								</div>
							</div>
						</div>
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
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        methods : {
			create(){

		        form.submit();
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
