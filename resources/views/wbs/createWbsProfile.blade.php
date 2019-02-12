@extends('layouts.main')
@section('content-header')
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
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <h4 class="box-title">WBS Profiles</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed pxTable" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th style="width: 2px">No</th>
                                <th style="width: 17%">Name</th>
                                <th style="width: 17%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 125px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createSubWBS(data)">
                                        MANAGE WBS
                                    </a>
                                    <a class="btn btn-primary btn-xs" :href="createActivity(data)">
                                        MANAGE ACTIVITY
                                    </a>
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteWbs(data)" data-toggle="modal">
                                        DELETE
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <input v-model="newWbsProfile.name" type="text" class="form-control width100" id="name" name="name" placeholder="Name">
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsProfile.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWbsProfile.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
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
                                            <label for="name" class="control-label">Name</label>
                                            <input id="name" type="text" class="form-control" v-model="editWbsProfile.name" placeholder="Insert Name here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbsProfile.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbsProfile.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
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
    wbs : "",
    newIndex : "",
    newWbsProfile : {
        name : "",
        description : "",
        deliverables : "",
    },
    editWbsProfile : {
        wbs_id: "",
        name : "",
        description : "",
        deliverables : "",
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
                if(this.newWbsProfile.name == ""
                || this.newWbsProfile.deliverables == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbsProfile.name == ""
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
            var deleted = false;
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
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWbsProfile.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbsProfile.name = data.name;
            this.editWbsProfile.description = data.description;
            this.editWbsProfile.deliverables = data.deliverables;
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
        getWBSProfile(){
            window.axios.get('/api/getWbsProfile').then(({ data }) => {
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
                this.newWbsProfile.name = "";
                this.newWbsProfile.description = "";
                this.newWbsProfile.deliverables = "";
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
        this.getWBSProfile();
    },
    
});
</script>
@endpush