@extends('layouts.main')
@section('content-header')
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
                                <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price (<b>{{submittedForm.currency}}</b>)</label>
                                
                                <div class="col-sm-2">
                                    <selectize id="currency" v-model="submittedForm.currency">
                                        <option v-for="(currency, index) in currencies" :value="currency.unit">{{ currency.name }}</option>
                                    </selectize>    
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" :disabled="costOk" class="form-control" id="cost_standard_price" required v-model="submittedForm.cost_standard_price">
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label">Weight (Kg)</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="weight" v-model="submittedForm.weight">
                            </div>
                        </div>
                        
                            <div class="form-group">
                                <label for="height" class="col-sm-2 control-label">Height (M)</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="height" v-model="submittedForm.height" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="length" class="col-sm-2 control-label">Length (M)</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lengths" v-model="submittedForm.lengths" >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="width" class="col-sm-2 control-label">Width (M)</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="width" v-model="submittedForm.width"  >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="volume" class="col-sm-2 control-label">Volume (M<sup>3</sup>)</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="volume" v-model="submittedForm.volume" disabled>
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
                            <div class="box-footer p-r-0">
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

    var data = {
        currencies : @json($currencies),
        submittedForm :{
            code : @json($material->code),
            name : @json($material->name),
            description : @json($material->description),
            cost_standard_price : @json($material->cost_standard_price),
            currency: @json($material->currency),
            weight : @json($material->weight),
            height :@json($material->height),
            lengths :@json($material->length),
            width :@json($material->width),
            volume :@json($material->volume),
            status : @json($material->status),
            type : @json($material->type),
        }
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
            costOk :function(){
                let isOk = false;

                if(this.submittedForm.currency == ""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                $('div.overlay').show();
                this.submittedForm.cost_standard_price = this.submittedForm.cost_standard_price.replace(/,/g , '');
                this.submittedForm.weight = this.submittedForm.weight.replace(/,/g , '');
                this.submittedForm.height = this.submittedForm.height.replace(/,/g , '');
                this.submittedForm.lengths = this.submittedForm.lengths.replace(/,/g , '');
                this.submittedForm.width = this.submittedForm.width.replace(/,/g , '');
                this.submittedForm.volume = this.submittedForm.volume.replace(/,/g , '');

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
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
        },
        created: function() {
            var maxDecimalDimension = 4;
            var maxDecimalCost = 2;
            
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
        }
    });
</script>

@endpush
