@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'PR Consolidation » Select Purchase Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => route('purchase_requisition.indexConsolidation'),
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
                @if($route == "/purchase_requisition")
                    <form id="select-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition.storeConsolidation') }}">
                @elseif($route == "/purchase_requisition_repair")
                    <form id="select-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition_repair.storeConsolidation') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="prd">
                        <table class="table table-bordered tableFixed tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">Number</th>
                                    <th width="35%">Description</th>
                                    <th width="20%">Project Name</th>
                                    <th width="10%">Status</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(PRs,index) in modelPRs">
                                    <td>{{ index+1 }}</td>
                                    <td v-if="PRs.type == 1">Material</td>
                                    <td v-else>Resource</td>
                                    <td>{{ PRs.number }}</td>
                                    <td>{{ PRs.description }}</td>
                                    <td v-if="PRs.project != null">{{ PRs.project.name }}</td>
                                    <td v-else>-</td>
                                    <td v-if="PRs.status == 0">ORDERED</td>
                                    <td v-else-if="PRs.status == 1">OPEN</td>
                                    <td v-else-if="PRs.status == 2">APPROVED</td>
                                    <td v-else-if="PRs.status == 3">NEED REVISION</td>
                                    <td v-else-if="PRs.status == 4">REVISED</td>
                                    <td v-else-if="PRs.status == 5">REJECTED</td>
                                    <td v-if="PRs.type == 2" class="no-padding p-t-2 p-b-2" align="center">
                                        <input type="checkbox" v-icheck="" v-model="checkedPR" :value="PRs.id" :disabled="materialOk">
                                    </td>
                                    <td v-else-if="PRs.type == 1" class="no-padding p-t-2 p-b-2" align="center">
                                        <input type="checkbox" v-icheck="" v-model="checkedPR" :value="PRs.id" :disabled="resourceOk">
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
    const form = document.querySelector('form#select-pr');

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

    var data = {
        modelPRs : @json($modelPRs),
        checkedPR : [],
        submittedForm : {},
        type : "",
    }

    var app = new Vue({
        el : '#prd',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;
                if(this.checkedPR.length == 0){
                    isOk = true;
                }
                return isOk;
            },
            resourceOk: function(){
                let isOk = false;

                this.modelPRs.forEach(data => {
                    if(data.id == this.checkedPR[0] && data.type == 2){
                        isOk = true;
                    }
                });

                return isOk;
            },
            materialOk: function(){
                let isOk = false;

                this.modelPRs.forEach(data => {
                    if(data.id == this.checkedPR[0] && data.type == 1){
                        isOk = true;
                    }
                });

                return isOk;
            }
        },
        methods: {
            submitForm(){
                var prd = this.checkedPR;
                var jsonPrd = JSON.stringify(prd);
                jsonPrd = JSON.parse(jsonPrd);

                this.modelPRs.forEach(data => {
                    if(data.id == this.checkedPR[0] && data.type == 1){
                        this.type = "1";
                    }else if(data.id == this.checkedPR[0] && data.type == 2){
                        this.type = "2";
                    }
                });

                this.submittedForm.checkedPR = jsonPrd;
                this.submittedForm.type = this.type;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
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
    });
</script>
@endpush
