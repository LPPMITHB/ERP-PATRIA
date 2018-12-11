@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create RAP » '.$project->name.' » Select Bill of Materials',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.selectProject'),
            'Select Bill of Materials' => route('rap.create', ['id' => $project->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form id="create-rap" class="form-horizontal" method="POST" action="{{ route('rap.store') }}">
            @csrf
                @verbatim
                <div id="rap">
                    <div class="box-body">
                        <table class="table table-bordered" id="boms-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Code</th>
                                    <th width="45%">Description</th>
                                    <th width="25%">Work Name</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(bom,index) in modelBOMs">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ bom.code }}</td>
                                    <td>{{ bom.description}}</td>
                                    <td>{{ bom.work.name }}</td>
                                    <td class="no-padding p-t-2 p-b-2" align="center">
                                        <input type="checkbox" v-icheck="" v-model="checkedBoms" :value="bom.id">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                            </div>
                        </div>
                    </div> <!-- /.box-body -->
                </div>
                @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-rap');

    $(document).ready(function(){
        $('#boms-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        modelBOMs : @json($modelBOMs),
        checkedBoms : [],
        submittedForm : {
            checkedBoms : [],
            project : @json($project)
        }
    }

    var app = new Vue({
        el : '#rap',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;
                if(this.checkedBoms.length == 0){
                    isOk = true;
                }
                return isOk;
            },
        },
        directives: {
            icheck: {
                inserted: function(el, b, vnode) {
                    var vdirective = vnode.data.directives,
                    vModel;
                    for (var i = 0, vDirLength = vdirective.length; i < vDirLength; i++) {
                        if (vdirective[i].name == "model") {
                            vModel = vdirective[i].expression;
                            break;
                        }
                    }
                    jQuery(el).iCheck({
                        checkboxClass: "icheckbox_square-blue",
                        radioClass: "iradio_square-blue",
                        increaseArea: "20%" // optional
                    });
                    jQuery(el).on("ifChanged", function(e) {
                        if ($(el).attr("type") == "radio") {
                            app.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = app.$data[vModel];

                            $(el).prop("checked")
                            ? app.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
        methods: {
            submitForm(){
                var bom = this.checkedBoms;
                var jsonBom = JSON.stringify(bom);
                jsonBom = JSON.parse(jsonBom);
                this.submittedForm.checkedBoms = jsonBom;            

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
         
    });
</script>
@endpush
