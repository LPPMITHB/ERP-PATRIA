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
            <form id="actual-cost" class="form-horizontal" method="POST" action="{{ route('rap.updateApprovalProjectPlanOtherCost') }}">
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
                                    <td class="p-l-0 textCenter">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" @click.prevent="update(data.id)">APPROVE</button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
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

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        costs: @json($modelOtherCost),
        works: [],
        newIndex: "",
        status : 2,
        cost_id:"",
        project_id: @json($project -> id),
        cost_types: @json($cost_types),
        editCost: {
            project_id: @json($project -> id),
            cost_type: "",
            cost_id:"",
            status:"",
        },
    };

    var vm = new Vue({
        el: '#input_actual_other_cost',
        data: data,
        computed: {
            updateOk: function() {
                let isOk = false;
                return isOk;
            },
        },
        methods: {
            getCosts() {
                window.axios.get('/rap/getCostsPlanned/' + this.project_id).then(({
                    data
                }) => {
                    this.costs = data;
                    this.newIndex = Object.keys(this.costs).length + 1;
                    var dT = $('#cost-table').DataTable();
                    dT.destroy();
                    this.$nextTick(function() {
                        $('#cost-table').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': false,
                            'ordering': false,
                            'info': true,
                            'autoWidth': false,
                            'initComplete': function() {
                                $('div.overlay').remove();
                            },
                            columnDefs: [{
                                targets: 0,
                                sortable: false
                            }, ]
                        });
                    })
                });
            },
            update(id) {
                var editCost = this.editCost;
                this.editCost.cost_id = id;
                this.editCost.status = 2;

                var url = "{{ route('rap.updateApprovalProjectPlanOtherCost') }}";
                editCost = JSON.stringify(editCost);

                window.axios.put(url, editCost).then((response) => {
                        if (response.data.error != undefined) {
                            iziToast.warning({
                                displayMode: 'replace',
                                title: response.data.error,
                                position: 'topRight',
                            });
                        } else {
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
        created: function() {
            this.getCosts();
        },
    });
</script>
@endpush