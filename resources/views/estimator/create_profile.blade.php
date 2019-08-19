@extends('layouts.main')
@section('content-header')
@if($route == "/estimator")
    @if($profile->id)
        @breadcrumb(
            [
                'title' => 'Edit Estimator Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Estimator Profiles' => route('estimator.indexEstimatorProfile'),
                    $profile->ship->type => route('estimator.showProfile',$profile->id),
                    'Edit Estimator Profile' => '',
                ]
            ]
        )
        @endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Estimator Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Estimator Profiles' => route('estimator.indexEstimatorProfile'),
                    'Create Estimator Profile' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@elseif($route == "/estimator_repair")
    @if($profile->id)
    @breadcrumb(
        [
            'title' => 'Edit Estimator Profile',
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator_repair.indexEstimatorProfile'),
                $profile->ship->type => route('estimator_repair.showProfile',$profile->id),
                'Edit Estimator Profile' => '',
            ]
        ]
    )
    @endbreadcrumb
    @else 
    @breadcrumb(
        [
            'title' => 'Create Estimator Profile',
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator_repair.indexEstimatorProfile'),
                'Create Estimator Profile' => '',
            ]
        ]
    )
    @endbreadcrumb
    @endif
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding">
                @if($route == "/estimator")
                    @if($profile->id)
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator.updateProfile',['id'=>$profile->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator.storeProfile') }}">
                    @endif
                @elseif($route == "/estimator_repair")
                    @if($profile->id)
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator_repair.updateProfile',['id'=>$profile->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator_repair.storeProfile') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="profile">
                            <div class="box-header no-padding">
                                <div class="col-xs-12 col-md-6 p-l-0">
                                    <div class="col-xs-12 col-md-3 p-t-5">
                                        <label for="">Profile Code</label>
                                    </div>
                                    <div class="col-xs-12 col-md-9">
                                        <input v-model="submittedForm.code" type="text" class="form-control width100" name="code" id="code" disabled>
                                    </div>
                                    <div class="col-xs-12 col-md-3 p-t-15">
                                        <label for="" >Ship Type</label>
                                    </div>
                                    <div class="col-xs-12 col-md-9 p-t-10">
                                        <selectize v-model="submittedForm.ship_id" :settings="ship_settings">
                                            <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                        </selectize>  
                                    </div>
                                    <div class="col-xs-12 col-md-3 p-t-15">
                                        <label for="" >Status</label>
                                    </div>
                                    <div class="col-xs-12 col-md-9 p-t-10">
                                        <select class="form-control" id="status" name="status" v-model="submittedForm.status">
                                            <option value="1">Active</option>
                                            <option value="0">Non Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="">Description</label>
                                    <textarea class="form-control" rows="3" v-model="submittedForm.description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 p-t-10 p-l-0 p-r-0">
                                <table class="table table-bordered tableFixed m-b-0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">WBS Cost Estimation</th>
                                            <th width="25%">Cost Standard</th>
                                            <th width="20%">Value</th>
                                            <th width="15%">Unit</th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(profile, index) in profileDetails">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ profile.wbs_code }} - {{ profile.wbs_name }}</td>
                                            <td class="tdEllipsis">{{ profile.cost_standard_code }} - {{ profile.cost_standard_name }}</td>
                                            <td class="tdEllipsis">Rp.{{ profile.value }}</td>
                                            <td class="tdEllipsis">{{ profile.uom_name }}</td>
                                            <td class="p-l-5" align="center">
                                                <a class="btn btn-primary btn-xs" @click="openEditModal(profile,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(profile)" class="btn btn-danger btn-xs">
                                                    <div class="btn-group">DELETE</div>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>{{newIndex}}</td>
                                            <td class="no-padding">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbs_settings">
                                                    <option v-for="(wbs, index) in modelWbs" :value="wbs.id">{{ wbs.code }} - {{ wbs.name }}</option>
                                                </selectize>    
                                            </td>
                                            <td class="no-padding">
                                                <selectize v-model="dataInput.cost_standard_id" :settings="cost_standard_settings">
                                                    <option v-for="(cost_standard, index) in selectedCostStandard" :value="cost_standard.id">{{ cost_standard.code }} - {{ cost_standard.name }}</option>
                                                </selectize>    
                                            </td>
                                            <td class="no-padding"><input class="form-control" type="text" v-model="dataInput.value" disabled></td>
                                            <td class="no-padding"><input class="form-control" type="text" v-model="dataInput.uom_name" disabled></td>
                                            <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                                <div class="btn-group">
                                                    ADD
                                                </div></a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-md-12 p-t-10 p-r-0">
                                <template v-if="profile.length != undefined">
                                    <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                                </template>
                                <template v-else>
                                    <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                                </template>
                            </div>

                            <div class="modal fade" id="edit_item">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Edit Estimator Profile</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">WBS Cost Estimation</label>
                                                    <selectize v-model="editInput.wbs_id" :settings="wbs_settings">
                                                        <option v-for="(wbs, index) in modelWbs" :value="wbs.id">{{ wbs.code }} - {{ wbs.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Cost Standard</label>
                                                    <selectize v-model="editInput.cost_standard_id" :settings="cost_standard_settings">
                                                        <option v-for="(cost_standard, index) in selectedCostStandardModal" :value="cost_standard.id">{{ cost_standard.code }} - {{ cost_standard.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="value" class="control-label">Value</label>
                                                    <input type="text" id="value" v-model="editInput.value" class="form-control" disabled>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="unit" class="control-label">Unit</label>
                                                    <input type="text" id="unit" v-model="editInput.uom_name" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update()">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#profile');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        newIndex : 0,
        ships : @json($modelShip),
        modelWbs : @json($modelWbs),
        modelCostStandard : @json($modelCostStandard),
        profile : @json($profile),
        selectedCostStandard : [],
        selectedCostStandardModal : [],
        profileDetails: [],
        cost_standard_ids: [],
        cost_standard_ids_modal: [],
        deleted_id : [],
        submittedForm:{
            ship_id : "",
            description : "",
            code : "",
            status : "",
        },
        dataInput : {
            cost_standard_id : "",
            cost_standard_name : "",
            cost_standard_code : "",
            wbs_id : "",
            wbs_name : "",
            wbs_code : "",
            uom_id : "",
            uom_name : "",
            value : "",
        },
        editInput : {
            cost_standard_id : "",
            cost_standard_name : "",
            cost_standard_code : "",
            wbs_id : "",
            wbs_name : "",
            wbs_code : "",
            uom_id : "",
            uom_name : "",
            value : "",
            index : "",
        },
        ship_settings: {
            placeholder: 'Please Select Ship Type!'
        },
        wbs_settings: {
            placeholder: 'Please Select WBS Cost Estimation!'
        },
        cost_standard_settings: {
            placeholder: 'Please Select Cost Standard!'
        },
    }

    var vm = new Vue({
        el : '#profile',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.dataInput.wbs_id == "" || this.dataInput.cost_standard_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.wbs_id == "" || this.editInput.cost_standard_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.submittedForm.ship_id == "" || this.submittedForm.status == "" || this.profileDetails.length < 1){
                    isOk = true;
                }
                return isOk;
            }
        },
        methods: {
            clearDataInput(){
                this.dataInput.cost_standard_id = "";
                this.dataInput.cost_standard_name = "";
                this.dataInput.cost_standard_code = "";
                this.dataInput.wbs_id = "";
                this.dataInput.wbs_name = "";
                this.dataInput.wbs_code = "";
                this.dataInput.uom_id = "";
                this.dataInput.uom_name = "";
                this.dataInput.value = "";
            },
            clearEditInput(){
                this.editInput.cost_standard_id = "";
                this.editInput.cost_standard_name = "";
                this.editInput.cost_standard_code = "";
                this.editInput.wbs_id = "";
                this.editInput.wbs_name = "";
                this.editInput.wbs_code = "";
                this.editInput.uom_id = "";
                this.editInput.uom_name = "";
                this.editInput.value = "";
                this.editInput.index = "";
            },
            openEditModal(profile,index){
                $('div.overlay').show();
                this.selectedCostStandardModal = [];

                this.editInput.cost_standard_id = profile.cost_standard_id;
                this.editInput.cost_standard_name = profile.cost_standard_name;
                this.editInput.cost_standard_code = profile.cost_standard_code;
                this.editInput.wbs_id = profile.wbs_id;
                this.editInput.wbs_name = profile.wbs_name;
                this.editInput.wbs_code = profile.wbs_code;
                this.editInput.uom_id = profile.uom_id;
                this.editInput.uom_name = profile.uom_name;
                this.editInput.value = profile.value;
                this.editInput.index = index;

                var cost_standard_ids = JSON.stringify(this.cost_standard_ids);
                cost_standard_ids = JSON.parse(cost_standard_ids);
                
                this.cost_standard_ids_modal = cost_standard_ids;
                this.cost_standard_ids_modal.forEach(id => {
                    if(id == profile.cost_standard_id){
                        var index = this.cost_standard_ids_modal.indexOf(id);
                        this.cost_standard_ids_modal.splice(index, 1);
                    }
                });

                this.modelCostStandard.forEach(costStandard =>{
                    if(costStandard.estimator_wbs_id == profile.wbs_id){
                        let status = true;
                        this.cost_standard_ids_modal.forEach(id=>{
                            if(id == costStandard.id){
                                status = false;
                            }
                        })
                        if(status){
                            this.selectedCostStandardModal.push(costStandard);
                        }
                    }
                })
                $('#edit_item').modal();
                $('div.overlay').hide();
            },
            update(){
                let old_cost_standard_id = this.profileDetails[this.editInput.index].cost_standard_id;
                let new_cost_standard_id = this.editInput.cost_standard_id;

                this.profileDetails[this.editInput.index].cost_standard_id = this.editInput.cost_standard_id;
                this.profileDetails[this.editInput.index].cost_standard_name = this.editInput.cost_standard_name;
                this.profileDetails[this.editInput.index].cost_standard_code = this.editInput.cost_standard_code;
                this.profileDetails[this.editInput.index].wbs_id = this.editInput.wbs_id;
                this.profileDetails[this.editInput.index].wbs_name = this.editInput.wbs_name;
                this.profileDetails[this.editInput.index].wbs_code = this.editInput.wbs_code;
                this.profileDetails[this.editInput.index].uom_id = this.editInput.uom_id;
                this.profileDetails[this.editInput.index].uom_name = this.editInput.uom_name;
                this.profileDetails[this.editInput.index].value = this.editInput.value;

                this.cost_standard_ids.forEach(id => {
                    if(id == old_cost_standard_id){
                        var index = this.cost_standard_ids.indexOf(id);
                        this.cost_standard_ids.splice(index, 1);
                    }
                });
                this.cost_standard_ids.push(new_cost_standard_id);
                this.clearEditInput();
            },
            removeRow(profile){
                $('div.overlay').show();
                if(profile.id != "" && profile.id != null && profile.id != undefined){
                    this.deleted_id.push(profile.id);
                }
                var index_cost_standard_id = "";
                var index_profile_detail = "";

                this.cost_standard_ids.forEach(id => {
                    if(id == profile.cost_standard_id){
                        index_cost_standard_id = this.cost_standard_ids.indexOf(id);
                    }
                });

                for (var i in this.profileDetails) { 
                    if(this.profileDetails[i].wbs_id == profile.wbs_id && this.profileDetails[i].cost_standard_id == profile.cost_standard_id){
                        index_profile_detail = i;
                    }
                }

                this.profileDetails.splice(index_profile_detail, 1);
                this.cost_standard_ids.splice(index_cost_standard_id, 1);
                this.newIndex = this.profileDetails.length + 1;

                this.clearDataInput();
                $('div.overlay').hide();
            },
            submitToTable(){
                var data = JSON.stringify(this.dataInput);
                data = JSON.parse(data);
                this.profileDetails.push(data);
                this.cost_standard_ids.push(data.cost_standard_id);

                this.clearDataInput();
                this.selectedCostStandard = [];
                this.newIndex = this.profileDetails.length + 1;
            },
            submitForm(){
                $('div.overlay').show();
                document.body.appendChild(form);
                this.profileDetails.forEach(data=>{
                    data.value = (data.value+"").replace(/,/g , '');
                })
                this.submittedForm.datas = this.profileDetails;
                this.submittedForm.deleted_id = this.deleted_id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch: {
            'dataInput.wbs_id': function(newValue){
                if(newValue != ""){
                    this.selectedCostStandard = [];
                    this.modelCostStandard.forEach(costStandard =>{
                        if(costStandard.estimator_wbs_id == newValue){
                            let status = true;
                            this.cost_standard_ids.forEach(id=>{
                                if(id == costStandard.id){
                                    status = false;
                                }
                            })
                            if(status){
                                this.selectedCostStandard.push(costStandard);
                                this.dataInput.wbs_name = costStandard.estimator_wbs.name;
                                this.dataInput.wbs_code = costStandard.estimator_wbs.code;
                            }
                        }
                    })
                }else{
                    this.clearDataInput();
                }
            },
            'dataInput.cost_standard_id': function(newValue){
                if(newValue != ""){
                    this.modelCostStandard.forEach(costStandard =>{
                        if(costStandard.id == newValue){
                            this.dataInput.value = (costStandard.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            this.dataInput.uom_id = costStandard.uom_id;
                            this.dataInput.uom_name = costStandard.uom.unit;
                            this.dataInput.cost_standard_name = costStandard.name;
                            this.dataInput.cost_standard_code = costStandard.code;
                        }
                    })
                }else{
                    this.dataInput.cost_standard_id = "";
                    this.dataInput.cost_standard_name = "";
                    this.dataInput.cost_standard_code = "";
                    this.dataInput.uom_id = "";
                    this.dataInput.uom_name = "";
                    this.dataInput.value = "";
                }
            },
            'editInput.wbs_id': function(newValue){
                if(newValue != ""){
                    this.selectedCostStandardModal = [];
                    this.modelCostStandard.forEach(costStandard =>{
                        if(costStandard.estimator_wbs_id == newValue){
                            let status = true;
                            this.cost_standard_ids_modal.forEach(id=>{
                                if(id == costStandard.id){
                                    status = false;
                                }
                            })
                            if(status){
                                this.selectedCostStandardModal.push(costStandard);
                                this.editInput.wbs_name = costStandard.estimator_wbs.name;
                                this.editInput.wbs_code = costStandard.estimator_wbs.code;
                            }
                        }
                    })
                }else{
                    this.clearEditInput();
                }
            },
            'editInput.cost_standard_id': function(newValue){
                if(newValue != ""){
                    this.modelCostStandard.forEach(costStandard =>{
                        if(costStandard.id == newValue){
                            this.editInput.value = (costStandard.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            this.editInput.uom_id = costStandard.uom_id;
                            this.editInput.uom_name = costStandard.uom.unit;
                            this.editInput.cost_standard_name = costStandard.name;
                            this.editInput.cost_standard_code = costStandard.code;
                        }
                    })
                }else{
                    this.editInput.cost_standard_id = "";
                    this.editInput.cost_standard_name = "";
                    this.editInput.cost_standard_code = "";
                    this.editInput.uom_id = "";
                    this.editInput.uom_name = "";
                    this.editInput.value = "";
                }
            }
        },
        created : function(){
            if(this.profile.length != undefined){
                this.submittedForm.code = @json($profile_code);
                this.submittedForm.status = 1;
            }else{
                this.submittedForm.code = this.profile.code;
                this.submittedForm.description = this.profile.description;
                this.submittedForm.ship_id = this.profile.ship_id;
                this.submittedForm.status = this.profile.status;

                this.profile.estimator_profile_details.forEach(pd =>{
                    var data = {
                        id : pd.id,
                        cost_standard_id : pd.cost_standard_id,
                        cost_standard_name : pd.estimator_cost_standard.name,
                        cost_standard_code : pd.estimator_cost_standard.code,
                        wbs_id : pd.estimator_cost_standard.estimator_wbs_id,
                        wbs_name : pd.estimator_cost_standard.estimator_wbs.name,
                        wbs_code : pd.estimator_cost_standard.estimator_wbs.code,
                        uom_id : pd.estimator_cost_standard.uom_id,
                        uom_name : pd.estimator_cost_standard.uom.unit,
                        value : (pd.estimator_cost_standard.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                    }
                    var dataTemp = JSON.stringify(data);
                    dataTemp = JSON.parse(dataTemp);
                    this.profileDetails.push(dataTemp);
                    this.cost_standard_ids.push(data.cost_standard_id);
                })
            }
            this.newIndex = this.profileDetails.length + 1;
        },
    })
</script>
@endpush