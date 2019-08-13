@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage WBS Configuration',
            'items' => [
                'Dashboard' => route('index'),
                'Create WBS Configuration' => route('wbs_repair.createWbsConfiguration'),
            ]
        ]
    )
    @endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <table id="wbs-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width=5%>No</th>
                                <th width=20%>WBS</th>
                                <th width=25%>Description</th>
                                <th width=23%>Deliverables</th>
                                <th style="width: 11%" v-if="!is_pami">Duration</th>
                                <th width=27%></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.number)">{{ data.number }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td v-if="!is_pami">{{ data.duration }} Day(s)</td>
                                <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="createSubWBS(data)">
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
                                <td class="p-l-0">
                                    <textarea v-model="newWbsConfiguration.number" class="form-control width100" rows="2" name="number" placeholder="WBS"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsConfiguration.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsConfiguration.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsConfiguration.duration" rows="2" class="form-control width100" id="duration" name="duration" placeholder="Duration"></textarea>
                                </td>
                                <td align="center" class="p-l-0">
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
                                    <div class="row">
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
    wbs : "",
    is_pami : @json($is_pami),
    newIndex : "",
    newWbsConfiguration : {
        number : "",
        description : "",
        deliverables : "",
        project_type : "",
        duration : "",
    },
    editWbsConfiguration : {
        wbs_id: "",
        number : "",
        description : "",
        deliverables : "",
        duration : "",
    },
    active_id : "",
    projectTypeSettings: {
        placeholder: 'Please Select Project Type'
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
    el: '#add_wbs',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newWbsConfiguration.number == ""
                || this.newWbsConfiguration.duration == ""
                || this.newWbsConfiguration.deliverables == "")
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
        deleteWbs(data){
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
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
                                vm.getWBSConfiguration();
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
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.number;
            this.editWbsConfiguration.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbsConfiguration.number = data.number;
            this.editWbsConfiguration.description = data.description;
            this.editWbsConfiguration.deliverables = data.deliverables;
            this.editWbsConfiguration.duration = data.duration;
        },
        createSubWBS(data){
            var url = "/wbs_repair/createSubWbsConfiguration/"+data.id;
            return url;
        },
        createActivity(data){
            var url = "/activity_repair/createActivityConfiguration/"+data.id;
            return url;
        },
        getWBSConfiguration(){
            window.axios.get('/api/getWbsConfiguration/').then(({ data }) => {
                this.wbs = data;
                this.newIndex = Object.keys(this.wbs).length+1;
                $('#wbs-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : false,
                    });
                })
            });
        },
        add(){
            var newWbsConfiguration = this.newWbsConfiguration;
            newWbsConfiguration = JSON.stringify(newWbsConfiguration);
            var url = "{{ route('wbs_repair.storeWbsConfiguration') }}";
            $('div.overlay').show();
            window.axios.post(url,newWbsConfiguration)
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

                this.getWBSConfiguration();
                this.newWbsConfiguration.number = "";
                this.newWbsConfiguration.description = "";
                this.newWbsConfiguration.deliverables = "";
                this.newWbsConfiguration.duration = "";
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
                var url = "/wbs/updateWbsConfiguration/"+editWbsConfiguration.wbs_id;
            }else{
                var url = "/wbs_repair/updateWbsConfiguration/"+editWbsConfiguration.wbs_id;
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

                this.getWBSConfiguration();
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

        }
    },
    watch : {
        // 'editWbsConfiguration.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsConfiguration.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsConfiguration.process_cost_string = process_cost_string);
        // },
        // 'editWbsConfiguration.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsConfiguration.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsConfiguration.other_cost_string = other_cost_string);
        // },
    },
    created: function() {
        this.getWBSConfiguration();
    },

});
</script>
@endpush
