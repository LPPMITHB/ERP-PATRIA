@extends('layouts.main')
@section('content-header')
    @if ($route == "/close_project")
        @breadcrumb(
            [
                'title' => 'Project Closing',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('close_project.selectProject'),
                    'Project Closing' => ""
                ]
            ]
        )
        @endbreadcrumb
    @elseif ($route == "/close_project_repair")
        @breadcrumb(
            [
                'title' => 'Project Closing',
                'items' => [
                    'Dashboard' => route('index'),
                    // 'Select Project' => route('close_project_repair.index'),
                    'Project Closing' => ""
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
                        <div class="col-md-7 col-xs-8 no-padding"><b>: <a target="_blank" class="text-primary" href="{{$route == '/close_project' ? '/project' : '/project_repair' }}/{{$project->id}}">{{$project->number}}</a></b></div>
                        
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
            <div id="add_close_project">
                <div class="box-body">
                    <h4 class="box-title">List of Documents</h4>
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
                    <button :disabled="closeOk" class="btn btn-primary btn-md col-sm-12"  @click="closeProject()">CLOSE PROJECT</button>
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <form id="close_project" class="form-horizontal" method="POST" action="{{ route('close_project.close', $project->id) }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
const form = document.querySelector('form#close_project');
// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $('div.overlay').hide();
});

function loading(){
    $('div.overlay').show();
}

var data = {
    route : @json($route),
    project : @json($project),
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
    el: '#add_close_project',
    data: data,
    mounted() {
        
    },
    computed:{
        closeOk: function(){
            let isOkDeliveryDocuments = false;
            let isOkProgress = false;
                this.delivery_documents.forEach(delivery_document => {
                    if(delivery_document.status == 1){
                        isOkDeliveryDocuments = true;
                    }
                });

                if(this.project.progress < 100){
                    isOkProgress = true;
                }
            return isOkDeliveryDocuments || isOkProgress;
        },
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
        closeProject(){
            $('div.overlay').show();
            form.submit();
        }
    },
    watch : {
    },
    created: function() {
        this.getDeliveryDocuments();
    },
    
});
</script>
@endpush