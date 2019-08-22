@extends('layouts.main')
@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Order » '.$modelPO->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order.index'),
                'Edit Purchase Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_order_repair")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Order » '.$modelPO->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order_repair.index'),
                'Edit Purchase Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            @if($route == "/purchase_order")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('purchase_order.update') }}">
            @elseif($route == "/purchase_order_repair")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('purchase_order_repair.update') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header p-b-0">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPO.purchase_requisition.number}}</b></div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="estimated_freight">Estimated Freight </label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <input class="form-control" v-model="modelPO.estimated_freight" placeholder="Estimated Freight">
                                    </div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="">Tax (%)</label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <input class="form-control" v-model="modelPO.tax" placeholder="Tax">
                                    </div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="">Currency</label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <selectize :disabled="currencyOk" v-model="modelPO.currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.id">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-5 p-t-7">
                                            <label for="">Vendor Name</label>
                                        </div>
                                        <div class="col-sm-7 p-l-0">
                                            <selectize v-model="modelPO.vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="delivery_terms">Delivery Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <selectize v-model="modelPO.delivery_term" :settings="dtSettings">
                                                <option v-for="(delivery_term, index) in delivery_terms" :value="delivery_term.id">{{ delivery_term.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="payment_terms">Payment Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <selectize v-model="modelPO.payment_term" :settings="ptSettings">
                                                <option v-for="(payment_term, index) in payment_terms" :value="payment_term.id">{{ payment_term.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row" v-if="modelPO.purchase_requisition.type == 3">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="delivery_date_subcon">Delivery Date</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input v-model="delivery_date_subcon" autocomplete="off" type="text" class="form-control datepicker" name="delivery_date_subcon" id="delivery_date_subcon" placeholder="Delivery Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-5 p-t-5">
                                            <label for="projects">Project Number</label>
                                        </div>
                                        <div class="col-sm-7 p-t-0 p-l-0">
                                            <selectize v-model="modelPO.project_id" :settings="projectSettings">
                                                <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">PO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="2" v-model="modelPO.description"></textarea>
                                        </div>
                                        <template v-if="modelPO.status == 3">
                                            <div class="col-sm-12">
                                                <label for="">Revision Description</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" rows="2" v-model="modelPO.revision_description"></textarea>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed p-t-10 m-b-5" style="border-collapse:collapse;" v-if="modelPO.purchase_requisition.type != 3">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <template v-if="modelPO.purchase_requisition.type == 1">
                                                    <th width="15%">Material Number</th>
                                                    <th width="21%">Material Description</th>
                                                </template>
                                                <template v-else>
                                                    <th width="15%">Resource Number</th>
                                                    <th width="21%">Resource Description</th>
                                                </template>
                                                <th style="width: 8%">Requested Quantity</th>
                                                <th style="width: 8%">Order Quantity</th>
                                                <th style="width: 6%">Unit</th>
                                                <th style="width: 10%">Price per pcs ({{selectedCurrency}})</th>
                                                <th style="width: 7%">Disc. (%)</th>
                                                <th style="width: 10%">Delivery Date</th>
                                                <th style="width: 8%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(POD,index) in PODetail">
                                                <td>{{ index + 1 }}</td>
                                                <template v-if="modelPO.purchase_requisition.type == 1">
                                                    <td class="tdEllipsis">{{ POD.material.code }}</td>
                                                    <td class="tdEllipsis">{{ POD.material.description }}</td>
                                                </template>
                                                <template v-else>
                                                    <td class="tdEllipsis">{{ POD.resource.code }}</td>
                                                    <td class="tdEllipsis">{{ POD.resource.name }}</td>
                                                </template>
                                                <td class="tdEllipsis">{{ POD.purchase_requisition_detail.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis" v-if="modelPO.purchase_requisition.type == 1">{{ POD.material.uom.unit }}</td>
                                                <td class="tdEllipsis" v-else>-</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.total_price" placeholder="Please Input Total Price">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.discount" placeholder="Discount">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input v-model="POD.delivery_date" required autocomplete="off" type="text" class="form-control datepicker width100 delivery_date" name="delivery_date" :id="makeId(POD.id)" placeholder="Delivery Date">
                                                </td>
                                                <td class="textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(POD,index)">
                                                        REMARK
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" style="border-collapse:collapse;" v-if="modelPO.purchase_requisition.type == 3">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 35%">Job Order</th>
                                                <th style="width: 10%">Project</th>
                                                <th style="width: 10%">WBS</th>
                                                <th style="width: 20%">Price / Service ({{selectedCurrency}})</th>
                                                <th style="width: 10%">Disc. (%)</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(POD,index) in PODetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{POD.job_order}}</td>
                                                <td class="tdEllipsis">{{POD.purchase_requisition_detail.project.number}} - {{POD.purchase_requisition_detail.project.name}}</td>
                                                <td class="tdEllipsis">{{POD.purchase_requisition_detail.wbs.number}} - {{POD.purchase_requisition_detail.wbs.description}}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.total_price" placeholder="Please Input Total Price">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.discount" placeholder="Discount">
                                                </td>
                                                <td class="textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(PRD,index)">
                                                        REMARK
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="dataOk">SAVE</button>
                            </div>
                            <div class="modal fade" id="edit_item">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Input Remark</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="remark" class="control-label">Remark</label>
                                                    <textarea name="remark" id="remark" rows="3" v-model="editRemark.remark" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#edit-po');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        payment_terms : @json($payment_terms),
        delivery_terms : @json($delivery_terms),
        modelPO : @json($modelPO),
        PODetail : @json($modelPOD),
        projects : @json($projects),
        currencies : @json($currencies),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        currencySettings: {
            placeholder: 'Please Select Currency'
        },
        dtSettings: {
            placeholder: 'Please Select Delvery Term'
        },
        ptSettings: {
            placeholder: 'Please Select Payment Term'
        },
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        selectedCurrency: "",
        submittedForm : {},
        editRemark : {
            remark : "",
        },
        delivery_date : "",
        delivery_date_subcon : @json($modelPO->delivery_date),
    }

    var vm = new Vue({
        el : '#po',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $(".delivery_date").datepicker().on(
                "changeDate", () => {
                    this.PODetail.forEach(POD => {
                        POD.delivery_date = $('#datepicker'+POD.id).val();
                    });
                }
            );
            $("#delivery_date_subcon").datepicker().on(
                "changeDate", () => {
                    this.delivery_date_subcon = $('#delivery_date_subcon').val();
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.modelPO.purchase_requisition.type != 3){
                    if(this.modelPO.vendor_id == "" || this.modelPO.currency == "" || this.delivery_date == ""){
                        isOk = true;
                    }
                }else{
                    if(this.modelPO.vendor_id == "" || this.modelPO.currency == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                    if(this.editRemark.remark == null || this.editRemark.remark == ""){
                        isOk = true;
                    }
                return isOk;
            },
            currencyOk : function(){
                let isOk = false;
                var currency_value = 1;
                this.currencies.forEach(data => {
                    if(this.modelPO.currency == data.name && this.modelPO.currency != "Rupiah"){
                        currency_value = data.value;
                    }
                });

                this.PODetail.forEach(POD => {
                    var ref = 0;
                    var decimal = ((POD.old_price / currency_value)+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            ref = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            ref = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        ref = (decimal[0]+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    if(parseFloat(POD.total_price.replace(/,/g , '')) != ref.replace(/,/g, '')){
                        isOk = true;
                    }
                });
                return isOk;
            }
        },
        methods : {
            makeId(id){
                return "datepicker"+id;
            },
            tooltip(text){
                Vue.directive('tooltip', function(el, binding){
                    $(el).tooltip('destroy');
                    $(el).tooltip({
                        title: text,
                        placement: binding.arg,
                        trigger: 'hover'
                    })
                })
                return text
            },
            getVendor(){
                $('div.overlay').show();
                window.axios.get('/api/getVendor').then(({ data }) => {
                    this.modelVendor = data;
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
            },
            openEditModal(POD,index){
                this.editRemark.remark = POD.remark;
                this.editRemark.index = index;
            },
            update(){

                var pod = this.PODetail[this.editRemark.index];

                pod.remark = this.editRemark.remark;

            },
            submitForm(){
                $('div.overlay').show();
                var data = this.PODetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);

                this.modelPO.estimated_freight = this.modelPO.estimated_freight.replace(/,/g , '');
                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , '');
                    POD.total_price = POD.total_price.replace(/,/g , '');
                });

                this.submittedForm.modelPO = this.modelPO;
                this.submittedForm.PODetail = data;
                this.submittedForm.type = this.type;
                this.submittedForm.delivery_date_subcon = this.delivery_date_subcon;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            PODetail:{
                handler: function(newValue) {
                    var data = newValue;
                    var status = 0;
                    data.forEach(POD => {
                        // discount
                        var discount = parseInt((POD.discount+"").replace(/,/g, ''));
                        if(discount > 100){
                            iziToast.warning({
                                title: 'Discount cannot exceed 100% !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            POD.discount = 100;
                        }
                        var decimal = (POD.discount+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                POD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                POD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            POD.discount = (POD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                        // total price
                        var decimal = (POD.total_price+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            POD.total_price = (POD.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                        // quantity
                        if(POD.purchase_requisition_detail.purchase_requisition.type == 1){
                            if(POD.material.uom.is_decimal == 0){
                                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else{
                                var decimal = (POD.quantity+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        POD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        POD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    POD.quantity = (POD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }
                            // delivery date
                            if(POD.delivery_date == null || POD.delivery_date == ""){
                                this.delivery_date = "";
                                status = 1;
                            }
                            if(status == 0){
                                this.delivery_date = "ok";
                            }
                        }else if(POD.purchase_requisition_detail.purchase_requisition.type == 2){
                            POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // delivery date
                            if(POD.delivery_date == null || POD.delivery_date == ""){
                                this.delivery_date = "";
                                status = 1;
                            }
                            if(status == 0){
                                this.delivery_date = "ok";
                            }
                        }else{
                            POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                    });
                },
                deep: true
            },
            'modelPO.tax' : function (newValue){
                var tax = (newValue+"").replace(/,/g, '');
                if(newValue > 100){
                    iziToast.warning({
                        title: 'Tax cannot exceed 100% !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.modelPO.tax = 100;
                }
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.modelPO.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.modelPO.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.modelPO.tax = (this.modelPO.tax+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'modelPO.estimated_freight': function (newValue){
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.modelPO.estimated_freight = (this.modelPO.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'modelPO.currency':function (newValue) {
                if(newValue == ''){
                    this.modelPO.currency = this.currencies[0].name;
                }
                this.currencies.forEach(data => {
                    if(newValue == data.name){
                        this.selectedCurrency = data.unit;
                        this.PODetail.forEach(pod => {
                            pod.total_price = parseFloat((pod.price+"").replace(/,/g , '')) / data.value;
                        });
                    }
                });
            },
            'modelPO.vendor_id':function(newValue){
                this.modelVendor.forEach(vendor=>{
                    if(vendor.id == newValue){
                        this.modelPO.delivery_term = vendor.delivery_term;
                        this.modelPO.payment_term = vendor.payment_term;
                    }
                })
            }
        },
        created: function() {
            this.getVendor();
            this.modelPO.estimated_freight = this.modelPO.estimated_freight / this.modelPO.value;
            var decimal = (this.modelPO.estimated_freight+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.modelPO.estimated_freight = (this.modelPO.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            this.type = this.modelPO.purchase_requisition.type;

            var data = this.PODetail;
            data.forEach(POD => {
                if(POD.purchase_requisition_detail.purchase_requisition.type != 3){
                    POD.delivery_date = POD.delivery_date.split("-").reverse().join("-");
                }
                POD.price = parseFloat((POD.total_price / POD.quantity+"").replace(/,/g , ''));
                POD.total_price = (POD.total_price / this.modelPO.value) / POD.quantity;

                // quantity
                if(POD.purchase_requisition_detail.purchase_requisition.type == 1){
                    if(POD.material.uom.is_decimal == 0){
                            POD.purchase_requisition_detail.quantity = (POD.purchase_requisition_detail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }else{
                        var decimal = (POD.purchase_requisition_detail.quantity+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                POD.purchase_requisition_detail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                POD.purchase_requisition_detail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            POD.purchase_requisition_detail.quantity = (POD.purchase_requisition_detail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
                var decimal = (POD.total_price+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    POD.total_price = (POD.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                if(POD.purchase_requisition_detail.purchase_requisition.type != 3){
                    if(POD.delivery_date == null || POD.delivery_date == ""){
                        this.delivery_date = "";
                        status = 1;
                    }
                    if(status == 0){
                        this.delivery_date = "ok";
                    }
                }

            });

            this.currencies.forEach(data => {
                if(this.modelPO.currency == data.name){
                    this.selectedCurrency = data.unit;
                }
            });


        },
    });
</script>
@endpush
