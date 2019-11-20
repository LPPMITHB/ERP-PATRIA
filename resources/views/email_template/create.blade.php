@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Create Email Template',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                'Email Template' => route('email_template.index'),
                'Create Email Template' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                <form id="create-email-template" class="form-horizontal" method="POST" action="{{ route('email_template.store') }}">
                    @csrf
                    @verbatim
                    <div id="emailTemplate">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-xs-12 no-padding"><b>Email Template Name</b></div>
                                <div class="col-xs-12 no-padding">
                                    <input class="form-control" placeholder="Please Input Email Template Name" type="text" v-model="input.name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="col-xs-12 no-padding"><b>Email Template Description</b></div>
                                <div class="col-xs-12 no-padding">
                                    <textarea class="form-control" placeholder="Please Input Email Template Description" rows="3" v-model="input.description"></textarea>
                                </div>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor" rows='10'></textarea>
                        </div>
                        <div class="col-md-12 p-t-5">
                            <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right"
                                :disabled="createOk">CREATE</button>
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
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    const form = document.querySelector('form#create-email-template');
    $(document).ready(function() {
        var editor = CKEDITOR.replace( 'summary-ckeditor' ,{
            language: 'en',
            removeButtons : "",
            toolbar : null,
        });
        $('div.overlay').hide();

        editor.on( 'change', function( evt ) {
            app.input.template = evt.editor.getData();
        });
    });

    var data = {
        sumbitedForm: {
            name: '',
            description: '',
            template: '',
        },
        input: {
            name: '',
            description: '',
            template: '',
        },
    }

    var app = new Vue({
        el: '#emailTemplate',
        data: data,
        methods: {
            clearData(){
                this.input.name = "";
                this.input.description = "";
                this.forms.template = "";
            },
            submitForm() {
                $('div.overlay').show();
                this.sumbitedForm.name = this.input.name;
                this.sumbitedForm.description = this.input.description;
                this.sumbitedForm.template = this.input.template;
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.sumbitedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            
        },
        computed: {
            createOk: function() {
                let isOk = false;
                if (this.input.name == "" || this.input.template == "") {
                    isOk = true;
                }
                return isOk;
            },
        },
    });
</script>
@endpush