@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'View Post',
            'items' => [
                'View All Posts' => route('customer_portal.createPost',$post->project_id),
                'View Post' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box-header no-padding">
                        <div class="box-body">
                            <div class="col-md-12"><h4><b>{{$post->subject}}</b></h4></div>
                            <div class="col-md-12"><p>{{$post->body}}</p></div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>
                
                        <h3 class="box-title">Replies</h3>
                    </div>
                    <div class="slimScrollDiv" style="position: relative; width: auto; height: 250px;">
                        <div class="box-body chat" id="chat-box" style="width: auto; height: 250px;">
                            <!-- chat item -->
                            <div class="item">
                                <img src="dist/img/user4-128x128.jpg" alt="user image" class="online">
                
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                                        Mike Doe
                                    </a>
                                    I would like to meet you to discuss the latest news about
                                    the arrival of the new theme. They say it is going to be one the
                                    best themes on the market
                                </p>
                                <div class="attachment">
                                    <h4>Attachments:</h4>
                
                                    <p class="filename">
                                        Theme-thumbnail-image.jpg
                                    </p>
                
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
                                    </div>
                                </div>
                                <!-- /.attachment -->
                            </div>
                            <!-- /.item -->
                            <!-- chat item -->
                            <div class="item">
                                <img src="dist/img/user3-128x128.jpg" alt="user image" class="offline">
                
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                                        Alexander Pierce
                                    </a>
                                    I would like to meet you to discuss the latest news about
                                    the arrival of the new theme. They say it is going to be one the
                                    best themes on the market
                                </p>
                            </div>
                            <!-- /.item -->
                            <!-- chat item -->
                            <div class="item">
                                <img src="dist/img/user2-160x160.jpg" alt="user image" class="offline">
                
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                                        Susan Doe
                                    </a>
                                    I would like to meet you to discuss the latest news about
                                    the arrival of the new theme. They say it is going to be one the
                                    best themes on the market
                                </p>
                            </div>
                            <!-- /.item -->
                        </div>
                        <div class="slimScrollBar"
                            style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 66px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 184.911px;">
                        </div>
                        <div class="slimScrollRail"
                            style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                        </div>
                    </div>
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="input-group">
                            <input class="form-control" placeholder="Type message...">
                
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success"><i class="fa fa-send"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-paperclip"></i> Attachments
                                <input v-on:change="saveAttachment()" type="file" name="attachments" id="attachments" multiple>
                            </div>
                            <div class="form-group m-t-10">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div v-for="(file,index) in new_post.temp_uploaded" class="col-sm-6">
                                                <div style="padding: 5px; background-color: #f5f5f5;" class="alert">
                                                    {{-- {{file.name}} --}}
                                                    <button @click.prevent="deleteAttachment(index)" type="button" class="close">×</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function(){
            $('div.overlay').hide();
        });
    </script>
@endpush
