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
                <form id="" class="form-horizontal" method="POST" action="{{ route('material_requisition_repair.store') }}">
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
                        <div v-show="selectedPR_id != ''">
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
                                        : <b></b>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <table class="table table-bordered tableFixed showTable" id="pr-table">
                                    <thead>
                                        <tr v-if="selectedPR.type == 3">
                                            <th width="5%">No</th>
                                            <th width="15%">Project Number</th>
                                            <th width="25%">WBS</th>
                                            <th width="40%">Job Order</th>
                                        </tr>
                                        <tr v-else>
                                            <th width="5%">No</th>
                                            <div v-if="selectedPR.type == 1">
                                                <th width="20%">Material Number</th>
                                                <th width="25%">Material Description</th>
                                            </div>
                                            <div v-else>
                                                <th width="20%">Resource Number</th>
                                                <th width="25%">Resource Description</th>
                                            </div>
                                            <th width="8%">Request Quantity</th>
                                            <th width="7%">Unit</th>
                                            <th width="14%">Project Number</th>
                                            <th width="13%">Required Date</th>
                                            <th width="10%">Allocation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="selectedPR.type == 3">
                                            <div v-for="(selectedPRD,index) in selectedPR.purchase_requisition_details">
                                                <td>{{ index }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </div>
                                        </tr>
                                        <tr v-else>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endverbatim
                </form>
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
