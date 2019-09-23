@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View Stocks Management',
        'items' => [
            'Dashboard' => route('index'),
            'View Stocks Management' => route('stock_management.index'),
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
                <form id="view-stock" class="form-horizontal">
                @csrf
                    @verbatim
                    <div id="stockmanagement">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12 p-l-20">
                                        <label for="">Warehouse</label>
                                        <selectize v-model="warehouse_id" :settings="warehouseSettings">
                                            <option v-for="(warehouse, index) in warehouses" :value="warehouse.id">{{warehouse.name}}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 p-l-20">
                                        <label for="">Storage Location</label>
                                        <selectize v-model="sloc_id" :settings="slocSettings">
                                            <option v-for="(storageLocation, index) in storageLocations" :value="storageLocation.id">{{storageLocation.name}}</option>
                                        </selectize>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row p-l-15">
                                    <label for="">Stock Information</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">Total Inventory Value</div>
                                    <div class="col-sm-6">: {{stockValue}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">Total Inventory Quantity</div>
                                    <div class="col-sm-6">: {{stockQuantity}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">Total Reserved Quantity</div>
                                    <div class="col-sm-6">: {{reservedStockQuantity}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">Total Available Quantity</div>
                                    <div class="col-sm-6">: {{availableQuantity}}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <template v-if='warehouse_id !=""'>
                                    <div class="row p-l-15">
                                        <label for="">Warehouse Information</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">Total Inventory Value</div>
                                        <div class="col-sm-6">: {{warehouseValue}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">Total Inventory Quantity</div>
                                        <div class="col-sm-6">: {{warehouseQuantity}}</div>
                                    </div>
                                </template>

                                <template v-if='sloc_id !=""'>
                                    <div class="row p-l-15">
                                        <label for="">Storage Location Information</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">Total Inventory Value</div>
                                        <div class="col-sm-6">: {{slocValue}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">Total Inventory Quantity</div>
                                        <div class="col-sm-6">: {{slocQuantity}}</div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="row">
                            <div v-show="warehouse_id == ''">
                                <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                                    <table class="table table-bordered showTable tablePagingVue tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">Material Number</th>
                                            <th style="width: 25%">Material Description</th>
                                            <th style="width: 6.66%">Stock Quantity</th>
                                            <th style="width: 6.66%">Reserved Stock</th>
                                            <th style="width: 6.66%">Available Stock</th>
                                            <th style="width: 5%">Unit</th>
                                            <th style="width: 15%">Total Value</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(stock,index) in stocks">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ stock.material.code }}</td>
                                                <td class="tdEllipsis">{{ stock.material.description }}</td>
                                                <td class="tdEllipsis">{{ stock.quantity }}</td>
                                                <td class="tdEllipsis">{{ stock.reserved }}</td>
                                                <td class="tdEllipsis">{{ stock.quantity-stock.reserved }}</td>
                                                <td class="tdEllipsis">{{ stock.material.uom.unit }}</td>
                                                <td class="tdEllipsis">Rp {{ (stock.material.cost_standard_price * stock.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-show="warehouse_id > 0 && sloc_id == ''">
                                <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                                    <table id="tablePagingVue2" class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">Material Number</th>
                                            <th style="width: 25%">Material Description</th>
                                            <th style="width: 5%">Unit</th>
                                            <th style="width: 10%">Material Quantity</th>
                                            <th style="width: 15%">Total Value</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(selectedDetail,index) in selectedSlocDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.code }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.description }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.uom.unit }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.quantity }}</td>
                                                <td class="tdEllipsis">Rp {{ selectedDetail.totalValue }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="warehouse_id > 0 && sloc_id > 0">
                                <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                                    <table id="tablePagingVue2" class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">Material Number</th>
                                            <th style="width: 25%">Material Description</th>
                                            <th style="width: 5%">Unit</th>
                                            <th style="width: 10%">Material Quantity</th>
                                            <th style="width: 15%">Total Value</th>
                                            <th style="width: 10%">Aging</th>
                                            <th style="width: 15%">Goods Receipt Number</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(selectedDetail,index) in selectedSlocDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.code }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.description }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.uom.unit }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.quantity }}</td>
                                                <td class="tdEllipsis">Rp {{ selectedDetail.totalValue }}</td>
                                                <td v-if="selectedDetail.goods_receipt_detail != null" class="tdEllipsis"> {{ selectedDetail.aging }} Day(s) </td>
                                                <td  v-else>-</td>
                                                <td v-if="selectedDetail.goods_receipt_detail != null" class="tdEllipsis"><a :href="showGrRoute(selectedDetail.goods_receipt_detail.goods_receipt.id)" class="text-primary"><b>{{ selectedDetail.goods_receipt_detail.goods_receipt.number }} </td>
                                                <td  v-else>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    const form = document.querySelector('form#view-stock');

    $(document).ready(function(){

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

    });

    var data = {
        materials : @json($materials),
        warehouses : @json($warehouses),
        storageLocations : "",
        sloc_id : "",
        warehouse_id : "",
        selectedSloc : [],
        selectedSlocDetail : [],
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        warehouseSettings: {
            placeholder: 'Please Select Warehouse'
        },
        stocks: @json($stocks),
        stockValue : "",
        stockQuantity : "",
        reservedStockQuantity : "",
        availableQuantity : "",
        warehouseValue : "",
        warehouseQuantity : "",
        slocValue : "",
        slocQuantity : "",
    }
    var vm = new Vue({
        el : '#stockmanagement',
        data : data,
        methods:{
            showGrRoute(id){
                url = "/goods_receipt/"+id;

                return url;
            },
        },

        watch : {
            'sloc_id' : function(newValue){
                $('div.overlay').show();
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSlocSM/'+newValue).then(({ data }) => {
                        this.selectedSloc.push(data.sloc);
                        this.selectedSlocDetail = data.slocDetail;
                        this.slocValue = "Rp "+data.slocValue;
                        this.slocQuantity = data.slocQuantity;

                        var data = this.selectedSlocDetail;
                        data.forEach(slocDetail => {
                            var decimalQty = (slocDetail.quantity+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.quantity = (slocDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }

                            slocDetail.totalValue = (slocDetail.value * slocDetail.quantity+"");
                            var decimalQty = (slocDetail.totalValue+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.totalValue = (slocDetail.totalValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        });

                        $('#tablePagingVue2').DataTable().destroy();
                        this.$nextTick(function() {
                            var tablePagingVue2 = $('#tablePagingVue2').DataTable( {
                                'paging'      : true,
                                'lengthChange': false,
                                'ordering'    : true,
                                'info'        : true,
                                'autoWidth'   : false,
                                'bFilter'     : true,
                                'initComplete': function(){
                                    $('div.overlay').hide();
                                }
                            });
                        })

                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.selectedSloc = [];
                    $('div.overlay').show();
                    if(this.warehouse_id != ""){
                        window.axios.get('/api/getWarehouseStockSM/'+this.warehouse_id).then(({ data }) => {
                            this.selectedSlocDetail = data;

                            var data = this.selectedSlocDetail;
                            data.forEach(slocDetail => {
                                var decimalQty = (slocDetail.quantity+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.quantity = (slocDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }

                            slocDetail.totalValue = (slocDetail.material.cost_standard_price * slocDetail.quantity+"");
                            var decimalQty = (slocDetail.totalValue+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.totalValue = (slocDetail.totalValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            });

                            $('#tablePagingVue2').DataTable().destroy();
                            this.$nextTick(function() {
                                var tablePagingVue2 = $('#tablePagingVue2').DataTable( {
                                    'paging'      : true,
                                    'lengthChange': false,
                                    'ordering'    : true,
                                    'info'        : true,
                                    'autoWidth'   : false,
                                    'bFilter'     : true,
                                    'initComplete': function(){
                                        $('div.overlay').hide();
                                    }
                                });
                            })
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again.. '+error,
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                    }
                    $('div.overlay').hide();
                }
            },
            warehouse_id : function (newValue){
                this.sloc_id = "";
                $('div.overlay').show();

                var searchField = document.getElementsByClassName("search");
                var i;
                for (i = 0; i < searchField.length; i++) {
                    searchField[i].value = "";
                    searchField[i].dispatchEvent(new Event('change'));
                }
                if(this.sloc_id == "" && this.warehouse_id != ""){
                    window.axios.get('/api/getWarehouseStockSM/'+newValue).then(({ data }) => {
                        this.selectedSlocDetail = data;

                        var data = this.selectedSlocDetail;
                        data.forEach(slocDetail => {
                            var decimalQty = (slocDetail.quantity+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.quantity = (slocDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }

                            slocDetail.totalValue = (slocDetail.material.cost_standard_price * slocDetail.quantity+"");
                            var decimalQty = (slocDetail.totalValue+"").replace(/,/g, '').split('.');
                            if(decimalQty[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalQty[1]+"").length > maxDecimal){
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    slocDetail.totalValue = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                slocDetail.totalValue = (slocDetail.totalValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        });

                        $('#tablePagingVue2').DataTable().destroy();
                        this.$nextTick(function() {
                            var tablePagingVue2 = $('#tablePagingVue2').DataTable( {
                                'paging'      : true,
                                'lengthChange': false,
                                'ordering'    : true,
                                'info'        : true,
                                'autoWidth'   : false,
                                'bFilter'     : true,
                                'initComplete': function(){
                                    $('div.overlay').hide();
                                }
                            });
                        })
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                    window.axios.get('/api/getWarehouseInfoSM/'+newValue).then(({ data }) => {
                        this.storageLocations = data.sloc;
                        this.warehouseValue = "Rp "+data.warehouseValue;
                        this.warehouseQuantity = data.warehouseQuantity;
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })

                }else{
                    this.storageLocations = "";
                    $('div.overlay').hide();
                }

            }

        },
        created: function(){
            window.axios.get('/api/getStockInfoSM/').then(({ data }) => {
                    this.stockValue = "Rp "+data.stockValue;
                    this.stockQuantity = data.stockQuantity;
                    this.reservedStockQuantity = data.reservedStockQuantity;
                    this.availableQuantity = data.availableQuantity;

                    $('div.overlay').hide();
            })
            .catch((error) => {
                iziToast.warning({
                    title: 'Please Try Again.. '+error,
                    position: 'topRight',
                    displayMode: 'replace'
                });
                $('div.overlay').hide();
            })
        }
    });
</script>
@endpush
