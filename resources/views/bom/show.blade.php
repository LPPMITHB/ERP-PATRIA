@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Material',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Bill Of Materials' => route('bom.indexProject'),
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
                <div class="col-sm-10 ">
                    <div class="col-sm-6 no-padding">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width: 25%" class="p-r-100">Code</td>
                                    <td style="width: 3%" class="p-r-5">:</td>
                                    <td><b>{{$modelBOM->code}}</b></td>
                                </tr>
                                <tr>
                                    <td valign="top">Description</td>
                                    <td valign="top">:</td>
                                    <td><b>{{$modelBOM->description}}</b></td>
                                </tr>
                                <tr>
                                    <td valign="top">Status</td>
                                    <td valign="top">:</td>
                                    @if($modelBOM->work_id != "")
                                        <td><b>{{ 'ASSIGNED' }}</b></td>
                                    @else
                                        <td><b>{{ 'NOT ASSIGNED' }}</b></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td valign="top">Work Name</td>
                                    <td valign="top">:</td>
                                    @if($modelBOM->work_id != "")
                                        <td><b>{{ $modelBOM->work->name }}</b></td>
                                    @else
                                        <td><b>{{ '-' }}</b></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 no-padding">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="p-l-40">Customer</td>
                                    <td class="p-r-5">:</td>
                                    <td><b>{{$modelBOM->project->customer->name}}</b></td>
                                </tr>
                                <tr>
                                    <td class="p-l-40">Project Code</td>
                                    <td class="p-r-5">:</td>
                                    <td><b>{{$modelBOM->project->code}}</b></td>
                                    
                                </tr>
                                <tr>
                                    <td class="p-l-40 p-r-40">Project Name</td>
                                    <td>:</td>
                                    <td><b>{{$modelBOM->project->name}}</b></td>
                                </tr>
                                <tr>
                                    <td class="p-l-40">Ship Name</td>
                                    <td>:</td>
                                    <td><b>{{$modelBOM->project->ship->name}}</b></td>
                                </tr>
                                <tr>
                                    <td class="p-l-40">Ship Type</td>
                                    <td>:</td>
                                    <td><b>{{$modelBOM->project->ship->type}}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-2 pull-right no-padding">
                    {{-- @can('destroy-bom')
                        <a class="btn btn-sm btn-danger pull-right m-t-5" class="m-r-30" href="#" onclick="deletebom()">DELETE</i></a>
                    @endcan
    
                    <form id="delete-form-{{ $modelBOM->id }}" action="{{ route('bom.destroy', ['id' => $modelBOM->id]) }}" method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                    </form> --}}
                
                    @can('edit-bom')
                        <a class="btn btn-sm btn-primary pull-right m-t-5" href="{{ route('bom.edit',['id'=>$modelBOM->id]) }}">EDIT</a>
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