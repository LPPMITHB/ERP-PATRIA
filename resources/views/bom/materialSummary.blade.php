@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Material Requirement Summary',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bom_repair.selectProjectSum'),
            'Material Requirement Summary' => "",
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
                <form id="create-bom-repair" class="form-horizontal" method="POST" action="{{ route('bom_repair.storeBomRepair') }}">
                @csrf
                </form>
                @verbatim
                <div id="mrd">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
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

                            <div class="col-sm-4 col-md-4">
                                <div class="col-sm-12">
                                    <label for="">BOM Description</label>
                                </div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" id="bomPrep-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="13%">Material Number</th>
                                        <th width="25%">Material Description</th>
                                        <th width="7%">Source</th>
                                        <th width="13%">Qty</th>
                                        <th width="13%">Prepared Qty</th>
                                        <th width="14%"></th>
                                        <th width="8%">Completed?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomPrep,index) in modelBomPrep">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ bomPrep.material.code }}</td>
                                        <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(bomPrep.material.description)">{{ bomPrep.material.description }}</td>
                                        <td>{{ bomPrep.source }}</td>
                                        <td>{{ bomPrep.quantity }}</td>
                                        <td>{{ bomPrep.already_prepared }}</td>
                                        <template v-if="bomPrep.status != 0">
                                            <td class="p-l-0 p-r-0 textCenter">
                                                <button class="btn btn-primary btn-xs" @click="openModalPrep(bomPrep, index)" data-toggle="modal" data-target="#material_prep">MANAGE MATERIAL</button>
                                            </td>
                                            <td class="no-padding p-t-2 p-b-2" align="center" >
                                                <input type="checkbox" v-icheck="" v-model="fulfilledBomPrep" :value="bomPrep.id">
                                            </td>
                                        </template>
                                        <template v-else>
                                            <td class="p-l-0 p-r-0 textCenter">
                                                <button class="btn btn-primary btn-xs" @click="openModalPrep(bomPrep, index)" data-toggle="modal"
                                                    data-target="#material_prep" disabled>MANAGE MATERIAL</button>
                                            </td>
                                            <td class="text-center">
                                                <i class="fa fa-check text-success"></i>
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 p-t-10">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                        </div>
                    </div>

                    <div class="modal fade" id="material_prep">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-left">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Material Preparation <b id="material_name"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table style="line-height: 20px">
                                                <thead>
                                                    <th colspan="2">Preparation Details</th>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-left">
                                                        <td>Quantity</td>
                                                        <td>:</td>
                                                        <td>&ensp;<b>{{activeBomPrep.quantity}}</b></td>
                                                    </tr>
                                                    <tr class="text-left">
                                                        <td>Prepared</td>
                                                        <td>:</td>
                                                        <td>&ensp;<b>{{activeBomPrep.prepared}}</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 mn-m-b-20">
                                            <h5><b>Material Family</b></h5>
                                        </div>

                                        <div class="col-sm-12">
                                            <table id="details-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                                <thead>
                                                    <tr>
                                                        <th width="4%">No</th>
                                                        <th width="20%">Material</th>
                                                        <th width="10%">Available Qty</th>
                                                        <th width="10%">Prepared Qty</th>
                                                    </tr>
                                                </thead>
                                                <br>
                                                <tbody>
                                                    <tr v-for="(data,index) in activeBomPrep.details">
                                                        <td>{{ index + 1 }}</td>
                                                        <td class="tdEllipsis text-left" data-container="body" v-tooltip:top="tooltipText(data.material_name)">{{data.material_name}}</td>
                                                        <td class="tdEllipsis text-left">{{data.available_quantity}}</td>
                                                        <td class="p-l-0 no-padding">
                                                            <input class="form-control width100" v-model="data.prepared" placeholder="Quantity">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="saveBomDetails">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                @endverbatim
            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-bom-repair');

    $(document).ready(function(){
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

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        modelProject: @json($project),
        modelBomPrep : @json($bomPreps),
        // stocks : @json($stocks),
        materials : @json($materials),
        submittedForm :{},
        total : [],
        description : @json($existing_bom != null ? $existing_bom->description : ""),
        fulfilledBomPrep :[],
        existing_bom : @json($existing_bom),
        
        activeBomPrep :{
            index : "",
            quantity : "",
            prepared : "",
            details : [],
        }
    }

    var vm = new Vue({
        el : '#mrd',
        data : data,
        computed : {
            createOk: function(){
                let isOk = false;
                var counter = 0;
                this.total.forEach(MRD => {
                    if(MRD == 0){
                        counter++;
                    }
                    if(counter == this.total.length && isOk == false){
                        isOk = true;
                    }
                });
                return isOk;
            },
        },
        methods : {
            saveBomDetails(){
                this.modelBomPrep[this.activeBomPrep.index].bom_details = this.activeBomPrep.details;
                this.modelBomPrep[this.activeBomPrep.index].already_prepared = this.activeBomPrep.prepared;

                this.materials.forEach(material => {
                    this.activeBomPrep.details.forEach(bom_detail => {
                        if(material.id == bom_detail.material_id){
                            if(material.stock != null){
                                var temp_available = material.stock.quantity - material.stock.reserved;
                                var add = temp_available - parseFloat((bom_detail.available_quantity+"").replace(/,/g, ''));
                                material.stock.reserved += parseFloat((add+"").replace(/,/g, ''));
                            }else{
                                var temp = {};
                                temp.material_id = material.id;
                                temp.quantity = 0;
                                var add = parseFloat((bom_detail.prepared+"").replace(/,/g, ''));
                                temp.reserved = parseFloat((add+"").replace(/,/g, ''));
                                temp.reserved_gi = 0;

                                material.stock = temp;
                            }
                        }
                    });
                });

            },
            openModalPrep(data, index){
                document.getElementById('material_name').innerHTML = data.material.description;
                this.activeBomPrep.index = index;
                this.activeBomPrep.quantity = data.quantity;
                this.activeBomPrep.prepared = data.already_prepared;
                this.activeBomPrep.details = [];

                if(data.material.family_id != null){
                    var family_ids = JSON.parse(data.material.family_id);
                    if(data.bom_details.length > 0){
                        this.materials.forEach(material => {
                            var found = false;
                            if(material.family_id != null){
                                family_ids_stock = JSON.parse(material.family_id);
                                family_ids_stock.forEach(family_id => {
                                    if(family_ids.includes(family_id)){
                                        found = true;
                                    }
                                });
                            }

                            if(found){
                                var temp = {};
                                temp.id = null;
                                temp.material_id = material_id;
                                temp.material_name = material.code+" - "+material.description;
                                temp.available_quantity = material.stock.quantity - material.stock.reserved;
                                temp.const_available_quantity = material.stock.quantity - material.stock.reserved;
                                temp.prepared = "";

                                this.activeBomPrep.details.push(temp);
                            }
                        });   

                        data.bom_details.forEach(bom_detail => {
                            this.activeBomPrep.details.forEach(detail =>{
                                if(bom_detail.material_id == detail.material_id){
                                    detail.id = bom_detail.id;
                                    if(detail.id != null){
                                        if(bom_detail.quantity != undefined){
                                            detail.available_quantity += parseFloat((bom_detail.quantity+"").replace(/,/g, ''));
                                            detail.const_available_quantity += parseFloat((bom_detail.quantity+"").replace(/,/g, ''));
                                            detail.prepared = bom_detail.quantity;
                                        }else{
                                            if(bom_detail.prepared != ""){
                                                detail.const_available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.prepared = bom_detail.prepared;
                                            }else{
                                                detail.const_available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.available_quantity = parseFloat((detail.const_available_quantity+"").replace(/,/g, ''));
                                            }
                                        }
                                    }else{
                                        if(bom_detail.prepared != ""){
                                            detail.available_quantity += parseFloat((bom_detail.prepared+"").replace(/,/g, ''));
                                            detail.const_available_quantity += parseFloat((bom_detail.prepared+"").replace(/,/g, ''));
                                            detail.prepared = bom_detail.prepared;
                                        }
                                    }
                                }
                            });
                        });
                    }else{
                        this.materials.forEach(material => {
                            var found = false;
                            if(material.family_id != null){
                                family_ids_stock = JSON.parse(material.family_id);
                                family_ids_stock.forEach(family_id => {
                                    if(family_ids.includes(family_id)){
                                        found = true;
                                    }
                                });
                            }

                            if(found){
                                var temp = {};
                                temp.id = null;
                                temp.material_id = material_id;
                                temp.material_name = material.code+" - "+material.description;
                                temp.available_quantity = material.stock.quantity - material.stock.reserved;
                                temp.const_available_quantity = material.stock.quantity - material.stock.reserved;
                                temp.prepared = "";

                                this.activeBomPrep.details.push(temp);
                            }
                        });                        
                    }
                }else{
                    if(data.bom_details.length > 0){
                        this.materials.forEach(material => {
                            if(data.material_id == material.id){
                                var temp = {};
                                if(material.stock != null){
                                    temp.id = null;
                                    temp.material_id = material.id;
                                    temp.material_name = material.code+" - "+material.description;
                                    temp.available_quantity = material.stock.quantity - material.stock.reserved;
                                    temp.const_available_quantity = material.stock.quantity - material.stock.reserved;
                                    temp.prepared = "";
                                }else{
                                    temp.id = null;
                                    temp.material_id = material.id;
                                    temp.material_name = material.code+" - "+material.description;
                                    temp.available_quantity = 0;
                                    temp.const_available_quantity = 0;
                                    temp.prepared = "";
                                }

                                this.activeBomPrep.details.push(temp);
                            }
                        });   

                        data.bom_details.forEach(bom_detail => {
                            this.activeBomPrep.details.forEach(detail =>{
                                if(bom_detail.material_id == detail.material_id){
                                    detail.id = bom_detail.id;
                                    if(detail.id != null){
                                        if(bom_detail.quantity != undefined){
                                            detail.available_quantity += parseFloat((bom_detail.quantity+"").replace(/,/g, ''));
                                            detail.const_available_quantity += parseFloat((bom_detail.quantity+"").replace(/,/g, ''));
                                            detail.prepared = bom_detail.quantity;
                                        }else{
                                            if(bom_detail.prepared != ""){
                                                detail.const_available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.prepared = bom_detail.prepared;
                                            }else{
                                                detail.const_available_quantity = parseFloat((bom_detail.const_available_quantity+"").replace(/,/g, ''));
                                                detail.available_quantity = parseFloat((detail.const_available_quantity+"").replace(/,/g, ''));
                                            }
                                        }
                                    }else{
                                        if(bom_detail.prepared != ""){
                                            detail.available_quantity += parseFloat((bom_detail.prepared+"").replace(/,/g, ''));
                                            detail.const_available_quantity += parseFloat((bom_detail.prepared+"").replace(/,/g, ''));
                                            detail.prepared = bom_detail.prepared;
                                        }
                                    }
                                }
                            });
                        });
                    }else{
                        this.materials.forEach(material => {
                            if(data.material_id == material.id){
                                var temp = {};
                                if(material.stock != null){
                                    temp.id = null;
                                    temp.material_id = material.id;
                                    temp.material_name = material.code+" - "+material.description;
                                    temp.available_quantity = material.stock.quantity - material.stock.reserved;
                                    temp.const_available_quantity = material.stock.quantity - material.stock.reserved;
                                    temp.prepared = "";
                                }else{
                                    temp.id = null;
                                    temp.material_id = material.id;
                                    temp.material_name = material.code+" - "+material.description;
                                    temp.available_quantity = 0;
                                    temp.const_available_quantity = 0;
                                    temp.prepared = "";
                                }

                                this.activeBomPrep.details.push(temp);
                            }
                        });                        
                    }
                }
            },
            tooltipText: function(text) {
                return text
            },
            submitForm(){
                $('div.overlay').show();
                var data = this.modelBomPrep;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(bom => {
                    bom.bom_details.forEach(bom_detail => {
                        bom_detail.prepared = (bom_detail.prepared+"").replace(/,/g, '');
                    }); 
                });

                this.submittedForm.bom_preps = data;
                this.submittedForm.description = this.description;
                this.submittedForm.project_id = this.modelProject.id;
                this.submittedForm.existing_bom = this.existing_bom;
                this.submittedForm.fulfilledBomPrep = this.fulfilledBomPrep;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            modelBomPrep:{
                handler: function(newValue) {
                    var decimalPrepared = (newValue.already_prepared+"").replace(/,/g, '').split('.');
                    if(decimalPrepared[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            newValue.already_prepared = (decimalPrepared[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalPrepared[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            newValue.already_prepared = (decimalPrepared[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalPrepared[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        newValue.already_prepared = (newValue.already_prepared+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }

                    var decimalQty = (newValue.quantity+"").replace(/,/g, '').split('.');
                    if(decimalQty[1] != undefined){
                        var maxDecimal = 2;
                        if((decimalQty[1]+"").length > maxDecimal){
                            newValue.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            newValue.quantity = (decimalQty[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalQty[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        newValue.quantity = (newValue.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                },
                deep: true
            },
            "activeBomPrep.details": {
                handler : function(newValue){
                    var total_prepared = 0;
                    newValue.forEach(detail => {
                        var temp_available = 0;
                        if(detail.prepared != ""){
                            var temp_prepared = parseFloat((detail.prepared+"").replace(/,/g, ''));
                            total_prepared += temp_prepared;
                            temp_available = detail.const_available_quantity - temp_prepared;
                        }else{
                            temp_available = detail.const_available_quantity;
                        }

                        var decimal = (temp_available+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                detail.available_quantity = (decimal[0]+"").replace(/[^0-9.-]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                detail.available_quantity = (decimal[0]+"").replace(/[^0-9.-]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            detail.available_quantity = (temp_available+"").replace(/[^0-9.-]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        
                        var decimal = (detail.prepared+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                detail.prepared = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                detail.prepared = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            detail.prepared = (detail.prepared+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                        
                    });

                    this.activeBomPrep.prepared = total_prepared;
                },
                deep: true
            },
        },
        created: function(){
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })
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
                            vm.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = vm.$data[vModel];

                            $(el).prop("checked")
                            ? vm.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
    });
</script>
@endpush
