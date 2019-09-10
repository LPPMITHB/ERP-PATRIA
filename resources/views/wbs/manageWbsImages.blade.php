@extends('layouts.main')
@section('content-header')
    @if($menu == "building")
        @breadcrumb(
            [
                'title' => 'Manage WBS Images',
                'items' => [
                    'Dashboard' => route('index'),
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="box-title"></div>
            </div>
            <div class="box-body" id="image-table">
                <a class="btn btn-primary btn-sm col-sm-12">UPLOAD DRAWING</a>
                @verbatim
                <table id="wbs-image-table" class="table-bordered tableFixed" style="border-collapse:collapse">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">Image</th>
                            <th style="width:35%">Name</th>
                            <th style="width:25%">WBS</th>
                            <th style="width:15%"></th>
                        </tr>
                    </thead>
                    <tbody v-for="(image, index) in images">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td><img style="display:block;" width="100%" :src="getSrc(image)"></td>
                            <td class="tdBreakWord" data-container="body">{{ image.drawing }}</td>
                            <td class="tdBreakWord" data-container="body"><a :href="getWbsLink(image.wbs_id)" target="_blank"><b>{{ image.wbs.number }}</b> {{ image.wbs.description }}</a></td>
                            <td><div class="parent-container"><a class="btn btn-primary btn-sm col-sm-6" :href="getSrc(image)">VIEW</a></div><a class="btn btn-danger btn-sm col-sm-6">DELETE</a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <!-- button at footer -->
                    </tfoot>
                </table>
                @endverbatim
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
$(document).ready( function() {
    $('div.overlay').hide();
});

var data = {
    images : @json($images),
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'
    })
})

var vm = new Vue({
    el: '#image-table',
    data: data,
    mounted() {
        $('.parent-container').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image'
            // other options
        });
    },
    methods:{
        tooltipText: function(text) {
            return text
        },
        getSrc(image){
            let path = '../../app/documents/wbs_images/'+image.drawing;
            return path;
        },
        getWbsLink(id){
            return "/wbs/show/" + id;
        }
    },
});
</script>
@endpush
