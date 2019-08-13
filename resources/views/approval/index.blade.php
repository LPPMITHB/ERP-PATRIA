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
                                    <selectize v-model="transactionId" :settings="transactionSettings">
                                        <option v-for="(transaction, index) in transactions" :value="transaction">{{ transaction }}</option>
                                    </selectize>  
                                </div>
                            </div>
                            <template v-if="selectedType != ''">
                                <div class="row no-padding">
                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <h5><b>Select Type:</b></h5>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <template v-for="(type,index) in types">
                                                <input type="radio" :value="type" v-model="selectedType">
                                                <label>{{ type }}</label>
                                                <br>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <table class="table table-bordered tableFixed">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="30%">Minimum</th>
                                                    <th width="30%">Maximum</th>
                                                    <th width="25%">Role</th>
                                                    <th width="10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(approval,index) in approvals[0].level_1">
                                                    <td>{{index + 1}}</td>
                                                    <td class="no-padding">
                                                        <input class="form-control" type="text" v-model="approval.minimum" placeholder="Please Input Minumum Amount">
                                                    </td>
                                                    <td class="no-padding">
                                                        <input class="form-control" type="text" v-model="approval.maximum" placeholder="Please Input Maximum Amount">
                                                    </td>
                                                    <td class="no-padding">
                                                        <selectize id="role" v-model="approval.role_id" :settings="roleSettings">
                                                            <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                        </selectize>  
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>{{ newIndexLevel1 }}</td>
                                                    <td class="no-padding">
                                                        <input class="form-control" type="text" v-model="dataInputLevel1.minimum" placeholder="Please Input Minumum Amount">
                                                    </td>
                                                    <td class="no-padding">
                                                        <input class="form-control" type="text" v-model="dataInputLevel1.maximum" placeholder="Please Input Maximum Amount">
                                                    </td>
                                                    <td class="no-padding">
                                                        <selectize id="role" v-model="dataInputLevel1.role_id" :settings="roleSettings">
                                                            <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                        </selectize>  
                                                    </td>
                                                    <td class="p-l-0" align="center">
                                                        <a @click.prevent="save_level_1()" class="btn btn-primary btn-xs" href="#">
                                                            <div class="btn-group">
                                                                ADD
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 p-r-0">
                                    <button @click.prevent="saveApproval()" type="button" class="btn btn-primary pull-right">SAVE</button>
                                </div>
                            </template>
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
        transactions : ['Purchase Requisition','Purchase Order', 'Material Requisition'],
        types : ['1 Stage', '2 Stage', '2 Stage Special Condition'],
        approvalPR : @json($approvalPR),
        roles: @json($roles),
        transactionId: "",
        selectedType : "",
        newIndexLevel1: 0,
        newIndexLevel2: 0,
        dataInputLevel1: {
            minimum:"",
            maximum:"",
            role_id:"",
        },
        dataInputLevel2: {
            minimum:"",
            maximum:"",
            role_id:"",
        },
        approvals: [],
        roleSettings: {
            placeholder: 'Please Select Role'
        },
        transactionSettings: {
            placeholder: 'Please Select Transaction'
        },
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        method: {
            add_level_1(){

            },
            add_level_2(){

            },
            saveApproval(){

            }
        },
        watch:{
            'transactionId': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getApprovalConfig/'+newValue).then(({ data }) => {
                        this.approvals = data;
                        this.selectedType = data[0].type;
                        this.approvals[0].level_1.forEach(approval=>{
                            approval.minimum = (approval.minimum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            approval.maximum = (approval.maximum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        })

                        this.newIndexLevel1 = this.approvals[0].level_1.length + 1;
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
                }else{
                    this.approvals = [];
                    this.selectedType = "";
                }
            },
            approvals:{
                handler: function(newValue) {
                    newValue[0].level_1.forEach(data => {
                        data.minimum = (data.minimum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        data.maximum = (data.maximum+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                },
                deep: true
            },
        },
        created(){
            this.newIndex += 1;
        },
    });
</script>
@endpush