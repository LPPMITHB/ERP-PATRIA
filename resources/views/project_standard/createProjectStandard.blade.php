@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Project Standard',
            'items' => [
                'Dashboard' => route('index'),
                'Create Project Standard' => route('project_standard.createProjectStandard'),
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
            <div id="add_project_standard">
                <div class="box-body">
                    <table id="project-standard-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width=5%>No</th>
                                <th width=20%>Ship Type</th>
                                <th width=25%>Name</th>
                                <th width=35%>Description</th>
                                <th width=15%></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in project">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.ship.type)">{{ data.ship.type }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="manageWbs(data)">
                                                MANAGE WBS
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" @click="openEditModal(data)" data-toggle="modal" href="#edit_project">
                                                EDIT
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-danger btn-xs col-xs-12" @click="deleteProjectStandard(data)" data-toggle="modal">
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
                                    <selectize v-model="newProjectStandard.shipType" :settings="shipTypeSettings">
                                        <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newProjectStandard.name" class="form-control width100" rows="2" name="name" placeholder="Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newProjectStandard.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td align="center" class="p-l-0">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal fade" id="edit_project">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Project <b id="project_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="number" class="control-label">Ship Type</label>
                                            <selectize v-model="editProjectStandard.shipType" :settings="shipTypeSettings">
                                                <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                            </selectize>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="name" class="control-label">Name</label>
                                            <textarea id="name" v-model="editProjectStandard.name" class="form-control" rows="2" placeholder="Insert Name here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editProjectStandard.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
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
    project : "",
    ships : @json($ships),
    newIndex : "",
    newProjectStandard : {
        shipType : "",
        name : "",
        description : "",
    },
    editProjectStandard : {
        project_standard_id: "",
        shipType : "",
        name : "",
        description : "",
    },
    active_id : "",
    shipTypeSettings: {
        placeholder: 'Please Select Ship Type'
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
    el: '#add_project_standard',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newProjectStandard.shipType == ""
                || this.newProjectStandard.name == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editProjectStandard.shipType == ""
                || this.editProjectStandard.name == "")
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
        deleteProjectStandard(data){
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this Project Standard?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "/project_standard/deleteProjectStandard/"+data.id;
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
                                vm.getProjectStandard();
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
            document.getElementById("project_code").innerHTML= data.number;
            this.editProjectStandard.project_id = data.id;
            this.active_id = data.id;
            this.editProjectStandard.shipType = data.ship_id;
            this.editProjectStandard.name = data.name;
            this.editProjectStandard.description = data.description;
        },
        manageWbs(data){
            var url = "/project_standard/createWbsStandard/"+data.id;
            return url;
        },
        getProjectStandard(){
            window.axios.get('/api/getProjectStandard/').then(({ data }) => {
                this.project = data;
                this.newIndex = Object.keys(this.project).length+1;
                $('#project-standard-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#project-standard-table').DataTable({
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
            var newProjectStandard = this.newProjectStandard;
            newProjectStandard = JSON.stringify(newProjectStandard);
            var url = "{{ route('project_standard.storeProjectStandard') }}";
            $('div.overlay').show();
            window.axios.post(url,newProjectStandard)
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

                this.getProjectStandard();
                this.newProjectStandard.shipType = "";
                this.newProjectStandard.name = "";
                this.newProjectStandard.description = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();
            })

        },
        update(){
            var editProjectStandard = this.editProjectStandard;
            var url = "";
            if(this.menu == "building"){
                var url = "/project/updateProjectStandard/"+editProjectStandard.project_id;
            }else{
                var url = "/project_standard/updateProjectStandard/"+editProjectStandard.project_id;
            }
            editProjectStandard = JSON.stringify(editProjectStandard);
            $('div.overlay').show();
            window.axios.put(url,editProjectStandard)
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

                this.getProjectStandard();
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
        // 'editProjectStandard.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editProjectStandard.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editProjectStandard.process_cost_string = process_cost_string);
        // },
        // 'editProjectStandard.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editProjectStandard.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editProjectStandard.other_cost_string = other_cost_string);
        // },
    },
    created: function() {
        this.getProjectStandard();
    },

});
</script>
@endpush
