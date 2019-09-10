@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Material',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            $material->description => route('material.show',$material->id),
            'Edit Material' => route('material.edit',$material->id),
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
                <form id="edit-material" class="form-horizontal" method="POST" action="{{ route('material.update',['id'=>$material->id]) }}">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="box-body">

                    @verbatim
                        <div id="material">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Item Number *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" data-inputmask="'mask': '99-aaa-*****-aa'" id="code" name="code" required autofocus v-model="submittedForm.code" @keyup="submittedForm.code  = this.event.target.value;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" required autofocus v-model="submittedForm.description">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price Material(Rp) *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cost_standard_price" required v-model="submittedForm.cost_standard_price">
                                </div>
                            </div>

                            <div class="form-group" v-if="true">
                                <label for="standard_price_config" class="col-sm-2 control-label">Cost Standard Price Type*</label>
                                <div class="col-sm-10">
                                    <selectize name="standard_price_config" id="standard_price_config" v-model="submittedForm.standard_price_config" :settings="standard_price_config_settings">
                                        <option v-for="(standard_price_config, index) in standard_prices_config" :value="standard_price_config.id">{{ standard_price_config.value | capitalize  }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group" v-if="submittedForm.standard_price_config == 4">
                                <label for="standard_price_config_range_id" class="col-sm-2 control-label">Range*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="standard_price_config_range_id" name="standard_price_config_range" required v-model="submittedForm.standard_price_config_range">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cost_standard_service" class="col-sm-2 control-label">Cost Standard Price Service (Rp) *</label>

                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" id="cost_standard_service" required v-model="submittedForm.cost_standard_service">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uom" class="col-sm-2 control-label">Unit Of Measurement *</label>
                                
                                <div class="col-sm-10">
                                    <selectize id="uom" v-model="submittedForm.uom_id" :settings="uom_settings">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="family_id" class="col-sm-2 control-label">Material Family</label>
                                <div class="col-sm-10">
                                    <selectize id="family_id" name="family_id" v-model="submittedForm.family_id" :settings="family_id_settings">
                                        <option v-for="(data, index) in material_families" :value="data.id">{{ data.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="density_id" class="col-sm-2 control-label">Density Type</label>
                                <div class="col-sm-10">
                                    <selectize id="density_id" name="density_id" v-model="submittedForm.density_id" :settings="density_id_settings">
                                        <option v-for="(data, index) in densities" :value="data.id">{{ data.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max" class="col-sm-2 control-label">Max</label>
                                
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" id="max" required v-model="submittedForm.max" :settings="max_settings">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="min" class="col-sm-2 control-label">Min</label>
                                
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" id="min" required v-model="submittedForm.min" :settings="min_settings">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dimension_type" class="col-sm-2 control-label">Dimension Type</label>
                                <div class="col-sm-10">
                                    <selectize id="dimension_type" name="dimension_type" v-model="submittedForm.dimension_type_id" :settings="dimension_type_settings">
                                        <option v-for="(data, index) in dimension_types" :value="data.id">{{ data.name }}</option>
                                    </selectize>   
                                </div>
                            </div>

                            <template v-for="dimension in selectedDimensionType">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">{{dimension.name}}</label>
                    
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="weight" v-model="dimension.value">
                                    </div>
    
                                    <div class="col-sm-2">
                                        <selectize disabled id="uom" v-model="dimension.uom_id" :settings="weight_uom_settings">
                                            <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                        </selectize>    
                                    </div>
                                </div>
                            </template>

                            
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">Material Type *</label>
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
                                    <label for="upload" class="col-sm-2 control-label">Upload Image</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    Browse&hellip; <input type="file" style="display: none;" multiple id="image" name="image">
                                                </span>
                                            </label>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status *</label>

                                    <div class="col-sm-10">
                                        <select v-model="submittedForm.status" class="form-control" name="status" id="status" required>
                                            <option value="1">Active</option>
                                            <option value="0">Non Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" v-if="is_pami">
                                    <label for="status" class="col-sm-2 control-label">Location Detail</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="location_detail" name="location_detail" required v-model="submittedForm.location_detail">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button :disabled="createOk" @click.prevent="submitForm" type="submit" class="btn btn-primary pull-right">SAVE</button>
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
    const form = document.querySelector('form#edit-material');

    $(document).ready(function(){
        $('div.overlay').hide();
    });
    Vue.filter('capitalize', function(value) {
            if (!value) return ''
            value = value.toString()
            return value.charAt(0).toUpperCase() + value.slice(1)
        });

    var data = {
        uoms : @json($uoms),
        is_pami : @json($is_pami),
        material_families : @json($material_families),
        densities : @json($densities),
        standard_prices_config: @json($standard_prices_config),
        submittedForm :{
            code : @json($material->code),
            description : @json($material->description),
            cost_standard_price : @json($material->cost_standard_price),
            cost_standard_service : @json($material->cost_standard_price_service),
            uom_id : @json($material->uom_id),
            min : @json($material->min),
            max : @json($material->max),
            dimension_uom_id : @json($material->dimension_uom_id),
            weight : @json($material->weight),
            weight_uom_id : @json($material->weight_uom_id),
            height :@json($material->height),
            height_uom_id : @json($material->dimension_uom_id),
            lengths :@json($material->length),
            length_uom_id : @json($material->dimension_uom_id),
            width :@json($material->width),
            width_uom_id : @json($material->dimension_uom_id),
            status : @json($material->status),
            type : @json($material->type),
            family_id : @json($dataFamily),
            density_id : @json($material->density_id),
            dimension_type_id : @json($material->dimension_type_id),
            location_detail : @json($material->location_detail),
            standard_price_config:@json($materialStandardPriceConfigID),
            standard_price_config_range: @json($materialStandardPriceConfigRange),
        },
        dimension_types : @json($dimension_types),
        selectedDimensionType : JSON.parse(@json($material->dimensions_value)),
        uom_settings: {
            placeholder: 'Select UOM!'
        },
        min_settings: {
            placeholder: '0'
        },
        max_settings: {
            placeholder: '0'
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
        family_id_settings: {
            placeholder: 'Select Material Family!',
            maxItems: null,
            plugins: ['remove_button'],
        },
        density_id_settings: {
            placeholder: 'Select Density!'
        },
        dimension_type_settings: {
            placeholder: 'Select Dimension Type!',
        },
        standard_price_config_settings: {
                placeholder: 'Select Standard Price'
            },
    }

    var vm = new Vue({
        el : '#material',
        data: data,
        computed : {
            createOk :function(){
                let isOk = false;

                if(this.submittedForm.code == "" || this.submittedForm.description == "" || this.submittedForm.uom_id == ""){
                    isOk = true;
                }
                if(this.is_pami && (this.submittedForm.location_detail == ""  || this.submittedForm.standard_price_config == "")){
                    isOk = true;
                }

                if(this.submittedForm.weight_uom_id != ""){
                    if(this.submittedForm.weight == ""){
                        isOk = true;
                    }
                }

                if(this.submittedForm.height_uom_id != ""){
                    if(this.submittedForm.height == "" || this.submittedForm.density_id == ""){
                        isOk = true;
                    }
                }

                if(this.submittedForm.length_uom_id != ""){
                    if(this.submittedForm.lengths == "" || this.submittedForm.density_id == ""){
                        isOk = true;
                    }
                }

                if(this.submittedForm.width_uom_id != ""){
                    if(this.submittedForm.width == "" || this.submittedForm.density_id == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
            weightOk :function(){
                let isOk = false;

                if(this.submittedForm.weight_uom_id == "" ||
                this.submittedForm.weight_uom_id == null
                ){
                    isOk = true;
                }
                return isOk;
            },
            heightOk :function(){
                let isOk = false;

                if(this.submittedForm.height_uom_id == "" ||
                this.submittedForm.height_uom_id == null
                ){
                    isOk = true;
                }
                return isOk;
            },
            lengthOk :function(){
                let isOk = false;

                if(this.submittedForm.length_uom_id == "" ||
                this.submittedForm.length_uom_id == null
                ){
                    isOk = true;
                }
                return isOk;
            },
            widthOk :function(){
                let isOk = false;

                if(this.submittedForm.width_uom_id == "" ||
                this.submittedForm.width_uom_id == null
                ){
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
                this.selectedDimensionType.forEach(dimension => {
                    dimension.value = (dimension.value+"").replace(/,/g , '');
                });
                this.submittedForm.selectedDimensionType = this.selectedDimensionType;
                this.submittedForm.standard_price_config = (this.submittedForm.standard_price_config + "").replace(/,/g, '');
                this.submittedForm.standard_price_config_range = (this.submittedForm.standard_price_config_range + "").replace(/,/g, '');
                this.submittedForm.weight = this.submittedForm.weight.replace(/,/g , '');
                this.submittedForm.height = this.submittedForm.height.replace(/,/g , '');
                this.submittedForm.lengths = this.submittedForm.lengths.replace(/,/g , '');
                this.submittedForm.width = this.submittedForm.width.replace(/,/g , '');
                this.submittedForm.volume = this.submittedForm.volume.replace(/,/g , '');

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
            calculateVolume(){
                this.submittedForm.volume = parseInt(this.submittedForm.height.replace(/,/g , '')) * parseInt(this.submittedForm.lengths.replace(/,/g , '')) * parseInt(this.submittedForm.width.replace(/,/g , ''));

                var volume = this.submittedForm.volume;
                this.submittedForm.volume = (volume+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        watch:{
            'submittedForm.cost_standard_price': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.submittedForm.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.submittedForm.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.submittedForm.cost_standard_price = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
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

                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
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

                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
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

                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
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

            'submittedForm.length_uom_id' : function(newValue) {
                if(newValue != ""){
                    this.submittedForm.width_uom_id = newValue;
                    this.submittedForm.height_uom_id = newValue;
                    this.submittedForm.dimension_uom_id = newValue;

                }
            },

            'submittedForm.width_uom_id' : function(newValue) {
                if(newValue != ""){
                    this.submittedForm.length_uom_id = newValue;
                    this.submittedForm.height_uom_id = newValue;
                    this.submittedForm.dimension_uom_id = newValue;

                }
            },

            'submittedForm.height_uom_id' : function(newValue) {
                if(newValue != ""){
                    this.submittedForm.length_uom_id = newValue;
                    this.submittedForm.width_uom_id = newValue;
                    this.submittedForm.dimension_uom_id = newValue;

                }
            },
            'submittedForm.dimension_type_id' : function(newValue) {
                if(newValue != ""){
                    this.dimension_types.forEach(data => {
                        if(data.id == newValue){
                            this.selectedDimensionType = data.dimensions;
                        }
                    });
                }else{
                    this.selectedDimensionType = [];
                }
            },
            selectedDimensionType:{
                handler: function(newValue) {
                    newValue.forEach(dimension => {
                        var uom_data = null;
                        this.uoms.forEach(uom => {
                            if(uom.id == dimension.uom_id){
                                uom_data = uom;
                            }
                        });
                        var is_decimal = uom_data.is_decimal;
                        if(is_decimal == 0){
                            dimension.value = (dimension.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        }else{
                            var decimal = dimension.value.replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    dimension.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    dimension.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                dimension.value = (dimension.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    });
                },
                deep: true
            },
        },
        created: function() {
            var maxDecimalDimension = 2;
            var maxDecimalCost = 2;

            this.submittedForm.min = (this.submittedForm.min+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            this.submittedForm.max = (this.submittedForm.max+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")

            var decimal = (this.submittedForm.cost_standard_price+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalCost){
                    this.submittedForm.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalCost).replace(/\D/g, "");
                }else{
                    this.submittedForm.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.cost_standard_price = (this.submittedForm.cost_standard_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            decimal = (this.submittedForm.cost_standard_service+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalCost){
                    this.submittedForm.cost_standard_service = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalCost).replace(/\D/g, "");
                }else{
                    this.submittedForm.cost_standard_service = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.cost_standard_service = (this.submittedForm.cost_standard_service+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            decimal = (this.submittedForm.weight+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalDimension){
                    this.submittedForm.weight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalDimension).replace(/\D/g, "");
                }else{
                    this.submittedForm.weight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.weight = (this.submittedForm.weight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            decimal = (this.submittedForm.height+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalDimension){
                    this.submittedForm.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalDimension).replace(/\D/g, "");
                }else{
                    this.submittedForm.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.height = (this.submittedForm.height+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            decimal = (this.submittedForm.lengths+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalDimension){
                    this.submittedForm.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalDimension).replace(/\D/g, "");
                }else{
                    this.submittedForm.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.lengths = (this.submittedForm.lengths+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            decimal = (this.submittedForm.width+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                if((decimal[1]+"").length > maxDecimalDimension){
                    this.submittedForm.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimalDimension).replace(/\D/g, "");
                }else{
                    this.submittedForm.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.submittedForm.width = (this.submittedForm.width+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

        },
    });
</script>

@endpush
