@extends('layouts.main')
@section('content-header')
    @if ($menu == "building")
        @if($wbs->wbs != null)
            @breadcrumb(
                [
                    'title' => "Manage Activities",
                    'items' => [
                        'Dashboard' => route('index'),
                        $wbs->name => route('wbs.createSubWbsProfile', $wbs->wbs->id),
                        "Manage Activities" => ""
                    ]
                ]
            )
            @endbreadcrumb
        @else
            @breadcrumb(
                [
                    'title' => "Manage Activities",
                    'items' => [
                        'Dashboard' => route('index'),
                        $wbs->name => route('wbs.createWbsProfile'),
                        "Manage Activities" => ""
                    ]
                ]
            )
            @endbreadcrumb
        @endif
    @else
        @if($wbs->wbs != null)
            @breadcrumb(
                [
                    'title' => "Manage Activities",
                    'items' => [
                        'Dashboard' => route('index'),
                        $wbs->name => route('wbs_repair.createSubWbsProfile', $wbs->wbs->id)
                    ]
                ]
            )
            @endbreadcrumb
        @else
            @breadcrumb(
                [
                    'title' => "Manage Activities",
                    'items' => [
                        'Dashboard' => route('index'),
                        $wbs->name => route('wbs_repair.createWbsProfile')
                    ]
                ]
            )
            @endbreadcrumb
        @endif
    @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header no-padding">
                <div class="box-header p-b-0">
                    <div class="col-xs-12 col-lg-4 col-md-12 p-l-5">    
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
            <div id="add_activity">
                <div class="box-body">
                    <table id="activity-table" class="table table-bordered" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 50%">Description</th>
                                <th style="width: 11%">Duration</th>
                                <th style="width: 14%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td>{{ data.duration }} Day(s)</td>
                                <td class="textCenter p-l-0 p-r-0">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_activity"  @click="openModalEditActivity(data)">EDIT</button>
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
                                    <textarea v-model="newActivityProfile.name" class="form-control width100" rows="3" id="name" name="name" placeholder="Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newActivityProfile.description" class="form-control width100" rows="3" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newActivityProfile.duration" rows="3" class="form-control width100" id="duration" name="duration" placeholder="Duration"></textarea>                                        
                                </td>
                                <td class="textCenter p-l-0">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal fade" id="edit_activity">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Activity <b id="edit_activity_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="p-l-0 form-group col-sm-12">
                                        <label for="name" class="control-label">Name</label>
                                        <textarea id="name" v-model="editActivityProfile.name" class="form-control" rows="2" placeholder="Insert Name Here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group col-sm-12">
                                        <label for="description" class=" control-label">Description</label>
                                        <textarea id="description" v-model="editActivityProfile.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group col-sm-12">
                                        <label for="duration" class=" control-label">Duration</label>
                                        <input v-model="editActivityProfile.duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >               
                                    </div>                             
                                </div>
                                <div class="modal-footer">
                                    <button :disabled="updateOk" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
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
    activities :[],
    newIndex : "",
    newActivityProfile : {
        name : "",
        description : "",
        duration : "",
        wbs_id : @json($wbs->id), 
    },
    editActivityProfile : {
        activity_id : "",
        name : "",
        description : "",
        duration : "",
        latest_predecessor : "",
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
    el: '#add_activity',
    data: data,
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newActivityProfile.name == ""
                || this.newActivityProfile.duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editActivityProfile.name == ""
                || this.editActivityProfile.duration == "")
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
        openModalEditActivity(data){
            window.axios.get('/api/getAllActivitiesEdit/'+this.project_id+'/'+data.id).then(({ data }) => {
                this.allActivitiesEdit = data;
            });
            document.getElementById("edit_activity_code").innerHTML= data.code;
            this.editActivityProfile.activity_id = data.id;
            this.editActivityProfile.name = data.name;
            this.editActivityProfile.description = data.description;
            this.editActivityProfile.duration  = data.duration;
        },
        getActivities(){
            window.axios.get('/api/getActivitiesProfile/'+this.newActivityProfile.wbs_id).then(({ data }) => {
                this.activities = data;
                this.newIndex = Object.keys(this.activities).length+1;

                $('#activity-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#activity-table').DataTable({
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
            var deleted = false;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this Activity?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "";
                        if(menuTemp == "building"){
                            url = "/activity/"+data.id;
                        }else{
                            url = "/activity_repair/"+data.id;
                        }
                        $('div.overlay').show();            
                        window.axios.delete(url)
                        .then((response) => {
                            if(response.data.error != undefined){
                                iziToast.warning({
                                    displayMode: 'replace',
                                    title: error,
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
                                vm.getActivities();
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
            this.newActivityProfile.duration = parseInt((this.newActivityProfile.duration+"").replace(/,/g , ''));
            var newActivityProfile = this.newActivityProfile;
            newActivityProfile = JSON.stringify(newActivityProfile);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('activity.storeActivityProfile') }}";
            }else{
                url = "{{ route('activity_repair.storeActivityProfile') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,newActivityProfile)
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
                    this.getActivities();  
                    this.newActivityProfile.name = "";
                    this.newActivityProfile.description = "";
                    this.newActivityProfile.duration = "";                
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

        },
        update(){            
            var editActivityProfile = this.editActivityProfile;
            var url = "";
            if(this.menu == "building"){
                var url = "/activity/updateActivityProfile/"+editActivityProfile.activity_id;
            }else{
                var url = "/activity_repair/updateActivityProfile/"+editActivityProfile.activity_id;
            }
            editActivityProfile = JSON.stringify(editActivityProfile);
            $('div.overlay').show();            
            window.axios.put(url,editActivityProfile)
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
                this.getActivities();
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

        },
    },
    watch: {
        newActivityProfile:{
            handler: function(newValue) {
            },
            deep: true
        },
        'newActivityProfile.duration':function(newValue){
            this.newActivityProfile.duration = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
        }
    },
    created: function() {
        this.getActivities();
    }
});


function roundNumber(num, scale) {
  if(!("" + num).includes("e")) {
    return +(Math.round(num + "e+" + scale)  + "e-" + scale);
  } else {
    var arr = ("" + num).split("e");
    var sig = ""
    if(+arr[1] + scale > 0) {
      sig = "+";
    }
    return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
  }
}
</script>
@endpush