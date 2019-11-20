@extends('layouts.main')
@section('content-header')
    @breadcrumb([
        'title' => 'Show Email Template',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Email Template' => route('email_template.index'),
            'Show Email Template' => '',
        ]
    ])
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                    <div class="box-header p-b-0">
                        <div class="box-tools pull-right p-t-5">
                        
                            @can('edit-email-template')
                            <a href="{{ route('email_template.edit',['id'=>$email_template->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                            @endcan
                        
                        </div>
                        @verbatim
                        <div id="emailTemplate">
                            <div class="col-xs-12 col-lg-4 col-md-12">
                                <div class="col-sm-12 no-padding"><b>Email Template Information</b></div>
                        
                                <div class="col-md-4 col-xs-6 no-padding">Name</div>
                                <div class="col-md-8 col-xs-6 no-padding"><b>: {{email_template.name}}</b></div>
                        
                                <div class="col-md-4 col-xs-6 no-padding">Description</div>
                                <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" v-tooltip:top="tooltipText(email_template.description)"><b>: {{email_template.description}}</b></div>
                            </div>
                        </div>
                        @endverbatim

                    </div> <!-- /.box-header -->
                    <div class="col-md-12 p-t-20">
                        <textarea class="form-control" id="template_editor" name="template_editor"
                            rows='10'></textarea>
                    </div>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function() {
        var template = @json($email_template->template);
        var editor = CKEDITOR.replace( 'template_editor' ,{
            language: 'en',
            removeButtons : "",
            toolbar : null,
            readOnly : true,
        });
        editor.setData(template);
        $('div.overlay').hide();
    });
    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        newIndex: 1,
        email_template : @json($email_template),
        input: {
            name: '',
            description: '',
            template: '',
        },
    }

    var app = new Vue({
        el: '#emailTemplate',
        data: data,
        mounted() {
        },
        methods: {
            tooltipText: function(text) {
                return text
            },
        },
        computed: {
        },
    });
</script>
@endpush