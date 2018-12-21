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
                                <input type="text" class="form-control" id="code" name="code" required autofocus disabled v-model="submittedForm.code">
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
                            <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price (Rp.)</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cost_standard_price" required v-model="submittedForm.cost_standard_price">
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
                                <button @click.prevent="submitForm" type="submit" class="btn btn-primary pull-right">SAVE</button>
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
        
        submittedForm :{
            code : @json($material->code),
            name : @json($material->name),
            description : @json($material->description),
            cost_standard_price : @json($material->cost_standard_price),
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
                this.submittedForm.cost_standard_price = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'submittedForm.weight': function(newValue) {
                this.submittedForm.weight = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'submittedForm.height': function(newValue) {
                this.submittedForm.height = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
                }
            },
            'submittedForm.lengths': function(newValue) {
                this.submittedForm.lengths = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
                }
            },
            'submittedForm.width': function(newValue) {
                this.submittedForm.width = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                    this.submittedForm.volume = 0;
                }else{
                    this.calculateVolume();
                }
            },
        },
        created: function() {
            this.submittedForm.cost_standard_price = (this.submittedForm.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.submittedForm.weight = (this.submittedForm.weight+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.submittedForm.height = (this.submittedForm.height+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.submittedForm.lengths = (this.submittedForm.lengths+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.submittedForm.width = (this.submittedForm.width+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.submittedForm.volume = (this.submittedForm.volume+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
</script>

@endpush
