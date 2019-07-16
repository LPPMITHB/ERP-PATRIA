@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Tidal',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Tidal' => '',
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
                <form id="add-delivery-term" class="form-horizontal" method="POST" action="{{ route('tidal.add') }}">
                @csrf
                    @verbatim
                    <div id="tidal">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_tidal">
                                                    ADD NEW TIDAL
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_tidal" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-4">
                                                    <label for="name">Tidal Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert Tidal name">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="description">Tidal Description</label>
                                                    <input v-model="input.description" type="text" class="form-control" placeholder="Please insert Tidal description">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="value">Status</label>
                                                    <select v-model="input.status" class="form-control">
                                                        <option value="0">Non Active</option>
                                                        <option value="1">Active</option>
                                                    </select>
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_tidal">
                                                    MANAGE CURRENT TIDAL
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_tidal" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Tidal Name</th>
                                                            <th width="30%">Tidal Description</th>
                                                            <th width="10%">Status</th>
                                                            <th width="10%" ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(tidal,index) in tidal"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="tidal.name" type="text" class="form-control"></td>
                                                            <td class="no-padding"><input v-model="tidal.description" type="text" class="form-control"></td>
                                                            <td class="no-padding">
                                                                <select v-model="tidal.status" class="form-control">
                                                                    <option value="0">Non Active</option>
                                                                    <option value="1">Active</option>
                                                                </select>
                                                            </td>
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
    const form = document.querySelector('form#add-delivery-term');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        tidal : @json($tidal),
        input:{
            name : "",
            unit : "",
            value : "",
            status : 1,
        },
        max_id : 1,
    }

    var vm = new Vue({
        el : '#tidal',
        data : data,
        methods: {
            clearData(){
                this.input.name = "";
                this.input.description = "";
                this.input.status = 1;
            },
            add(){
                $('div.overlay').show();
                this.input.id = this.max_id + 1;
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.tidal.push(input);
                var tidal = this.tidal;
                tidal = JSON.stringify(tidal);
                var url = "{{ route('tidal.add') }}";

                window.axios.put(url,tidal).then((response) => {
                    iziToast.success({
                        title: 'Success Save Tidal',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    $('#current_tidal').collapse("show");
                    $('#new_tidal').collapse("hide");
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
                var tidal = this.tidal;
                tidal = JSON.stringify(tidal);
                var url = "{{ route('tidal.add') }}";

                window.axios.put(url,tidal).then((response) => {
                    iziToast.success({
                        title: 'Success Save Tidal',
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
        watch: {
            
        },
        created : function(){
            var modelDeliveryTerms = this.tidal;
            modelDeliveryTerms.forEach(data => {
                if(data.id > this.max_id){
                    this.max_id = data.id;
                }
            });
        }
    });
</script>
@endpush
