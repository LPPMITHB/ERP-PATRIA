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
                                <div class="col-xs-12 col-md-4" v-if="modelProject != null">
                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPR.number}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="modelProject.customer.name"><b>: {{modelProject.customer.name}}</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.planned_start_date}}</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.planned_end_date}}</b></div>
                                </div>
                                    <div class="col-xs-12 col-md-4" v-else>
                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPR.number}}</b></div>

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
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="type">Vendor Name</label>
                                            <selectize v-model="vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="required_date">Required Date</label>
                                            <input v-model="required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="required_date" id="required_date" placeholder="Required Date">  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">PO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="2" v-model="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 p-t-20">
                                            <label for="">Currency :</label>
                                        </div>
                                        <div class="col-sm-9 p-t-15 p-l-0">
                                            <selectize v-model="currency" :settings="currencySettings">
                                                <option v-for="(data, index) in currencies" :value="data.name">{{ data.name }} - {{ data.unit }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body p-t-0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th v-if="modelPR.type == 1" style="width: 25%">Material Name</th>
                                                <th v-else style="width: 25%">Resource Name</th>
                                                <th style="width: 7%">Qty</th>
                                                <th style="width: 8%">Order</th>
                                                <th style="width: 15%">Price / pcs ({{selectedCurrency}})</th>
                                                <th style="width: 25%">WBS Name</th>
                                                <th style="width: 15%">Alocation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(PRD,index) in PRDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td v-if="modelPR.type == 1" class="tdEllipsis">{{ PRD.material.code }} - {{ PRD.material.name }}</td>
                                                <td v-else class="tdEllipsis">{{ PRD.resource.code }} - {{ PRD.resource.name }}</td>
                                                <td class="tdEllipsis">{{ PRD.sugQuantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="PRD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input v-if="modelPR.type == 1" class="form-control width100" v-model="PRD.material.cost_standard_price" placeholder="Please Input Total Price">
                                                    <input v-else class="form-control width100" v-model="PRD.resource.cost_standard_price" placeholder="Please Input Total Price">
                                                </td>
                                                <td class="tdEllipsis" v-if="PRD.wbs != null">{{ PRD.wbs.name }}</td>
                                                <td class="tdEllipsis" v-else>-</td>
                                                <td class="tdEllipsis" v-if="PRD.alocation != null">{{ PRD.alocation }}</td>
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
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Quantity" || title == "Order" || title == "Price / pcs (Rp.)"){
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
        selectedCurrency : "",
        currency : "",
        vendor_id : "",
        required_date : "",
        description : "",
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#po',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
            });
            $("#required_date").datepicker().on(
                "changeDate", () => {
                    this.required_date = $('#required_date').val();
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.vendor_id == "" || this.required_date == "" || this.currency == ""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods : {
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
                var data = this.PRDetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);
                if(this.modelPR.type == 1){
                    data.forEach(PRD => {
                        PRD.quantity = PRD.quantity.replace(/,/g , '');      
                        PRD.material.cost_standard_price = PRD.material.cost_standard_price.replace(/,/g , '');      
                    });
                }else{
                    data.forEach(PRD => {
                        PRD.quantity = PRD.quantity.replace(/,/g , '');      
                        PRD.resource.cost_standard_price = PRD.resource.cost_standard_price.replace(/,/g , '');      
                    });
                }

                this.submittedForm.PRD = data;
                this.submittedForm.type = this.modelPR.type;
                this.submittedForm.vendor_id = this.vendor_id;
                this.submittedForm.currency = this.currency;
                this.submittedForm.required_date = this.required_date;
                this.submittedForm.description = this.description;
                this.submittedForm.pr_id = this.modelPR.id;
                this.submittedForm.project_id = this.modelPR.project_id;
                this.submittedForm.currency = this.currency;

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
                    if(this.modelPR.type == 1){
                        data.forEach(PRD => {
                            PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
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
                        });
                    }else{
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
                        });
                    }
                },
                deep: true
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
                        }else{
                            this.PRDetail.forEach(prd => {
                                prd.resource.cost_standard_price = parseInt((prd.resource.price+"").replace(/,/g , '')) / data.value;
                            });
                        }
                    }
                });
            },
        },
        created: function() {
            this.getVendor();
            var data = this.PRDetail;
            if(this.modelPR.type == 1){
                data.forEach(PRD => {
                    PRD.quantity = PRD.quantity - PRD.reserved;
                    PRD.sugQuantity = PRD.quantity;
                    PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.sugQuantity = (PRD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.material.cost_standard_price = (PRD.material.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                });
            }else{
                data.forEach(PRD => {
                    PRD.quantity = PRD.quantity - PRD.reserved;
                    PRD.sugQuantity = PRD.quantity;
                    PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.sugQuantity = (PRD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    PRD.resource.cost_standard_price = (PRD.resource.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
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
            }else{
                this.PRDetail.forEach(prd => {
                    prd.resource.price = parseInt((prd.resource.cost_standard_price+"").replace(/,/g , ''));
                });
            }
        },
    });
</script>
@endpush
