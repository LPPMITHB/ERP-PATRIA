@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Customer',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => route('customer.index'),
            $customer->name => route('customer.show',$customer->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-tools pull-right p-t-5">
                    @can('edit-customer')
                        <a href="{{ route('customer.edit',['id'=>$customer->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                    @endcan
                </div>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#general_info" data-toggle="tab">General Information</a></li>
                        <li><a href="#credit_limit" data-toggle="tab">Credit Limit</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="general_info">
                        <table class="table table-bordered showTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Attribute</th>
                                    <th width="65%">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Code</td>
                                    <td>{{ $customer->code }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Name</td>
                                    <td>{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Address 1</td>
                                    <td>{{ $customer->address_1 }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Address 2</td>
                                    <td>{{ $customer->address_2 }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Phone Number 1</td>
                                    <td>{{ $customer->phone_number_1 }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Phone Number 2</td>
                                    <td>{{ $customer->phone_number_2 }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Contact Name</td>
                                    <td>{{ $customer->contact_name }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Email</td>
                                    <td>{{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Tax Number</td>
                                    <td>{{ $customer->tax_number }}</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Pkp Number</td>
                                    <td>{{ $customer->pkp_number }}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Province</td>
                                    <td>{{ $customer->province }}</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Zip Code</td>
                                    <td>{{ $customer->zip_code }}</td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>Country</td>
                                    <td>{{ $customer->country }}</td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>Business Unit</td>
                                    <td>{{ $business_unit }}</td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td>Status</td>
                                    <td class="iconTd">
                                        @if ($customer->status == 1)
                                            <i class="fa fa-check"></i></td>
                                        @elseif ($customer->status == 0)
                                            <i class="fa fa-times"></i>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="credit_limit">
                        <form id="credit-limit" class="form-horizontal" method="POST" action="{{ route('customer.updateCreditLimit',['id'=>$customer->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        @csrf
                            @verbatim
                                <div id="credit-limit">
                                    <div class="col-sm-4">
                                        <label for="">Credit Limit</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="credit_limit" name="credit_limit" required v-model="dataInput.credit_limit">
                                    </div>
                                    <div class="col-sm-4 p-t-10">
                                        <label for="">Used Limit</label>
                                    </div>
                                    <div class="col-sm-8 p-t-10">
                                        <input type="text" class="form-control" id="used_limit" name="used_limit" disabled v-model="dataInput.used_limit">
                                    </div>
                                    <div class="col-sm-4 p-t-10">
                                        <label for="">Remaining Limit</label>
                                    </div>
                                    <div class="col-sm-8 p-t-10">
                                        <input type="text" class="form-control" id="remaining_limit" name="remaining_limit" disabled v-model="dataInput.remaining_limit">
                                    </div>
                                </div>

                                <div class="col-md-12 p-t-10">
                                    <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE CREDIT LIMIT</button>
                                </div>
                            @endverbatim
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#credit-limit');

     $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        customer : @json($customer),
        dataInput : {
            credit_limit : "",
            used_limit : "",
            remaining_limit : "",
        },
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#credit-limit',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;

                if(this.dataInput.credit_limit == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            submitForm(){
                $('div.overlay').show();
                document.body.appendChild(form);
                this.dataInput.credit_limit = (this.dataInput.credit_limit+"").replace(/,/g , '');
                this.dataInput.used_limit = (this.dataInput.used_limit+"").replace(/,/g , '');
                var data = JSON.stringify(this.dataInput);

                this.submittedForm.datas = JSON.parse(data);
                this.submittedForm.customer_id = this.customer.id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch:{
            dataInput:{
                handler: function(newValue) {
                    this.dataInput.credit_limit = (newValue.credit_limit+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.dataInput.used_limit = (newValue.used_limit+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    var remaining_limit = (newValue.credit_limit+"").replace(/,/g , '') - (newValue.used_limit+"").replace(/,/g , '');
                    this.dataInput.remaining_limit = remaining_limit.toLocaleString('en');
                },
                deep: true
            },
        },
        created: function() {
            this.dataInput.credit_limit = (this.customer.credit_limit+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.dataInput.used_limit = (this.customer.used_limit+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            var remaining_limit = (this.dataInput.credit_limit+"").replace(/,/g , '') - (this.dataInput.used_limit+"").replace(/,/g , '');
            this.dataInput.remaining_limit = remaining_limit.toLocaleString('en');
        }
    })
</script>
@endpush