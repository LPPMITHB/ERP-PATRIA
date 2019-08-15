@extends('layouts.main')
@section('content-header')
@if($route == "/estimator")
    @if($profile->id)
        @breadcrumb(
            [
                'title' => 'Edit Estimator Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Estimator Profiles' => route('estimator.indexEstimatorProfile'),
                    $profile->ship->type => route('estimator.showProfile',$profile->id),
                    'Edit Estimator Profile' => '',
                ]
            ]
        )
        @endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Estimator Profile',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Estimator Profiles' => route('estimator.indexEstimatorProfile'),
                    'Create Estimator Profile' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@elseif($route == "/estimator_repair")
    @if($profile->id)
    @breadcrumb(
        [
            'title' => 'Edit Estimator Profile',
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator_repair.indexEstimatorProfile'),
                $profile->ship->type => route('estimator_repair.showProfile',$profile->id),
                'Edit Estimator Profile' => '',
            ]
        ]
    )
    @endbreadcrumb
    @else 
    @breadcrumb(
        [
            'title' => 'Create Estimator Profile',
            'items' => [
                'Dashboard' => route('index'),
                'View All Estimator Profiles' => route('estimator_repair.indexEstimatorProfile'),
                'Create Estimator Profile' => '',
            ]
        ]
    )
    @endbreadcrumb
    @endif
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/estimator")
                    @if($profile->id)
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator.updateProfile',['id'=>$profile->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator.storeProfile') }}">
                    @endif
                @elseif($route == "/estimator_repair")
                    @if($profile->id)
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator_repair.updateProfile',['id'=>$profile->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="profile" class="form-horizontal" method="POST" action="{{ route('estimator_repair.storeProfile') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="profile">
                            <div class="box-header no-padding">
                                <div class="col-xs-12 col-md-4" v-if="pr_type != 'Subcon'">
                                    <label for="">Profile Code</label>
                                    <div class="col-sm-12 p-l-0">
                                        <input v-model="profile_code" type="text" class="form-control width100" name="profile_code" id="profile_code">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 p-l-0">
                                    <label for="" >Ship Type</label>
                                    <selectize v-model="ship_id" :settings="ship_settings" :disabled="dataOk">
                                        <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.name }}</option>
                                    </selectize>  
                                </div>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#profile');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        submittedForm:{},
        ship_id : "",
        description : "",
        dataInput : {
            cost_standard_id : "",
        },
        ship_settings: {
            placeholder: 'Please Select Ship Type!'
        },
    }

    var vm = new Vue({
        el : '#profile',
        data : data,

    })
</script>
@endpush