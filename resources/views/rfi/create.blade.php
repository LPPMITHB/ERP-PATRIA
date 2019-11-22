@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'Create RFI',
    'items' => [
        'Dashboard' => route('index'),
        'Select Project' => route('rfi.selectProject'),
        'Select QC Task' => route('rfi.selectQcTask', $project->id),
        "Create RFI"=> "",
    ]
])
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="box">
            <div class="box-body">
                <div class="box-tools pull-right">
                    <a href="{{ route('qc_task.edit',['id'=>$qcTask->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4 col-md-12">    
                        <div class="col-sm-12 no-padding"><b>Quality Control Task Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$qcTask->description}}"><b>: {{$qcTask->description}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Status</div>
                        @if ($qcTask->status == 1)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: NOT DONE</b></div>
                        @elseif($qcTask->status == 0)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: DONE</b></div>
                        @endif

                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        @php
                        $date = DateTime::createFromFormat('Y-m-d', $qcTask->start_date);
                        $date = $date->format('d-m-Y');
                        @endphp
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$date}}"><b>: {{$date}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        @php
                        $date = DateTime::createFromFormat('Y-m-d', $qcTask->end_date);
                        $date = $date->format('d-m-Y');
                        @endphp
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$date}}"><b>: {{$date}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">External Join</div>
                        @if ($qcTask->external_join == 1)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: Yes</b></div>
                        @elseif($qcTask->external_join == 0)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: No</b></div>
                        @endif
                    </div>

                    <div class="col-xs-12 col-lg-4 col-md-12">    
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->number}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Deliverable</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
                                if($wbs->planned_start_date != null){
                                    $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_start_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                }else{
                                    echo "-";
                                }
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
                                if($wbs->planned_end_date != null){
                                    $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_end_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                }else{
                                    echo "-";
                                }
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-body">
                @verbatim
                <div id="create_rfi">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#create_rfi_tab" data-toggle="tab" aria-expanded="true">Create RFI</a></li>
                            <li class=""><a href="#qc_task_details" data-toggle="tab" aria-expanded="false">QC Task Details</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="create_rfi_tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <template v-if="emailTemplates.length > 0">
                                            <label for="">Email Template</label>
                                            <selectize v-model="email_template_id" :settings="emailTemplateSetting">
                                                <option v-for="(email_template, index) in emailTemplates" :value="email_template.id">{{ qc_type.name }}
                                                </option>
                                            </selectize>
                                        </template>

                                        <template v-else>
                                            <label for="">Email Template</label>
                                            <selectize v-model="email_template_id" disabled :settings="emailTemplateEmptySetting">
                                            </selectize>
                                        </template>
                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-6">
                                        <label for="code" class="control-label">From</label>
                                        <input type="text" class="form-control" id="code" name="code" v-model="input.from" placeholder="From">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="code" class="control-label">To</label>
                                        <input type="text" class="form-control" id="code" name="code" v-model="input.to" placeholder="To">
                                    </div>
                                    <div class="col-sm-12 p-t-10">
                                        <label for="code" class="control-label">Subject</label>
                                        <input type="text" class="form-control" id="code" name="code" v-model="input.subject" placeholder="Subject">
                                    </div>
                                    <div class="col-md-12 p-t-20">
                                        <textarea class="form-control" id="email-editor" name="email-editor" rows='10'></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="qc_task_details">
                                <table id="qctd-table" class="table table-bordered showTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 35%">Name</th>
                                            <th style="width: 45%">Description</th>
                                            <th style="width: 15%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in qcTaskDetail">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ data.name }}</td>
                                            <td class="tdEllipsis">{{ data.description }}</td>
                                            <td class="tdEllipsis" v-if="data.status == null">NOT DONE</td>
                                            <td class="tdEllipsis" v-else>{{data.status}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
                @endverbatim
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        $('div.overlay').hide();

        var editor = CKEDITOR.replace( 'email-editor' ,{
            language: 'en',
            removeButtons : "",
            toolbar : null,
        });
        $('div.overlay').hide();

        editor.on( 'change', function( evt ) {
            vm.input.body = evt.editor.getData();
        });
    });
    var data = {
        qcTaskDetail: @json($qcTask->qualityControlTaskDetails),
        emailTemplates : @json($emailTemplates),
        email_template_id : "",
        emailTemplateSetting:{
            placeholder: 'Email Templates',
        },
        emailTemplateEmptySetting:{
            placeholder: 'There are no Email Templates',
        },
        input:{
            from : "",
            to : "",
            subject: "",
            body : "",
        }
    };

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })
    
    var vm = new Vue({
        el: '#create_rfi',
        data: data,
        methods: {
            tooltipText: function(text) {
                return text
            },
            createRouteEdit(id) {
                var url = "/qc_task/" + id + "/edit";
                return url;
            },
        }
    });
    $(document).ready(function() {
        $('#qctd-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'bFilter': true,
            'initComplete': function() {
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush