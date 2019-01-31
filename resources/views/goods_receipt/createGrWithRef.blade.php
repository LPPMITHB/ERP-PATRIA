@extends('layouts.main')

@section('content-header')
@if($route == "/goods_receipt")
    @breadcrumb(
        [
            'title' => 'Create Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Order' => route('goods_receipt.selectPO'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'Create Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Order' => route('goods_receipt_repair.selectPO'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/goods_receipt")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt.store') }}">
                @elseif($route == "/goods_receipt_repair")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="pod">
                        <div class="col-sm-12 no-padding">
                            <div class="box-header">
                                <div class="col-xs-12 col-lg-6 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-xs-4 no-padding">PO Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelPO.number }}</b></div>
                                        
                                        <div class="col-md-4 col-xs-4 no-padding">Vendor</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelPO.vendor.name }}</b></div>
                
                                        <div class="col-md-4 col-xs-4 no-padding">Address</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" v-tooltip:top="tooltipText(modelPO.vendor.address)"><b>: {{ modelPO.vendor.address }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Phone Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelPO.vendor.phone_number }}</b></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-3 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                            <div class="col-md-4 col-lg-7 col-xs-12 no-padding"> GR Description : <textarea class="form-control" rows="3" v-model="description" style="width:310px"></textarea>
                                            </div>
                                        </div>
                            </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table table-bordered tablePagingVue tableFixed">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="35%">Material Name</th>
                                                <th width="10%">Quantity</th>
                                                <th width="10%">Received</th>
                                                <th width="30%">Storage Location</th>
                                                <th width="10%">Item OK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(POD,index) in modelPOD" v-if="POD.quantity > 0" :id="getId(POD.id)">
                                                <td>{{ index+1 }}</td>
                                                <td>{{ POD.material_code }} - {{ POD.material_name }}</td>
                                                <td>{{ POD.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="POD.received" placeholder="Please Input Received Quantity">
                                                </td>
                                                <td class="no-padding">
                                                    <selectize v-model="POD.sloc_id" :settings="slocSettings">
                                                        <option v-for="(storageLocation, index) in modelSloc" :value="storageLocation.id">{{storageLocation.code}} - {{storageLocation.name}}</option>
                                                    </selectize>  
                                                </td>
                                                <td class="no-padding p-t-2 p-b-2" align="center">
                                                    <input type="checkbox" v-icheck="" v-model="checkedPOD" :value="POD.id">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-t-10">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                                </div>
                            </div>
                        </div>
                    @endverbatim
                </form>
        </div><!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-gr');

    $(document).ready(function(){
        $('div.overlay').hide();

        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'Material Name' || title == 'Storage Location'){
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }else{
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });
    });

    var data = {
        modelPOD : @json($datas),
        modelPO :   @json($modelPO),
        modelSloc : @json($modelSloc),
        checkedPOD :[],

        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        description:"",
        submittedForm :{},
    }

        Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })
    var app = new Vue({
        el : '#pod',
        data : data,
        computed : {
            createOk: function(){
                let isOk = true;
                this.modelPOD.forEach(POD => {
                    if(POD.sloc_id != ""){
                        isOk = false;
                    }
                });
                return isOk;
            }
        },
        methods : {
            getId: function(id){
                return id;
            },
            tooltipText: function(text) {
                return text
            },
            changeText(){
                if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
                    if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != modelPO.vendor.address ){
                        document.getElementsByClassName('tooltip-inner')[0].innerHTML= modelPO.vendor.address;    
                    }
                }
            }, 
            submitForm(){
                var data = this.modelPOD;
                data = JSON.stringify(data)
                data = JSON.parse(data)
                
                
                var pod = this.checkedPOD;
                var jsonPod = JSON.stringify(pod);
                jsonPod = JSON.parse(jsonPod);
                var isOk = false;

                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , ''); 
                    POD.received = parseInt(POD.received);   
                    if(POD.sloc_id != ""){
                        if(this.checkedPOD.indexOf(POD.id+"") == -1){
                            isOk = true;
                            POD.item_OK = 0;
                            document.getElementById(POD.id).style.backgroundColor = "yellow";
                        }
                        else{
                            POD.item_OK = 1;
                        }
                    }
                });
                if(isOk){ 
                    iziToast.warning({
                        title: 'Please Check the Material\'s Quality and check the ItemOk Checkbox',
                        position: 'topRight',
                        displayMode: 'replace',
                    });
                }
                else{
                    this.submittedForm.POD = data;
                    this.submittedForm.checkedPOD = jsonPod;            
                    this.submittedForm.purchase_order_id = this.modelPO.id;
                    this.submittedForm.description = this.description;
                    
                    let struturesElem = document.createElement('input');
                    struturesElem.setAttribute('type', 'hidden');
                    struturesElem.setAttribute('name', 'datas');
                    struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                    form.appendChild(struturesElem);
                    form.submit();
                }
            }
        },
        directives: {
            icheck: {
                inserted: function(el, b, vnode) {
                    var vdirective = vnode.data.directives,
                    vModel;
                    for (var i = 0, vDirLength = vdirective.length; i < vDirLength; i++) {
                        if (vdirective[i].name == "model") {
                            vModel = vdirective[i].expression;
                            break;
                        }
                    }
                    jQuery(el).iCheck({
                        checkboxClass: "icheckbox_square-blue",
                        radioClass: "iradio_square-blue",
                        increaseArea: "20%" // optional
                    });
                    jQuery(el).on("ifChanged", function(e) {
                        if ($(el).attr("type") == "radio") {
                            app.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = app.$data[vModel];

                            $(el).prop("checked")
                            ? app.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
        watch : {
            modelPOD:{
                handler: function(newValue) {
                    // console.log(newValue)
        
                    var data = newValue;
                    data.forEach(POD => {
                        if(parseInt(POD.quantity.replace(/,/g , '')) < parseInt(POD.received.replace(/,/g , ''))){
                            POD.received = POD.quantity;
                            iziToast.warning({
                                title: 'Cannot input more than avaiable quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }
                        POD.received = (POD.received+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                    });
                },
                deep: true
            },
            checkedPOD:function(newValue){
                var data = this.modelPOD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(POD => {
                    if(POD.sloc_id != ""){
                        if(newValue.indexOf(POD.id+"") == -1){
                            isOk = true;
                            POD.item_OK = 0;
                        }
                        else{
                            document.getElementById(POD.id).style.backgroundColor = "white";
                            POD.item_OK = 1;
                        }
                    }
                });
            }
        },
        created: function(){
            var data = this.modelPOD;
            data.forEach(POD => {
                // POD.sloc_id = null;
                POD.received = parseInt(POD.quantity) - parseInt(POD.received);
                POD.quantity = POD.received;
                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                POD.received = (POD.received+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
        updated: function () {
            this.$nextTick(function () {
            })
        }
    });
</script>
@endpush
