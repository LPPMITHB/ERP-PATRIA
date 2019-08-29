@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Material Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Material Requisition' => route('sales_plan.index'),
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
                @if($route == 'sales_plan')
                    <form id="create-sales-plan" class="form-horizontal" method="POST" action="{{ route('sales_plan.store') }}">
                @elseif($route == 'sales_plan_repair')
                    <form id="create-sales-plan" class="form-horizontal" method="POST" action="{{ route('sales_plan_repair.store') }}">
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
                                <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
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
                                            <td class="tdEllipsis">{{ sales_plan.ship }}</td>
                                            <td class="tdEllipsis">{{ sales_plan.customer }}</td>
                                            <td class="tdEllipsis">{{ sales_plan.value }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
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
    const form = document.querySelector('form#create-sales-plan');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        year : "",
        years : @json($years),
        user_id : @json($user_id),
        sales_plans : [],
        yearSettings : {
            placeholder : "Please select year",
        },
        submittedForm : {},
        data_init : @json($data_init),
    }
    var vm = new Vue({
        el : '#sales-plan',
        data : data,
        mounted(){

        },
        computed : {
            updateOk: function(){
            },
        },
        methods : {
            tooltip(text){
                Vue.directive('tooltip', function(el, binding){
                    $(el).tooltip('destroy');
                    $(el).tooltip({
                        title: text,
                        placement: binding.arg,
                        trigger: 'hover'
                    })
                })
                return text
            },
            submitForm(){
                // $('div.overlay').show();
                // this.submittedForm.description = this.description;
                // this.submittedForm.delivery_date = this.delivery_date;
                // this.submittedForm.project_id = this.project_id;
                // this.submittedForm.materials = this.dataMaterial;

                // let struturesElem = document.createElement('input');
                // struturesElem.setAttribute('type', 'hidden');
                // struturesElem.setAttribute('name', 'datas');
                // struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                // form.appendChild(struturesElem);
                // form.submit();
            },
            update(old_material_id, new_material_id){
                $('div.overlay').show();
                $('div.overlay').hide();
                
            },
            openEditModal(data,index){

            },
            
        },
        watch : {
            year : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSalesPlan/'+newValue).then(({ data }) => {
                        this.sales_plans = [];
                        this.sales_plans = data;
                        
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
            'dataInput.quantity': function(newValue){
                if(newValue != ""){
                    var temp = parseFloat((newValue+"").replace(",", ""));
                    this.dataInput.quantityFloat = temp;

                    if(this.dataInput.is_decimal){
                        var decimal = (newValue+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            this.dataInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }else{
                        this.dataInput.quantity = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                }
            },
            'dataInput.quantityFloat' : function(newValue){
                var qty = "";
                var temp = newValue;
                if(temp > this.dataInput.available){
                    iziToast.warning({
                        title: 'There is no available stock for this material',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    qty = this.dataInput.available;
                }else{
                    qty = temp;
                }
                this.dataInput.quantity = qty+"";
            },
        },
        created: function() {
            this.year = @json($this_year);
            this.sales_plans = @json($data_init);
        },
    });
</script>
@endpush
