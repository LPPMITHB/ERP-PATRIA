@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Order » Select Material',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => route('purchase_order.selectPR'),
            'Select Material' => route('purchase_order.selectPRD',$modelPR->id),
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
                <form id="select-material" class="form-horizontal" action="{{ route('purchase_order.create') }}">
                @csrf
                    @verbatim
                    <div id="prd">
                        <table class="table table-bordered table-hover" id="prd-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Material</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Ordered</th>
                                    <th width="10%">Remaining</th>
                                    <th width="25%">Work Name</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(PRD,index) in modelPRD">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ PRD.material.name }}</td>
                                    <td>{{ PRD.quantity }}</td>
                                    <td>{{ PRD.reserved }}</td>
                                    <td>{{ PRD.remaining }}</td>
                                    <td>{{ PRD.work.name }}</td>
                                    <td class="no-padding p-t-2 p-b-2" align="center">
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
        $('#prd-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });

    var data = {
        modelPRD : @json($modelPRD),
        modelPR : @json($modelPR),
        checkedPRD : [],
        submittedForm : {},
    }

    var app = new Vue({
        el : '#prd',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;
                if(this.checkedPRD.length == 0){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                var prd = this.checkedPRD;
                var jsonPrd = JSON.stringify(prd);
                jsonPrd = JSON.parse(jsonPrd);
                this.submittedForm.checkedPRD = jsonPrd;            
                this.submittedForm.id = this.modelPR.id;            

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
        created: function() {
            var data = this.modelPRD;
            data.forEach(PRD => {
                PRD.remaining = PRD.quantity - PRD.reserved;
                PRD.remaining = (PRD.remaining+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                PRD.reserved = (PRD.reserved+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush
