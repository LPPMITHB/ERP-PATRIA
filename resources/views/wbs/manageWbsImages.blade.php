@extends('layouts.main')
@section('content-header')
    @if($menu == "building")
        @breadcrumb(
            [
                'title' => 'Manage WBS Images',
                'items' => [
                    'Dashboard' => route('index'),
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
                <div class="box-title"></div>
            </div>
            <div class="box-body" id="image-table">
                <a class="btn btn-primary btn-sm col-sm-12" data-toggle="modal" href="#add-image">UPLOAD DRAWING</a>
                @verbatim
                <table id="wbs-images-table" class="table-bordered tableFixed" style="border-collapse:collapse">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">Image</th>
                            <th style="width:35%">Name</th>
                            <th style="width:10%">Project</th>
                            <th style="width:15%">WBS</th>
                            <th style="width:15%"></th>
                        </tr>
                    </thead>
                    <tbody v-for="(image, index) in images">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td><img style="display:block;" width="100%" :src="getSrc(image)"></td>
                            <td class="tdBreakWord" data-container="body">{{ image.drawing }}</td>
                            <td class="tdBreakWord" data-containter="body">{{image.wbs.project.name}}</td>
                            <td class="tdBreakWord" data-container="body"><a :href="getWbsLink(image.wbs_id)" target="_blank"><b>{{ image.wbs.number }}</b> {{ image.wbs.description }}</a></td>
                            <td><div class="parent-container"><a class="btn btn-primary btn-sm col-sm-6" :href="getSrc(image)">VIEW</a></div><a class="btn btn-danger btn-sm col-sm-6" @click="deleteWbsImage(image)">DELETE</a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <!-- button at footer -->
                    </tfoot>
                </table>
                @endverbatim
            </div>
            <div class="modal fade" id="add-image">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title">Add WBS Drawing</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <label for="upload" class="col-sm-12 control-label">Upload Drawing</label>
                                <div class="form-group col-sm-12">
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse&hellip; <input type="file" style="display: none;" multiple id="image" name="image">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <label for="description" class="col-sm-12 control-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="img_desc" v-model="editWbs.img_desc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">UPLOAD</button>
                        </div>
                    </div>
                </div>
            </div>
            @if ($menu == "building")
                <form id="uploadImage" class="form-horizontal" method="POST" action="{{ route('wbs.updateWithForm',['id'=>$wbs->id]) }}" enctype="multipart/form-data">
            @elseif ($menu == "repair")
                <form id="uploadImage" class="form-horizontal" method="POST" action="{{ route('wbs_repair.updateWithForm',['id'=>$wbs->id]) }}" enctype="multipart/form-data">
            @else
            @endif
                @csrf
                <input type="hidden" name="_method" value="PATCH">
            </form>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
const form = document.querySelector('form#uploadImage');
$(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).ready(function(){
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

var data = {
    images : @json($images),
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'
    })
})

var vm = new Vue({
    el: '#image-table',
    data: data,
    mounted() {
        $('.parent-container').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image'
            // other options
        });
    },
    methods:{
        tooltipText: function(text) {
            return text
        },
        getSrc(image){
            let path = '../../app/documents/wbs_images/'+image.drawing;
            return path;
        },
        getWbsLink(id){
            return "/wbs/show/" + id;
        },
        getAllImages(){
            window.axios.get('/api/getAllImages').then(({ data }) => {
                $('div.overlay').show();
                this.images = data;
                $('#wbs-images-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-images-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                    });
                    $('div.overlay').hide();
                })
            });
        },
        deleteWbsImage(image){
            var route = this.route;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this image?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "/wbs/deleteWbsImage/"+image.id;
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
                                $('div.overlay').show();
                                iziToast.success({
                                    displayMode: 'replace',
                                    title: response.data.response,
                                    position: 'topRight',
                                });
                                vm.getAllImages();
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
        }
    },
    update(){
        let imageElem = document.getElementById('image');
        form.appendChild(imageElem);
        form.submit();
    },
    created: function(){
        this.getAllImages();
    }
});
</script>
@endpush
