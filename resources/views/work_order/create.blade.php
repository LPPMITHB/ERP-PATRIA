@extends('layouts.main')
@section('content-header')
@if($route == "/work_order")
    @breadcrumb(
        [
            'title' => 'Create Work Order » Select Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Work Requisition' => route('work_order.selectWR'),
                'Select Material' => route('work_order.selectWRD',$modelWR->id),
                'Create Work Order' => "",
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/work_order_repair")
    @breadcrumb(
        [
            'title' => 'Create Work Order » Select Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Work Requisition' => route('work_order_repair.selectWR'),
                'Select Material' => route('work_order_repair.selectWRD',$modelWR->id),
                'Create Work Order' => "",
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
            @if($route == "/work_order")
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('work_order.store') }}">
            @elseif($route == "/work_order_repair")
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('work_order_repair.store') }}">
            @endif        
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12 col-md-4" v-if="modelProject != null">
                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWR.number}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="modelProject.customer.name"><b>: {{modelProject.customer.name}}</b></div>

                                    <div class="col-sm-3 no-padding p-t-15">
                                        <label for="">Currency *</label>
                                    </div>
                                    <div class="col-sm-9 p-t-13 p-l-0">
                                        <selectize :disable="currencyOk" v-model="currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.id">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-3 no-padding p-t-10">
                                        <label for="">Tax (%)</label>
                                    </div>
                                    <div class="col-sm-9 p-t-5 p-l-0">
                                        <input class="form-control" v-model="tax" placeholder="Tax">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4" v-else>
                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWR.number}}</b></div>

                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-sm-3 no-padding p-t-15">
                                        <label for="">Currency *</label>
                                    </div>
                                    <div class="col-sm-9 p-t-13 p-l-0">
                                        <selectize v-model="currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.id">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-3 no-padding p-t-10">
                                        <label for="">Tax (%)</label>
                                    </div>
                                    <div class="col-sm-9 p-t-5 p-l-0">
                                        <input class="form-control" v-model="tax" placeholder="Tax">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-5 p-t-7">
                                            <label for="">Vendor Name *</label>
                                        </div>
                                        <div class="col-sm-7 p-l-0">
                                            <selectize v-model="vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5 p-t-10">
                                            <label for="delivery_terms">Delivery Term</label>
                                        </div>
                                        <div class="col-sm-7 p-t-5 p-l-0">
                                            <selectize v-model="delivery_term" :settings="dtSettings">
                                                <option v-for="(delivery_term, index) in delivery_terms" :value="delivery_term.id">{{ delivery_term.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5 p-t-10">
                                            <label for="payment_terms">Payment Term</label>
                                        </div>
                                        <div class="col-sm-7 p-t-5 p-l-0">
                                            <selectize v-model="payment_term" :settings="ptSettings">
                                                <option v-for="(payment_term, index) in payment_terms" :value="payment_term.id">{{ payment_term.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5 p-t-10">
                                            <label for="estimated_freight">Estimated Freight ({{selectedCurrency}})</label>
                                        </div>
                                        <div class="col-sm-7 p-t-5 p-l-0">
                                            <input class="form-control" v-model="estimated_freight" placeholder="Estimated Freight">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">WO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" v-model="description"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3 p-t-15">
                                            <label for="delivery_date">Delivery Date *</label>
                                        </div>
                                        <div class="col-sm-9 p-t-13 p-l-0">
                                            <input v-model="delivery_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="delivery_date" id="delivery_date" placeholder="Delivery Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body p-t-0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed" id="wo-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 15%">Material Number</th>
                                                <th style="width: 15%">Material Description</th>
                                                <th style="width: 5%">Unit</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">Order</th>
                                                <th style="width: 15%">Price / pcs ({{selectedCurrency}})</th>
                                                <th style="width: 10%">Discount (%)</th>
                                                <th style="width: 25%">WBS Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(WRD,index) in WRDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.material.code)">{{ WRD.material.code }} </td>
                                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.material.description)">{{ WRD.material.description }}</td>
                                                <td class="tdEllipsis">{{ WRD.material.uom.unit }}</td>
                                                <td class="tdEllipsis">{{ WRD.sugQuantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.cost" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.discount" placeholder="Discount">
                                                </td>
                                                <td class="tdEllipsis" v-if="WRD.wbs != null">{{ WRD.wbs.number }} - {{ WRD.wbs.description}}</td>
                                                <td class="tdEllipsis" v-else>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="dataOk">CREATE</button>
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
        // $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        // $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Quantity" || title == "Order" || title == "Price / pcs (Rp.)" || title == "Discount (%)"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( tableNonPagingVue.column(i).search() !== this.value ) {
        //             tableNonPagingVue
        //                 .column(i)
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     });
        // });

        // var tableNonPagingVue = $('.tableNonPagingVue').DataTable( {
        //     orderCellsTop   : true,
        //     paging          : false,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : false,
        //     ordering        : false,
        // });

        // $('div.overlay').hide();
        $('#wo-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        payment_terms : @json($payment_terms),
        delivery_terms : @json($delivery_terms),
        payment_term : null,
        delivery_term : null,
        modelWR : @json($modelWR),
        WRDetail : @json($modelWRD),
        currencies : @json($currencies),
        modelProject : @json($modelProject),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        currencySettings: {
            placeholder: 'Please Select Currency'
        },
        dtSettings: {
            placeholder: 'Please Select Delivery Term'
        },
        ptSettings: {
            placeholder: 'Please Select Payment Term'
        },
        vendor_id : "",
        selectedCurrency : "",
        currency : "",
        tax : "",
        estimated_freight : "",
        vendor_id : "",
        delivery_date : "",
        description : "",
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#po',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#delivery_date").datepicker().on(
                "changeDate", () => {
                    this.delivery_date = $('#delivery_date').val();
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.vendor_id == "" || this.delivery_date == ""){
                    isOk = true;
                }
                this.WRDetail.forEach(wrd => {
                    if(wrd.cost == 0 || wrd.cost == ""){
                        isOk = true;
                    }
                });
                return isOk;
            },
            currencyOk : function(){
            },
        },
        methods : {
            tooltipText: function(text) {
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
            submitForm(){
                var data = this.WRDetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);

                data.forEach(WRD => {
                    WRD.quantity = WRD.quantity.replace(/,/g , '');      
                    WRD.cost = (WRD.cost).replace(/,/g , '');      
                });

                this.submittedForm.WRD = data;
                this.submittedForm.vendor_id = this.vendor_id;
                this.submittedForm.delivery_date = this.delivery_date;
                this.submittedForm.description = this.description;
                this.submittedForm.wr_id = this.modelWR.id;
                this.submittedForm.project_id = this.modelWR.project_id;
                this.submittedForm.payment_term = this.payment_term;
                this.submittedForm.delivery_term = this.delivery_term;
                this.submittedForm.currency = this.currency;
                this.submittedForm.estimated_freight = this.estimated_freight.replace(/,/g , '');
                this.submittedForm.tax = this.tax;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            WRDetail:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(WRD => {
                        var is_decimal = WRD.material.uom.is_decimal;
                        if(is_decimal == 0){
                            WRD.quantity = (WRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        }else{
                            var decimal = WRD.quantity.replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    WRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    WRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                WRD.quantity = (WRD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        } 

                        var decimal = (WRD.cost+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WRD.cost = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WRD.cost = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WRD.cost = (WRD.cost+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } 

                        var discount = parseInt((WRD.discount+"").replace(/,/g, ''));
                        if(discount > 100){
                            iziToast.warning({
                                title: 'Discount cannot exceed 100% !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            WRD.discount = 100;
                        }
                        var decimal = (WRD.discount+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WRD.discount = (WRD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }  
                    });
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
            'vendor_id':function(newValue){
                this.modelVendor.forEach(vendor=>{
                    if(vendor.id == newValue){
                        this.delivery_term = vendor.delivery_term;
                        this.payment_term = vendor.payment_term;
                    }
                })
            },
            'currency':function (newValue) {
                if(newValue == ''){
                    this.currency = this.currencies[0].id;
                }
                this.currencies.forEach(data => {
                    if(newValue == data.id){
                        this.selectedCurrency = data.unit;
                    }
                });
            },
        },
        created: function() {
            this.getVendor();
            var data = this.WRDetail;
            data.forEach(WRD => {
                WRD.quantity = WRD.quantity - WRD.reserved;
                var is_decimal = WRD.material.uom.is_decimal;
                if(is_decimal == 0){
                    WRD.quantity = (WRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = (WRD.quantity+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            WRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            WRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        WRD.quantity = (WRD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                } 
                WRD.sugQuantity = WRD.quantity;
            });
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })

            this.currency = this.currencies[0].id;
            this.selectedCurrency = this.currencies[0].unit;
        },
    });
</script>
@endpush
