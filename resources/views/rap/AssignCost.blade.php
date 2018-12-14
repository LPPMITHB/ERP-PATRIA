@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Assign Cost » '.$project->name,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.selectProjectAssignCost'),
            'Assign Cost' => ""
        ]
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-sm-6">
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
                                <td>Start Date</td>
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
                                <td>End Date</td>
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
            @verbatim
            <div id="create_cost">
                <div class="box-body">
                    <h4 class="box-title">List of Costs</h4>
                    <table id="cost-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Type</th>
                                <th width="30%">Description</th>
                                <th width="20%">Cost</th>
                                <th width="10%">Status</th>
                                <th width="25%">Work</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cost,index) in costs">
                                <td>{{ index + 1 }}</td>
                                <td v-if="cost.type == 0">{{ 'Other Cost' }}</td>
                                <td v-else>{{ 'Process Cost' }}</td>
                                <td class="tdEllipsis">{{ cost.description }}</td>
                                <td class="tdEllipsis">Rp.{{ cost.cost }}</td>
                                <template v-if="cost.wbs_id == null">
                                    <td>{{ "Not Assigned" }}</td>
                                </template>
                                <template v-else>
                                    <td>{{ "Assigned" }}</td>
                                </template>
                                <td class="no-padding">
                                    <selectize v-model="cost.wbs_id" :id="index" :settings="workSettings">
                                        <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                    </selectize>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endverbatim
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

    function getNewCost(project_id){
        window.axios.get('/api/getNewCost/'+project_id).then(({ data }) => {
            this.data.costs = data;
            var data = this.data.costs;
            data.forEach(cost => {
                cost.cost = (cost.cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        });
    }

    function save(wbs_id,index){
        var costs = this.data.costs;
        var cost_id = costs[index].id;
        var data = {
            cost_id : cost_id,
            wbs_id : wbs_id
        }
        $('div.overlay').show();
        data = JSON.stringify(data);
        var url = "{{ route('rap.storeAssignCost') }}";
        window.axios.patch(url,data).then((response) => {
            getNewCost(response.data.project_id);

            iziToast.success({
                title: 'Success Assign Cost !',
                position: 'topRight',
                displayMode: 'replace'
            });
        })
        .catch((error) => {
            iziToast.warning({
                title: 'Please Try Again..',
                position: 'topRight',
                displayMode: 'replace'
            });
            console.log(error);
            $('div.overlay').hide();
        })
        $('div.overlay').hide();
    }
    
    var data = {
        costs : @json($costs),
        works : [],
        workSettings: {
            placeholder: 'Work (Optional)',
            plugins: ['dropdown_direction'],
            dropdownDirection : 'down',
            onChange : function(id){
                var wbs_id = id;
                var obj = $(this)[0];
                var index = obj.$input["0"].id;
                save(wbs_id,index);
            }
        },
    };

    var vm = new Vue({
        el: '#create_cost',
        data: data,
        methods:{
            getWorks(){
                window.axios.get('/project/getAllWorks/'+this.costs[0].project_id).then(({ data }) => {
                    this.works = data;
                });
            },
        },
        created: function() {
            this.getWorks();
            var data = this.costs;
            data.forEach(cost => {
                cost.cost = (cost.cost+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
    });


</script>
@endpush