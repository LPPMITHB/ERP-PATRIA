@extends('layouts.main')
@section('content-header')
    @if($menu == "building")
        @breadcrumb(
            [
                'title' => 'Manage WBS Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create WBS Profile' => route('wbs.createWbsProfile'),
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Manage WBS Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create WBS Profile' => route('wbs_repair.createWbsProfile'),
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
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <div class="col-xs-12 col-md-4 p-l-0">
                        <label for="" >Project Type</label>
                        <selectize v-model="newWbsProfile.project_type" :settings="projectTypeSettings">
                            <option v-for="(project_type, index) in project_types" :value="project_type.id">{{ project_type.name }}</option>
                        </selectize>  
                    </div>
                    <div v-show="newWbsProfile.project_type != ''" >
                        <table id="wbs-table" class="table table-bordered tableFixed">
                            <thead>
                                <tr>
                                    <th width=5%>No</th>
                                    <th width=20%>Number</th>
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
                                                <a class="btn btn-primary btn-xs col-xs-12" :href="createBom(data.id)">
                                                    MANAGE BOM
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                <a class="btn btn-primary btn-xs col-xs-12" :href="createResource(data.id)">
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
                                        <textarea v-model="newWbsProfile.number" class="form-control width100" rows="2" name="number" placeholder="Number"></textarea>
                                    </td>
                                    <td class="p-l-0">
                                        <textarea v-model="newWbsProfile.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                    </td>
                                    <td class="p-l-0">
                                        <textarea v-model="newWbsProfile.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                    </td>
                                    <td class="p-l-0">
                                        <textarea v-model="newWbsProfile.duration" rows="2" class="form-control width100" id="duration" name="duration" placeholder="Duration"></textarea>                                        
                                    </td>
                                    <td align="center" class="p-l-0">
                                        <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                                            <label for="number" class="control-label">Number</label>
                                            <input id="number" type="text" class="form-control" v-model="editWbsProfile.number" placeholder="Insert Number here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbsProfile.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbsProfile.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="duration" class=" control-label">Duration</label>
                                            <input v-model="editWbsProfile.duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >               
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
    menu : @json($menu),
    project_types : @json($project_type),
    wbs : "",
    newIndex : "",
    newWbsProfile : {
        number : "",
        description : "",
        deliverables : "",
        project_type : "",
        duration : "",
    },
    editWbsProfile : {
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
                if(this.newWbsProfile.number == ""
                || this.newWbsProfile.duration == ""
                || this.newWbsProfile.deliverables == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbsProfile.number == ""
                || this.editWbsProfile.duration == ""
                || this.editWbsProfile.deliverables == "")
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
            var menuTemp = this.menu;
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
                        var url = "";
                        if(menuTemp == "building"){
                            url = "/wbs/"+data.id;
                        }else{
                            url = "/wbs_repair/"+data.id;
                        }
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
                                vm.getWBSProfile();
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
            this.editWbsProfile.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbsProfile.number = data.number;
            this.editWbsProfile.description = data.description;
            this.editWbsProfile.deliverables = data.deliverables;
            this.editWbsProfile.duration = data.duration;
        },
        createSubWBS(data){
            var url = "";
            if(this.menu == "building"){
                url = "/wbs/createSubWbsProfile/"+data.id;
            }else{
                url = "/wbs_repair/createSubWbsProfile/"+data.id;                
            }
            return url;
        },
        createActivity(data){
            var url = "";
            if(this.menu == "building"){
                url = "/activity/createActivityProfile/"+data.id;
            }else{
                url = "/activity_repair/createActivityProfile/"+data.id;                
            }
            return url;
        },
        createBom(id){
            var url = "";
            if(this.menu == "building"){
                url = "/wbs/createBomProfile/"+id;
            }else{
                url = "/wbs_repair/createBomProfile/"+id;                
            }
            return url;
        },
        createResource(id){
            var url = "";
            if(this.menu == "building"){
                url = "/wbs/createResourceProfile/"+id;
            }else{
                url = "/wbs_repair/createResourceProfile/"+id;  
            }
            return url;
        },              
        getWBSProfile(){
            window.axios.get('/api/getWbsProfile/'+this.menu+'/'+this.newWbsProfile.project_type).then(({ data }) => {
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
            var newWbsProfile = this.newWbsProfile;
            newWbsProfile = JSON.stringify(newWbsProfile);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('wbs.storeWbsProfile') }}";
            }else{
                url = "{{ route('wbs_repair.storeWbsProfile') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,newWbsProfile)
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
                
                this.getWBSProfile();
                this.newWbsProfile.number = "";
                this.newWbsProfile.description = "";
                this.newWbsProfile.deliverables = "";
                this.newWbsProfile.duration = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        update(){            
            var editWbsProfile = this.editWbsProfile;    
            var url = "";
            if(this.menu == "building"){
                var url = "/wbs/updateWbsProfile/"+editWbsProfile.wbs_id;                
            }else{
                var url = "/wbs_repair/updateWbsProfile/"+editWbsProfile.wbs_id;                
            }        
            editWbsProfile = JSON.stringify(editWbsProfile);
            $('div.overlay').show();            
            window.axios.put(url,editWbsProfile)
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
                
                this.getWBSProfile();   
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
        'newWbsProfile.project_type' : function(newValue){
            if(newValue != ""){
                this.getWBSProfile();
            }
        },
        // 'editWbsProfile.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsProfile.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsProfile.process_cost_string = process_cost_string);
        // },
        // 'editWbsProfile.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbsProfile.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbsProfile.other_cost_string = other_cost_string);
        // },
    },
    created: function() {
        // this.getWBSProfile();
    },
    
});
</script>
@endpush