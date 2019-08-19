@extends('layouts.main')
@section('content-header')
@if($route == "/quotation")
    @if($quotation->id)
        @breadcrumb(
            [
                'title' => 'Edit Quotation',
                'items' => [
                    'Dashboard' => route('index'),
                    $quotation->code => route('quotation.show',$quotation->id),
                    'Edit Quotation' => '',
                ]
            ]
        )@endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Quotation',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create Quotation' => '',
                ]
            ]
        )@endbreadcrumb
    @endif
@elseif($route == "/quotation_repair")
    @if($quotation->id)
        @breadcrumb(
            [
                'title' => 'Edit Quotation',
                'items' => [
                    'Dashboard' => route('index'),
                    $quotation->code => route('quotation_repair.show',$quotation->id),
                    'Edit Quotation' => '',
                ]
            ]
        )@endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Quotation',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create Quotation' => '',
                ]
            ]
        )@endbreadcrumb
    @endif
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding">
                @if($route == "/quotation")
                    @if($quotation->id)
                        <form id="quotation" class="form-horizontal" method="POST" action="{{ route('quotation.update',['id'=>$quotation->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="quotation" class="form-horizontal" method="POST" action="{{ route('quotation.store') }}">
                    @endif
                @elseif($route == "/quotation_repair")
                    @if($quotation->id)
                        <form id="quotation" class="form-horizontal" method="POST" action="{{ route('quotation_repair.update',['id'=>$quotation->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="quotation" class="form-horizontal" method="POST" action="{{ route('quotation_repair.store') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="quotation">
                            <div class="box-header no-padding">
                                <div class="col-sm-5 no-padding">
                                    <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                        <label for="" >Estimator Profile</label>
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-10">
                                        <selectize v-model="dataInput.profile_id" :settings="profile_settings">
                                            <option v-for="(profile, index) in profiles" :value="profile.id">{{ profile.code }} - {{ profile.ship.type }}</option>
                                        </selectize>  
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                        <label for="" >Customer</label>
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-10">
                                        <selectize v-model="dataInput.customer_id" :settings="customer_settings">
                                            <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.code }} - {{ customer.name }}</option>
                                        </selectize>  
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                        <label for="" >Margin (%)</label>
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-10">
                                        <input v-model="dataInput.margin" type="text" class="form-control width100" name="margin" id="margin" placeholder="Please Input Margin">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Description</label>
                                    <textarea class="form-control" rows="3" v-model="dataInput.description"></textarea>
                                </div>
                                <div class="col-sm-3 p-r-0">
                                    <a href="#top" class="btn btn-sm btn-primary pull-right" data-toggle="modal">Terms Of Payment</a>
                                </div>
                            </div>

                            <template v-if="dataInput.profile_id != ''">
                                <div class="col-md-12 p-t-10 p-l-0 p-r-0">
                                    <table class="table table-bordered tableFixed m-b-0">
                                        <thead>
                                            <tr>
                                                <th width="20%">Cost Standard</th>
                                                <th width="25%">Description</th>
                                                <th width="20%">Value</th>
                                                <th width="10%">Unit</th>
                                                <th width="25%">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="(wbs, index) in dataWbs">
                                            <tr>
                                                <td colspan="5" class="p-t-13 p-b-13 bg-primary"><b>{{ wbs.code }} - {{ wbs.name }}</b></td>
                                                <tr v-for="(pd,index) in selectedProfile[0].estimator_profile_details">
                                                    <template v-if="pd.estimator_cost_standard.estimator_wbs_id == wbs.id">
                                                        <td>{{ pd.estimator_cost_standard.code }} - {{ pd.estimator_cost_standard.name }}</td>
                                                        <td>{{ pd.estimator_cost_standard.description ? pd.estimator_cost_standard.description : '-' }}</td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="pd.value" placeholder="Please input value">
                                                        </td>
                                                        <td>{{ pd.estimator_cost_standard.uom.unit }}</td>
                                                        <td>Rp.{{ pd.total_price }}</td>
                                                    </template>
                                                </tr>
                                            </tr>
                                        </tbody>
                                            <tr>
                                                <td class="p-t-13 p-b-13" colspan="4" align="right"><b>Margin</b></td>
                                                <td>{{ dataInput.margin }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="p-t-13 p-b-13" colspan="4" align="right"><b>Total Price :</b></td>
                                                <td>Rp.{{ totalPrice }}</td>
                                            </tr>
                                    </table>
                                </div>
                                <div class="col-md-12 p-t-10 p-r-0">
                                    <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                                </div>
                            </template>

                            <div class="modal fade" id="top">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Terms of Payment</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row p-l-10 p-r-10">
                                                <table class="table table-bordered tableFixed m-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">No</th>
                                                            <th width="35%">Project Progress (%)</th>
                                                            <th width="40%">Payment Percentage (%)</th>
                                                            <th width="15%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(top, index) in tops">
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="top.project_progress" placeholder="Please input Project Progress">
                                                            </td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="top.payment_percentage" placeholder="Please input Payment Percentage">
                                                            </td>
                                                            <td class="p-l-0" align="center"><a @click.prevent="save(index)" :disabled="editOk(index)" class="btn btn-primary btn-xs" href="#">
                                                                <div class="btn-group">
                                                                    SAVE
                                                                </div></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td>{{ newIndex }}</td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="inputTop.project_progress" placeholder="Please input Project Progress">
                                                            </td>
                                                            <td class="no-padding">
                                                                <input class="form-control" type="text" v-model="inputTop.payment_percentage" placeholder="Please input Payment Percentage">
                                                            </td>
                                                            <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                                                <div class="btn-group">
                                                                    ADD
                                                                </div></a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">CANCEL</button>
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
    const form = document.querySelector('form#quotation');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        customers : @json($customers),
        profiles : @json($profiles),
        dataInput: {
            profile_id : "",
            margin : "",
            description : "",
            customer_id : "",
        },
        profile_settings: {
            placeholder: 'Please Select Estimator Profile!'
        },
        customer_settings: {
            placeholder: 'Please Select Customer!'
        },
        selectedProfile : [],
        dataWbs : [],
        tops:[],
        inputTop:{
            project_progress: "",
            payment_percentage: "",
        },
        newIndex:"",
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#quotation',
        data : data,
        computed: {
            createOk: function(){
                let isOk = false;

                if(this.dataInput.profile_id == ""){
                    isOk = true;
                }

                this.selectedProfile[0].estimator_profile_details.forEach(pd =>{
                    if(pd.value == undefined || pd.value == ""){
                        isOk = true;
                    }
                })

                return isOk;
            },
            totalPrice: function(){
                let total_price = 0;
                this.selectedProfile[0].estimator_profile_details.forEach(pd =>{
                    if(pd.value != undefined){
                        total_price += (pd.value+"").replace(/,/g , '') * pd.estimator_cost_standard.value;
                    }
                });
                total_price = total_price * (1 + (this.dataInput.margin+"").replace(/,/g , '')/100);
                total_price = (total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return total_price;
            },
            inputOk: function(){
                let isOk = false;

                if(this.inputTop.project_progress == "" || this.inputTop.project_progress == 0 || this.inputTop.payment_percentage == "" || this.inputTop.payment_percentage == 0){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            editOk(index){
                let isOk = false;

                if(this.tops[index].project_progress == "" || this.tops[index].project_progress == 0 || this.tops[index].payment_percentage == "" || this.tops[index].payment_percentage == 0){
                    isOk = true;
                }

                return isOk;
            },
            submitToTable(){
                let status = true;

                if(this.tops.length > 0){
                    let index = this.tops.length - 1;
                    if(this.tops[index].project_progress >= parseFloat((this.inputTop.project_progress+"").replace(/,/g , ''))){
                        this.inputTop.project_progress = parseFloat((this.tops[index].project_progress+"").replace(/,/g , '')) + 1;
                        iziToast.warning({
                            title: 'Please Input Project Progress More Than '+ this.tops[index].project_progress +" %",
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        status = false;
                    }

                    let payment_percentage = 0;
                    this.tops.forEach(top =>{
                        payment_percentage += parseFloat((top.payment_percentage+"").replace(/,/g , ''));
                    })

                    let remaining = 100 - payment_percentage;
                    if(remaining < parseFloat((this.inputTop.payment_percentage+"").replace(/,/g , ''))){
                        iziToast.warning({
                            title: 'Please Input Payment Percentage Less Than '+ remaining +" %",
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        status = false;
                        this.inputTop.payment_percentage = remaining;
                    }
                }
                
                if(status){
                    var data = JSON.stringify(this.inputTop);
                    data = JSON.parse(data);
                    this.tops.push(data);
    
                    this.inputTop.project_progress = "";
                    this.inputTop.payment_percentage = "";
                    this.newIndex = this.tops.length + 1;

                    iziToast.success({
                        title: 'Success Add New Terms of Payment',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                }
            },
            save(index){
                iziToast.success({
                    title: 'Success Update Terms of Payment',
                    position: 'topRight',
                    displayMode: 'replace'
                });
            },
            submitForm(){
                $('div.overlay').show();
                document.body.appendChild(form);
                this.tops.forEach(top=>{
                    top.project_progress = (top.project_progress+"").replace(/,/g , '');
                    top.payment_percentage = (top.payment_percentage+"").replace(/,/g , '');
                })

                let total_price = 0;
                this.selectedProfile[0].estimator_profile_details.forEach(pd =>{
                    pd.value = (pd.value+"").replace(/,/g , '');
                    pd.total_price = (pd.total_price+"").replace(/,/g , '');
                    total_price += parseFloat((pd.total_price+"").replace(/,/g , ''));
                })

                this.submittedForm.profile_id = this.dataInput.profile_id;
                this.submittedForm.customer_id = this.dataInput.customer_id;
                this.submittedForm.margin = this.dataInput.margin;
                this.submittedForm.description = this.dataInput.description;
                this.submittedForm.price = total_price;
                this.submittedForm.total_price = total_price * (1 + parseFloat(this.dataInput.margin) / 100);
                this.submittedForm.pd = this.selectedProfile;
                this.submittedForm.top = this.tops;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch: {
            'dataInput.margin': function(newValue){
                if(newValue != ""){
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.dataInput.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.dataInput.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.dataInput.margin = (this.dataInput.margin+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }else{
                    this.dataInput.margin = 0;
                }
            },
            'dataInput.profile_id': function(newValue){
                this.selectedProfile = [];
                this.dataWbs = [];
                if(newValue != ""){
                    this.profiles.forEach(profile =>{
                        if(profile.id == newValue){
                            this.selectedProfile.push(profile);
                            this.selectedProfile[0].estimator_profile_details.forEach(spd =>{
                                spd.total_price = 0;
                                let status = true;
                                if(this.dataWbs.length > 0){
                                    this.dataWbs.forEach(wbs =>{
                                        if(wbs.id == spd.estimator_wbs_id){
                                            status = false;
                                        }
                                    })
                                }
                                if(status){
                                    let statusWbs = true;
                                    this.dataWbs.forEach(wbs =>{
                                        if(wbs.id == spd.estimator_cost_standard.estimator_wbs_id){
                                            statusWbs = false;
                                        }
                                    })
                                    if(statusWbs){
                                        this.dataWbs.push(spd.estimator_cost_standard.estimator_wbs);
                                    }
                                }
                            })
                        }
                    })
                }
            },
            selectedProfile:{
                handler: function(newValue) {
                    this.selectedProfile[0].estimator_profile_details.forEach(pd =>{
                        if(pd.value != undefined){
                            var decimal = (pd.value+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    pd.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    pd.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                pd.value = (pd.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        // kalkulasi total price (value {inputan user} * harga pada cost standard)
                        pd.total_price = (((pd.value+"").replace(/,/g , '') * pd.estimator_cost_standard.value)+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    })
                },
                deep: true
            },
            'inputTop.project_progress' : function(newValue){
                if(newValue != ""){
                    if((this.inputTop.project_progress+"").replace(/,/g , '') > 100){
                        this.inputTop.project_progress = 100;
                        iziToast.warning({
                            title: 'Project Progress Cannot Greater Than 100%',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }

                    var decimal = (this.inputTop.project_progress+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.inputTop.project_progress = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.inputTop.project_progress = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.inputTop.project_progress = (this.inputTop.project_progress+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'inputTop.payment_percentage' : function(newValue){
                if(newValue != ""){
                    if((this.inputTop.payment_percentage+"").replace(/,/g , '') > 100){
                        this.inputTop.payment_percentage = 100;
                        iziToast.warning({
                            title: 'Payment Percentage Cannot Greater Than 100%',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }

                    var decimal = (this.inputTop.payment_percentage+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.inputTop.payment_percentage = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.inputTop.payment_percentage = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.inputTop.payment_percentage = (this.inputTop.payment_percentage+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            }
        },
        created : function(){
            this.dataInput.margin = 0;
            this.newIndex = this.tops.length + 1;
        }
    });

</script>
@endpush