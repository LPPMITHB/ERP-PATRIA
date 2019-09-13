@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'View Quality Control Type',
    'items' => [
        'Dashboard' => route('index'),
        'View All Materials' => route('qc_type.index'),
        $qcType->name => route('qc_type.show',$qcType->id),
    ]
])
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="box">
            <div class="box-body">
                <div class="box-tools pull-right">
                    <a href="{{ route('qc_type.edit',['id'=>$qcType->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4 m-l-10">
                        <div class="row">
                            <div class="col-xs-4 col-md-4">
                                Name
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b>{{$qcType->name}}</b>
                            </div>
                
                            <div class="col-xs-4 col-md-4">
                                Description
                            </div>
                            <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip"
                                title="{{$qcType->description}}">
                                : <b> {{ ($qcType->description != "") ? $qcType->description : '-' }} </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-body">
                @verbatim
                <div id="index_qcTypeDetail" class="tab-pane active" id="general_info">
                    <table id="qctd-table" class="table table-bordered showTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 40%">Name</th>
                                <th style="width: 55%">Description</th>
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