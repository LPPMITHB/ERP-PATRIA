@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Service',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bos.indexProject'),
            'Select Bill Of Service' => route('bos.indexBos', ['id' => $modelBOS->project_id]),
            'View Bill Of Service' => route('bos.show', ['id' => $modelBOS->id]),
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
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->project->code}}"><b>: {{$modelBOS->project->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Project Name</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->project->name}}"><b>: {{$modelBOS->project->name}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Name</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->project->ship->type}}"><b>: {{$modelBOS->project->ship->type}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Type</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->project->ship->type}}"><b>: {{$modelBOS->project->ship->type}}</b></div>

                    <div class="col-xs-4 no-padding">Customer</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->project->customer->name}}"><b>: {{$modelBOS->project->customer->name}}</b></div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                
                    <div class="col-xs-4 no-padding">Code</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->wbs->code}}"><b>: {{$modelBOS->wbs->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Name</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->wbs->name}}"><b>: {{$modelBOS->wbs->name}}</b></div>

                    <div class="col-xs-4 no-padding">Description</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->wbs->description}}"><b>: {{$modelBOS->wbs->description}}</b></div>

                    <div class="col-xs-4 no-padding">Deliverable</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->wbs->deliverables}}"><b>: {{$modelBOS->wbs->deliverables}}</b></div>

                    <div class="col-xs-4 no-padding">Progress</div>
                    <div class="col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->wbs->progress}}%"><b>: {{$modelBOS->wbs->progress}}%</b></div>
                </div>

                <div class="col-xs-12 col-md-3 p-b-10">
                    <div class="col-sm-12 no-padding"><b>BOS Information</b></div>
            
                    <div class="col-md-5 col-xs-4 no-padding">Code</div>
                    <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->code}}"><b>: {{$modelBOS->code}}</b></div>
                    
                    <div class="col-md-5 col-xs-4 no-padding">Description</div>
                    <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelBOS->description}}"><b>: {{$modelBOS->description}}</b></div>

                    {{-- <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                    <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$rap_number}}"><a href="{{ route('rap.show',$modelRAP->id) }}" class="text-primary"><b>: {{$rap_number}}</b></a></div>

                    @if(isset($modelPR))
                        <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis"  data-container="body" data-toggle="tooltip" title="{{$pr_number}}"><a href="{{ route('purchase_requisition.show',$modelPR->id) }}" class="text-primary"><b>: {{$pr_number}}</b></a></div>
                    @else
                        <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>
                    @endif --}}
                </div>
                
                <div class="col-md-1 col-xs-12">
                    @can('edit-bos')
                        <a class="btn btn-sm btn-primary pull-right btn-block" href="{{ route('bos.edit',['id'=>$modelBOS->id]) }}">EDIT</a>
                    @endcan
                </div>
            </div>
            @verbatim
            <div class="box-body" id="show-bos">
                <table id="services-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Service Name</th>
                            <th width="45%">Description</th>
                            <th width="15%">Cost Standard Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bosDetail,index) in bosDetail">
                            <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                            <td>{{ bosDetail.service.code }} - {{ bosDetail.service.name }}</td>
                            <td v-if="bosDetail.service.description != null">{{ bosDetail.service.description }}</td>
                            <td v-else-if="bosDetail.service.description != ''">-</td>
                            <td v-else>-</td>
                            <td>{{ bosDetail.cost_standard_price }}</td>
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
        $('#services-table').DataTable({
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
        bos : @json($modelBOS),
        bosDetail : @json($modelBOSDetail),
    }

    var vm = new Vue({
        el : '#show-bos',
        data : data,
        created: function() {
            var data = this.bosDetail;
            data.forEach(bosDetail => {
                bosDetail.cost_standard_price = (bosDetail.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush