@extends('layouts.main')

@push('style')

@endpush

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approval Configuration',
        'items' => [
            'Dashboard' => route('index'),
            'Approval Configuration' => '',
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
                <form id="approval" class="form-horizontal" method="POST" action="{{ route('approval.save') }}">
                @csrf
                    @verbatim
                    <div id="approval">
                        <div class="box-body no-padding">
                            <div class="row p-l-10">
                                <div class="col-xs-12 col-md-4">
                                    <label for="" >Transaction</label>
                                    <selectize v-model="selectedTransaction" :settings="transactionSettings">
                                        <option v-for="(transaction, index) in transactions" :value="transaction">{{ transaction }}</option>
                                    </selectize>  
                                </div>
                                <template v-if="selectedType != ''">
                                    <div class="col-sm-8">
                                        <h5><b>Select Type:</b></h5>
                                        <div class="col-sm-12 no-padding">
                                            <template v-for="(type,index) in types">
                                                <div class="col-sm-12 col-md-4 no-padding">
                                                    <input type="radio" :value="type" v-model="selectedType">
                                                    <label>{{ type }}</label>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <template v-if="selectedType == 'Single Approval'">
                                        <div class="col-sm-12 p-t-10">
                                            <table class="table table-bordered tableFixed">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="29%">Minimum</th>
                                                        <th width="29%">Maximum</th>
                                                        <th width="25%">Role</th>
                                                        <th width="12%"></th>
                                                    </tr>
                                                </thead>
                                                <template v-if="approvals.length > 0">
                                                    <tbody>
                                                        <tr v-for="(approval,index) in approvals[0].value">
                                                            <td>{{index + 1}}</td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="approval.minimum" placeholder="Please Input Minumum Amount">
                                                            </td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="approval.maximum" placeholder="Please Input Maximum Amount">
                                                            </td>
                                                            <td class="no-padding">
                                                                <selectize id="role" v-model="approval.role_id_1" :settings="roleSettings">
                                                                    <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                                </selectize>  
                                                            </td>
                                                            <td class="p-l-0" align="center">
                                                                <a @click.prevent="update()" class="btn btn-primary btn-xs" href="">
                                                                    SAVE
                                                                </a>
                                                                <a @click.prevent="remove(index)" class="btn btn-danger btn-xs" href="">
                                                                    DELETE
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                                <tfoot>
                                                    <tr>
                                                        <td>{{ newIndex }}</td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="dataInput.minimum" placeholder="Please Input Minumum Amount">
                                                        </td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="dataInput.maximum" placeholder="Please Input Maximum Amount">
                                                        </td>
                                                        <td class="no-padding">
                                                            <selectize id="role" v-model="dataInput.role_id_1" :settings="roleSettings">
                                                                <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                            </selectize>  
                                                        </td>
                                                        <td class="p-l-0" align="center">
                                                            <a @click.prevent="save()" class="btn btn-primary btn-xs" href="#" :disabled="addOk">
                                                                <div class="btn-group">
                                                                    ADD
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </template>

                                    <template v-else-if="selectedType == 'Two Step Approval' || selectedType == 'Joint Approval'">
                                        <div class="col-sm-12 p-t-10">
                                            <table class="table table-bordered tableFixed">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="22%">Minimum</th>
                                                        <th width="23%">Maximum</th>
                                                        <th width="19%">Role 1</th>
                                                        <th width="19%">Role 2</th>
                                                        <th width="12%"></th>
                                                    </tr>
                                                </thead>
                                                <template v-if="approvals.length > 0">
                                                    <tbody>
                                                        <tr v-for="(approval,index) in approvals[0].value">
                                                            <td>{{index + 1}}</td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="approval.minimum" placeholder="Please Input Minumum Amount">
                                                            </td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="approval.maximum" placeholder="Please Input Maximum Amount">
                                                            </td>
                                                            <td class="no-padding">
                                                                <selectize id="role" v-model="approval.role_id_1" :settings="roleSettings">
                                                                    <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                                </selectize>  
                                                            </td>
                                                            <td class="no-padding">
                                                                <selectize id="role" v-model="approval.role_id_2" :settings="roleSettings">
                                                                    <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                                </selectize>  
                                                            </td>
                                                            <td class="p-l-0" align="center">
                                                                <a @click.prevent="update()" class="btn btn-primary btn-xs" href="">
                                                                    SAVE
                                                                </a>
                                                                <a @click.prevent="remove(index)" class="btn btn-danger btn-xs" href="">
                                                                    DELETE
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                                <tfoot>
                                                    <tr>
                                                        <td>{{ newIndex }}</td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="dataInput.minimum" placeholder="Please Input Minumum Amount">
                                                        </td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="dataInput.maximum" placeholder="Please Input Maximum Amount">
                                                        </td>
                                                        <td class="no-padding">
                                                            <selectize id="role" v-model="dataInput.role_id_1" :settings="roleSettings">
                                                                <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                            </selectize>  
                                                        </td>
                                                        <td class="no-padding">
                                                            <selectize id="role" v-model="dataInput.role_id_2" :settings="roleSettings">
                                                                <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                            </selectize>  
                                                        </td>
                                                        <td class="p-l-0" align="center">
                                                            <a @click.prevent="save()" class="btn btn-primary btn-xs" href="#" :disabled="addOk">
                                                                <div class="btn-group">
                                                                    ADD
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </template>

                                </template>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#approval');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        transactions : ['Purchase Requisition','Purchase Order', 'Material Requisition','Material Write Off',''],
        types : ['Single Approval', 'Two Step Approval', 'Joint Approval'],
        approvalPR : @json($approvalPR),
        roles: @json($roles),
        selectedTransaction: "",
        selectedType : "",
        newIndex: 0,
        newIndexLevel2: 0,
        dataInput: {
            minimum:"",
            maximum:"",
            role_id_1:null,
            role_id_2:null,
        },
        approvals: [],
        roleSettings: {
            placeholder: 'Please Select Role'
        },
        transactionSettings: {
            placeholder: 'Please Select Transaction'
        },
        submittedForm: {},
        tempApprovals: [],
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        computed : {
            addOk :function(){
                let isOk = false;
                if(this.selectedType == "Single Approval"){
                    if(this.dataInput.minimum == "" || this.dataInput.maximum == "" || this.dataInput.role_id_1 == null || this.dataInput.role_id_1 == ""){
                        isOk = true;
                    }
                }else{
                    if(this.dataInput.minimum == "" || this.dataInput.maximum == "" || this.dataInput.role_id_1 == null || this.dataInput.role_id_2 == null || this.dataInput.role_id_1 == "" || this.dataInput.role_id_2 == ""){
                        isOk = true;
                    }
                }
                return isOk;
            }
        },
        methods: {
            getApproval(){
                window.axios.get('/api/getApprovalConfig/'+this.selectedTransaction).then(({ data }) => {
                    this.approvals = data;
                    this.selectedType = data[0].type;
                    this.approvals[0].value.forEach(approval=>{
                        approval.minimum = (approval.minimum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        approval.maximum = (approval.maximum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    })

                    this.newIndex = this.approvals[0].value.length + 1;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
                this.clearDataInput();
            },
            clearDataInput(){
                this.dataInput.maximum = "";
                this.dataInput.minimum = "";
                this.dataInput.role_id_1 = null;
                this.dataInput.role_id_2 = null;
            },
            update(){
                $('div.overlay').show();
                let status = true;

                this.approvals[0].value.forEach(data=> {
                    if(data.minimum == "" || data.maximum == "" || parseInt((data.minimum+"").replace(/,/g , '')) > parseInt((data.maximum+"").replace(/,/g , '')) || data.role_id_1 == data.role_id_2){
                        status = false;
                    }
                })

                if(status){
                    var approvals = JSON.stringify(this.approvals);
                    approvals = JSON.parse(approvals);
                    approvals[0].value.forEach(value =>{
                        value.maximum = (value.maximum+"").replace(/,/g , '');
                        value.minimum = (value.minimum+"").replace(/,/g , '');
                    })
                    this.submittedForm.data = approvals;
                    this.submittedForm.selectedTransaction = this.selectedTransaction;

                    var url = "{{ route('approval.save') }}";
                    window.axios.put(url,this.submittedForm).then((response) => {
                        iziToast.success({
                            title: 'Success Update Approval Configuration',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                }else{
                    iziToast.warning({
                        title: 'Please re-check the value!',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }
            },
            remove(index){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this Approval Config?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            vm.approvals[0].value.splice(index, 1);
                            vm.submittedForm.data = vm.approvals;
                            vm.submittedForm.selectedTransaction = vm.selectedTransaction;
                            $('div.overlay').show();
                            var url = "{{ route('approval.save') }}";
                            window.axios.put(url,vm.submittedForm).then((response) => {
                                iziToast.success({
                                    title: 'Success Delete Approval Configuration',
                                    position: 'topRight',
                                    displayMode: 'replace'
                                });
                                $('div.overlay').hide();
                                vm.getApproval();
                            })
                            .catch((error) => {
                                iziToast.warning({
                                    title: 'Please Try Again..',
                                    position: 'topRight',
                                    displayMode: 'replace'
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
            save(){
                $('div.overlay').show();
                if(parseInt((this.dataInput.minimum+"").replace(/,/g , '')) > parseInt((this.dataInput.maximum+"").replace(/,/g , ''))){
                    iziToast.warning({
                        title: 'Minimum value cannot greater than maximum value!',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }else if(this.dataInput.role_id_1 == this.dataInput.role_id_2){
                    iziToast.warning({
                        title: 'Role 1 and Role 2 must be different!',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }else{
                    var data = JSON.stringify(this.dataInput);
                    if(this.approvals.length > 0){
                        this.approvals[0].value.push(JSON.parse(data));
                    }else{
                        this.submittedForm.selectedType = this.selectedType;
                        this.submittedForm.value = JSON.parse(data);
                    }
                    var approvals = JSON.stringify(this.approvals);
                    approvals = JSON.parse(approvals);
                    approvals[0].value.forEach(value =>{
                        value.maximum = (value.maximum+"").replace(/,/g , '');
                        value.minimum = (value.minimum+"").replace(/,/g , '');
                    })

                    this.submittedForm.data = approvals;
                    this.submittedForm.selectedTransaction = this.selectedTransaction;
                    var url = "{{ route('approval.save') }}";
                    window.axios.put(url,this.submittedForm).then((response) => {
                        iziToast.success({
                            title: 'Success Add New Approval Configuration',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.getApproval();
                        this.clearDataInput();
                        this.tempApprovals = [];
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                }
            },
        },
        watch:{
            'selectedType': function(newValue){
                this.clearDataInput();
                if(newValue != ""){
                    if(this.approvals.length > 0){
                        if(newValue != this.approvals[0].type){
                            let approval = JSON.stringify(this.approvals);
                            this.tempApprovals = JSON.parse(approval);
                            this.approvals = [];
                            this.newIndex = 1;
                        }
                    }else{
                        if(newValue == this.tempApprovals[0].type){
                            let approval = JSON.stringify(this.tempApprovals);
                            this.approvals = JSON.parse(approval);
                            this.tempApprovals = [];
                            this.newIndex = this.approvals[0].value.length + 1;
                        }
                    }
                }
            },
            'selectedTransaction': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    this.getApproval();
                }else{
                    this.approvals = [];
                    this.selectedType = "";
                }
            },
            approvals:{
                handler: function(newValue) {
                    if(newValue.length > 0){
                        newValue[0].value.forEach(data => {
                            data.minimum = (data.minimum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            data.maximum = (data.maximum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                    }
                },
                deep: true
            },
            'dataInput.minimum': function(newValue){
                if(newValue != ""){
                    this.dataInput.minimum = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.maximum': function(newValue){
                if(newValue != ""){
                    this.dataInput.maximum = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        },
    });
</script>
@endpush