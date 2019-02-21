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
                @if($route == "/work_order")
                    <form id="select-material" class="form-horizontal" action="{{ route('work_order.create') }}">
                @elseif($route == "/work_order_repair")
                    <form id="select-material" class="form-horizontal" action="{{ route('work_order_repair.create') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="prd">
                        <table class="table table-bordered tableFixed tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Material Number</th>
                                    <th width="16%">Material Description</th>
                                    <th width="5%">Unit</th>
                                    <th width="17%">Description</th>
                                    <th width="7%">Quantity</th>
                                    <th width="7%">Ordered</th>
                                    <th width="8%">Remaining</th>
                                    <th width="20%">WBS Name</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(WRD,index) in modelWRD">
                                    <td>{{ index+1 }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.material.code)">{{ WRD.material.code }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.material.description)">{{ WRD.material.description }}</td>
                                    <td>{{ WRD.material.uom.unit }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.description)">{{ WRD.description }}</td>
                                    <td>{{ WRD.quantity }}</td>
                                    <td>{{ WRD.reserved }}</td>
                                    <td>{{ WRD.remaining }}</td>
                                    <td v-if="WRD.wbs != null" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(WRD.wbs.number)">{{ WRD.wbs.number }} - {{ WRD.wbs.description }}</td>
                                    <td v-else>-</td>
                                    <td class="no-padding p-t-2 p-b-2" align="center">
                                        <input type="checkbox" v-icheck="" v-model="checkedWRD" :value="WRD.id">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
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

    $(document).ready(function(){
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == '' || title == 'No' || title == "Quantity" || title == "Ordered" || title == "Remaining"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
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
            fixedHeader     : true,
            paging          : true,
            autoWidth       : false,
            lengthChange    : false,
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
        modelWRD : @json($modelWRD),
        modelWR : @json($modelWR),
        checkedWRD : [],
        submittedForm : {},
    }

    var app = new Vue({
        el : '#prd',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;
                if(this.checkedWRD.length == 0){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                var prd = this.checkedWRD;
                var jsonPrd = JSON.stringify(prd);
                jsonPrd = JSON.parse(jsonPrd);
                this.submittedForm.checkedWRD = jsonPrd;            
                this.submittedForm.id = this.modelWR.id;            

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            tooltipText: function(text) {
                return text
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

                            $(el).prop("checked")
                            ? app.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
        created: function() {
            var data = this.modelWRD;
            data.forEach(WRD => {
                WRD.remaining = WRD.quantity - WRD.reserved;
                WRD.remaining = (WRD.remaining+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                WRD.quantity = (WRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                WRD.reserved = (WRD.reserved+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush
