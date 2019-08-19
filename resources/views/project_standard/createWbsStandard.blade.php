@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage WBS Standard',
            'items' => [
                'Dashboard' => route('index'),
                'Project Standard |'.$project_standard->name => route('project_standard.createProjectStandard'),
                'Create WBS Standard' => route('project_standard.createWbsStandard',$project_standard->id),
            ]
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
                        <div class="col-sm-12 no-padding"><b>Project Standard Information</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Ship Type</div>
                        <div class="col-md-7 col-xs-8 no-padding" data-container="body" data-toggle="tooltip" title="{{$project_standard->ship->type}}"><b>: {{$project_standard->ship->type}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Name</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project_standard->name}}"><b>: {{$project_standard->name}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding" data-container="body" data-toggle="tooltip" title="{{$project_standard->description}}"><b>: {{$project_standard->description}}</b></div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="add_wbs_standard">
                <div class="box-body">
                    <table id="wbs-standard-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width=5%>No</th>
                                <th width=20%>WBS</th>
                                <th width=25%>Description</th>
                                <th width=23%>Deliverables</th>
                                <th width=10%>Duration</th>
                                <th width=25%></th>
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
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="manageSubWBS(data)">
                                                MANAGE WBS
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="manageActivity(data)">
                                                MANAGE ACTIVITY
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="manageMaterial(data)">
                                                MANAGE MATERIAL
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="manageActivity(data)">
                                                MANAGE RESOURCE
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
                                    <textarea v-model="newWbsStandard.number" class="form-control width100" rows="2" name="number" placeholder="WBS"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsStandard.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsStandard.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsStandard.duration" rows="2" class="form-control width100" id="duration" name="duration" placeholder="Duration"></textarea>
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
                                            <input id="number" type="text" class="form-control" v-model="editWbsStandard.number" placeholder="Insert WBS Title here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbsStandard.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbsStandard.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="duration" class=" control-label">Duration</label>
                                            <input v-model="editWbsStandard.duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >
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
    project_standard : @json($project_standard),
    wbs : "",
    newIndex : "",
    newWbsStandard : {
        project_standard_id : @json($project_standard->id),
        number : "",
        description : "",
        deliverables : "",
        duration : "",
    },
    editWbsStandard : {
        wbs_id: "",
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
    el: '#add_wbs_standard',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newWbsStandard.number == ""
                || this.newWbsStandard.duration == ""
                || this.newWbsStandard.deliverables == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbsStandard.number == ""
                || this.editWbsStandard.duration == ""
                || this.editWbsStandard.deliverables == "")
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
                        var url = "/project_standard/deleteWbsStandard/"+data.id;
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
                                vm.getWBSStandard();
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
            this.editWbsStandard.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbsStandard.number = data.number;
            this.editWbsStandard.description = data.description;
            this.editWbsStandard.deliverables = data.deliverables;
            this.editWbsStandard.duration = data.duration;
        },
        manageSubWBS(data){
            var url = "/project_standard/createSubWbsStandard/"+data.id;
            return url;
        },
        manageActivity(data){
            var url = "/project_standard/createActivityStandard/"+data.id;
            return url;
        },
        manageMaterial(data){
            var url = "/project_standard/manageMaterial/"+data.id;
            return url;
        },
        getWBSStandard(){
            window.axios.get('/api/getWbsStandard/'+this.project_standard.id).then(({ data }) => {
                this.wbs = data;
                this.newIndex = Object.keys(this.wbs).length+1;
                $('#wbs-standard-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-standard-table').DataTable({
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
            var newWbsStandard = this.newWbsStandard;
            newWbsStandard = JSON.stringify(newWbsStandard);
            var url = "{{ route('project_standard.storeWbsStandard') }}";
            $('div.overlay').show();
            window.axios.post(url,newWbsStandard)
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

                this.getWBSStandard();
                this.newWbsStandard.number = "";
                this.newWbsStandard.description = "";
                this.newWbsStandard.deliverables = "";
                this.newWbsStandard.duration = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();
            })

        },
        update(){
            var editWbsStandard = this.editWbsStandard;
            var url = "";
            if(this.menu == "building"){
                var url = "/wbs/updateWbsStandard/"+editWbsStandard.wbs_id;
            }else{
                var url = "/project_standard/updateWbsStandard/"+editWbsStandard.wbs_id;
            }
            editWbsStandard = JSON.stringify(editWbsStandard);
            $('div.overlay').show();
            window.axios.put(url,editWbsStandard)
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

                this.getWBSStandard();
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
        // 'editWbsStandard.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsStandard.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsStandard.process_cost_string = process_cost_string);
        // },
        // 'editWbsStandard.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsStandard.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsStandard.other_cost_string = other_cost_string);
        // },
    },
    created: function() {
        this.getWBSStandard();
    },

});
</script>
@endpush
