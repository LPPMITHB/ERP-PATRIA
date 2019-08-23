@extends('layouts.main')
@section('content-header')
@if($route == "/sales_order")
    @if($sales_order->id)
        @breadcrumb(
            [
                'title' => 'Edit Sales Order',
                'items' => [
                    'Dashboard' => route('index'),
                    $sales_order->code => route('sales_order.show',$sales_order->id),
                    'Edit Sales Order' => '',
                ]
            ]
        )@endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Sales Order',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create Sales Order' => '',
                ]
            ]
        )@endbreadcrumb
    @endif
@elseif($route == "/sales_order_repair")
    @if($sales_order->id)
        @breadcrumb(
            [
                'title' => 'Edit Sales Order',
                'items' => [
                    'Dashboard' => route('index'),
                    $sales_order->code => route('sales_order_repair.show',$sales_order->id),
                    'Edit Sales Order' => '',
                ]
            ]
        )@endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Sales Order',
                'items' => [
                    'Dashboard' => route('index'),
                    'Create Sales Order' => '',
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
                @if($route == "/sales_order")
                    @if($sales_order->id)
                        <form id="sales_order" class="form-horizontal" method="POST" action="{{ route('sales_order.update',['id'=>$sales_order->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="sales_order" class="form-horizontal" method="POST" action="{{ route('sales_order.store') }}">
                    @endif
                @elseif($route == "/sales_order_repair")
                    @if($sales_order->id)
                        <form id="sales_order" class="form-horizontal" method="POST" action="{{ route('sales_order_repair.update',['id'=>$sales_order->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="sales_order" class="form-horizontal" method="POST" action="{{ route('sales_order_repair.store') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="sales-order">
                            <div class="box-header no-padding">
                                <template v-if="sales_order.length != undefined">
                                    <div class="col-sm-5 no-padding">
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Quotation Number</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <input v-model="quotation.number" type="text" class="form-control width100" name="number" id="number" disabled>
                                        </div>
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Customer</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <selectize v-model="quotation.customer_id" :settings="customer_settings">
                                                <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.code }} - {{ customer.name }}</option>
                                            </selectize>  
                                        </div>
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Margin (%)</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <input v-model="quotation.margin" type="text" class="form-control width100" name="margin" id="margin" placeholder="Please Input Margin">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Description</label>
                                        <textarea class="form-control" rows="3" v-model="quotation.description"></textarea>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-sm-5 no-padding">
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Quotation Number</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <input v-model="sales_order.quotation.number" type="text" class="form-control width100" name="number" id="number" disabled>
                                        </div>
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Customer</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <selectize v-model="sales_order.customer_id" :settings="customer_settings">
                                                <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.code }} - {{ customer.name }}</option>
                                            </selectize>  
                                        </div>
                                        <div class="col-xs-12 col-md-4 p-t-15 p-l-0">
                                            <label for="" >Margin (%)</label>
                                        </div>
                                        <div class="col-xs-12 col-md-8 p-t-10">
                                            <input v-model="sales_order.margin" type="text" class="form-control width100" name="margin" id="margin" placeholder="Please Input Margin">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Description</label>
                                        <textarea class="form-control" rows="3" v-model="sales_order.description"></textarea>
                                    </div>
                                </template>
                                <div class="col-sm-3 p-r-0">
                                    <a href="#top" class="btn btn-sm btn-primary pull-right" data-toggle="modal">Terms Of Payment</a>
                                </div>
                            </div>

                            <template v-if="sales_order.length != undefined">
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
                                                <tr v-for="(qd,index) in quotation.quotation_details">
                                                    <template v-if="qd.estimator_cost_standard.estimator_wbs_id == wbs.id">
                                                        <td>{{ qd.estimator_cost_standard.code }} - {{ qd.estimator_cost_standard.name }}</td>
                                                        <td>{{ qd.estimator_cost_standard.description ? qd.estimator_cost_standard.description : '-' }}</td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="qd.value" placeholder="Please input value">
                                                        </td>
                                                        <td>{{ qd.estimator_cost_standard.uom.unit }}</td>
                                                        <td>Rp.{{ qd.total_price }}</td>
                                                    </template>
                                                </tr>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td class="p-t-13 p-b-13" colspan="4" align="right"><b>Margin :</b></td>
                                            <td>{{ quotation.margin }}%</td>
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

                            <template v-else>
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
                                                <tr v-for="(sod,index) in sales_order.sales_order_details">
                                                    <template v-if="sod.estimator_cost_standard.estimator_wbs_id == wbs.id">
                                                        <td>{{ sod.estimator_cost_standard.code }} - {{ sod.estimator_cost_standard.name }}</td>
                                                        <td>{{ sod.estimator_cost_standard.description ? sod.estimator_cost_standard.description : '-' }}</td>
                                                        <td class="no-padding">
                                                            <input class="form-control" type="text" v-model="sod.value" placeholder="Please input value">
                                                        </td>
                                                        <td>{{ sod.estimator_cost_standard.uom.unit }}</td>
                                                        <td>Rp.{{ sod.total_price }}</td>
                                                    </template>
                                                </tr>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td class="p-t-13 p-b-13" colspan="4" align="right"><b>Margin :</b></td>
                                            <td>{{ sales_order.margin }}%</td>
                                        </tr>
                                        <tr>
                                            <td class="p-t-13 p-b-13" colspan="4" align="right"><b>Total Price :</b></td>
                                            <td>Rp.{{ totalPrice }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12 p-t-10 p-r-0">
                                    <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
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
    const form = document.querySelector('form#sales_order');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        sales_order : [],
        quotation : [],
        customers : @json($customers),
        customer_settings: {
            placeholder: 'Please Select Customer!'
        },
        dataWbs : [],
        tops:[],
        inputTop:{
            project_progress: "",
            payment_percentage: "",
        },
        newIndex:"",
        submittedForm : {},
        quotationDetails : [],
    }

    var vm = new Vue({
        el : '#sales-order',
        data : data,
        computed: {
            edit: function(){
                let isOk = false;

                if(this.quotation.length == undefined){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.quotation.customer_id == ""){
                    isOk = true;
                }

                this.quotation.quotation_details.forEach(qd =>{
                    if(qd.value == undefined || qd.value == ""){
                        isOk = true;
                    }
                })

                return isOk;
            },
            totalPrice: function(){
                let total_price = 0;

                if(this.sales_order.length != undefined){
                    this.quotation.quotation_details.forEach(qd =>{
                        if(qd.value != undefined){
                            total_price += (qd.value+"").replace(/,/g , '') * qd.price;
                        }
                    });
                    total_price = Math.floor(total_price * (1 + (this.quotation.margin+"").replace(/,/g , '')/100));
                    total_price = (total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }else{
                    this.sales_order.sales_order_details.forEach(sod =>{
                        if(sod.value != undefined){
                            total_price += (sod.value+"").replace(/,/g , '') * sod.price;
                        }
                    });
                    total_price = Math.floor(total_price * (1 + (this.sales_order.margin+"").replace(/,/g , '')/100));
                    total_price = (total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

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
                document.body.appendChild(form);
                $('div.overlay').show();

                this.tops.forEach(top=>{
                    top.project_progress = (top.project_progress+"").replace(/,/g , '');
                    top.payment_percentage = (top.payment_percentage+"").replace(/,/g , '');
                })

                let total_price = 0;

                if(this.sales_order.length != undefined){
                    this.quotation.quotation_details.forEach(qd =>{
                        qd.value = (qd.value+"").replace(/,/g , '');
                        qd.total_price = (qd.total_price+"").replace(/,/g , '');
                        total_price += parseFloat((qd.total_price+"").replace(/,/g , ''));
                    })
                    this.submittedForm.pd = this.quotation;

                    this.submittedForm.customer_id = this.quotation.customer_id;
                    this.submittedForm.margin = this.quotation.margin;
                    this.submittedForm.description = this.quotation.description;
                    this.submittedForm.total_price = total_price * (1 + parseFloat(this.quotation.margin) / 100);
                }else{
                    this.sales_order.sales_order_details.forEach(qd =>{
                        qd.value = (qd.value+"").replace(/,/g , '');
                        qd.total_price = (qd.total_price+"").replace(/,/g , '');
                        total_price += parseFloat((qd.total_price+"").replace(/,/g , ''));
                    })
                    this.submittedForm.pd = this.sales_order;

                    this.submittedForm.customer_id = this.sales_order.customer_id;
                    this.submittedForm.margin = this.sales_order.margin;
                    this.submittedForm.description = this.sales_order.description;
                    this.submittedForm.total_price = total_price * (1 + parseFloat(this.sales_order.margin) / 100);
                }
                this.submittedForm.price = total_price;
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
            'quotation.margin': function(newValue){
                if(newValue != ""){
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.quotation.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.quotation.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.quotation.margin = (this.quotation.margin+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }else{
                    this.quotation.margin = 0;
                }
            },
            'sales_order.margin': function(newValue){
                if(newValue != ""){
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.sales_order.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.sales_order.margin = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.sales_order.margin = (this.sales_order.margin+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }else{
                    this.sales_order.margin = 0;
                }
            },
            quotation:{
                handler: function(newValue) {
                    this.quotation.quotation_details.forEach(qd =>{
                        if(qd.value != undefined){
                            var decimal = (qd.value+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    qd.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    qd.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                qd.value = (qd.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            // kalkulasi total price (value {inputan user} * harga pada cost standard)
                            qd.total_price = (((qd.value+"").replace(/,/g , '') * qd.price)+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    })
                },
                deep: true
            },
            sales_order:{
                handler: function(newValue) {
                    if(this.sales_order.length == undefined){
                        this.sales_order.sales_order_details.forEach(sod =>{
                            if(sod.value != undefined){
                                var decimal = (sod.value+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        sod.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        sod.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    sod.value = (sod.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                                // kalkulasi total price (value {inputan user} * harga pada cost standard)
                                sod.total_price = (((sod.value+"").replace(/,/g , '') * sod.price)+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        })
                    }
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
            this.sales_order = @json($sales_order);
            this.quotation = @json($quotation);

            if(this.sales_order.length !=undefined){
                // create sales order
                this.quotation.quotation_details.forEach(qd =>{
                    let status = true;
                    if(this.dataWbs.length > 0){
                        this.dataWbs.forEach(wbs =>{
                            if(wbs.id == qd.estimator_cost_standard.estimator_wbs_id){
                                status = false;
                            }
                        })
                    }
                    if(status){
                        let statusWbs = true;
                        this.dataWbs.forEach(wbs =>{
                            if(wbs.id == qd.estimator_cost_standard.estimator_wbs_id){
                                statusWbs = false;
                            }
                        })
                        if(statusWbs){
                            this.dataWbs.push(qd.estimator_cost_standard.estimator_wbs);
                        }
                    }
                })
                this.tops = JSON.parse(this.quotation.terms_of_payment);
            }else{
                // edit sales order
                this.sales_order.sales_order_details.forEach(sod =>{
                    let status = true;
                    if(this.dataWbs.length > 0){
                        this.dataWbs.forEach(wbs =>{
                            if(wbs.id == sod.estimator_cost_standard.estimator_wbs_id){
                                status = false;
                            }
                        })
                    }
                    if(status){
                        let statusWbs = true;
                        this.dataWbs.forEach(wbs =>{
                            if(wbs.id == sod.estimator_cost_standard.estimator_wbs_id){
                                statusWbs = false;
                            }
                        })
                        if(statusWbs){
                            this.dataWbs.push(sod.estimator_cost_standard.estimator_wbs);
                        }
                    }
                })
                this.tops = JSON.parse(this.sales_order.terms_of_payment);
            }
            this.newIndex = this.tops.length + 1;
        }
    });

</script>
@endpush