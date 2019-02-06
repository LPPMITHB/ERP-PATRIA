@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Issue',
        'items' => [
            'Dashboard' => route('index'),
            'Select Material Requisition' => route('goods_issue.selectMR'),
            'Create Goods Issue' => route('goods_issue.createGiWithRef',$modelMR->id),
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
                @if($menu=="building")
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('goods_issue.store') }}">
                @else
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('goods_issue_repair.store') }}">
                @endif
                @csrf
                </form>
                @verbatim
                <div id="mrd">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-xs-5 no-padding">MR Number</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelMR.number}}</b></div>
        
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
                                    <label for="">GI Description</label>
                                </div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" id="mrd-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="45%">Material</th>
                                        <th width="13%">Quantity</th>
                                        <th width="13%">Issued</th>
                                        <th width="14%">Manage Picking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(MRD,index) in modelMRD">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ MRD.material.code }} - {{ MRD.material.name }}</td>
                                        <td>{{ MRD.quantity - MRD.already_issued }}</td>
                                        <td>{{ total[index] }}</td>
                                        <td class="p-l-0 p-r-0 textCenter">
                                            <button class="btn btn-primary btn-xs" data-toggle="modal" @click="slocDetailCheck(MRD.modelGI)" :href="targetModal(MRD.id)">MANAGE PICKING</button>
                                            <template v-if="MRD.modelGI.length > 0">
                                                <div class="modal fade" :id="MRD.id">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                                <h4 class="modal-title">Picking Configuration for <b>{{MRD.material.name}}</b></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table style="line-height: 20px">
                                                                    <thead>
                                                                        <th colspan="2">MR Details</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="text-left">
                                                                            <td>Quantity</td>
                                                                            <td>:</td>
                                                                            <td>&ensp;<b>{{MRD.quantity - MRD.already_issued}}</b></td>
                                                                        </tr>
                                                                        <tr class="text-left">
                                                                            <td>Issued</td>
                                                                            <td>:</td>
                                                                            <td>&ensp;<b>{{total[index]}}</b></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table id="gi-table" class="table table-bordered" style="border-collapse:collapse;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Storage Location</th>
                                                                            <th>Issued</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <br>
                                                                    <tbody>
                                                                        <tr v-for="(data,index) in MRD.modelGI" >
                                                                            <td>{{ index + 1 }}</td>
                                                                            <td class="tdEllipsis text-left">{{data.storage_location.code}} - {{data.storage_location.name}} (Available : {{data.quantity}})</td>
                                                                            <td class="p-l-0 no-padding">
                                                                                <input class="form-control width100" v-model="MRD.modelGI[index].issued" placeholder="Please Input Quantity">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </template>
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
    const form = document.querySelector('form#create-gi');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title != 'Material'){
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
        modelProject: @json($modelProject),
        modelMRD : @json($modelMRDs),
        modelMR :   @json($modelMR),
        modelSloc : @json($modelSloc),
        maxQtySloc : "",
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        description:"",
        submittedForm :{},
        total : [],
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
            slocDetailCheck(ModalGI){
                if(ModalGI.length < 1){
                    iziToast.warning({
                        title: 'There is no stock available in any storage location',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                }
            },
            targetModal(id){
                return '#'+id;
            },
            submitForm(){
                var data = this.modelMRD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(MRD => {
                    MRD.modelGI.forEach(modelGI => {
                        modelGI.issued = parseInt((modelGI.issued+"").replace(/,/g , ''));
                    });  
                });

                this.submittedForm.MRD = data;
                this.submittedForm.mr_id = this.modelMR.id;
                this.submittedForm.description = this.description;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            modelMRD:{
                handler: function(newValue) {
                    var arrTot = [];
                    newValue.forEach(function (MRD, i) {
                        var activeMRD = MRD;
                        if(activeMRD.modelGI.length > 0){
                            activeMRD.issued = 0;
                            total = 0;
                            activeMRD.modelGI.forEach(function (modelGI, index) {
                                var issued = parseInt((modelGI.issued+"").replace(/,/g , ''));
                                var qty = parseInt((modelGI.quantity+"").replace(/,/g , ''));

                                var maxQtyMR =  parseInt((activeMRD.quantity+"").replace(/,/g , ''));
                                maxQtyMR -=  parseInt((activeMRD.already_issued+"").replace(/,/g , ''));
                                if(modelGI.issued != ""){
                                    total += parseInt((modelGI.issued+"").replace(/,/g , ''));
                                    if(total > maxQtyMR){
                                        iziToast.warning({
                                            title: 'Issued quantity cannot be more than MR quantity',
                                            position: 'topRight',
                                            displayMode: 'replace'
                                        });
                                        modelGI.issued = "";
                                    }
                                }

                                if(issued > qty){
                                    iziToast.warning({
                                        title: 'Issued quantity cannot be more than available quantity in storage location',
                                        position: 'topRight',
                                        displayMode: 'replace'
                                    });
                                    modelGI.issued = modelGI.quantity;
                                }

                                modelGI.issued = (modelGI.issued+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            });
                            arrTot.push(total);
                            
                        }
                    });
                    this.total = arrTot;
                },
                deep: true
            },
        },
        mounted: function(){
            this.modelMRD.forEach(MRD => {
                window.axios.get('/api/getSlocDetail/'+MRD.material_id).then(({ data }) => {
                    MRD.modelGI = data;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again.. ('+error+')',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            });
        },
        created: function(){
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })
        }
    });
</script>
@endpush
