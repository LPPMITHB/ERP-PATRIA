@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'View All Quality Control Type',
    'subtitle' => '',
    'items' => [
    'Dashboard' => route('index'),
    'View All Quality Control Type' => '',
    ]
])
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        <a href="{{ route('qc_type.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div>
                @verbatim
                <div id="index_qc_type">
                    <table id="qc-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Name</th>
                                <th width="45%">Description</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in qc_type">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    <a :href="createRouteShow(data.id)" class="btn btn-primary btn-xs">VIEW</a>
                                    <a :href="createRouteEdit(data.id)" class="btn btn-primary btn-xs">EDIT</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                @endverbatim
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->

@endsection

@push('script')
<script>
    $('div.overlay').hide();
    var data = {
        qc_type:'',
    };
    var vm = new Vue({
        el: '#index_qc_type',
        data: data,
        methods: {
            createRouteShow(id) {
                var url = "/qc_type/" + id;
                return url;
            },
            createRouteEdit(id) {
                var url = "/qc_type/" + id + "/edit";
                return url;
            }
        },
        mounted(){
            //
            loading();
            window.axios.get('/api/get/qc_type_master')
            .then(({ data }) => {
                this.qc_type = data;
            })
            .finally(function(){
                $('#qc-table').DataTable({
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
            
            
        }
    });

    // $(document).ready(function() {
    //     $('#qc-table').DataTable({
    //         'paging': true,
    //         'lengthChange': false,
    //         'ordering': true,
    //         'info': true,
    //         'autoWidth': false,
    //         'bFilter': true,
    //         'initComplete': function() {
    //             $('div.overlay').hide();
    //         }
    //     });
    // });

    function loading() {
        $('div.overlay').show();
    }
</script>
@endpush