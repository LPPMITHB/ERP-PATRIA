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
                <div class="col-sm-4">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-r-40">Project Code</td>
                                <td class="p-r-5">:</td>
                                <td><b>{{$modelBOM->project->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Project Name</td>
                                <td>:</td>
                                <td><b>{{$modelBOM->project->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship Name</td>
                                <td>:</td>
                                <td><b>{{$modelBOM->project->ship->name}}</b></td>

                                
                            </tr>
                            <tr>
                                <td>Ship Type</td>
                                <td>:</td>
                                <td><b>{{$modelBOM->project->ship->type}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td><b>{{$modelBOM->project->customer->name}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <table>
                        <thead>
                            <th colspan="2">WBS Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->work->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->work->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->work->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Deliverable</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->work->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->work->progress}}%</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3">
                    <table>
                        <thead>
                            <th colspan="2">BOM Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelBOM->description}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                       
                </div>
                <div class="col-sm-1">
                    @can('edit-bom')
                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('bom.edit',['id'=>$modelBOM->id]) }}">EDIT</a>
                    @endcan
                </div>
            </div>
            @verbatim
            <div class="box-body" id="show-bom">
                <table id="materials-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="45%">Material Name</th>
                            <th width="45%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bomDetail,index) in bomDetail">
                            <td class="p-t-15 p-b-15">{{ index+1 }}</td>
                            <td>{{ bomDetail.material.name }}</td>
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

    function deletebom(){
        iziToast.show({
            timeout: 10000,
            color : 'red',
            displayMode: 'replace',
            icon: 'fa fa-warning',
            title: 'Warning !',
            message: 'Are you sure to delete BOM ?',
            position: 'topRight',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    document.getElementById('delete-form-{{ $modelBOM->id }}').submit();
                }, true], 
                ['<button>CANCEL</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                    }, toast, 'buttonName');
                }]
            ],
        });
    }
</script>
@endpush