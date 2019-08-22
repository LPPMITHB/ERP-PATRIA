@extends('layouts.main')
@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => 'Create Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_order.selectPR'),
                'Select Material' => route('purchase_order.selectPRD',$modelPR->id),
                'Create Purchase Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_order_repair")
    @breadcrumb(
        [
            'title' => 'Create Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_order_repair.selectPR'),
                'Select Material' => route('purchase_order_repair.selectPRD',$modelPR->id),
                'Create Purchase Order' => '',
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
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('purchase_order.store') }}">
            @elseif($route == "/purchase_order_repair")
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('purchase_order_repair.store') }}">
            @endif
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPR.number}}</b></div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="estimated_freight">Estimated Freight </label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <input class="form-control" v-model="estimated_freight" placeholder="Estimated Freight">
                                    </div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="">Tax (%)</label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <input class="form-control" v-model="tax" placeholder="Tax">
                                    </div>

                                    <div class="col-sm-5 no-padding p-t-15">
                                        <label for="">Currency</label>
                                    </div>
                                    <div class="col-sm-7 p-t-13 p-l-0">
                                        <selectize :disabled="currencyOk" v-model="currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.name">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-5 p-t-7">
                                            <label for="">Vendor Name</label>
                                        </div>
                                        <div class="col-sm-7 p-l-0">
                                            <selectize v-model="vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="delivery_terms">Delivery Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="delivery_terms" placeholder="Delivery Terms">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="payment_terms">Payment Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="payment_terms" placeholder="Payment Terms">
                                        </div>
                                    </div>
                                    <div class="row" v-if="modelPR.type == 3">
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
                                        <div class="col-sm-12">
                                            <label for="">PO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" v-model="description"></textarea>
                                        </div>
                                        <div class="col-sm-12 p-t-5" v-if="modelPR.type != 3">
                                            <a class="btn btn-primary btn-xs pull-right" data-toggle="modal" href="#vendor_list" @click.prevent="vendor_list">
                                                VENDOR LIST
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body p-t-0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" style="border-collapse:collapse;" v-if="modelPR.type != 3">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <template v-if="modelPR.type == 1">
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
                                            <tr v-for="(PRD,index) in PRDetail">
                                                <td>{{ index + 1 }}</td>
                                                <template v-if="modelPR.type == 1">
                                                    <td class="tdEllipsis">{{ PRD.material.code }}</td>
                                                    <td class="tdEllipsis">{{ PRD.material.description }}</td>
                                                </template>
                                                <template v-else>
                                                    <td class="tdEllipsis">{{ PRD.resource.code }}</td>
                                                    <td class="tdEllipsis">{{ PRD.resource.name }}</td>
                                                </template>
                                                <td class="tdEllipsis">{{ PRD.sugQuantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="PRD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis" v-if="modelPR.type == 1">{{ PRD.material.uom.unit }}</td>
                                                <td class="tdEllipsis" v-else>-</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input v-if="modelPR.type == 1" class="form-control width100" v-model="PRD.material.cost_standard_price" placeholder="Please Input Total Price">
                                                    <input v-else class="form-control width100" v-model="PRD.resource.cost_standard_price" placeholder="Please Input Total Price">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="PRD.discount" placeholder="Discount">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input v-model="PRD.required_date" required autocomplete="off" type="text" class="form-control datepicker width100 delivery_date" name="delivery_date" :id="makeId(PRD.id)" placeholder="Delivery Date">
                                                </td>
                                                <td class="textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(PRD,index)">
                                                        REMARK
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" style="border-collapse:collapse;" v-if="modelPR.type == 3">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 35%">Job Order</th>
                                                <th style="width: 10%">Area</th>
                                                <th style="width: 10%">Area Unit</th>
                                                <th style="width: 20%">Price / Service ({{selectedCurrency}})</th>
                                                <th style="width: 10%">Disc. (%)</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(PRD,index) in PRDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{PRD.activity_detail.job_order}}</td>
                                                <td class="tdEllipsis">{{PRD.activity_detail.area}}</td>
                                                <td class="tdEllipsis">{{PRD.activity_detail.area_uom.name}}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="PRD.activity_detail.service_detail.cost_standard_price" placeholder="Please Input Total Price">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="PRD.discount" placeholder="Discount">
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
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="dataOk">CREATE</button>
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

                            <div class="modal fade" id="vendor_list">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Vendor List</h4>
                                        </div>
                                        <div class="modal-body p-b-0">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="">Material</label>
                                                    <selectize v-model="vendorList.material_id" :settings="materialSettings">
                                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12" v-if="vendorList.material_id != ''">
                                                    <table class="table table-bordered tableFixed p-t-10 showTable" style="border-collapse:collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%">No</th>
                                                                <th style="width: 60%">Vendor</th>
                                                                <th style="width: 15%">Count</th>
                                                                <th style="width: 20%">Last Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(po,index) in vendorList.po_list">
                                                                <td>{{ index+1 }}</td>
                                                                <td>{{ po.vendor_code }} - {{ po.vendor_name }}</td>
                                                                <td>{{ po.count }} Time(s)</td>
                                                                <td>Rp.{{ po.price }}</td>
                                                            </tr>
                                                            <template v-if="vendorList.po_list.length < 1">
                                                                <tr>
                                                                    <td colspan="4" class="textCenter">No Transaction For This Material</td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="close">CLOSE</button>
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
    const form = document.querySelector('form#create-po');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Qty" || title == "Order" || title == "Price / pcs (Rp)" || title == "Disc. (%)"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tableNonPagingVue.column(i).search() !== this.value ) {
                    tableNonPagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tableNonPagingVue = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
            ordering        : false,
        });



        $('div.overlay').hide();
    });

    var data = {
        materials : @json($materials),
        modelPR : @json($modelPR),
        PRDetail : @json($modelPRD),
        modelProject : @json($modelProject),
        currencies : @json($currencies),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        currencySettings: {
            placeholder: 'Please Select Currency'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        selectedCurrency : "",
        currency : "",
        tax : "",
        estimated_freight : "",
        delivery_terms : "",
        payment_terms : "",
        vendor_id : "",
        delivery_date : "",
        delivery_date_subcon : "",
        description : "",
        editRemark : {
            remark : "",
        },
        submittedForm : {},
        vendorList : {
            material_id : "",
            po_list : [],
        }
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
                    this.PRDetail.forEach(PRD => {
                        PRD.required_date = $('#datepicker'+PRD.id).val();
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
                if(this.modelPR.type != 3){
                    if(this.vendor_id == "" || this.delivery_date == "" || this.currency == ""){
                        isOk = true;
                    }
                }else{
                    if(this.vendor_id == "" || this.currency == ""){
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
                    if(this.currency == data.name && this.currency != "Rupiah"){
                        currency_value = data.value;
                    }
                });

                this.PRDetail.forEach(PRD => {
                    var ref = 0;
                    var decimal = ((PRD.old_price / currency_value)+"").replace(/,/g, '').split('.');
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
                    if(parseFloat((PRD.old_price+"").replace(/,/g , '')) != ref.replace(/,/g, '')){
                        isOk = true;
                    }
                });
                return isOk;
            },
        },
        methods : {
            vendor_list(){
                this.vendorList.material_id = "";
            },
            makeId(id){
                return "datepicker"+id;
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
            openEditModal(PRD,index){

                this.editRemark.remark = PRD.remark;
                this.editRemark.index = index;
            },
            update(){

                var prd = this.PRDetail[this.editRemark.index];

                prd.remark = this.editRemark.remark;

            },
            submitForm(){
                $('div.overlay').show();
                var data = this.PRDetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);
                if(this.modelPR.type == 1){
                    data.forEach(PRD => {
                        PRD.quantity = PRD.quantity.replace(/,/g , '');
                        PRD.material.cost_standard_price = PRD.material.cost_standard_price.replace(/,/g , '');
                    });
                }else if(this.modelPR.type == 2){
                    data.forEach(PRD => {
                        PRD.quantity = PRD.quantity.replace(/,/g , '');
                        PRD.resource.cost_standard_price = PRD.resource.cost_standard_price.replace(/,/g , '');
                    });
                }
                this.estimated_freight = this.estimated_freight.replace(/,/g , '');

                this.submittedForm.PRD = data;
                this.submittedForm.type = this.modelPR.type;
                this.submittedForm.vendor_id = this.vendor_id;
                this.submittedForm.currency = this.currency;
                this.submittedForm.description = this.description;
                this.submittedForm.pr_id = this.modelPR.id;
                this.submittedForm.currency = this.currency;
                this.submittedForm.tax = this.tax;
                this.submittedForm.estimated_freight = this.estimated_freight;
                this.submittedForm.delivery_terms = this.delivery_terms;
                this.submittedForm.payment_terms = this.payment_terms;
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
            PRDetail:{
                handler: function(newValue) {
                    var data = newValue;
                    var status = 0;
                    if(this.modelPR.type == 1){
                        data.forEach(PRD => {
                            // quantity
                            if(PRD.material.uom.is_decimal == 0){
                                PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else{
                                var decimal = (PRD.quantity+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        PRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        PRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    PRD.quantity = (PRD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }

                            // cost standard price
                            var decimal = (PRD.material.cost_standard_price+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    PRD.material.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    PRD.material.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                PRD.material.cost_standard_price = (PRD.material.cost_standard_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }

                            // discount
                            var discount = parseInt((PRD.discount+"").replace(/,/g, ''));
                            if(discount > 100){
                                iziToast.warning({
                                    title: 'Discount cannot exceed 100% !',
                                    position: 'topRight',
                                    displayMode: 'replace'
                                });
                                PRD.discount = 100;
                            }
                            var decimal = (PRD.discount+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                PRD.discount = (PRD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }

                            // delivery date
                            if(PRD.required_date == null || PRD.required_date == ""){
                                this.delivery_date = "";
                                status = 1;
                            }
                            if(status == 0){
                                this.delivery_date = "ok";
                            }
                        });
                    }else if(this.modelPR.type == 2){
                        data.forEach(PRD => {
                            PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            var decimal = (PRD.resource.cost_standard_price+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    PRD.resource.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    PRD.resource.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                PRD.resource.cost_standard_price = (PRD.resource.cost_standard_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            var discount = parseInt((PRD.discount+"").replace(/,/g, ''));
                            if(discount > 100){
                                iziToast.warning({
                                    title: 'Discount cannot exceed 100% !',
                                    position: 'topRight',
                                    displayMode: 'replace'
                                });
                                PRD.discount = 100;
                            }
                            var decimal = (PRD.discount+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                PRD.discount = (PRD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            if(PRD.required_date == null || PRD.required_date == ""){
                                this.delivery_date = "";
                                status = 1;
                            }
                            if(status == 0){
                                this.delivery_date = "ok";
                            }
                        });
                    }else{
                        data.forEach(PRD => {

                        // cost standard price
                        var decimal = (PRD.activity_detail.service_detail.cost_standard_price+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                PRD.activity_detail.service_detail.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                PRD.activity_detail.service_detail.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            PRD.activity_detail.service_detail.cost_standard_price = (PRD.activity_detail.service_detail.cost_standard_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                        // discount
                        var discount = parseInt((PRD.discount+"").replace(/,/g, ''));
                        if(discount > 100){
                            iziToast.warning({
                                title: 'Discount cannot exceed 100% !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            PRD.discount = 100;
                        }
                        var decimal = (PRD.discount+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                PRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            PRD.discount = (PRD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        });
                    }
                },
                deep: true
            },
            'tax' : function (newValue){
                var tax = parseInt((newValue+"").replace(/,/g, ''));
                if(newValue > 100){
                    iziToast.warning({
                        title: 'Tax cannot exceed 100% !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.tax = 100;
                }
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.tax = (this.tax+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'estimated_freight': function (newValue){
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.estimated_freight = (this.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'currency':function (newValue) {
                if(newValue == ''){
                    this.currency = this.currencies[0].name;
                }
                this.currencies.forEach(data => {
                    if(newValue == data.name){
                        this.selectedCurrency = data.unit;
                        if(this.modelPR.type == 1){
                            this.PRDetail.forEach(prd => {
                                prd.material.cost_standard_price = parseInt((prd.material.price+"").replace(/,/g , '')) / data.value;
                            });
                        }else if(this.modelPR.type == 2){
                            this.PRDetail.forEach(prd => {
                                prd.resource.cost_standard_price = parseInt((prd.resource.price+"").replace(/,/g , '')) / data.value;
                            });
                        }else{
                            this.PRDetail.forEach(prd => {
                                prd.activity_detail.service_detail.cost_standard_price = parseInt((prd.activity_detail.service_detail.price+"").replace(/,/g , '')) / data.value;
                            });
                        }
                    }
                });
            },
            'vendorList.material_id':function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getVendorList/'+newValue).then(({ data }) => {
                        this.vendorList.po_list = data;
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    })
                }else{
                    this.vendorList.po_list = [];
                }
            },
            'vendorList.po_list':function(newValue){
                this.vendorList.po_list.forEach(data=>{
                    var decimal = (data.price+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            data.price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            data.price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        data.price = (data.price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                })
            }
        },
        created: function() {
            this.getVendor();
            var data = this.PRDetail;
            var status = 0;
            if(this.modelPR.type == 1){
                data.forEach(PRD => {
                    // separator quantity
                    PRD.quantity = PRD.quantity - PRD.reserved;
                    PRD.sugQuantity = PRD.quantity;
                    if(PRD.material.uom.is_decimal == 0){
                        PRD.sugQuantity = (PRD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }else{
                        var decimal = (PRD.sugQuantity+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                PRD.sugQuantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                PRD.sugQuantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            PRD.sugQuantity = (PRD.sugQuantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }

                    PRD.material.cost_standard_price = (PRD.material.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.required_date = (PRD.required_date != null) ? PRD.required_date.split("-").reverse().join("-") : null;

                    if(PRD.required_date == null || PRD.required_date == ""){
                        this.delivery_date = "";
                        status = 1;
                    }
                    if(status == 0){
                        this.delivery_date = "ok";
                    }
                });
            }else if(this.modelPR.type == 2){
                data.forEach(PRD => {
                    PRD.quantity = PRD.quantity - PRD.reserved;
                    PRD.sugQuantity = PRD.quantity;
                    PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.sugQuantity = (PRD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.resource.cost_standard_price = (PRD.resource.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.required_date = (PRD.required_date != null) ? PRD.required_date.split("-").reverse().join("-") : null;

                    if(PRD.required_date == null || PRD.required_date == ""){
                        this.delivery_date = "";
                        status = 1;
                    }
                    if(status == 0){
                        this.delivery_date = "ok";
                    }
                });
            }else{
                data.forEach(PRD => {
                    PRD.activity_detail.service_detail.cost_standard_price = (PRD.activity_detail.service_detail.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            }
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'
                })
            });

            this.currency = this.currencies[0].name;
            this.selectedCurrency = this.currencies[0].unit;

            if(this.modelPR.type == 1){
                this.PRDetail.forEach(prd => {
                    prd.material.price = parseInt((prd.material.cost_standard_price+"").replace(/,/g , ''));
                });
            }else if(this.modelPR.type == 2){
                this.PRDetail.forEach(prd => {
                    prd.resource.price = parseInt((prd.resource.cost_standard_price+"").replace(/,/g , ''));
                });
            }
        },
    });
</script>
@endpush
