@extends('layouts.main')
@if($modelPR->type == 1)
@php($type = 'Material')
@elseif($modelPR->type == 2)
@php($type = 'Resource')
@elseif($modelPR->type == 3)
@php($type = 'Subcon')
@endif
@section('content-header')
@if($route == "/purchase_order")
@breadcrumb(
[
'title' => 'Create Purchase Order » Select '.$type,
'items' => [
'Dashboard' => route('index'),
'Select Purchase Requisition' => route('purchase_order.selectPR'),
'Select Material' => ''
]
]
)
@endbreadcrumb
@elseif($route == "/purchase_order_repair")
@breadcrumb(
[
'title' => 'Create Purchase Order » Select '.$type,
'items' => [
'Dashboard' => route('index'),
'Select Purchase Requisition' => route('purchase_order_repair.selectPR'),
'Select Material' => ''
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
            <div class="box-body">
                @if($route == "/purchase_order")
                <form id="select-material" class="form-horizontal" action="{{ route('purchase_order.create') }}">
                    @elseif($route == "/purchase_order_repair")
                    <form id="select-material" class="form-horizontal" action="{{ route('purchase_order_repair.create') }}">
                        @endif
                        @csrf
                        @verbatim
                        <div id="prd">
                            <table class="table table-bordered tableFixed" id="pr-table" v-if="modelPR.type != 3">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <template v-if="modelPR.type == 1">
                                            <th width="15%">Material Number</th>
                                            <th width="25%">Material Description</th>
                                        </template>
                                        <template v-else>
                                            <th width="15%">Resource Number</th>
                                            <th width="25%">Resource Description</th>
                                        </template>
                                        <th width="8%">Requested Quantity</th>
                                        <th width="8%">Quantity Reserved</th>
                                        <th width="8%">Remaining Quantity</th>
                                        <th width="6%">Unit</th>
                                        <th width="15%">Project Number</th>
                                        <th width="10%">Allocation</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(PRD,index) in modelPRD">
                                        <td>{{ index+1 }}</td>
                                        <template v-if="modelPR.type == 1">
                                            <td class="tdEllipsis">{{ PRD.material.code }}</td>
                                            <td class="tdEllipsis"><a data-toggle="modal" href="#show_image" @click="openEditModal(PRD,index)"><span> {{ PRD.material.description }}</span></a></td>
                                            <td class="tdEllipsis">{{ PRD.quantity }}</td>
                                            <td class="tdEllipsis">{{ PRD.reserved }}</td>
                                            <td class="tdEllipsis">{{ PRD.remaining }}</td>
                                            <td class="tdEllipsis">{{ PRD.material.uom.unit }}</td>
                                            <td class="tdEllipsis" v-if="PRD.project != null">{{ PRD.project.number }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis" v-if="PRD.alocation != null">{{ PRD.alocation }}</td>
                                            <td class="tdEllipsis" v-else>-</td>

                                        </template>
                                        <template v-else>
                                            <td class="tdEllipsis">{{ PRD.resource.code }}</td>
                                            <td class="tdEllipsis">{{ PRD.resource.name }}</td>
                                            <td class="tdEllipsis">{{ PRD.quantity }}</td>
                                            <td class="tdEllipsis">{{ PRD.reserved }}</td>
                                            <td class="tdEllipsis">{{ PRD.remaining }}</td>
                                            <td class="tdEllipsis">-</td>
                                            <td class="tdEllipsis" v-if="PRD.project != null">{{ PRD.project.number }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis" v-if="PRD.alocation != null">{{ PRD.alocation }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                        </template>
                                        <td class="no-padding p-t-2 p-b-2" align="center">
                                            <input type="checkbox" v-icheck="" v-model="checkedPRD" :value="PRD.id">
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered tableFixed" id="pr-table" v-if="modelPR.type == 3">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Project Number</th>
                                        <th width="20%">WBS</th>
                                        <th width="35%">Job Order</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(PRD,index) in modelPRD">
                                        <td class="tdEllipsis">{{ index+1 }}</td>
                                        <td class="tdEllipsis">{{ PRD.project.number }}</td>
                                        <td class="tdEllipsis">{{ PRD.wbs.number }} - {{ PRD.wbs.description }}</td>
                                        <td class="tdEllipsis">{{ PRD.job_order }}</td>
                                        <td class="tdEllipsis" class="no-padding p-t-2 p-b-2" align="center">
                                            <input type="checkbox" v-icheck="" v-model="checkedPRD" :value="PRD.id">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 p-t-10">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                                </div>
                            </div>
                            <div class="modal fade" id="show_image">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">{{this.imageTitle}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img style="width:100%; height:500px" v-bind:src="this.imageSource">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endverbatim
                    </form>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#select-material');

    $(document).ready(function() {
        $('#pr-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'initComplete': function() {
                $('div.overlay').hide();
            }
        });
        //     $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        //     $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //         var title = $(this).text();
        //         if(title == '' || title == 'No' || title == "Qty" || title == "Ord" || title == "Rmn"){
        //             $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //         }else{
        //             $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //         }

        //         $( 'input', this ).on( 'keyup change', function () {
        //             if ( tablePagingVue.column(i).search() !== this.value ) {
        //                 tablePagingVue
        //                     .column(i)
        //                     .search( this.value )
        //                     .draw();
        //             }
        //         });
        //     });

        //     var tablePagingVue = $('.tablePagingVue').DataTable( {
        //         orderCellsTop   : true,
        //         fixedHeader     : true,
        //         paging          : true,
        //         autoWidth       : false,
        //         lengthChange    : false,
        //     });

        //     $('div.overlay').hide();
    });
    var URLTO = "{{ URL::to('/') }}";
    var data = {
        modelPRD: @json($modelPRD),
        modelPR: @json($modelPR),
        urlTo: URLTO,
        checkedPRD: [],
        submittedForm: {},
        imageSource: "",
    }

    var app = new Vue({
        el: '#prd',
        data: data,
        computed: {
            createOk: function() {
                let isOk = false;
                if (this.checkedPRD.length == 0) {
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm() {
                $('div.overlay').show();
                var prd = this.checkedPRD;
                var jsonPrd = JSON.stringify(prd);
                jsonPrd = JSON.parse(jsonPrd);

                this.submittedForm.type = this.modelPR.type;
                this.submittedForm.checkedPRD = jsonPrd;
                this.submittedForm.id = this.modelPR.id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            openEditModal(data, index) {
                this.imageSource = this.urlTo +'/app/documents/material/'+ data.material.image;
                this.imageTitle = data.material.description;
            },
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

                            $(el).prop("checked") ?
                                app.$data[vModel].push($(this).val()) :
                                data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
        created: function() {
            var data = this.modelPRD;
            data.forEach(PRD => {
                PRD.remaining = PRD.quantity - PRD.reserved;

                // remaining
                var decimal = (PRD.remaining + "").replace(/,/g, '').split('.');
                if (decimal[1] != undefined) {
                    var maxDecimal = 2;
                    if ((decimal[1] + "").length > maxDecimal) {
                        PRD.remaining = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                    } else {
                        PRD.remaining = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                    }
                } else {
                    PRD.remaining = (PRD.remaining + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                // quantity
                var decimal = (PRD.quantity + "").replace(/,/g, '').split('.');
                if (decimal[1] != undefined) {
                    var maxDecimal = 2;
                    if ((decimal[1] + "").length > maxDecimal) {
                        PRD.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                    } else {
                        PRD.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                    }
                } else {
                    PRD.quantity = (PRD.quantity + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                // reserved
                var decimal = (PRD.reserved + "").replace(/,/g, '').split('.');
                if (decimal[1] != undefined) {
                    var maxDecimal = 2;
                    if ((decimal[1] + "").length > maxDecimal) {
                        PRD.reserved = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                    } else {
                        PRD.reserved = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                    }
                } else {
                    PRD.reserved = (PRD.reserved + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            });
        }
    });
</script>
@endpush
