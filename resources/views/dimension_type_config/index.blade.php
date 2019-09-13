@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Dimension Type',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Dimension Type' => '',
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
                <form id="add-delivery-term" class="form-horizontal" method="POST" action="{{ route('dimension_type.add') }}">
                @csrf
                    @verbatim
                    <div id="dimension_type">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_dimension_type">
                                                    ADD NEW DIMENSION TYPE
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_dimension_type" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-4">
                                                    <label for="name">Dimension Type Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert Dimension Type name">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="description">Dimension Type Description</label>
                                                    <input v-model="input.description" type="text" class="form-control" placeholder="Please insert Dimension Type description">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="value">Status</label>
                                                    <select v-model="input.status" class="form-control">
                                                        <option value="0">Non Active</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm 12 p-l-15 p-r-15">
                                                    <label class="m-t-10" for="value">Dimensions</label>
                                                    <table class="table table-bordered tableFixed">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th width="30%">Dimension Name</th>
                                                                <th width="30%">Dimension UOM</th>
                                                                <th width="10%" ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(dimension,index) in input.dimensions"> 
                                                                <td>{{ index+1 }}</td>
                                                                <td class="no-padding"><input v-model="dimension.name" type="text" class="form-control"></td>
                                                                <td class="no-padding">
                                                                    <selectize id="uom" v-model="dimension.uom_id" :settings="uomConfigSettings">
                                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name+" - "+uom.unit}}</option>
                                                                    </selectize>
                                                                </td>
                                                                <td align="center" class="p-l-0">
                                                                    <button @click.prevent="removeRow(index)" class="btn btn-danger btn-xs" id="btnDelete">DELETE</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="p-l-10">{{newIndex}}</td>
                                                                <td class="p-l-0">
                                                                    <input v-model="input_dimension.name" type="text" class="form-control width100" id="name" name="name" placeholder="Name">
                                                                </td>
                                                                <td class="p-l-0">
                                                                    <selectize id="uom" v-model="input_dimension.uom_id" :settings="uomConfigSettings">
                                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name+" - "+uom.unit}}</option>
                                                                    </selectize>
                                                                </td>
                                                                <td align="center" class="p-l-0">
                                                                    <button @click.prevent="addDimension" :disabled="addDimensionOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_dimension_type">
                                                    MANAGE CURRENT DIMENSION TYPE
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_dimension_type" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Dimension Type Name</th>
                                                            <th width="30%">Dimensions</th>
                                                            <th width="10%">Status</th>
                                                            <th width="10%" ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(dimension_type,index) in dimension_types"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="dimension_type.name" type="text" class="form-control"></td>
                                                            <td class="no-padding">
                                                                <button type="button" @click.prevent="openModalManage(index,dimension_type)" class="btn btn-primary btn-xs col-xs-12 " data-toggle="modal" data-target="#manage_dimensions">MANAGE DIMENSIONS</button>
                                                            </td>
                                                            <td class="no-padding">
                                                                <select v-model="dimension_type.status" class="form-control">
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
                        <div class="modal fade" id="manage_dimensions">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Manage Dimensions</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label class="" for="value">Dimensions</label>
                                        <table class="table table-bordered tableFixed">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="30%">Dimension Name</th>
                                                    <th width="30%">Dimension UOM</th>
                                                    <th width="10%" ></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(dimension,index) in manage_dimensions"> 
                                                    <td>{{ index+1 }}</td>
                                                    <td class="no-padding"><input v-model="dimension.name" type="text" class="form-control"></td>
                                                    <td class="no-padding">
                                                        <selectize id="uom" v-model="dimension.uom_id" :settings="uomConfigSettings">
                                                            <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name+" - "+uom.unit}}</option>
                                                        </selectize>
                                                    </td>
                                                    <td align="center" class="p-l-0">
                                                        <button @click.prevent="removeRowEdit(index)" class="btn btn-danger btn-xs" id="btnDelete">DELETE</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="p-l-10">{{editIndex}}</td>
                                                    <td class="p-l-0">
                                                        <input v-model="edit_dimension.name" type="text" class="form-control width100" id="name" name="name" placeholder="Name">
                                                    </td>
                                                    <td class="p-l-0">
                                                        <selectize id="uom" v-model="edit_dimension.uom_id" :settings="uomConfigSettings">
                                                            <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name+" - "+uom.unit}}</option>
                                                        </selectize>
                                                    </td>
                                                    <td align="center" class="p-l-0">
                                                        <button @click.prevent="addEditDimension" :disabled="addEditDimensionOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="saveDimension">SAVE CHANGES</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
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
        dimension_types : @json($dimension_type),
        uoms : @json($uom),
        input:{
            name : "",
            dimensions : [],
            status : 1,
        },
        input_dimension:{
            name : "",
            uom_id : "",
        },
        edit_dimension:{
            name : "",
            uom_id : "",
        },
        activeIndex : "",
        newIndex : 1,
        editIndex : 1,
        manage_dimensions:[],
        max_id : 1,
        uomConfigSettings: {
            placeholder: 'UOM',
        },
    }

    var vm = new Vue({
        el : '#dimension_type',
        data : data,
        computed: {
            addDimensionOk: function(){
                let isOk = false;
                if(this.input_dimension.name == "" || 
                this.input_dimension.uom_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            addEditDimensionOk: function(){
                let isOk = false;
                if(this.edit_dimension.name == "" || 
                this.edit_dimension.uom_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                if(this.manage_dimensions.length == 0)
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods: {
            removeRow(idx){
                this.input.dimensions.splice(idx, 1);
                this.newIndex = this.input.dimensions.length +1;
            },
            removeRowEdit(idx){
                this.manage_dimensions.splice(idx, 1);
                this.editIndex = this.manage_dimensions.length+1;
            },
            openModalManage(idx, dimension_type){
                var temp = JSON.stringify(dimension_type);
                temp = JSON.parse(temp);
                this.activeIndex = idx;
                this.manage_dimensions = temp.dimensions;
                this.editIndex = this.manage_dimensions.length+1;
            },
            clearData(){
                this.input.name = "";
                this.input.description = "";
                this.input.dimensions = [];
                this.input.status = 1;
            },
            clearDataDimension(){
                this.input_dimension.name = "";
                this.input_dimension.uom_id = "";
            },
            clearDataEditDimension(){
                this.edit_dimension.name = "";
                this.edit_dimension.uom_id = "";
            },
            addDimension(){
                var input = JSON.stringify(this.input_dimension);
                input = JSON.parse(input);
                this.input.dimensions.push(input);
                this.clearDataDimension();

                this.newIndex = this.input.dimensions.length +1;
            },
            addEditDimension(){
                var input = JSON.stringify(this.edit_dimension);
                input = JSON.parse(input);

                this.manage_dimensions.push(input);
                this.clearDataEditDimension();

                this.editIndex = this.manage_dimensions.length +1;
            },
            add(){
                $('div.overlay').show();
                this.input.id = this.max_id + 1;
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.dimension_types.push(input);
                var dimension_type = this.dimension_types;
                dimension_type = JSON.stringify(dimension_type);
                var url = "{{ route('dimension_type.add') }}";

                window.axios.put(url,dimension_type).then((response) => {
                    iziToast.success({
                        title: 'Success Save Dimension Type',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    this.clearDataDimension();
                    this.newIndex = 1;
                    $('#current_dimension_type').collapse("show");
                    $('#new_dimension_type').collapse("hide");
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
            saveDimension(){
                $('div.overlay').show();
                var input = JSON.stringify(this.manage_dimensions);
                input = JSON.parse(input);

                this.dimension_types[this.activeIndex].dimensions = input;
                iziToast.success({
                    title: 'Success to change Dimension Type, please click SAVE button to UPDATE the data',
                    position: 'topRight',
                    displayMode: 'replace'
                });
                $('div.overlay').hide();
            },
            save(){
                $('div.overlay').show();
                var dimension_type = this.dimension_types;
                dimension_type = JSON.stringify(dimension_type);
                var url = "{{ route('dimension_type.add') }}";

                window.axios.put(url,dimension_type).then((response) => {
                    iziToast.success({
                        title: 'Success Save Dimension Type',
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
            var modelDimensionType = this.dimension_types;
            modelDimensionType.forEach(data => {
                if(data.id > this.max_id){
                    this.max_id = data.id;
                }
            });
        }
    });
</script>
@endpush
