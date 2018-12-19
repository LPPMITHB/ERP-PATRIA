@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Material',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bom.indexProject'),
            'Select Bill Of Material' => route('bom.indexBom', ['id' => $modelBOM->project_id]),
            'View Bill Of Material' => route('bom.show', ['id' => $modelBOM->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box ">
            <div class="box-header">
                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>

                    <div class="col-xs-4 no-padding">Project Code</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->number}}"><b>: {{$modelBOM->project->number}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Ship Name</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->name}}"><b>: {{$modelBOM->project->name}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Type</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->ship->type}}"><b>: {{$modelBOM->project->ship->type}}</b></div>

                    <div class="col-xs-4 no-padding">Customer</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->project->customer->name}}"><b>: {{$modelBOM->project->customer->name}}</b></div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                
                    <div class="col-xs-4 no-padding">Code</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->code}}"><b>: {{$modelBOM->wbs->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Name</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOM->wbs->name}}"><b>: {{$modelBOM->wbs->name}}</b></div>

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

                    <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                    <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelRAP->number}}"><a href="{{ route('rap.show',$modelRAP->id) }}" class="text-primary"><b>: {{$modelRAP->number}}</b></a></div>

                    @if(isset($modelPR))
                        <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis"  data-container="body" data-toggle="tooltip" title="{{$modelPR->number}}"><a href="{{ route('purchase_requisition.show',$modelPR->id) }}" class="text-primary"><b>: {{$modelPR->number}}</b></a></div>
                    @else
                        <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>
                    @endif
                </div>
                
                <div class="col-md-1 col-xs-12">
                    @can('edit-bom')
                        <a class="btn btn-sm btn-primary pull-right btn-block" href="{{ route('bom.edit',['id'=>$modelBOM->id]) }}">EDIT</a>
                    @endcan
                    @can('edit-bom-repair')
                    <a class="btn btn-sm btn-primary pull-right btn-block" href="{{ route('bom_repair.edit',['id'=>$modelBOM->id]) }}">EDIT</a>
                @endcan
                </div>
            </div>
            @verbatim
            <div class="box-body" id="show-bom">
                <template v-if="route == '/bom'">
                    <table id="materials-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Material Name</th>
                                <th width="45%">Description</th>
                                <th width="15%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bomDetail,index) in bomDetail">
                                <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                                <td>{{ bomDetail.material.code }} - {{ bomDetail.material.name }}</td>
                                <td v-if="bomDetail.material.description != null">{{ bomDetail.material.description }}</td>
                                <td v-else>-</td>
                                <td>{{ bomDetail.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <template v-else-if="route == '/bom_repair'">
                    <table id="materials-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Material Name</th>
                                <th width="45%">Description</th>
                                <th width="15%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bomDetail,index) in bomDetail">
                                <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                                <template v-if="bomDetail.material_id != null">
                                    <td >{{ bomDetail.material.code }} - {{ bomDetail.material.name }}</td>
                                    <td v-if="bomDetail.material.description != null">{{ bomDetail.material.description }}</td>
                                    <td v-else>-</td>
                                </template>
                                <template v-else-if="bomDetail.service_id != null">
                                    <td >{{ bomDetail.service.code }} - {{ bomDetail.service.name }}</td>
                                    <td v-if="bomDetail.service.description != null">{{ bomDetail.service.description }}</td>
                                    <td v-else>-</td>
                                </template>
                                <td>{{ bomDetail.quantity }}</td>
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
        $('#materials-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        bom : @json($modelBOM),
        bomDetail : @json($modelBOMDetail),
        route : @json($route)
    }

    var vm = new Vue({
        el : '#show-bom',
        data : data,
        created: function() {
            var data = this.bomDetail;
            data.forEach(bomDetail => {
                bomDetail.quantity = (bomDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush