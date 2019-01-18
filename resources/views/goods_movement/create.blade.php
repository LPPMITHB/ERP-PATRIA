@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Goods Movement',
        'items' => [
            'Dashboard' => route('index'),
            'Goods Movement' => route('goods_movement.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @if($route == "/goods_movement")
                    <form id="create-gm" class="form-horizontal" method="POST" action="{{ route('goods_movement.store') }}">
                @elseif($route == "/goods_movement_repair")
                    <form id="create-gm" class="form-horizontal" method="POST" action="{{ route('goods_movement_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                        <div id="stock-transfer">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-sm-4">
                                            <label class="control-label">Warehouse From</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <selectize v-model="dataHeader.warehouse_from_id" :settings="warehouseFromSettings">
                                                <option v-for="(warehouse, index) in modelWarehouseFrom" :value="warehouse.id">{{ warehouse.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-4">
                                            <label class="control-label">Warehouse To</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <selectize v-model="dataHeader.warehouse_to_id" :settings="warehouseToSettings" :disabled="slocFromOk">
                                                <option v-for="(warehouse, index) in modelWarehouseTo" :value="warehouse.id">{{ warehouse.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-sm-4">
                                            <label class="control-label">Storage Loc. From</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <selectize id="slocFrom" v-model="dataHeader.sloc_from_id" :settings="slocFromSettings" :disabled="warehouseFromOk">
                                                <option v-for="(sloc, index) in modelSlocFrom" :value="sloc.id">{{ sloc.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-4">
                                            <label class="control-label">Storage Loc. To</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <selectize id="slocTo" v-model="dataHeader.sloc_to_id" :settings="slocToSettings" :disabled="warehouseToOk">
                                                <option v-for="(sloc, index) in modelSlocTo" :value="sloc.id">{{ sloc.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-if="dataHeader.warehouse_from_id != '' && dataHeader.sloc_to_id != ''">
                                <div class="row">
                                    <div class="col-sm-12 p-t-10 p-l-25 p-r-25">
                                        <table id="sld" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">No</th>
                                                    <th style="width: 20%">Material Code</th>
                                                    <th style="width: 45%">Material Name</th>
                                                    <th style="width: 15%">Avaiable Qty</th>
                                                    <th style="width: 15%">Transfer Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(sld,index) in dataSLD" v-if="sld.available > 0">
                                                    <td>{{ index + 1 }}</td>
                                                    <td class="tdEllipsis">{{ sld.material.code }}</td>
                                                    <td class="tdEllipsis">{{ sld.material.name }}</td>
                                                    <td class="tdEllipsis">{{ sld.quantity_rn }}</td>
                                                    <td class="no-padding">
                                                        <input class="form-control width100" v-model="sld.quantity" placeholder="Please Input Quantity">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                                </div>
                            </template>
                        </div>
                    @endverbatim   
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>         
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $('div.overlay').hide();
    const form = document.querySelector('form#create-gm');

    var data = {
        number : 0,
        modelWarehouseFrom : @json($modelWarehouse),
        modelWarehouseTo : [],
        modelSlocFrom : [],
        modelSlocTo : [],
        dataSLD : [],
        warehouseFromSettings: {
            placeholder: 'Please Select Warehouse From'
        },
        warehouseToSettings: {
            placeholder: 'Please Select Warehouse To'
        },
        slocFromSettings: {
            placeholder: 'Please Select Storage Location From'
        },
        slocToSettings: {
            placeholder: 'Please Select Storage Location To'
        },
        dataHeader : {
            warehouse_from_id : "",
            warehouse_to_id : "",
            sloc_from_id : "",
            sloc_to_id : "",
            description : "",
        },
        submittedForm:{},
    }

    var vm = new Vue({
        el : '#stock-transfer',
        data : data,
        computed : {
            allOk: function(){
                let isOk = false;
                
                if(this.dataSLD.length < 1){
                    isOk = true;
                }
                var status = this.getStatus();
                if(status == 0){
                    isOk = true;
                }
                return isOk;
            },
            slocFromOk: function(){
                let isOk = false;
                if(this.dataHeader.sloc_from_id == ""){
                    isOk = true;
                    this.dataHeader.warehouse_to_id = "";
                    this.dataHeader.sloc_to_id = "";
                }
                return isOk;
            },
            warehouseFromOk: function(){
                let isOk = false;
                if(this.dataHeader.warehouse_from_id == ""){
                    isOk = true;
                    this.dataHeader.warehouse_to_id = "";
                    this.dataHeader.sloc_to_id = "";
                    this.dataHeader.sloc_from_id = "";
                }
                return isOk;
            },
            warehouseToOk: function(){
                let isOk = false;
                if(this.dataHeader.warehouse_to_id == ""){
                    isOk = true;
                    this.dataHeader.sloc_to_id = "";
                }
                return isOk;
            },
        },
        methods : {
            getStatus(){
                var status = 0
                this.dataSLD.forEach(SLD => {
                    if(SLD.quantity != ""){
                        status = 1;
                    }
                });
                return status;
            },
            submitForm(){
                this.submittedForm.dataHeader = this.dataHeader;
                this.submittedForm.dataSLD = this.dataSLD;     

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch : {
            'dataHeader.sloc_to_id' : function(newValue){
                $('#sld').DataTable().destroy();
                this.$nextTick(function() {
                    $('#sld').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            },
            'dataHeader.warehouse_from_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSlocGM/'+newValue).then(({ data }) => {
                        this.modelSlocFrom = data;
                        var $slocFrom = $(document.getElementById('slocFrom')).selectize();
                        $slocFrom[0].selectize.focus();
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
                }
            },
            'dataHeader.warehouse_to_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    var data = {
                        warehouse_id : newValue,
                        sloc_from_id : this.dataHeader.sloc_from_id
                    };
                    data = JSON.stringify(data);
                    window.axios.get('/api/getSlocToGM/'+data).then(({ data }) => {
                        this.modelSlocTo = data;
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
                }
            },
            'dataHeader.sloc_from_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    var data = {
                        warehouse_id : this.dataHeader.warehouse_to_id,
                        sloc_from_id : newValue
                    };
                    data = JSON.stringify(data);
                    window.axios.get('/api/getSlocToGM/'+data).then(({ data }) => {
                        this.modelSlocTo = data;
                        var $slocTo = $(document.getElementById('slocTo')).selectize();
                        $slocTo[0].selectize.focus();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })

                    window.axios.get('/api/getSlocDetailGM/'+newValue).then(({ data }) => {
                        this.dataSLD = data;
                        this.dataSLD.forEach(sld => {
                            sld.available = sld.quantity;
                            sld.quantity_rn = sld.quantity;
                            sld.quantity_rn = (sld.quantity_rn+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            sld.quantity = "";
                        });
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
                }
            },
            dataSLD:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(SLD => {
                        if(parseInt(SLD.quantity.replace(/,/g , '')) > parseInt(SLD.quantity_rn.replace(/,/g , ''))){
                            SLD.quantity = SLD.quantity_rn;
                            iziToast.warning({
                                title: 'Cannot input more than available quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }
                        SLD.quantity = (SLD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                    });
                },
                deep: true
            },
        },
        created: function() {
            this.modelWarehouseTo = this.modelWarehouseFrom;
        },
    });
</script>
@endpush