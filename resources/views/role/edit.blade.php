@extends('layouts.main')
@section('content-header')
@breadcrumb(
[
'title' => 'Edit Role',
'items' => [
'Dashboard' => route('index'),
'View All Roles' => route('role.index'),
'Edit Role' => route('role.edit',$role->id),
]
]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="update-role" class="form-horizontal" method="POST"
                    action="{{ route('role.update',['id'=>$role->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    @csrf
                    @verbatim
                    <div id="role">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input v-model="role.name" type="text" class="form-control" id="name" name="name"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <input v-model="role.description" type="text" class="form-control" id="description"
                                        name="description" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="business_unit" class="col-sm-2 control-label">Business Unit</label>
                                <div class="col-sm-10">
                                    <selectize id="business_unit" v-model="business_unit"
                                        :settings="businessUnitSettings">
                                        <option v-for="main_menu in main_menus" :value="main_menu.id">
                                            {{ main_menu.name }}</option>
                                    </selectize>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div v-for="menu in menus">
                                <a href="" @click.prevent="getMenu(menu)">
                                    <div class="box box-solid no-margin m-b-10 ">
                                        <div class="box-header with-border" :id="menu.id">
                                            <div class="col-sm-10 tdEllipsis no-padding">
                                                <span>{{ menu.name }}</span>
                                            </div>
                                            <i class="fa fa-angle-double-right pull-right"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div v-for="menu in optionalMenus">
                                <a href="" @click.prevent="getMenu(menu)">
                                    <div class="box box-solid no-margin m-b-10 ">
                                        <div class="box-header with-border " :id="menu.id">
                                            <div class="col-sm-10 tdEllipsis no-padding">
                                                <span>{{ menu.name }}</span>
                                            </div>
                                            <i class="fa fa-angle-double-right pull-right"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <template v-for="sub_menu in sub_menus">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">{{ sub_menu.name }}</h3>
                                    </div>
                                    <div class="box-body">
                                        <template v-for="permission in permissionsLeft">
                                            <template v-if="permission.menu_id == sub_menu.id">
                                                <div class="col-md-6">
                                                    <div class="p-t-10 p-l-10"><input type="checkbox" v-icheck=""
                                                            v-model="checkedPermissions" :value="permission.middleware">
                                                        <span>{{ permission.name }}</span></div>
                                                </div>
                                            </template>
                                        </template>
                                        <template v-for="permission in permissionsRight">
                                            <template v-if="permission.menu_id == sub_menu.id">
                                                <div class="col-md-6">
                                                    <div class="p-t-10 p-l-10"><input type="checkbox" v-icheck=""
                                                            v-model="checkedPermissions" :value="permission.middleware">
                                                        <span>{{ permission.name }}</span></div>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row">
                            <div class="col-md-12 p-t-30">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right"
                                    :disabled="createOk">SAVE</button>
                            </div>
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
<script>
    const form = document.querySelector('form#update-role');

    $(document).ready(function(){
        $('div.overlay').hide();
        $('.alert').addClass('animated bounce');
        
    });

    var data = {
       menus : @json($menus),
       optionalMenus : [],
       main_menus : @json($mainMenu),
       role : @json($role),
       checkedPermissions : @json($checkedPermissions),
       menu_id : "",
       permissionsLeft : [],
       permissionsRight : [],
       sub_menus : [],
       submittedForm : {
           name : "",
           description : "",
           permissions : [],
           checkedPermissions : []
       },
       businessUnitSettings: {
            placeholder: 'Please Select Business Unit'
        },
       business_unit : "",
    }

    var app = new Vue({
        el : '#role',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;

                if(this.role.name == "" || this.role.description == "" || this.checkedPermissions.length < 1){
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
            getMenu(menu){
                if(this.menu_id != ""){
                    document.getElementById(this.menu_id).className = "box-header with-border";
                }
                this.sub_menus = [];
                this.menu_id = menu.id;
                document.getElementById(menu.id).className = "box-header with-border bg-aqua";

                this.getSubMenu(menu.id);
                this.getPermission(menu.id);
                if(this.sub_menus.length == 0){
                    this.sub_menus.push(menu);
                }
                
            },
            getPermission(id_menu){
                $('div.overlay').show();
                window.axios.get('/api/getPermission/'+id_menu).then(({ data }) => {
                    this.permissionsLeft = [];
                    this.permissionsRight = [];
                    for (var i = 0; i < data.length; i++) {
                        if(i % 2 === 0) { // index is even
                            this.permissionsLeft.push(data[i]);
                        }else{
                            this.permissionsRight.push(data[i]);
                        }
                    }
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            getSubMenu(id_menu){
                window.axios.get('/api/getSubMenu/'+id_menu).then(({ data }) => {
                    if(data.length > 0){
                        this.sub_menus = [];
                        this.sub_menus = data;
                    }
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            submitForm(){
                var permission = this.checkedPermissions;
                var jsonPermission = JSON.stringify(permission);
                jsonPermission = JSON.parse(jsonPermission);

                this.submittedForm.name = this.role.name;
                this.submittedForm.description = this.role.description;
                this.submittedForm.checkedPermissions = jsonPermission;

                for(var i in permission){
                    permission[i] = '"'+permission[i]+'":true';
                    this.submittedForm.permissions.push(permission[i]);
                }
                
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch:{
            'business_unit': function(newValue){
                window.axios.get('/api/getSubMenu/'+newValue).then(({ data }) => {
                    this.optionalMenus = [];
                    data.forEach(menu => {
                        this.optionalMenus.push(menu);
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            }
        }
    });
       
</script>
@endpush