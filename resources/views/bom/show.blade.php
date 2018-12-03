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
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Project Name</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->name}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Name</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->ship->name}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Type</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->ship->type}}</b></div>

                    <div class="col-xs-4 no-padding">Customer</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->customer->name}}</b></div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                
                    <div class="col-xs-4 no-padding">Code</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->work->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Name</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->work->name}}</b></div>

                    <div class="col-xs-4 no-padding">Description</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->work->description}}</b></div>

                    <div class="col-xs-4 no-padding">Deliverable</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->work->deliverables}}</b></div>

                    <div class="col-xs-4 no-padding">Progress</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->work->progress}}%</b></div>
                </div>

                <div class="col-xs-12 col-md-3 p-b-10">
                    <div class="col-sm-12 no-padding"><b>BOM Information</b></div>
            
                    <div class="col-xs-4 no-padding">Code</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Description</div>
                    <div class="col-xs-8 no-padding"><b>: {{$modelBOM->description}}</b></div>
                </div>
                
                <div class="col-md-1 col-xs-12">
                    @can('edit-bom')
                        <a class="btn btn-sm btn-primary pull-right btn-block" href="{{ route('bom.edit',['id'=>$modelBOM->id]) }}">EDIT</a>
                    @endcan
                </div>
            </div>
            @verbatim
            <div class="box-body" id="show-bom">
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
                            <td v-else-if="bomDetail.material.description != ''">-</td>
                            <td v-else>-</td>
                            <td>{{ bomDetail.quantity }}</td>
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
        jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
    });

    var data = {
        bom : @json($modelBOM),
        bomDetail : @json($modelBOMDetail),
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