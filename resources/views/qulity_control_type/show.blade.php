@extends('layouts.main')

@section('content-header')
@breadcrumb(
[
'title' => 'View Quality Controll Type',
'items' => [
'Dashboard' => route('index'),
'View All Materials' => route('qc_type.index'),
$qcType->name => route('qc_type.show',$qcType->id),
]
]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="box">
            <div class="box-header">
                <b>
                    <h4><b>Name</b> : {{ strtoupper($qcType->name)}}<h4>
                </b>
                <p><b>Description :</b>
                 
                </p><span><textarea rows="3" cols="115"> {{$qcType->description}}</textarea></span>
            </div>
            <div class="box-body">
                <div class="box-tools pull-right p-t-5">
                    {{-- @can('edit-material') --}}
                    <a href="{{ route('qc_type.edit',['id'=>$qcType->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    {{-- @endcan --}}
                </div>
                @verbatim
                <div id="index_qcTypeDetail" class="tab-pane active" id="general_info">
                    <table id="qctd-table" class="table table-bordered width100 showTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 40%">Attribute</th>
                                <th style="width: 55%">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in qcTypeDetail">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endverbatim
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
    var data = {
        qcTypeDetail: @json($qcTypeDetail),
    };
    var vm = new Vue({
        el: '#index_qcTypeDetail',
        data: data,
        methods: {
            createRouteEdit(id) {
                var url = "/qc_type/" + id + "/edit";
                return url;
            }
        }
    });
    $(document).ready(function() {
    $('#qctd-table').DataTable({
        'paging': true,
        'lengthChange': false,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'bFilter': true,
        'initComplete': function() {
        $('div.overlay').hide();
        }
    });
    });
</script>
@endpush