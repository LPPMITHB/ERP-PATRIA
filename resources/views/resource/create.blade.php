@extends('layouts.main')
@section('content-header')
@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'Create Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource.index'),
                'Create Resource' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'Create Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource_repair.index'),
                'Create Resource' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif

@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                    @if($route == "/resource")
                        <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.store') }}">
                    @elseif($route == "/resource_repair")
                        <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource_repair.store') }}">
                    @endif
                @csrf
                @verbatim
                    <div id="resource">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  required v-model="resource_code" disabled>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required autofocus v-model="dataInput.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" v-model="dataInput.description">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cost_standard_price" v-model="dataInput.cost_standard_price">
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">CREATE</button>
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
    const form = document.querySelector('form#resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        resource : @json($resource),
        resource_code : @json($resource_code),
        dataInput : {
            code : @json($resource_code),
            name : "",
            description : "",
            cost_standard_price : ""
        }
    }

    var vm = new Vue({
        el : '#resource',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == ""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                $('div.overlay').show();

                this.dataInput.cost_standard_price = (this.dataInput.cost_standard_price+"").replace(/,/g , '');

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                form.submit();
            }
        },
        watch: {
            'dataInput.cost_standard_price': function(newValue) {
                if(newValue != ""){
                    this.dataInput.cost_standard_price = (this.dataInput.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        }
    });
</script>
@endpush
