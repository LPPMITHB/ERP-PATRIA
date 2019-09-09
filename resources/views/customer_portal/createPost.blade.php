@extends('layouts.main')

@section('content-header')
@breadcrumb([
  'title' => 'Post Complaints » '.$project->name,
  'items' => [
    'Dashboard' => route('index'),
    'Select Project' => route('customer_portal.selectProjectPost'),
    'Post Complaints' => "",
  ]
])
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    @verbatim
    <div id="posts-vue">
        <div class="col-md-2 m-b-10 pull-right">
            <a v-show="index_post" @click="create_post_event()" class="btn btn-primary btn-block">CREATE NEW POST</a>
            <a v-show="create_post" @click="index_post_event()" class="btn btn-primary btn-block">BACK TO POSTS</a>
        </div>

        <div v-show="index_post" class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Posts</h3>

                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages" style="margin-top:-35px">
                        <table id="posts-table" class="table table-hover table-striped tableFixed">
                            <thead style="display:none;">
                                <tr>
                                    <th>Subject</th>
                                    <th>Attachment</th>
                                    <th></th>
                                    <th>mailbox-date</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in posts">
                                    <td style="width: 55%" class="tdEllipsis" class="mailbox-subject">
                                        <b>{{data.subject}}</b> - {{data.body}}
                                    </td>
                                    <td style="width: 10%" class="mailbox-attachment text-center"
                                        v-if="data.file_name != null"><i class="fa fa-paperclip"></i></td>
                                    <td style="width: 10%" class="mailbox-attachment" v-else></td>
                                    <td>
                                      <span v-if="data.new_comment" class="pull-right-container">
                                        <small class="label bg-green">{{data.new_comment_qty}} new comment(s)</small>
                                      </span>
                                    </td>
                                    <td style="width: 20%" class="mailbox-date text-center">{{data.time_since}}</td>
                                    <td style="width: 10%" class="mailbox-action text-center">
                                        <a class="btn btn-primary btn-xs" :href="showPost(data.id)">VIEW</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">

                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->

        <div v-show="create_post" class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Post</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <input v-model="new_post.subject" class="form-control" placeholder="Subject:">
                    </div>
                    <div class="form-group">
                        <textarea id="compose-textarea" v-model="new_post.body" class="form-control"
                            style="height: 300px;" placeholder="Body:"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachments
                            <input v-on:change="saveAttachment()" type="file" name="attachments" id="attachments"
                                multiple>
                        </div>
                        <div class="form-group m-t-10">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div v-for="(file,index) in new_post.temp_uploaded" class="col-sm-6">
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
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button :disabled="createOk" @click.prevent="submitPost()" class="btn btn-primary"><i
                                class="fa fa-envelope-o"></i> CREATE</button>
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    @endverbatim
</div>
@endsection

@push('script')
<script>
    $('div.overlay').hide();

    var data = {
        posts: [],
        new_post: {
            temp_uploaded: [],
            subject: "",
            body: "",
        },
        project: @json($project),
        index_post: true,
        create_post: false,
    };

    Vue.directive('tooltip', function (el, binding) {
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'
        })
    })


    var vm = new Vue({
        el: '#posts-vue',
        data: data,
        mounted() {},
        computed: {
            createOk: function () {
                let isOk = false;
                if (this.new_post.subject == "") {
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            showPost(id) {
                return "/customer_portal/showPost/" + id;
            },
            getPosts() {
                window.axios.get('/api/getPosts/' + this.project.id).then(({
                    data
                }) => {
                    $('div.overlay').show();
                    this.posts = data;
                    this.posts.forEach(post => {
                        post.time_since = moment(post.created_at, "YYYY-MM-DD hh:mm:ss")
                            .fromNow();
                    });
                    this.newIndex = Object.keys(this.posts).length + 1;
                    $('#posts-table').DataTable().destroy();
                    this.$nextTick(function () {
                        $('#posts-table').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': true,
                            'ordering': false,
                            'info': true,
                            'autoWidth': false,
                        });
                        $('div.overlay').hide();
                        this.index_post_event();
                    })
                });
            },
            saveAttachment() {
                var temp_files = document.getElementById('attachments').files;
                for (let i = 0; i < temp_files.length; i++) {
                    const element = temp_files[i];
                    this.new_post.temp_uploaded.push(element);
                }
            },
            deleteAttachment(index) {
                this.new_post.temp_uploaded.splice(index, 1);
            },
            submitPost() {
                let formData = new FormData();

                this.new_post.temp_uploaded.forEach(function (file, index) {
                    formData.append('files[' + index + ']', file);
                });
                formData.append('subject', this.new_post.subject);
                formData.append('body', this.new_post.body);
                formData.append('project_id', this.project.id);

                $('div.overlay').show();
                var url = "{{ route('customer_portal.storePost') }}";
                window.axios.post(url, formData)
                    .then((response) => {
                        if (response.data.error != undefined) {
                            iziToast.warning({
                                displayMode: 'replace',
                                title: response.data.error,
                                position: 'topRight',
                            });
                            $('div.overlay').hide();
                        } else {
                            iziToast.success({
                                displayMode: 'replace',
                                title: response.data.response,
                                position: 'topRight',
                            });
                            this.getPosts();
                            this.new_post.temp_uploaded = [];
                            this.new_post.subject = "";
                            this.new_post.body = "";
                        }

                    })
                    .catch((error) => {
                        console.log(error);
                        $('div.overlay').hide();
                    })
            },
            index_post_event() {
                this.index_post = true;
                this.create_post = false;
            },
            create_post_event() {
                this.create_post = true;
                this.index_post = false;
            }
        },
        watch: {},
        created: function () {
            this.getPosts();
        },
    });
</script>
@endpush