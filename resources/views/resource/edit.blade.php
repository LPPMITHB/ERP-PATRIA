@extends('layouts.main')
@section('content-header')
@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'Edit Resource',
            'subtitle' => 'Edit',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource.index'),
                'Edit Resource' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'Edit Resource',
            'subtitle' => 'Edit',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource_repair.index'),
                'Edit Resource' => '',
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
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.update',['id'=>$resource->id]) }}">
                @elseif($route == "/resource_repair")
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource_repair.update',['id'=>$resource->id]) }}">
                @endif
                @csrf
                <input type="hidden" name="_method" value="PATCH"> 
                @verbatim
                    <div id="resource">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  required v-model="dataInput.code" disabled>
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
                                    <input type="text" class="form-control" id="description" name="description" v-model="dataInput.description">
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">SAVE</button>
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
    const form = document.querySelector('form#resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        resource : @json($resource),
        submittedForm:{},
        dataInput : {
            code : @json($resource->code),
            name : @json($resource->name),
            description : @json($resource->description),
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

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                form.submit();
            }
        },
    });
</script>
@endpush
