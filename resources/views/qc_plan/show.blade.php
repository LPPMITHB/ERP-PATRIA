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
                        <div class="col-md-7 col-xs-8 no-padding"><b>:$</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Deliverable</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip"
                            title="#"><b>: $</b></div>


                    </div>
                </div>
            </div>

            <div class="box-body">

                <div id="index_qcTaskDetail" class="tab-pane active " id="general_info">
                    <table id="qctd-table" class="table table-bordered showTable nowrap" style="width:100%">
                        <thead>
                            <tr>
                                @foreach($qualityPlanTable as $qualityPlanTables)
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                <th>No</th>
                                @endforeach

                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(data,index) in qcTaskDetail">

                            </tr>
                            <tr>
                                @foreach($qualityPlanTable as $qualityPlanTables)
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>
                                <td>no</td>


                                @endforeach
                            </tr>
                        </tbody>
                        @verbatim
                    </table>
                    <div class="modal fade" id="show_modal_wbs_images">
                        <div class="modal-dialog modalPredecessor modalFull">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">View WBS Images</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="qctd-table" class="table table-bordered showTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 35%">File Name</th>
                                                        <th style="width: 45%">Description</th>
                                                        <th style="width: 4%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data,index) in wbsImages">
                                                        <td>{{ index + 1 }}</td>
                                                        <td class="tdEllipsis" data-container="body"
                                                            v-tooltip:top="tooltipText(data.drawing)">{{ data.drawing }}
                                                        </td>
                                                        <td class="tdEllipsis" data-container="body"
                                                            v-tooltip:top="tooltipText(data.description)">
                                                            {{ data.description }}</td>
                                                        <td>
                                                            <a class="btn btn-primary btn-sm"
                                                                :href="view(data.drawing)">VIEW</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endverbatim
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
        qcTaskDetail: null,
        wbsImages: null,
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
    $(document).ready(function() {
        $('#qctd-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'scrollX': true,
            'ordering': true,
            'info': true,
            'bFilter': true,
            'initComplete': function() {
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush