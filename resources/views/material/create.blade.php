@extends('layouts.main')
@section('content-header')

{{-- @if($material->id)
@breadcrumb(
    [
        'title' => 'Edit Material',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            $material->name => route('material.show',$material->id),
            'Edit Material' => route('material.edit',$material->id),
        ]
    ]
)
@endbreadcrumb
@else --}}
@breadcrumb(
    [
        'title' => 'Create Material',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            'Create Material' => route('material.create'),
        ]
    ]
)
@endbreadcrumb
{{-- @endif --}}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <!-- @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif -->

                <form id="create-material"class="form-horizontal" method="POST" action="{{ route('material.store') }}">
                @csrf
                    <div class="box-body">
                       
                        @verbatim
                        <div id="material">
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" data-inputmask="'mask': '99-aaa-*****-aa'" id="code" name="code" required autofocus v-model="submittedForm.code" @keyup="submittedForm.code  = this.event.target.value;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" required autofocus v-model="submittedForm.name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" v-model="submittedForm.description">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price Material(Rp)</label>
                            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cost_standard_price" required v-model="submittedForm.cost_standard_price">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost_standard_service" class="col-sm-2 control-label">Cost Standard Price Service (Rp)</label>
                            
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="cost_standard_service" required v-model="submittedForm.cost_standard_service">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="min" class="col-sm-2 control-label">Min</label>
                            
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="min" required v-model="submittedForm.min">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="max" class="col-sm-2 control-label">Max</label>
                            
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="max" required v-model="submittedForm.max">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label">Weight</label>
            
                            <div class="col-sm-8">
                                <input type="text" :disabled="weightOk" class="form-control" id="weight" v-model="submittedForm.weight">
                            </div>

                            <div class="col-sm-2">
                                <selectize id="uom" v-model="submittedForm.weight_uom_id" :settings="weight_uom_settings">
                                    <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                </selectize>    
                            </div>
                        </div>
                        
                            <div class="form-group">
                                <label for="height" class="col-sm-2 control-label">Height</label>
                
                                <div class="col-sm-8">
                                    <input type="text" :disabled="heightOk" class="form-control" id="height" v-model="submittedForm.height" >
                                </div>

                                <div class="col-sm-2">
                                    <selectize id="uom" v-model="submittedForm.height_uom_id" :settings="height_uom_settings">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                    </selectize>    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="length" class="col-sm-2 control-label">Length</label>
                
                                <div class="col-sm-8">
                                    <input type="text" :disabled="lengthOk" class="form-control" id="lengths" v-model="submittedForm.lengths" >
                                </div>

                                <div class="col-sm-2">
                                    <selectize id="uom" v-model="submittedForm.length_uom_id" :settings="length_uom_settings">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                    </selectize>    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="width" class="col-sm-2 control-label">Width</label>
                
                                <div class="col-sm-8">
                                    <input type="text" :disabled="widthOk" class="form-control" id="width" v-model="submittedForm.width"  >
                                </div>

                                <div class="col-sm-2">
                                    <selectize id="uom" v-model="submittedForm.width_uom_id" :settings="width_uom_settings">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                    </selectize>    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">Type</label>
                                <div class="col-sm-10">
                                    <select v-model="submittedForm.type" class="form-control" name="type" id="type" required>
                                        <option value="3">Bulk part</option>
                                        <option value="2">Component</option>
                                        <option value="1">Consumable</option>
                                        <option value="0">Raw</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                
                                <div class="col-sm-10">
                                    <select v-model="submittedForm.status" class="form-control" name="status" id="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button :disabled="createOk" @click.prevent="submitForm" type="submit" class="btn btn-primary pull-right">CREATE</button>
                            </div>
                        </div>
                        @endverbatim
                    <!-- /.box-footer -->
                    </div>
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
    const form = document.querySelector('form#create-material');

    $(document).ready(function(){
        $("#code").inputmask();
        $('div.overlay').hide();
    });

    var data = {
        uoms : @json($uoms),
        submittedForm :{
            code : "",
            name : "",
            description : "",
            cost_standard_price : "",
            cost_standard_service : "",
            min : 0,
            max : 0,
            weight : 0,
            weight_uom_id : "",
            height :0,
            height_uom_id : "",
            lengths :0,
            length_uom_id : "",
            width :0,
            width_uom_id : "",
            status : 1,
            type : 1,
        },
        weight_uom_settings: {
            placeholder: 'Select weight UOM!'
        },
        height_uom_settings: {
            placeholder: 'Select height UOM!'
        },
        length_uom_settings: {
            placeholder: 'Select length UOM!'
        },
        width_uom_settings: {
            placeholder: 'Select width UOM!'
        },
    }

    var vm = new Vue({
        el : '#material',
        data: data,
        computed : {
            createOk :function(){
                let isOk = false;

                if(this.submittedForm.code == "" || this.submittedForm.name == "" || this.submittedForm.cost_standard_price == ""){
                    isOk = true;
                }
                return isOk;
            },
            weightOk :function(){
                let isOk = false;

                if(this.submittedForm.weight_uom_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            heightOk :function(){
                let isOk = false;

                if(this.submittedForm.height_uom_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            lengthOk :function(){
                let isOk = false;

                if(this.submittedForm.length_uom_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            widthOk :function(){
                let isOk = false;

                if(this.submittedForm.width_uom_id == ""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                $('div.overlay').show();
                this.submittedForm.cost_standard_price = this.submittedForm.cost_standard_price.replace(/,/g , '');
                this.submittedForm.cost_standard_service = this.submittedForm.cost_standard_service.replace(/,/g , '');
                this.submittedForm.min = (this.submittedForm.min+"").replace(/,/g , '');
                this.submittedForm.max = (this.submittedForm.max+"").replace(/,/g , '');

                if(this.submittedForm.min == ""){
                    this.submittedForm.min = 0;
                }else if(this.submittedForm.min != ""){
                    this.submittedForm.min = this.submittedForm.min;
                }

                if(this.submittedForm.max == ""){
                    this.submittedForm.max = 0;
                }else if(this.submittedForm.max != ""){
                    this.submittedForm.max = this.submittedForm.max;
                }

                
                this.submittedForm.weight = (this.submittedForm.weight+"").replace(/,/g , '');
                this.submittedForm.height = (this.submittedForm.height+"").replace(/,/g , '');
                this.submittedForm.lengths = (this.submittedForm.lengths+"").replace(/,/g , '');
                this.submittedForm.width = (this.submittedForm.width+"").replace(/,/g , '');
                this.submittedForm.volume = (this.submittedForm.volume+"").replace(/,/g , '');

                if(parseInt(this.submittedForm.max) < parseInt(this.submittedForm.min)){
                    iziToast.error({
                        title: 'max value cannot exceed min value !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }else{
                    let struturesElem = document.createElement('input');
                    struturesElem.setAttribute('type', 'hidden');
                    struturesElem.setAttribute('name', 'datas');
                    struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                    form.appendChild(struturesElem);
                    form.submit();
                }
            },
        },
        watch:{
            'submittedForm.cost_standard_service': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.cost_standard_service = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.cost_standard_service = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.cost_standard_service = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'submittedForm.weight': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 4;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.weight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.weight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.weight = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'submittedForm.height': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 4;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.height = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'submittedForm.lengths': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 4;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.lengths = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'submittedForm.width': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 4;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.width = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },

            'submittedForm.cost_standard_price': function(newValue) {
                if(newValue != ""){
                    
                    this.submittedForm.cost_standard_price = (this.submittedForm.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                }
            },

            'submittedForm.min': function(newValue) {
                if(newValue != ""){
                    
                    this.submittedForm.min = (this.submittedForm.min+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.submittedForm.max = (this.submittedForm.max+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    if(parseInt((this.submittedForm.max+"").replace(/,/g , '')) < parseInt((this.submittedForm.min+"").replace(/,/g , ''))){
                        iziToast.warning({
                            title: 'max value cannot exceed min value !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }
                }else{
                    this.submittedForm.max = 0;
                }
            },

            'submittedForm.max': function(newValue) {
                if(newValue != ""){

                    this.submittedForm.max = (this.submittedForm.max+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    if(parseInt((this.submittedForm.max+"").replace(/,/g , '')) < parseInt((this.submittedForm.min+"").replace(/,/g , ''))){
                        iziToast.warning({
                            title: 'max value cannot exceed min value !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }
                }else{
                    if(this.submittedForm.max != this.submittedForm.min){
                        iziToast.warning({
                            title: 'max value cannot exceed min value !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }
                }
            },
        },
    });
</script>

@endpush
