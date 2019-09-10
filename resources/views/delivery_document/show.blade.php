@extends('layouts.main')
@section('content-header')
    @if ($route == "/delivery_document")
        @breadcrumb(
            [
                'title' => 'View Delivery Document',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('delivery_document.selectProjectIndex'),
                    'View Delivery Document' => ""
                ]
            ]
        )
        @endbreadcrumb
    @elseif ($route == "/delivery_document_repair")
        @breadcrumb(
            [
                'title' => 'View Delivery Document',
                'items' => [
                    'Dashboard' => route('index'),
                    // 'Select Project' => route('delivery_document_repair.index'),
                    'View Delivery Document' => ""
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Progress</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->progress}} %</b></div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="add_delivery_document">
                <div class="box-body">
                    <table id="delivery-documents-table" class="table table-bordered tableFixed showTable" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th style="width: 5px">No</th>
                                <th style="width: 17%">Document Name</th>
                                <th style="width: 30%">File Name</th>
                                <th style="width: 8%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in delivery_documents">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.document_name }}</td>
                                <td v-if="data.file_name != null">
                                    <div class="iframe-popup">
                                        <a target="_blank" class="text-primary" :href="view(data.file_name)">{{ data.file_name }}</a>
                                    </div>
                                </td>
                                <td v-else>-</td>
                                <td>{{ data.status == 1 ? "NOT UPLOADED" : "UPLOADED" }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>

// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $('div.overlay').hide();
});

function loading(){
    $('div.overlay').show();
}

var data = {
    route : @json($route),
    project_id : @json($project->id),
    delivery_documents : [],
    newIndex : 1, 
    active_id : "",
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})


var vm = new Vue({
    el: '#add_delivery_document',
    data: data,
    mounted() {
        
    },
    computed:{
    }, 
    methods:{
        view(file_name){
            let path = '../../app/documents/delivery_documents/'+file_name;
            
            return path;
        },
        tooltipText: function(text) {
            return text
        },
        getDeliveryDocuments(){
            window.axios.get('/api/getDeliveryDocuments/'+this.project_id).then(({ data }) => {
                $('div.overlay').show();
                this.delivery_documents = data;
                this.newIndex = Object.keys(this.delivery_documents).length+1;
                $('#delivery-documents-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#delivery-documents-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                    });
                    $('.parent-container').magnificPopup({
                        delegate: 'a', // child items selector, by clicking on it popup will open
                        type: 'iframe'
                        // other options
                    });
                    $('div.overlay').hide();
                })
            });
        },
    },
    watch : {
    },
    created: function() {
        this.getDeliveryDocuments();
    },
    
});
</script>
@endpush