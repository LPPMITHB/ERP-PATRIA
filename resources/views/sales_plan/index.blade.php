@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Sales Plan',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Sales Plan' => route('sales_plan.index'),
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
                @if($route == '/sales_plan')
                    <form id="manage-sales-plan" class="form-horizontal" method="POST" action="{{ route('sales_plan.store') }}">
                @elseif($route == '/sales_plan_repair')
                    <form id="manage-sales-plan" class="form-horizontal" method="POST" action="{{ route('sales_plan_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="sales-plan">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4">
                                <label for="" >Year</label>
                                <selectize v-model="year" :settings="yearSettings">
                                    <option v-for="(year, index) in years" :value="year">{{ year }}</option>
                                </selectize>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table id="sales-plan-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Month</th>
                                            <th style="width: 23%">Ship</th>
                                            <th style="width: 38%">Cust</th>
                                            <th style="width: 15%">Value</th>
                                            <th style="width: 13%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(sales_plan,index) in sales_plans">
                                            <td>{{ sales_plan.month }}</td>
                                            <td class="tdEllipsis" data-container="body">{{ sales_plan.ship }}</td>
                                            <td class="tdEllipsis" data-container="body">{{ sales_plan.customer }}</td>
                                            <td class="tdEllipsis">Rp {{ (sales_plan.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a disabled v-if="parseInt(this_year) >= year && parseInt(this_month) > sales_plan.month" class="btn btn-primary btn-xs">
                                                    MANAGE
                                                </a>
                                                <a v-else-if="parseInt(this_year) <= parseInt(year) && parseInt(this_month) <= sales_plan.month" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openManageModal(sales_plan)">
                                                    MANAGE
                                                </a>
                                                <a v-else-if="parseInt(this_year) < parseInt(year)" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openManageModal(sales_plan)">
                                                    MANAGE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Manage Sales Plan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="manage_ship" class="control-label">Ships</label>
                                                <selectize id="manage_ship" v-model="sales_plan.ship_ids" :settings="shipSettings">
                                                    <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                                </selectize>
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="manage_customer" class="control-label">Customers</label>
                                                <selectize id="manage_customer" v-model="sales_plan.customer_ids" :settings="customerSettings">
                                                    <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.name }}</option>
                                                </selectize>
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="manage_value" class="control-label">Value</label>
                                                <input type="text" id="manage_value" v-model="sales_plan.value" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update()">SAVE</button>
                                    </div>
                                </div>
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
    const form = document.querySelector('form#manage-sales-plan');

    $(document).ready(function(){
        $('div.overlay').hide();
    });


    var data = {
        year : "",
        years : @json($years),
        this_month : @json($this_month),
        this_year : @json($this_year),
        user_id : @json($user_id),
        sales_plans : [],
        ships : @json($ships),
        customers : @json($customers),
        sales_plan : {
            id : "",
            ship_ids : [],
            customer_ids : [],
            value : "",
            month : "",
        },
        yearSettings : {
            placeholder : "Please select year",
        },
        shipSettings: {
            placeholder: 'Please Select Ships',
            maxItems : null,
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
        },
        customerSettings: {
            placeholder: 'Please Select Customers',
            maxItems : null,
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
        },
        submittedForm : {},
        data_init : @json($data_init),
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#sales-plan',
        data : data,
        mounted(){

        },
        computed : {
            updateOk: function(){
                let isOk = false;
                
                // var string_newValue = this.sales_plan.value+"";
                // string_newValue = parseFloat(string_newValue.replace(/,/g , ''));

                // if(this.sales_plan.ship_ids.length == 0 ||
                // this.sales_plan.customer_ids.length == 0 ||
                // string_newValue < 0 || 
                // string_newValue == 0 || 
                // string_newValue == "" || 
                // isNaN(string_newValue)){
                //     isOk = true;
                // }

                return isOk;
            },
        },
        methods : {
            tooltipText: function(text) {
                return text
            },
            update(){
                $('div.overlay').show();
                var temp_sales_plan = JSON.stringify(this.sales_plan);
                temp_sales_plan = JSON.parse(temp_sales_plan);
                temp_sales_plan.year = this.year;
                temp_sales_plan.value = (temp_sales_plan.value+"").replace(/,/g , '');

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(temp_sales_plan));
                form.appendChild(struturesElem);
                form.submit();
                
            },
            openManageModal(data,index){
                this.sales_plan.id = data.id;
                this.sales_plan.month = data.month;
                this.sales_plan.ship_ids = data.ship_ids;
                this.sales_plan.customer_ids = data.customer_ids;
                this.sales_plan.value = data.value;
            },
            
        },
        watch : {
            year : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSalesPlan/'+newValue).then(({ data }) => {
                        this.sales_plans = [];
                        this.sales_plans = data;
                        $('#sales-plan-table').DataTable().destroy();
                        this.$nextTick(function() {
                            $('#sales-plan-table').DataTable({
                                'paging'      : false,
                                'lengthChange': false,
                                'searching'   : false,
                                'ordering'    : false,
                                'info'        : true,
                                'autoWidth'   : false,
                                columnDefs : [
                                    { targets: 0, sortable: false},
                                ]
                            });
                        })
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    var data_init = this.data_init;
                    this.sales_plans = data_init;
                }
            },
            'sales_plan.value': function(newValue){
                if(newValue != ""){
                    this.sales_plan.value = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
        },
        created: function() {
            this.year = @json($this_year);
        },
    });
</script>
@endpush
