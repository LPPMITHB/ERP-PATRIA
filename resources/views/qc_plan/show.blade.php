@extends('layouts.main')

@section('content-header')
@breadcrumb([
'title' => 'Show Quality Control Plan',
'items' => [
'Dashboard' => route('index'),
'Show All Project' => route('qc_plan.selectProject')
]
])
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
		@csrf
		@verbatim
        <div class="box">
            <div class="box-body">
                <div class="box-tools pull-right">
                    <a href="#" class="btn btn-primary btn-sm">EDIT</a>
                    <a class="btn btn-primary btn-sm" data-toggle="modal" href="#">VIEW WBS
                        IMAGES</a>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4 col-md-12">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        <div class="col-md-3 col-xs-4 no-padding">Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: $</b></div>
                        <div class="col-md-3 col-xs-4 no-padding">Owner</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: $</b></div>
                        <div class="col-md-3 col-xs-4 no-padding">Status</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: $</b></div>


                    </div>

                    <div class="col-xs-12 col-lg-4 col-md-12">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: $</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: $</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Deliverable</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="#"><b>: $</b></div>
                    </div>
                </div>
            </div>
            <div>
                <div id="index_qcTaskDetail" class="tab-pane active " id="general_info">
                    <table id="qctd-table" class="table table-bordered tableFixed m-b-0" style="width:100%">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th>QC Type</th>
                                <th>Role</th>
								<th>Configuration</th>
								<th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
							<tr>
								<!-- To-Do = Display previously existing qc plan info -->
                                <td></td>
                                <td></td>
                                <td></td>
								<td></td>
								<td></td>
                            </tr>
                        </tbody>
						<tfoot>
							<tr>
								<td></td>
								<td class="p-l-0 textLeft">
									<selectize :settings="typeSettings">
										<option v-for="(type, index) in qc_types" :value="type">{{ type }}</option>
									</selectize>
								</td>
								<td class="p-l-0 textLeft">
									<selectize :settings="roleSettings">
										<option v-for="(role, index) in qcp_roles" :value="role">{{ role }}</option>
									</selectize>
								</td>
								<td class="p-l-0 textLeft">
									<selectize :settings="configSettings">
										<option v-for="(config, index) in qcp_configs" :value="config">{{ config }}</option>
									</selectize>
								</td>
								<td class="p-l-0 textCenter"><a class="btn btn-primary btn-xs">ADD</a></td>
							</tr>
						</tfoot>
                    </table>
                </div>
            </div>
        </div>
		@endverbatim
    </div>
</div>

@endsection
@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
    var data = {
		// To-Do : Get Project and WBS Data
		// project : json_decode etc,
		// wbs : json_decode etc,
        qcp_roles : ["Internal", "Class", "Owner", "Regulator"],
		qcp_configs : ["Witness", "Review", "Etc"],
		qc_types : [],
		typeSettings : {
			placeholder : "Select QC Type",
		},
		roleSettings : {
			placeholder : "Select Role",
		},
		configSettings : {
			placeholder : "Select Configuration",
		},
    };

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'
        })
    })

    var vm = new Vue({
        el: '#index_qcTaskDetail',
        data: data,
        methods: {
            tooltipText: function(text) {
                return text
            },
            createRouteEdit(id) {
                var url = "/qc_task/" + id + "/edit";
                return url;
            },
        }
    });
</script>
@endpush
