@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'View Resource Standard',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('project_standard.selectProjectResource'),
                'Select WBS' => route('project_standard.selectWBS', ['id' => $project->id, 'action' => 'resource']),
                'View Resource Standard' => '',
            ]
        ]
    )
    @endbreadcrumb
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
                            
                            <div class="col-xs-4 no-padding">Name</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.name)"><b>: {{project.name}}</b></div>
    
                            <div class="col-xs-4 no-padding">Description</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.description)"><b>: {{project.description}}</b></div>
    
                            <div class="col-xs-4 no-padding">Ship Type</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.ship.type)"><b>: {{project.ship.type}}</b></div>
                        </div>

                        <div v-if= "wbs != null" class="col-xs-12 col-md-3">
                            <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                            
                            <div class="col-xs-4 no-padding">Number</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
    
                            <div class="col-xs-4 no-padding">Description</div>
                            <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                            <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
    
                            <div class="col-xs-4 no-padding">Deliverable</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
    
                        </div>

                        <div class="col-md-2 col-xs-12 pull-right">
                            <a class="btn btn-sm btn-primary pull-right btn-block" :href="editResourceStandard(wbs.id)">EDIT</a>
                        </div>    
                    </div>
                    <table class="table table-bordered tableFixed" id="bom-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Resource Number</th>
                                <th width="45%">Resource Description</th>
                                <th width="10%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(resourceStandards,index) in resourceStandards">
                                <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                                <td>{{ resourceStandards.resource.code }}</td>
                                <td>{{ resourceStandards.resource.description }}</td>
                                <td>{{ resourceStandards.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
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
        resourceStandards : @json($resourceStandards),
        wbs : @json($wbs),
        project : @json($project),
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
            editResourceStandard(id){
                var url = "";
                url = "/project_standard/manageResource/"+id;
                return url;
            },
        },
        created: function() {
            var data = this.resourceStandards;
            data.forEach(resourceStandards => {
                var decimal = (resourceStandards.quantity+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        resourceStandards.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        resourceStandards.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    resourceStandards.quantity = (resourceStandards.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }         
            });
        }
    });
</script>
@endpush