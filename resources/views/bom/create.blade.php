@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Bill Of Material',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Bill Of Materials' => route('bom.indexProject'),
            'Create Bill Of Material' => route('bom.create', ['id' => $project->id]),
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
                <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('bom.store') }}">
                @csrf
                    @verbatim
                    <div id="bom">
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
                                            <td><b>{{project.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Project Name</td>
                                            <td>:</td>
                                            <td><b>{{project.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ship Name</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.name}}</b></td>
    
                                            
                                        </tr>
                                        <tr>
                                            <td>Ship Type</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.type}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Customer</td>
                                            <td>:</td>
                                            <td><b>{{project.customer.name}}</b></td>
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
                                            <td>&ensp;<b>{{work.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.description}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Deliverable</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.deliverables}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Progress</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.progress}}%</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <td rowspan="2">BOM Description</td>
                                <td rowspan="2">:</td>
                                <td rowspan="2">
                                    <textarea class="form-control" rows="3" v-model="submittedForm.description" style="width:326px"></textarea>  
                                </td>
                            </div>
                            
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="28%">Material</th>
                                        <th width="38%">Description</th>
                                        <th width="19%">Quantity</th>
                                        <th width="10%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(material, index) in materialTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ material.material_name }}</td>
                                        <td>{{ material.description }}</td>
                                        <td>{{ material.quantity }}</td>
                                        <td class="p-l-0" align="center"><a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                            <div class="btn-group">
                                                DELETE
                                            </div></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.quantity"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-bom');

    $(document).ready(function(){
        $('div.overlay').hide();
        $('.alert').addClass('animated bounce');
        
    });

    var data = {
        project : @json($project),
        materials : @json($materials),
        work : @json($work),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            bom_code : "",
            description : ""
        },
        input : {
            material_id : "",
            material_name : "",
            description : "",
            quantity : "",
            quantityInt : 0
        },
        materialTable : [],
        materialSettings: {
            placeholder: 'Please Select Material'
        },
    }

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                var string_newValue = this.input.quantityInt+"";
                this.input.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.input.material_id == "" || this.input.material_name == "" || this.input.description == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.submittedForm.project_id == "" || this.submittedForm.bom_code == "" || this.materialTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                this.submittedForm.materials = this.materialTable;
                this.submittedForm.work_id = this.work.id;          

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.material_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.materialTable.push(data);
                    this.newIndex = this.materialTable.length + 1;

                    this.input.description = "";
                    this.input.material_id = "";
                    this.input.material_name = "";
                    this.input.quantity = "";
                    this.input.quantityInt = 0;
                }
            },
            removeRow: function(index) {
                this.materialTable.splice(index, 1);
                this.newIndex = this.materialTable.length + 1;
            }
        },
        watch: {
            'input.material_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;

                        }
                        this.input.material_name = data.name;
                    });
                }
            },
            'input.quantity': function(newValue){
                this.input.quantityInt = newValue;
                this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            }
        },
        created: function() {
            this.submittedForm.project_id = this.project.id;

            this.newIndex = this.materialTable.length + 1;
        }
    });
       
</script>
@endpush
