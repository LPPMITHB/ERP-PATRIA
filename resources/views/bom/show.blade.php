@extends('layouts.main')

@section('content-header')
@if($route == "/bom")
    @breadcrumb(
        [
            'title' => 'View Bill Of Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('bom.indexProject'),
                'Select Bill Of Material' => route('bom.indexBom', ['id' => $modelBOM->project_id]),
                'View Bill Of Material' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/bom_repair")
    @breadcrumb(
        [
            'title' => 'View BOM / BOS',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('bom_repair.indexProject'),
                'Select BOM / BOS' => route('bom_repair.indexBom', ['id' => $modelBOM->project_id]),
                'View BOM / BOS' => '',
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
                @verbatim
                <div class="box-body p-t-0" id="show-bom">
                    <div class="box-header p-l-0 p-r-0 p-b-0">
                        <div class="col-xs-12 col-md-4">
                            <div class="col-sm-12 no-padding"><b>Project Information</b></div>
    
                            <div class="col-xs-4 no-padding">Project Number</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.project.number)"><b>: {{bom.project.number}}</b></div>
                            
                            <div class="col-xs-4 no-padding">Ship Name</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.project.name)"><b>: {{bom.project.name}}</b></div>
    
                            <div class="col-xs-4 no-padding">Ship Type</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.project.ship.type)"><b>: {{bom.project.ship.type}}</b></div>
    
                            <div class="col-xs-4 no-padding">Customer</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.project.customer.name)"><b>: {{bom.project.customer.name}}</b></div>
                        </div>

                        <div v-if= "bom.wbs != null" class="col-xs-12 col-md-3">
                            <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                            
                            <div class="col-xs-4 no-padding">Number</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.wbs.number)"><b>: {{bom.wbs.number}}</b></div>
    
                            <div class="col-xs-4 no-padding">Description</div>
                            <div v-if="bom.wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.wbs.description)"><b>: {{bom.wbs.description}}</b></div>
                            <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.wbs.description)"><b>: -</b></div>
    
                            <div class="col-xs-4 no-padding">Deliverable</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.wbs.deliverables)"><b>: {{bom.wbs.deliverables}}</b></div>
    
                            <div class="col-xs-4 no-padding">Progress</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.wbs.progress)"><b>: {{bom.wbs.progress}}%</b></div>
                        </div>

                        <div class="col-xs-12 col-md-3 p-b-10">
                            <div class="col-sm-12 no-padding"><b>BOM Information - {{status}}</b></div>
                    
                            <div class="col-md-5 col-xs-4 no-padding">Code</div>
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.code)"><b>: {{bom.code}}</b></div>
                            
                            <div class="col-md-5 col-xs-4 no-padding">Description</div>
                            <div v-if="bom.description != ''" class="col-md-7 col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.description)"><b>: {{bom.description}}</b></div>
                            <div v-else class="col-md-7 col-xs-8 no-padding tdEllipsis" v-tooltip:top="(bom.description)"><b>: -</b></div>

                            <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                            <div v-if="bom.rap != null" class="col-md-7 col-xs-8 no-padding tdEllipsis"><a :href="showRap(bom.rap.id)" class="text-primary"><b>: {{bom.rap.number}}</b></a></div>
                            <div v-else class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>        
                            
                            <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                            <div v-if="bom.purchase_requisition != null" class="col-md-7 col-xs-8 no-padding tdEllipsis"><a :href="showPr(bom.purchase_requisition.id)" class="text-primary"><b>: {{bom.purchase_requisition.number}}</b></a></div>
                            <div v-else class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>     

                        </div>

                        <div class="col-md-2 col-xs-12 pull-right">
                            <template v-if="route == '/bom'">
                                <a class="btn btn-sm btn-primary pull-right btn-block" :href="editBom(bom.id)">EDIT</a>
                                <a v-if="bom.status == 1" class="btn btn-sm btn-primary pull-right btn-block" @click="confirmBom(bom.id)">CONFIRM</a>
                            </template>
                            <template v-else-if="route == '/bom_repair'">
                                <a class="btn btn-sm btn-primary pull-right btn-block" :href="editBomRepair(bom.project.id)">EDIT</a>
                            </template>
                        </div>    
                    </div>
                    <template v-if="route == '/bom'">
                        <table class="table table-bordered tableFixed" id="bom-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Material Number</th>
                                    <th width="45%">Material Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Unit</th>
                                    <th width="10%">Source</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(bomDetail,index) in bomDetail">
                                    <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                                    <td>{{ bomDetail.material.code }}</td>
                                    <td>{{ bomDetail.material.description }}</td>
                                    <td>{{ bomDetail.quantity }}</td>
                                    <td>{{ bomDetail.material.uom.unit }}</td>
                                    <td>{{ bomDetail.source}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <template v-else-if="route == '/bom_repair'">
                        <table class="table table-bordered tableFixed" id="bom-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Type</th>
                                    <th width="20%">Material Number</th>
                                    <th width="45%">Material Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Unit</th>
                                    <th width="10%">Source</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(bomDetail,index) in bomDetail">
                                    <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                                    <template v-if="bomDetail.material_id != null">
                                        <td>Material</td>
                                        <td>{{ bomDetail.material.code }}</td>
                                        <td>{{ bomDetail.material.description }}</td>
                                        <td>{{ bomDetail.quantity }}</td>
                                        <td>{{ bomDetail.material.uom.unit }}</td>
                                        <td>{{ bomDetail.source }}</td>
                                    </template>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
                @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        // $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        // $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'Unit' || title == 'Quantity' || title == 'No' || title == ""){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( tablePagingVue.column(i).search() !== this.value ) {
        //             tablePagingVue
        //                 .column(i)
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     });
        // });

        // var tablePagingVue = $('.tablePagingVue').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        // });
        // $('div.overlay').hide();
        $('#bom-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        status : @json(($modelBOM->status == 0) ? 'CONFIRMED' : 'OPEN'),
        bom : @json($modelBOM),
        bomDetail : @json($modelBOMDetail),
        route : @json($route),
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#show-bom',
        data : data,
        methods:{
            showRap(id){
                var url = "";
                if(this.route == "/bom"){
                    url = "/rap/"+id;
                }else{
                    url = "/rap_repair/"+id;                
                }
                return url;
            },
            showPr(id){
                var url = "";
                if(this.route == "/bom"){
                    url = "/purchase_requisition/"+id;
                }else{
                    url = "/purchase_requisition_repair/"+id;                
                }
                return url;
            },
            editBom(id){
                var url = "";
                if (this.bom.status == 1){
                    url = "/bom/materialSummaryBuilding/"+this.bom.wbs_id;
                }else{
                    url = "/bom/"+this.bom.id+"/edit";
                }
                return url;
            },
            editBomRepair(id){
                var url = "";
                url = "/bom_repair/materialSummary/"+id;
                return url;
            },
            confirm(id){
                $('div.overlay').show();
                if(this.route == "/bom"){
                    var url = "{{ route('bom.confirmBom') }}"
                }else if(this.route == "/bom_repair"){
                    var url = "{{ route('bom_repair.confirmBom') }}"
                }
                // update to database
                window.axios.put(url,this.bom.id).then((response)=>{
                    window.axios.get('/api/getBomHeader/'+this.bom.id).then(({ data }) => {
                        this.bom = data;
                        this.status = data.status;
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
                    iziToast.success({
                        title: 'BOM Confirmed !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            confirmBom(id){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to confirm this BOM?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            vm.confirm(id)
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
        },
        created: function() {
            var data = this.bomDetail;
            data.forEach(bomDetail => {
                var decimal = (bomDetail.quantity+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    bomDetail.quantity = (bomDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }         
            });
        }
    });
</script>
@endpush