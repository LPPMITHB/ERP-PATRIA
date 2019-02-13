@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => "Create Sub WBS Profile",
        'items' => $array
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="box-header">
                    <div class="col-xs-12 col-lg-4 col-md-12">    
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Name</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->name}}</b></div>
                        
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
                    <h4 class="box-title">Sub WBS Profiles</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 4%">No</th>
                                <th style="width: 17%">Name</th>
                                <th style="width: 17%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 17%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createSubWBSRoute(data)">
                                        ADD WBS
                                    </a>
                                    <a class="btn btn-primary btn-xs" :href="createActivity(data)">
                                        ADD ACTIVITY
                                    </a>
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="textLeft p-l-0">
                                    <textarea v-model="newSubWbsProfile.name" class="form-control width100" rows="2" name="name" placeholder="Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWbsProfile.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWbsProfile.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
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
    menu : @json($menu),
    wbs : "",
    newIndex : "", 
    newSubWbsProfile : {
        name : "",
        description : "",
        deliverables : "",
        wbs_profile_id : @json($wbs->id),
    },
    editWbsProfile : {
        wbs_profile_id: "",
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
                if(this.newSubWbsProfile.name == ""
                || this.newSubWbsProfile.deliverables == "")
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
        // updateOk: function(){
        //     let isOk = false;
        //         if(this.dataUpd.uom_id == ""
        //         || this.dataUpd.standard_price.replace(/,/g , '') < 1)
        //         {
        //             isOk = true;
        //         }
        //     return isOk;
        // },

    }, 
    methods:{
        tooltipText: function(text) {
            return text
        },
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWbsProfile.wbs_profile_id = data.id;
            this.active_id = data.id;
            this.editWbsProfile.name = data.name;
            this.editWbsProfile.description = data.description;
            this.editWbsProfile.deliverables = data.deliverables;
        },
        createSubWBSRoute(data){
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
        getSubWBS(){
            window.axios.get('/api/getSubWbsProfile/'+this.newSubWbsProfile.wbs_profile_id).then(({ data }) => {
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
        add(){            
            var newSubWbsProfile = this.newSubWbsProfile;
            newSubWbsProfile = JSON.stringify(newSubWbsProfile);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('wbs.storeWbsProfile') }}";
            }else{
                url = "{{ route('wbs_repair.storeWbsProfile') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,newSubWbsProfile)
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
                this.newSubWbsProfile.name = "";
                this.newSubWbsProfile.description = "";
                this.newSubWbsProfile.deliverables = "";
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
                var url = "/wbs/updateWbsProfile/"+editWbsProfile.wbs_profile_id;                
            }else{
                var url = "/wbs_repair/updateWbsProfile/"+editWbsProfile.wbs_profile_id;                
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