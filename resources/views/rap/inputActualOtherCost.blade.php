@extends('layouts.main')
@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'Input Actual Other Cost',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.selectProjectActualOtherCost'),
                'Input Actual Cost' => ""
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'Input Actual Other Cost',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.selectProjectActualOtherCost'),
                'Input Actual Cost' => ""
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
            <form id="actual-cost" class="form-horizontal" method="POST" action="{{ route('rap.storeActualCost') }}">
            <input type="hidden" name="_method" value="PATCH">
            @csrf
                @verbatim
                <div id="input_actual_other_cost">
                    <div class="box-body p-t-0">
                        <table id="cost-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Cost Type</th>
                                    <th style="width: 25%">Work Breakdown Structure</th>
                                    <th style="width: 15%">Planned Cost</th>
                                    <th style="width: 15%">Actual Cost</th>
                                    <th style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in costs">
                                    <td>{{ index + 1 }}</td>
                                    <td class="tdEllipsis">{{ data.cost_type }}</td>
                                    <td v-if="data.wbs_id != null" class="tdEllipsis">{{ data.wbs.number }} - {{ data.wbs.description }}</td>
                                    <td v-else class="tdEllipsis">-</td>
                                    <td class="tdEllipsis">Rp.{{ data.plan_cost }}</td>
                                    <td v-if="data.actual_cost != ''" class="tdEllipsis">Rp.{{ data.actual_cost }}</td>
                                    <td v-else class="tdEllipsis">-</td>
                                    <td class="p-l-0 textCenter">
                                        <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_cost">
                                            INPUT ACTUAL COST
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
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
                                            <div class="col-sm-12">
                                                <label for="cost_type" class="control-label">Cost Type</label>
                                                <input type="text" id="cost_type" v-model="editCost.cost_type" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <textarea id="description" v-model="editCost.description" class="form-control" rows="2" disabled></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="wbs" class="control-label">Work Breakdown Structure</label>
                                                <input type="text" id="wbs" v-model="editCost.wbs" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="cost" class="control-label">Plan Cost</label>
                                                <input type="text" id="cost" v-model="editCost.cost" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="actual_cost" class="control-label">Actual Cost</label>
                                                <input type="text" id="actual_cost" v-model="editCost.actual_cost" class="form-control" placeholder="Insert Actual Cost here...">
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
            </form>
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
    const form = document.querySelector('form#actual-cost');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        costs : "",
        works : [],
        newIndex : "", 
        cost_types : @json($cost_types),
        newCost : {
            description : "",
            cost : "",
            actual_cost : "",
            wbs_id : "",
            project_id : @json($project->id),
        },
        editCost : {
            cost_id : "",
            description : "",
            cost : "",
            actual_cost : "",
            wbs_id : "",
            wbs : "",
            project_id : @json($project->id),
            cost_type : "",
        },
        workSettings: {
            placeholder: 'Work (Optional)',
            plugins: ['dropdown_direction'],
            dropdownDirection : 'down',
        },
    };

    var vm = new Vue({
        el: '#input_actual_other_cost',
        data: data,
        computed:{
            updateOk: function(){
                let isOk = false;
                    if(this.editCost.actual_cost == null)
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
                if(data.wbs_id != null){
                    this.editCost.wbs_id = data.wbs_id;
                    this.editCost.wbs = data.wbs.number +' - '+ data.wbs.description;
                }else{
                    this.editCost.wbs = '-';
                }
                this.editCost.cost = data.plan_cost;
                this.editCost.actual_cost = data.actual_cost;
                this.editCost.cost_type = data.cost_type;
            },
            getCosts(){
            window.axios.get('/rap/getCostsApproved/'+this.newCost.project_id).then(({ data }) => {

                this.costs = data;
                this.costs.forEach(cost => {
                    cost.actual_cost = (cost.actual_cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");      
                    cost.plan_cost = (cost.plan_cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");   
                    this.cost_types.forEach(ct =>{
                        if(ct.id == cost.cost_type){
                            cost.cost_type = ct.name;
                        }
                    })   
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
            
            update(){            
                var editCost = this.editCost;   
                editCost.actual_cost = editCost.actual_cost.replace(/,/g , '');

                var url = "{{ route('rap.storeActualCost') }}";
                editCost = JSON.stringify(editCost);

                window.axios.put(url,editCost).then((response) => {
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
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        },
        watch : {
            'editCost.actual_cost': function(newValue) {
                var string_newValue = newValue+"";
                cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                Vue.nextTick(() => this.editCost.actual_cost = cost_string);
            },
        },
        created: function() {
            this.getCosts();
        },
    });
</script>
@endpush