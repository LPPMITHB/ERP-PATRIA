@extends('layouts.main')
@section('content-header')
    @if ($route == "/delivery_document")
        @breadcrumb(
            [
                'title' => 'Manage List  Document',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('project.index'),
                    'Manage List     Document' => ""
                ]
            ]
        )
        @endbreadcrumb
    @elseif ($route == "/delivery_document_repair")
        @breadcrumb(
            [
                'title' => 'Manage List  Document',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('project_repair.index'),
                    'Manage List     Document' => ""
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
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->progress}}</b></div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="add_delivery_document">
                <div class="box-body">
                    <table id="delivery-documents-table" class="table table-bordered tableFixed" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th style="width: 5px">No</th>
                                <th style="width: 17%">Document Name</th>
                                <th style="width: 30%">File Name</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in delivery_documents">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.document_name }}</td>
                                <td v-if="data.file_name != ''">
                                    <div class="parent-container">
                                        <a class="text-primary" :href="view(data)">{{ data.file_name }}</a>
                                    </div>
                                </td>
                                <td v-else></td>
                                <td>{{ data.status == 1 ? "NOT UPLOADED" : "UPLOADED" }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>    
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        DELETE
                                    </a>    
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <textarea v-model="newDeliveryDocument.document_name" class="form-control width100" rows="2" name="create_document_name" placeholder="Document Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <div class="input-group width100">
                                        <label class="input-group-btn" style="width : 1%">
                                            <span class="btn btn-primary">
                                                Upload File&hellip; <input type="file" style="display: none;" id="add_document">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </td>
                                <td>NOT UPLOADED</td>
                                <td align="center">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal fade" id="edit_delivery_document">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Delivery Documents <b id="delivery_documents_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="number" class="control-label">Number</label>
                                            <input id="number" type="text" class="form-control" v-model="editDeliveryDocument.number" placeholder="Insert Number here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="upload" class="col-sm-2 control-label">Upload Drawing</label>
                                            <div class="col-sm-5">
                                                {{-- <form method="POST" enctype="multipart/form-data"> --}}
                                                    <div class="input-group">
                                                        <label class="input-group-btn">
                                                            <span class="btn btn-primary">
                                                                Browse&hellip; <input type="file" style="display: none;" multiple id="edit_document" name="document">
                                                            </span>
                                                        </label>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                {{-- </form> --}}
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
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
$(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    // document.getElementById('document').files.push(input.get(0).files[0]);
    // console.log(document.getElementById('document').files);
    vm.newDeliveryDocument.file = input.get(0).files[0];
});

// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $('div.overlay').hide();

    $(':file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
    });
});

function loading(){
    $('div.overlay').show();
}

var data = {
    route : @json($route),
    delivery_documents : [],
    newIndex : 1, 
    newDeliveryDocument : {
        document_name : "",
        project_id : @json($project->id),
        file : null,
    },
    editDeliveryDocument : {
        document_name : "",
        project_id : @json($project->id),
        file : null,
    },
    maxWeight : 0,
    totalWeight : 0,
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
        createOk: function(){
            let isOk = false;
                if(this.newDeliveryDocument.document_name == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editDeliveryDocument.document_name == "")
                {
                    isOk = true;
                }
            return isOk;
        },
    }, 
    methods:{
        view(data){
            let path = '../../app/documents/delivery_documents/'+data.file_name;
            
            return path;
        },
        tooltipText: function(text) {
            return text
        },
        openEditModal(data){
        },
        getDeliveryDocuments(){
            window.axios.get('/api/getDeliveryDocuments/'+this.newDeliveryDocument.project_id).then(({ data }) => {
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
                        type: 'image'
                        // other options
                    });
                    $('div.overlay').hide();
                })
            });
        },
        add(){            
            var newDeliveryDocument = this.newDeliveryDocument;
            var url = "";
            if(this.route == "/delivery_document"){
                url = "{{ route('delivery_document.store') }}";
            }else{
            }
            let data = new FormData();
            data.append('file', document.getElementById('add_document').files[0]);
            data.append('document_name', this.newDeliveryDocument.document_name );
            data.append('project_id', this.newDeliveryDocument.project_id );
            $('div.overlay').show();            
            window.axios.post(url,data)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                }
                
                this.getDeliveryDocuments();
                this.newDeliveryDocument.document_name = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })
        },
        update(){            

        },
        deleteDeliveryDocument(data){
            var menuTemp = this.menu;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this WBS?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ],
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