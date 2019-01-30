@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Issue Resources',
        'items' => [
            'Dashboard' => route('index'),
            'Issue Resources' => route('resource.assignResource'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route=="/resource")
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('resource.storeIssue') }}">
                @elseif($route == "/resource_repair")
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('resource_repair.storeIssue') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="assignRsc">
                        <div class="row">
                            <div class="col-sm-4 col-md-4" style="margin-left: -15px">
                                <div class="col-sm-12">
                                    <label for="">Issue Description</label>
                                </div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table id="assign-rsc" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 25%">Resource</th>
                                            <th style="width: 25%">Resource Detail</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in modelIssued">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ data.resource_name }}</td>
                                            <td>{{ data.resource_detail_name }}</td>
                                            <td >{{ "IDLE" }}</td>
                                            <td class="p-l-3 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td class="p-l-10">{{newIndex}}</td>
                                        <td class="p-l-0 textLeft">
                                            <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                            </selectize>
                                        </td>
                                        <td class="p-l-0 textLeft" v-show="dataInput.resource_id == ''">
                                            <selectize disabled :settings="nullResourceDetailSettings">
                                            </selectize>
                                        </td>
                                        <td class="p-l-0 textLeft" v-show="modelResourceDetails.length == 0 && dataInput.resource_id != ''">
                                            <selectize disabled :settings="emptyResourceDetailSettings">
                                            </selectize>
                                        </td>
                                        <td class="p-l-0 textLeft" v-show="modelResourceDetails.length > 0">
                                            <selectize v-model="dataInput.resource_detail_id" :settings="resourceDetailSettings">
                                                <option v-for="(resource_detail,index) in modelResourceDetails" :value="resource_detail.id">[{{ resource_detail.code }}] {{ resource_detail.brand }}</option>
                                            </selectize>
                                        </td>
                                        <td>
                                            {{ status }}
                                        </td>
                                        <td class="p-l-0 textCenter">
                                            <button @click.prevent="add" :disabled="addOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Assign Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="control-label">Resource</label>
                                                <selectize v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.resource_id == ''">
                                                <label class="control-label">Resource Detail</label>
                                                <selectize disabled :settings="nullResourceDetailSettings">
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="modelResourceDetailsEdit.length == 0 && editInput.resource_id != ''">
                                                <label class="control-label">Resource Detail</label>
                                                <selectize disabled :settings="emptyResourceDetailSettings">
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="modelResourceDetailsEdit.length > 0">
                                                <label class="control-label">Resource Detail</label>
                                                <selectize v-model="editInput.resource_detail_id" :settings="resourceDetailSettings">
                                                    <option v-for="(resource_detail,index) in modelResourceDetailsEdit" :value="resource_detail.id">[{{ resource_detail.code }}] {{ resource_detail.brand }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="control-label">Status</label>
                                                <input disabled type="text" class="form-control" v-model="statusEdit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-gi');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelResources : @json($resources),
        modelResourceDetails : [],
        modelResourceDetailsEdit : [],
        statusResourceDetails : true,
        statusResourceDetailsEdit : true,
        description : "",
        status : "",
        statusEdit : "IDLE",
        modelIssued : [],
        newIndex : 0,
        dataInput : {
            resource_id :"",
            resource_name : "",
            resource_detail_id : "",
            resource_detail_name : ""
        },
        editInput : {
            resource_id :"",
            old_resource_id : "",
            resource_name : "",
            resource_detail_id : "",
            resource_detail_name : "",
        },
        submittedForm:{},
        activeIndex : "",
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        resourceDetailSettings: {
            placeholder: 'Please Select Resource'
        },
        nullResourceDetailSettings: {
            placeholder: 'Please Select Resource First'
        },
        emptyResourceDetailSettings: {
            placeholder: "This Resource doesn't have resource detail"
        },
    }

    var vm = new Vue({
        el : '#assignRsc',
        data : data,

        computed : {
            createOk: function(){
                let isOk = false;

                if(this.modelIssued.length == 0){
                    isOk = true;
                }

                return isOk;
            },
            addOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == "" || this.dataInput.resource_detail_id == "" || this.statusResourceDetails){
                    isOk = true;
                }

                return isOk;
            },

            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.resource_detail_id == "" || this.statusResourceDetailsEdit){
                    isOk = true;
                }

                return isOk;
            }
        },

        methods : {
            add(){
                $('div.overlay').show();
                var temp_data = JSON.stringify(this.dataInput);
                temp_data = JSON.parse(temp_data);
                this.modelIssued.push(temp_data);

                this.dataInput.resource_id = "";
                this.dataInput.resource_name = "";
                this.dataInput.resource_detail_id = "";
                this.dataInput.resource_detail_name = "";
                this.status = "";

                this.newIndex = this.modelIssued.length + 1;
                $('div.overlay').hide();

            },
            removeRow(index){
                this.modelIssued.splice(index, 1);                
                this.newIndex = this.modelIssued.length + 1;
            },
            openEditModal(data,index){
                this.editInput.resource_id = data.resource_id;
                this.editInput.old_resource_id = data.resource_id;
                this.editInput.resource_detail_id = data.resource_detail_id;
                this.activeIndex = index;
            }, 
            update(){
                $('div.overlay').show();
                var updatedData = this.modelIssued[this.activeIndex];
                updatedData.resource_id = this.editInput.resource_id;
                updatedData.resource_name = this.editInput.resource_name;
                updatedData.resource_detail_id = this.editInput.resource_detail_id;
                updatedData.resource_detail_name = this.editInput.resource_detail_name;
                
                $('div.overlay').hide();
            },
            submitForm(){
                this.submittedForm.description = this.description;
                this.submittedForm.resources = this.modelIssued;    

                console.log(JSON.stringify(this.submittedForm));
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch : {
            'dataInput.resource_id' : function(newValue){
                $('div.overlay').show();
                this.modelResourceDetails = [];
                var toast = document.querySelector('.iziToast'); // Selector of your toast    
                if(toast != null){
                    iziToast.hide({
                        transitionOut: 'fadeOutUp'
                    }, toast);
                }   
                
                if(newValue != ""){
                    this.modelResources.forEach(resource => {
                        if(resource.id == newValue){
                            this.dataInput.resource_name = resource.code+" - "+resource.name;
                        }
                    });

                    this.dataInput.resource_detail_id = "";
                    let resourceDetail = [];
                    this.modelIssued.forEach(data => {
                        resourceDetail.push(data.resource_detail_id);
                    });

                    let datas = [];
                    datas.push(newValue,resourceDetail);
                    datas = JSON.stringify(datas);
                    window.axios.get('/api/getResourceDetail/'+datas).then(({ data }) => {
                        this.modelResourceDetails = data;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. ('+error+')',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.dataInput.resource_detail_id = "";
                    $('div.overlay').hide();
                }
            },
            'editInput.resource_id' : function(newValue){
                $('div.overlay').show();
                this.modelResourceDetailsEdit = [];
                if(this.editInput.old_resource_id != newValue){
                    this.editInput.resource_detail_id = "";
                    this.editInput.resource_detail_name = "";
                    this.editInput.old_resource_id = null;
                }

                if(this.editInput.old_resource_id == null){
                    this.editInput.resource_detail_id = "";
                    this.editInput.resource_detail_name = "";
                }
                var toast = document.querySelector('.iziToast'); // Selector of your toast    
                if(toast != null){
                    iziToast.hide({
                        transitionOut: 'fadeOutUp'
                    }, toast);
                }   
                if(newValue != ""){
                    this.modelResources.forEach(resource => {
                        if(resource.id == newValue){
                            this.editInput.resource_name = resource.code+" - "+resource.name;
                        }
                    });
                    
                    let resourceDetail = [];

                    let nowIndex = this.activeIndex;
                    this.modelIssued.forEach(function(data,index) {
                        if(index != nowIndex){
                            resourceDetail.push(data.resource_detail_id);
                        }
                    });

                    let datas = [];
                    datas.push(newValue,resourceDetail);
                    datas = JSON.stringify(datas);
                    window.axios.get('/api/getResourceDetail/'+datas).then(({ data }) => {
                        this.modelResourceDetailsEdit = data;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. ('+error+')',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.editInput.resource_detail_id = "";
                    $('div.overlay').hide();
                }
            },
            'dataInput.resource_detail_id' : function(newValue){
                $('div.overlay').show();
                var toast = document.querySelector('.iziToast'); // Selector of your toast                                
                if(newValue != ""){
                    this.statusResourceDetails = true;
                    this.modelResourceDetails.forEach(resourceDetail => {
                        if(resourceDetail.id == newValue){
                            this.dataInput.resource_detail_name = "["+resourceDetail.code+"] "+resourceDetail.brand;
                            if(resourceDetail.status == 1){
                                this.status = "IDLE";
                                this.statusResourceDetails = false;
                                if(toast != null){
                                    iziToast.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                }
                                $('div.overlay').hide();
                            } else if(resourceDetail.status == 2){
                                this.status = "USED";
                                iziToast.warning({
                                    close: false,
                                    timeout: 0,
                                    title: 'The resource is still used!',
                                    position: 'topRight',
                                    displayMode: 'replace'
                                });
                                $('div.overlay').hide();
                            }
                        }
                    });
                }else{
                    if(toast != null){
                        iziToast.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);
                    }
                    this.status = "";
                    $('div.overlay').hide();
                }
            },
            'editInput.resource_detail_id' : function(newValue){
                $('div.overlay').show();
                var toast = document.querySelector('.iziToast'); // Selector of your toast                                
                if(newValue != ""){
                    this.statusResourceDetailsEdit = true;
                    this.modelResourceDetailsEdit.forEach(resourceDetail => {
                        if(resourceDetail.id == newValue){
                            this.editInput.resource_detail_name = "["+resourceDetail.code+"] "+resourceDetail.brand;
                            if(resourceDetail.status == 1){
                                this.statusEdit = "IDLE";
                                this.statusResourceDetailsEdit = false;
                                if(toast != null){
                                    iziToast.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                }
                                $('div.overlay').hide();
                            } else if(resourceDetail.status == 2){
                                this.statusEdit = "USED";
                                iziToast.warning({
                                    close: false,
                                    timeout: 0,
                                    title: 'The resource is still used!',
                                    position: 'topRight',
                                    displayMode: 'replace'
                                });
                                $('div.overlay').hide();
                            }
                        }
                    });
                }else{
                    if(toast != null){
                        iziToast.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);
                    }
                    this.statusEdit = "-";
                    $('div.overlay').hide();
                }
            }
        },
        created : function(){
            this.newIndex = this.modelIssued.length+1;
        }
    });
</script>
@endpush
