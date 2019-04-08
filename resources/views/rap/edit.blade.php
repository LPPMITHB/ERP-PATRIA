@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit RAP » '.$modelRap->number,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.indexSelectProject'),
            'View RAP' => route('rap.edit',$modelRap->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form id="edit-rap" class="form-horizontal" method="POST" action="{{ route('rap.update',['id'=>$modelRap->id]) }}">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="box-header">
                    <div class="row p-t-10 p-l-10 p-r-10">
                        <div class="col-xs-12 col-md-4">
                            <div class="col-sm-12 no-padding"><b>Project Information</b></div>
        
                            <div class="col-xs-4 no-padding">Project Number</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->code}}"><b>: {{$modelBOM->project->number}}</b></div>
                            
                            <div class="col-xs-4 no-padding">Ship Name</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->name}}"><b>: {{$modelBOM->project->name}}</b></div>
        
                            <div class="col-xs-4 no-padding">Ship Type</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->ship->type}}"><b>: {{$modelBOM->project->ship->type}}</b></div>
        
                            <div class="col-xs-4 no-padding">Customer</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->customer->name}}"><b>: {{$modelBOM->project->customer->name}}</b></div>
                        </div>
        
                        <div class="col-xs-12 col-md-4">
                            <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                            <div class="col-xs-4 no-padding">Number</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->number}}"><b>: {{$modelBOM->wbs->number}}</b></div>
                            
                            <div class="col-xs-4 no-padding">Description</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->description}}"><b>: {{$modelBOM->wbs->description}}</b></div>
        
                            <div class="col-xs-4 no-padding">Deliverable</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->deliverables}}"><b>: {{$modelBOM->wbs->deliverables}}</b></div>
        
                            <div class="col-xs-4 no-padding">Progress</div>
                            <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->progress}}%"><b>: {{$modelBOM->wbs->progress}}%</b></div>
                        </div>
        
                        <div class="col-xs-12 col-md-3 p-b-10">
                            <div class="col-sm-12 no-padding"><b>BOM Information</b></div>
                    
                            <div class="col-md-5 col-xs-4 no-padding">Code</div>
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->code}}"><b>: {{$modelBOM->code}}</b></div>
                            
                            <div class="col-md-5 col-xs-4 no-padding">Description</div>
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->description}}"><b>: {{$modelBOM->description}}</b></div>
                        </div>
                    </div>
                </div>
                @verbatim
                <div id="edit-rap">
                    <div class="box-body p-b-0">
                        <table class="table table-bordered tableNonPagingVue tableFixed">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Material Number</th>
                                    <th width="30%">Material Description</th>
                                    <th width="5%">Unit</th>
                                    <th width="15%">Quantity</th>
                                    <th width="25%">Cost per unit (Rp.)</th>
                                    <th width="25%">Sub Total Cost (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rapd, index) in modelRAPD">
                                    <td>{{ index+1 }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(rapd.material.code)">{{ rapd.material.code }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(rapd.material.description)">{{ rapd.material.description }}</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(rapd.material.uom.unit)">{{ rapd.material.uom.unit }}</td>
                                    <td class="">{{ rapd.quantity }}</td>
                                    <td class="no-padding">
                                        <input v-model="rapd.price" class="form-control width100">
                                    </td>
                                    <td class="no-padding">
                                        <input v-model="rapd.priceTotal" class="form-control width100" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" @click.prevent="update" class="btn btn-primary pull-right">SAVE</button>
                    </div>
                </div>
                @endverbatim
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </form>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#edit-rap');

    $(document).ready(function(){
        $('div.overlay').hide();

        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'Material Name'){
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }else{
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
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
        });
    });

    var data = {
        modelRAPD : @json($modelRAPD)   
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })
    var vm = new Vue({
        el: '#edit-rap',
        data: data,
        methods:{
            update(){
                this.modelRAPD.forEach(data=>{
                    if(data.price == ""){
                        data.price = 0;
                        data.priceTotal = 0;
                    }
                })
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.modelRAPD));
                form.appendChild(struturesElem);
                $(document.body).append(form)
                form.submit();
            },
            tooltipText: function(text) {
                return text
            },
        },
        watch:{
            modelRAPD:{
                handler: function(newValue) {
                    this.modelRAPD.forEach(rapDetail => {
                        rapDetail.price = (rapDetail.price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                        let total = parseInt((rapDetail.price+"").replace(/,/g , '')) * rapDetail.quantity;
                        rapDetail.priceTotal = (total+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");   
                    });
                },
                deep: true
            },
        },
        created: function(){
            this.modelRAPD.forEach(rapDetail => {
                rapDetail.priceTotal = rapDetail.price;
                rapDetail.price = rapDetail.price / rapDetail.quantity;
                rapDetail.price = (rapDetail.price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                rapDetail.priceTotal = (rapDetail.priceTotal+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush
