@extends('layouts.main')

@section('content-header')
@if (Auth::user()->role_id != 3)
    @breadcrumb([
        'title' => 'View Post',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('customer_portal.selectProjectReply'),
            'View All Posts' => route('customer_portal.selectPost',$post->project_id),
            'View Post' => '',
        ]
    ])
@else
    @breadcrumb([
        'title' => 'View Post',
        'items' => [
        'Dashboard' => route('index'),
            'Select Project' => route('customer_portal.selectProjectPost'),
            'View All Posts' => route('customer_portal.createPost',$post->project_id),
            'View Post' => '',
        ]
    ])
@endif

@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box-header no-padding">
                        <div class="box-text">
                            <div class="col-md-12">
                                <h4><b>{{$post->subject}}</b></h4>
                            </div>
                            <div class="col-md-12">
                                <p>{{$post->body}}</p>
                            </div>
                            @if($post->file_name != null)
                            <div class="col-sm-8">
                                <div class="row">
                                    @foreach (json_decode($post->file_name) as $file)
                                    <div class="col-sm-6 iframe-popup">
                                        <a target="_blank"
                                            href="../../app/documents/posts/{{$post->id}}/{{$file}}">
                                            <div style="padding: 5px; background-color: #f5f5f5;" class="alert">
                                                {{$file}}
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="comments-vue">
                <div class="box-text p-t-0">
                    <div class="box">
                        <div class="box-header">
                            <i class="fa fa-posts-o"></i>
    
                            <h3 class="box-title">Replies</h3>
                        </div>
                        <div class="box-body">
                            <div style="overflow-y: scroll; height:400px;" class="box-text chat" id="chat-box">
                                <div v-for="(comment, index) in comments" >
                                    <div v-if="user_id != comment.user.id" class="item m-t-20 row">
                                        <p class="col-sm-12 m-l-0 text-left">
                                            <b>{{comment.user.name}}</b>
                                        </p>
                                        <p class="message col-sm-12 m-t-5 m-l-0">
                                            {{comment.text}}
                                        </p>
                                        <div v-if="comment.file_name != null" class="col-sm-9 attachment m-l-20 pull-left">
                                            <h4>Attachments:</h4>
                                        
                                            <div class="col-sm-12p p-l-10">
                                                <div class="row">
                                                    <div v-for="(file, index) in JSON.parse(comment.file_name)" class="col-sm-6 iframe-popup p-l-0">
                                                        <a target="_blank" :href="view(comment,file)">
                                                            <div style="padding: 5px; background-color: #f5f5f5;" class="alert">
                                                                {{file}}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <b class="col-sm-12 pull-left">
                                            <small class="text-muted pull-left"><i class="fa fa-clock-o"></i> {{comment.time}}</small>
                                        </b>
                                        <!-- /.attachment -->
                                    </div>
                                    <div class="item m-t-20 row" v-else>
                                        <p class="col-sm-12 m-l-0 text-right">
                                            <b>{{comment.user.name}}</b>
                                        </p>
                                        <p class="message col-sm-12 m-t-5 m-l-0 text-right">
                                            {{comment.text}}
                                        </p>
                                        <div v-if="comment.file_name != null" class="col-sm-9 attachment m-l-20 pull-right">
                                            <h4>Attachments:</h4>
        
                                            <div class="col-sm-12p p-l-10">
                                                <div class="row">
                                                    <div v-for="(file, index) in JSON.parse(comment.file_name)" class="col-sm-6 iframe-popup p-l-0">
                                                        <a target="_blank" :href="view(comment,file)">
                                                            <div style="padding: 5px; background-color: #f5f5f5;" class="alert">
                                                                {{file}}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <b class="col-sm-12 pull-right">
                                            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{comment.time}}</small>
                                        </b>
                                        <!-- /.attachment -->
                                    </div>
                                </div>
                                <!-- /.item -->                               
                            </div>
                        </div>
                        <!-- /.chat -->
                        <div class="box-footer">
                            <div class="input-group">
                                <input class="form-control" v-model="new_comment.text" placeholder="Type message...">
                                <div class="input-group-btn" style="overflow: hidden">
                                    <button type="button" @click.prevent="submitComment()" id="send_button" class="btn btn-success send_button"><i class="fa fa-send"></i></button>
                                </div>
                            </div>
                            <div class="form-group m-t-10">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Attachments
                                    <input v-on:change="saveAttachment()" type="file" name="attachments" id="attachments"
                                        multiple>
                                </div>
                                <div class="form-group m-t-10">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div v-for="(file,index) in new_comment.temp_uploaded" class="col-sm-6">
                                                    <div style="padding: 5px; background-color: #f5f5f5;" class="alert">
                                                        {{file.name}}
                                                        <button @click.prevent="deleteAttachment(index)" type="button"
                                                            class="close">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.box-text -->
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('div.overlay').hide();
    });

    var data = {
        comments: [],
        new_comment: {
            temp_uploaded: [],
            text: "",
        },
        post: @json($post),
        user_id: @json($user_id),
    };

    Vue.directive('tooltip', function (el, binding) {
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'
        })
    })


    var vm = new Vue({
        el: '#comments-vue',
        data: data,
        mounted() {},
        computed: {
        },
        methods: {
            view(comment,file_name){
                let path = '../../app/documents/comments/'+comment.id+'/'+file_name;
                
                return path;
            },
            getComments() {
                window.axios.get('/api/getComments/'+ this.post.id).then(({data
                }) => {
                    $('div.overlay').show();
                    this.comments = data;
                    this.comments.forEach(comment => {
                        comment.time = moment(comment.created_at).format("DD-MM-YYYY HH:mm:ss");
                        // comment.files = JSON.parse(comment.file_name);
                    });
                    this.newIndex = Object.keys(this.comments).length + 1;
                    $('#comments-table').DataTable().destroy();
                    this.$nextTick(function () {
                        $('#comments-table').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': true,
                            'ordering': false,
                            'info': true,
                            'autoWidth': false,
                            'initComplete': function(){
                            },
                        });
                        $('div.overlay').hide();
                        var objDiv = document.getElementById("chat-box");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    })
                });
            },
            getCommentsEmit() {
                window.axios.get('/api/getComments/'+ this.post.id).then(({data
                }) => {
                    $('div.overlay').show();
                    this.comments = data;
                    this.comments.forEach(comment => {
                        comment.time = moment(comment.created_at).format("DD-MM-YYYY HH:mm:ss");
                        // comment.files = JSON.parse(comment.file_name);
                    });
                    this.newIndex = Object.keys(this.comments).length + 1;
                    $('#comments-table').DataTable().destroy();
                    this.$nextTick(function () {
                        $('#comments-table').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': true,
                            'ordering': false,
                            'info': true,
                            'autoWidth': false,
                            'initComplete': function(){
                            },
                        });
                        $('div.overlay').hide();
                        var objDiv = document.getElementById("chat-box");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    })
                });
            },
            saveAttachment() {
                var temp_files = document.getElementById('attachments').files;
                for (let i = 0; i < temp_files.length; i++) {
                    const element = temp_files[i];
                    this.new_comment.temp_uploaded.push(element);
                }
            },
            deleteAttachment(index) {
                this.new_comment.temp_uploaded.splice(index, 1);
            },
            submitComment() {
                let formData = new
                FormData();
                this.new_comment.temp_uploaded.forEach(function (file, index) {
                    formData.append('files[' + index + ']',file);
                });
                formData.append('text', this.new_comment.text);
                formData.append('post_id', this.post.id);
                $('div.overlay').show();
                var url = "{{ route('customer_portal.storeComment') }}";
                window.axios.post(url, formData).then((response) => {
                    if (response.data.error != undefined) {
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();
                    } else {
                        // iziToast.success({
                        //     displayMode: 'replace',
                        //     title: response.data.response,
                        //     position: 'topRight',
                        // });
                        this.getComments();
                        this.new_comment.temp_uploaded = [];
                        this.new_comment.text = "";
                    }

                })
                .catch((error) => {
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
        },
        watch: {
            'new_comment.text' : function(newValue){
                if(newValue != ""){
                    document.getElementById("send_button").style.right = "0px";
                }else{
                    document.getElementById("send_button").style.right = "40px";
                }
            }
        },
        created: function () {
            this.getComments();
        },
    });

</script>
@endpush
