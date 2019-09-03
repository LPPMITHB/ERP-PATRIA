@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Customer Call / Visit',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Customer Visit' => route('yard.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    @if($route = "customer_visit")
        <form id="create-customer-visit" class="form-horizontal" method="POST" action="{{ route('customer_visit.store') }}">
            @csrf
        </form>
    @elseif($route = "customer_visit_repair")
        <form id="create-customer-visit" class="form-horizontal" method="POST" action="{{ route('customer_visit_repair.store') }}">
            @csrf
        </form>
    @endif

    <form id="edit-customer-visit" class="form-horizontal" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
    </form>
    
    <form id="delete-customer-visit" class="form-horizontal" method="POST">
        @csrf
        <input type="hidden" name="_method" value="DELETE" />
    </form>

    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header m-b-10">
                    <div class="box-tools pull-right p-t-5">
                        <a href="{{ route('yard.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <div id="calendar">
        
                </div>
            </div> <!-- /.box-body -->
            @verbatim
            <div id="customer_visit">
                <div class="modal fade" id="create_customer_visit">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Create Customer Call / Visit (<b>{{customer_visit.planned_date}}</b>)</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label">Type</label>
                                        <selectize id="type" v-model="customer_visit.type" :settings="typeSettings">
                                            <option value="Visit">Visit</option>
                                            <option value="Call">Call</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="customer" class="control-label">Customer</label>
                                        <selectize id="customer" v-model="customer_visit.customer_id" :settings="customerSettings">
                                            <option v-for="(customer, index) in modelCustomer" :value="customer.id">{{ customer.code }} - {{ customer.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="note" class="control-label">Notes</label>
                                        <textarea v-model="customer_visit.note" class="form-control" rows="3" name="note"></textarea>                                        
                                    </div>
                                </div>                                
                            </div>

                            <div class="modal-footer">
                                <button :disabled="createOk" @click="submitForm" type="button" class="btn btn-primary" data-dismiss="modal">CREATE</button>
                            </div>    
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="edit_customer_visit">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Edit Customer Call / Visit (<b>{{edit_customer_visit.planned_date}}</b>)</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label">Type</label>
                                        <selectize id="type" v-model="edit_customer_visit.type" :settings="typeSettings">
                                            <option value="Visit">Visit</option>
                                            <option value="Call">Call</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="customer" class="control-label">Customer</label>
                                        <selectize id="customer" v-model="edit_customer_visit.customer_id" :settings="customerSettings">
                                            <option v-for="(customer, index) in modelCustomer" :value="customer.id">{{ customer.code }} - {{ customer.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="note" class="control-label">Notes</label>
                                        <textarea v-model="edit_customer_visit.note" class="form-control" rows="3" name="note"></textarea>                                        
                                    </div>
                                </div> 

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="report" class="control-label">Report</label>
                                        <textarea v-model="edit_customer_visit.report" class="form-control" rows="3" name="report"></textarea>                                        
                                    </div>
                                </div> 
                                
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger pull-left" type="button" @click="deleteCustomerVisit(edit_customer_visit)" data-toggle="modal">
                                    DELETE
                                </button>
                                <button :disabled="editOk" @click="submitFormEdit()" type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                            </div>    
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
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
    const formCreate = document.querySelector('form#create-customer-visit');
    const formEdit = document.querySelector('form#edit-customer-visit');
    const formDelete = document.querySelector('form#delete-customer-visit');
    var customer_visit = {!!$customerVisits!!};

    var data = {
        route : @json($route),
        modelCustomer : @json($modelCustomer),
        customer_visit :{
            planned_date : "",
            type : "",
            customer_id : "", 
            note : "",
        },
        edit_customer_visit :{
            id: "",
            planned_date : "",
            type : "",
            customer_id : "", 
            note : "",
            report : "",
        },
        customerSettings: {
            placeholder: 'Please select Customer!',
        },
        typeSettings: {
            placeholder: 'Please select Type!',
        },
    }

    var vm = new Vue({
        el : '#customer_visit',
        data : data,
        mounted() {
        },
        computed : {
            createOk: function(){
                let isOk = false;
                    if(this.customer_visit.planned_date == ""
                    || this.customer_visit.type == ""
                    || this.customer_visit.customer_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            editOk: function(){
                let isOk = false;
                    if(this.edit_customer_visit.planned_date == ""
                    || this.edit_customer_visit.type == ""
                    || this.edit_customer_visit.customer_id == ""
                    || this.edit_customer_visit.note == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.customer_visit));
                formCreate.appendChild(struturesElem);
                formCreate.submit();
            },
            submitFormEdit(){
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.edit_customer_visit));
                formEdit.appendChild(struturesElem);
                formEdit.submit();
            },
            deleteCustomerVisit(data){
                var menuTemp = this.menu;
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this Customer Call / Visit?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "/"+vm.route+"/"+data.id;
                            
                            $('div.overlay').show();            
                            document.getElementById("delete-customer-visit").action = "/"+vm.route+"/"+data.id;
                            formDelete.submit();

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
    });

    var events = [];
    for(var i =0; i < customer_visit.length; i++) 
    {
        events.push( 
            {
                id : customer_visit[i].id,
                title: customer_visit[i].type+" - "+customer_visit[i].customer.name, 
                start: customer_visit[i].planned_date,
                end: customer_visit[i].planned_date,
                type : customer_visit[i].type,
                customer_id : customer_visit[i].customer_id,
                note : customer_visit[i].note,
                report : customer_visit[i].report,
                clickable : true,
                textColor : 'white',
            }
        )
    }

    $(document).ready(function(){ 
        $('div.overlay').hide();    
        $('#calendar').fullCalendar({
            events : events,
            eventRender: function(eventObj, $el) {
                $($el).css("font-weight", "bold");
                $el.tooltip({
                    title: eventObj.title,
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body',
                });
            },
            aspectRatio:  2,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            //Set day biar bisa diklik
            dayClick: function(date, jsEvent, view, resourceObj) {
                vm.customer_visit.type = "";
                vm.customer_visit.customer_id = "";
                vm.customer_visit.planned_date = "";
                vm.customer_visit.note = "";
                $('#create_customer_visit').modal('show');
                vm.customer_visit.planned_date = date.format('DD-MM-YYYY');
            },
            eventClick: function (calEvent, jsEvent, view) {
                if(calEvent.clickable == true){
                    $('#edit_customer_visit').modal('show');
                    vm.edit_customer_visit.id = calEvent.id;
                    vm.edit_customer_visit.type = calEvent.type;
                    vm.edit_customer_visit.customer_id = calEvent.customer_id;
                    vm.edit_customer_visit.planned_date = calEvent.planned_date;
                    vm.edit_customer_visit.note = calEvent.note;
                    vm.edit_customer_visit.report = calEvent.report;
                    
                    vm.edit_customer_visit.description = calEvent.description;
                    document.getElementById("edit-customer-visit").action = "/"+vm.route+"/"+calEvent.id;
                }
            },
        }); 
        function eventRenderCallback(event, element, view){
            var title = element.find(".fc-title").val();
            element.find(".fc-title").html("<b>"+title+"</b>");
        }   
    });

</script>
@endpush
