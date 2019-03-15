@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Material Family',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Material Family' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form id="add-currency" class="form-horizontal" method="POST" action="{{ route('material_family.add') }}">
                @csrf
                    @verbatim
                    <div id="material_family">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_currency">
                                                    ADD NEW MATERIAL FAMILY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_currency" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-12">
                                                    <input v-model="input.id" type="hidden" class="form-control">
                                                    <label for="name">Material Family Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert material family name">
                                                </div>
                                                <div class="col-xs-12 p-t-10">
                                                    <button type="submit" class="btn btn-primary pull-right" @click.prevent="add()">CREATE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_currency">
                                                    MANAGE CURRENT MATERIAL FAMILY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_currency" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="85%">Material Family Name</th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,index) in material_family"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="data.name" type="text" class="form-control"></td>
                                                            <td class="p-l-0" align="center">
                                                                <a @click.prevent="save()" class="btn btn-primary btn-xs" href="#">
                                                                    <div class="btn-group">
                                                                        SAVE
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
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
    const form = document.querySelector('form#add-currency');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        material_family : @json($material_family),
        input:{
            id : @json($id),
            name : ""
        }
    }

    var vm = new Vue({
        el : '#material_family',
        data : data,
        methods: {
            clearData(){
                this.input.id = "";
                this.input.name = "";
            },
            add(){
                $('div.overlay').show();
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.material_family.push(input);

                var material_family = this.material_family;
                material_family = JSON.stringify(material_family);
                var url = "{{ route('material_family.add') }}";

                window.axios.put(url,material_family).then((response) => {
                    iziToast.success({
                        title: 'Success Save Material Family',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    $('#current_currency').collapse();
                    $('#new_currency').collapse("hide");
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                })
                $('div.overlay').hide();
            },
            save(){
                $('div.overlay').show();
                var material_family = this.material_family;
                material_family = JSON.stringify(material_family);
                var url = "{{ route('material_family.add') }}";

                window.axios.put(url,material_family).then((response) => {
                    iziToast.success({
                        title: 'Success Save Material Family',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                })
                $('div.overlay').hide();
            }
        },
        created:function(){
        }
    });
</script>
@endpush
