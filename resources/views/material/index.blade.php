@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Materials',
        'subtitle' => 'Index',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('material.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            @verbatim
            <div id="index_material">
                <div class="box-body">
                    <table class="table table-bordered table-hover tableFixed" id="material-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Code</th>
                                <th style="width: 30%">Name</th>
                                <th style="width: 35%">Description</th>
                                <th style="width: 10%">Type</th>
                                <th style="width: 10%"></th>
    
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in materials">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" :title="data.name">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" :title="data.description">{{ data.description }}</td>
                                <td v-if="data.type == 3">Bulk part</td>
                                <td v-else-if="data.type == 2">Component</td>
                                <td v-else-if="data.type == 1">Consumable</td>
                                <td v-else-if="data.type == 0">Raw</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    <a :href="createRouteShow(data.id)" class="btn btn-primary btn-xs">VIEW</a>
                                    <a :href="createRouteEdit(data.id)" class="btn btn-primary btn-xs">EDIT</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- /.box-body -->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            @endverbatim
        </div>
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>

    var data = {
        materials : @json($materials),
    };

    var vm = new Vue({
        el: '#index_material',
        data: data,
        methods:{
            createRouteShow(id){
                var url = "/material/"+id;
                return url;
            },
            createRouteEdit(id){
                var url = "/material/"+id+"/edit";
                return url;
            }
        }
    });
    
    $(document).ready(function(){
        $('#material-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush