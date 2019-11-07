@extends('layouts.main')
@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Manage WBS Images',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('wbs.selectProject'),
                    'Manage WBS Images' => ""
                ]
            ]
        )
        @endbreadcrumb
    @else
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
            <div id="add_wbs_images">
                <div class="box-body">
                    <table id="wbs-images-table" class="table table-bordered tableFixed" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 17%">WBS</th>
                                <th style="width: 30%">File Name</th>
                                <th style="width: 26%">Description</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs_images">
                                <td>{{ index + 1 }}</td>
                                <td v-if="data.wbs_id != null">{{ data.wbs.number}} - {{ data.wbs.description}}</td>
                                <td v-else>-</td>
                                <td v-if="data.drawing != null">
                                    <a target="_blank" class="text-primary" :href="view(data.drawing)">{{ data.drawing }}</a>
                                </td>
                                <td v-else>-</td>
                                <td>{{ data.description }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs_images">
                                        EDIT
                                    </a>    
                                    <a class="btn btn-danger btn-xs" @click="deleteDeliveryDocument(data)">
                                        DELETE
                                    </a>    
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <selectize class="selectizeFull" id="wbs" v-model="newWbsImages.wbs_id" :settings="wbsSettings">
                                        <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0">
                                    <div class="input-group width100">
                                        <label class="input-group-btn" style="width : 1%">
                                            <span class="btn btn-primary">
                                                Upload File&hellip; <input type="file" style="display: none;" id="add_document">
                                            </span>
                                        </label>
                                        <input id="file_name_readonly" type="text" class="form-control" readonly>
                                    </div>
                                </td>
                                <td>
                                    <textarea v-model="newWbsImages.description" class="form-control width100" rows="2" name="description"
                                        placeholder="Description"></textarea>
                                </td>
                                <td align="center">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal fade" id="edit_wbs_images">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Wbs Images</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="wbs" class="control-label">WBS</label>
                                            <selectize class="selectizeFull" id="wbs" v-model="editWbsImages.wbs_id" :settings="wbsSettings">
                                                <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                            </selectize>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="upload" class="control-label">File</label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary">
                                                        Upload File&hellip; <input type="file" style="display: none;" id="edit_document">
                                                    </span>
                                                </label>
                                                <input id="edit_file_name_read_only" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" v-model="editWbsImages.description"></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="upload" class="control-label">Preview Last Uploaded File</label>
                                            <div class="input-group">
                                                <div v-if="editWbsImages.drawing != null" class="iframe-popup">
                                                    <a target="_blank" class="text-primary"
                                                        :href="view(editWbsImages.drawing)">{{ editWbsImages.drawing }}</a>
                                                </div>
                                                <div v-else>
                                                    No file uploaded
                                                </div>
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
    if(input.get(0).id == "add_document"){
        vm.newWbsImages.file = input.get(0).files[0];
    }else{
        vm.editWbsImages.file = input.get(0).files[0];
    }
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
    menu : @json($menu),
    wbs_images : [],
    wbss : @json($wbss),
    newIndex : 1, 
    newWbsImages : {
        wbs_id : "",
        description : "",
        project_id : @json($project->id),
        file : null,
    },
    editWbsImages : {
        id : "",
        wbs_id : "",
        description : "",
        project_id : @json($project->id),
        file : null,
    },
    active_id : "",
    wbsSettings: {
        placeholder: 'Please Select WBS(Optional)'
    },
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})


var vm = new Vue({
    el: '#add_wbs_images',
    data: data,
    mounted() {
        
    },
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newWbsImages.file == null)
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbsImages.drawing == "")
                {
                    isOk = true;
                }
            return isOk;
        },
    }, 
    methods:{
        view(drawing){
            let path = '../../app/documents/wbs_images/'+drawing;
            
            return path;
        },
        tooltipText: function(text) {
            return text
        },
        openEditModal(data){
            this.editWbsImages.id = data.id;
            this.editWbsImages.wbs_id = data.wbs_id;
            this.editWbsImages.description = data.description;
            this.editWbsImages.drawing = data.drawing;
            
            var file_name_readonly = document.getElementById("edit_file_name_read_only");
            file_name_readonly.value = data.drawing;
        },
        getWbsImages(){
            window.axios.get('/api/getWbsImages/'+this.newWbsImages.project_id).then(({ data }) => {
                $('div.overlay').show();
                this.wbs_images = data;
                this.newIndex = Object.keys(this.wbs_images).length+1;
                $('#wbs-images-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-images-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
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
        add(){            
            var newWbsImages = this.newWbsImages;
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('wbs.storeWBSImages') }}";
            }else{
            }
            let data = new FormData();
            data.append('file', document.getElementById('add_document').files[0]);
            data.append('description', this.newWbsImages.description );
            data.append('project_id', this.newWbsImages.project_id );
            data.append('wbs_id', this.newWbsImages.wbs_id );
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
                
                this.getWbsImages();
                this.newWbsImages.wbs_id = "";
                this.newWbsImages.description = "";
                var file_name_readonly = document.getElementById("file_name_readonly");
                file_name_readonly.value = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })
        },
        update(){            
            var editWbsImages = this.editWbsImages;
            var url = "";
            if(this.menu == "building"){
                url = "/wbs/"+this.editWbsImages.id;
            }else{
            }
            let data = new FormData();
            data.append('file', document.getElementById('edit_document').files[0]);
            data.append('description', this.editWbsImages.description );
            data.append('project_id', this.editWbsImages.project_id );
            data.append('wbs_id', this.editWbsImages.wbs_id );
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
                
                this.getWbsImages();
                this.editWbsImages.wbs_id = "";
                this.editWbsImages.description = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })
        },
        deleteDeliveryDocument(data){
            var menu = this.menu;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this Wbs Image?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "";
                        if(menu == "building"){
                            url = "/wbs/deleteImages/"+data.id;
                        }else{
                        }
                        $('div.overlay').show();            
                        window.axios.delete(url)
                        .then((response) => {
                            if(response.data.error != undefined){
                                response.data.error.forEach(error => {
                                    iziToast.warning({
                                        displayMode: 'replace',
                                        title: error,
                                        position: 'topRight',
                                    });
                                });
                                $('div.overlay').hide();
                            }else{
                                iziToast.success({
                                    displayMode: 'replace',
                                    title: response.data.response,
                                    position: 'topRight',
                                });
                                vm.getWbsImages();
                            }
                        })
                        .catch((error) => {
                            iziToast.warning({
                                displayMode: 'replace',
                                title: "Please try again.. ",
                                position: 'topRight',
                            });
                            console.log(error);
                            $('div.overlay').hide();            
                        })
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
        this.getWbsImages();
    },
    
});
</script>
@endpush