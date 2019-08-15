@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => "Manage Sub WBS Configuration",
        'items' => $array
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header no-padding">
                <div class="box-header p-b-0">
                    <div class="col-xs-12 col-lg-4 col-md-12 p-l-5">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Name</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->number}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Deliverable</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th width=5%>No</th>
                                <th width=20%>WBS</th>
                                <th width=25%>Description</th>
                                <th width=23%>Deliverables</th>
                                <th style="width: 11%">Duration</th>
                                <th width=27%></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.number)">{{ data.number }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td>{{ data.duration }} Day(s)</td>
                                <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="createSubWBSRoute(data)">
                                                MANAGE WBS
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="createActivity(data)">
                                                MANAGE ACTIVITY
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                                EDIT
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-danger btn-xs col-xs-12" @click="deleteWbs(data)" data-toggle="modal">
                                                DELETE
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="textLeft p-l-0">
                                    <textarea v-model="newSubWbsConfiguration.number" class="form-control width100" rows="2" name="number" placeholder="WBS"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWbsConfiguration.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWbsConfiguration.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWbsConfiguration.duration" rows="2" class="form-control width100" id="duration" name="duration" placeholder="Duration"></textarea>
                                </td>
                                <td class="text-center" >
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal fade" id="edit_wbs">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Work Breakdown Structures <b id="wbs_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row m-t-15">
                                        <div class="form-group col-sm-12">
                                            <label for="number" class="control-label">WBS</label>
                                            <input id="number" type="text" class="form-control" v-model="editWbsConfiguration.number" placeholder="Insert WBS Title here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbsConfiguration.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbsConfiguration.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="duration" class=" control-label">Duration</label>
                                            <input v-model="editWbsConfiguration.duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
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
    wbs : "",
    newIndex : "",
    newSubWbsConfiguration : {
        number : "",
        description : "",
        deliverables : "",
        wbs_configuration_id : @json($wbs->id),
        duration : "",
    },
    editWbsConfiguration : {
        wbs_configuration_id: "",
        number : "",
        description : "",
        deliverables : "",
        duration : "",
    },
    active_id : "",
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'
    })
})

var vm = new Vue({
    el: '#add_wbs',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newSubWbsConfiguration.number == ""
                || this.newSubWbsConfiguration.duration == ""
                || this.newSubWbsConfiguration.deliverables == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbsConfiguration.number == ""
                || this.editWbsConfiguration.duration == ""
                || this.editWbsConfiguration.deliverables == "")
                {
                    isOk = true;
                }
            return isOk;
        },
    },
    methods:{
        tooltipText: function(text) {
            return text
        },
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.nunber;
            this.editWbsConfiguration.wbs_configuration_id = data.id;
            this.active_id = data.id;
            this.editWbsConfiguration.number = data.number;
            this.editWbsConfiguration.description = data.description;
            this.editWbsConfiguration.deliverables = data.deliverables;
            this.editWbsConfiguration.duration = data.duration;
        },
        createSubWBSRoute(data){
            var url = "/wbs_repair/createSubWbsConfiguration/"+data.id;
            return url;
        },
        createActivity(data){
            var url = "/activity_repair/createActivityConfiguration/"+data.id;
            return url;
        },
        getSubWBS(){
            window.axios.get('/api/getSubWbsConfiguration/'+this.newSubWbsConfiguration.wbs_configuration_id).then(({ data }) => {
                this.wbs = data;
                this.newIndex = Object.keys(this.wbs).length+1;

                $('#wbs-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });
        },
        deleteWbs(data){
            var menuTemp = this.menu;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this WBS?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "/wbs_repair/deleteWbsConfiguration/"+data.id;
                        $('div.overlay').show();
                        window.axios.delete(url)
                        .then((response) => {
                            if(response.data.error != undefined){
                                response.data.error.forEach(error => {
                                    iziToast.warning({
                                        displayMode: 'replace',
                                        title: error,
                                        position: 'topRight',
                                    });
                                });
                                $('div.overlay').hide();
                            }else{
                                iziToast.success({
                                    displayMode: 'replace',
                                    title: response.data.response,
                                    position: 'topRight',
                                });
                                $('div.overlay').hide();
                                vm.getSubWBS();
                            }
                        })
                        .catch((error) => {
                            iziToast.warning({
                                displayMode: 'replace',
                                title: "Please try again.. ",
                                position: 'topRight',
                            });
                            console.log(error);
                            $('div.overlay').hide();
                        })

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },
        add(){
            var newSubWbsConfiguration = this.newSubWbsConfiguration;
            newSubWbsConfiguration = JSON.stringify(newSubWbsConfiguration);
            var url ="{{ route('wbs_repair.storeWbsConfiguration') }}";
            $('div.overlay').show();
            window.axios.post(url,newSubWbsConfiguration)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();
                }
                this.getSubWBS();
                this.newSubWbsConfiguration.number = "";
                this.newSubWbsConfiguration.description = "";
                this.newSubWbsConfiguration.deliverables = "";
                this.newSubWbsConfiguration.duration = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();
            })

        },
        update(){
            var editWbsConfiguration = this.editWbsConfiguration;
            var url = "";
            if(this.menu == "building"){
                var url = "/wbs/updateWbsConfiguration/"+editWbsConfiguration.wbs_configuration_id;
            }else{
                var url = "/wbs_repair/updateWbsConfiguration/"+editWbsConfiguration.wbs_configuration_id;
            }
            editWbsConfiguration = JSON.stringify(editWbsConfiguration);
            $('div.overlay').show();
            window.axios.put(url,editWbsConfiguration)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();
                }

                this.getSubWBS();
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();
            })

        }
    },
    watch: {
    },
    created: function() {
        this.getSubWBS();
    }
});
</script>
@endpush
