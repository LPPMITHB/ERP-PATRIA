@extends('layouts.main')
@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'Create Other Cost',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.selectProjectCost'),
                'Create Cost' => ""
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'Create Other Cost',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.selectProjectCost'),
                'Create Cost' => ""
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
            <div class="box-header no-padding p-t-10">
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Project Code</div>
                    <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Ship Type</div>
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
            @verbatim
            <div id="create_cost">
                <div class="box-body p-t-0">
                    <table id="cost-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 15%">Cost (Rp.)</th>
                                <th style="width: 25%">Work Breakdown Structure</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in costs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">Rp.{{ data.plan_cost }}</td>
                                <td v-if="data.wbs_id != null" class="tdEllipsis">{{ data.wbs.name }}</td>
                                <td v-else class="tdEllipsis">-</td>
                                <td class="p-l-0 textCenter">
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_cost">
                                        EDIT
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="no-padding">
                                    <input v-model="newCost.description" class="form-control width100" rows="2" name="description">
                                </td>
                                <td class="no-padding">
                                    <input v-model="newCost.cost" class="form-control width100" rows="2" name="cost">
                                </td>
                                <td class="no-padding">
                                    <selectize v-model="newCost.wbs_id" :settings="workSettings">
                                        <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                    </selectize>
                                </td>
                                <td class="no-padding textCenter">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">SUBMIT</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal fade" id="edit_cost">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Costs</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editCost.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="cost" class="control-label">Cost</label>
                                            <input type="text" id="cost" v-model="editCost.cost" class="form-control" placeholder="Insert Cost here...">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="wbs" class="control-label">Work Breakdown Structure</label>
                                            <selectize v-model="editCost.wbs_id" :settings="workSettings">
                                                <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div id="myPopoverContent" style="display : none;">
                
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
    costs : "",
    works : [],
    newIndex : "", 
    newCost : {
        description : "",
        cost : "",
        wbs_id : null,
        project_id : @json($project->id),
    },
    editCost : {
        cost_id : "",
        description : "",
        cost : "",
        wbs_id : null,
        project_id : @json($project->id),
    },
    workSettings: {
        placeholder: 'Please Select Work (Optional)',
        plugins: ['dropdown_direction'],
        dropdownDirection : 'down',
    },
};

var vm = new Vue({
    el: '#create_cost',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newCost.name == ""
                || this.newCost.description == ""
                || this.newCost.cost == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editCost.name == ""
                || this.editCost.description == ""
                || this.editCost.cost == "")
                {
                    isOk = true;
                }
            return isOk;
        },

    }, 
    methods:{
        openEditModal(data){
            this.editCost.cost_id = data.id;
            this.editCost.description = data.description;
            this.editCost.wbs_id = data.wbs_id;
            this.editCost.cost = data.plan_cost;
        },
        getWorks(){
            window.axios.get('/api/getAllWorks/'+this.newCost.project_id).then(({ data }) => {
                this.works = data;
            });
        },
        getCosts(){
            window.axios.get('/rap/getCosts/'+this.newCost.project_id).then(({ data }) => {
                this.costs = data;
                this.costs.forEach(cost => {   
                    cost.plan_cost = (cost.plan_cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");      
                });
                this.newIndex = Object.keys(this.costs).length+1;
                var dT = $('#cost-table').DataTable();
                dT.destroy();
                this.$nextTick(function() {
                    $('#cost-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        'initComplete': function(){
                            $('div.overlay').remove();
                        },
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });
        },
        add(){            
            var newCost = this.newCost;
            newCost.cost = newCost.cost.replace(/,/g , '');
            newCost = JSON.stringify(newCost);
            var url = "{{ route('rap.storeCost') }}";
            window.axios.post(url,newCost)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                }
                
                this.getCosts();
                this.newCost.description = "";
                this.newCost.cost = "";
                this.newCost.wbs_id = "";                
            })
            .catch((error) => {
                console.log(error);
            })

        },
        update(){            
            var editCost = this.editCost;   
            editCost.cost = editCost.cost.replace(/,/g , '');        
            var url = "/rap/updateCost/"+editCost.cost_id;
            editCost = JSON.stringify(editCost);
            window.axios.put(url,editCost)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                }
                
                this.getCosts();
                this.newCost.description = "";
                this.newCost.cost = "";
                this.newCost.wbs_id = "";
            })
            .catch((error) => {
                console.log(error);
            })


        }
    },
    watch : {
        'newCost.cost': function(newValue) {
            var string_newValue = newValue+"";
            cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            Vue.nextTick(() => this.newCost.cost = cost_string);
        },

        costs: function(newValue) {
            newValue.forEach(cost => {
                cost.cost = (cost.cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
        'editCost.cost': function(newValue) {
            var string_newValue = newValue+"";
            cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            Vue.nextTick(() => this.editCost.cost = cost_string);
        },
    },
    created: function() {
        this.getCosts();
        this.getWorks();
    },
    
});


</script>
@endpush