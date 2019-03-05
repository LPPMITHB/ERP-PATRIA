@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Resources Schedule',
        'items' => [
            'Dashboard' => route('index'),
            'Resources Schedule' => '',
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
                    @verbatim
                    <div id="vue">
                        <div class="col-sm-12 p-l-0 p-b-10">
                            <div class="col-sm-4 col-xs-12 p-l-5">
                                <label for="">Resource</label>
                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                </selectize>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <label for="">Resource Detail</label>
                                <selectize v-model="dataInput.resource_detail_id" :settings="resourceDetailSettings" :disabled="resourceOk">
                                    <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }}</option>
                                </selectize>
                            </div>
                        </div>
                        <div id="calendar" v-show="dataInput.resource_id != '' && dataInput.resource_detail_id != ''">
                
                        </div>
                    </div>
                    @endverbatim
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();

 
    });

    var data = {
        events : [],
        resources : @json($resources),
        resourceDetail : @json($resourceDetail),
        selectedRD : [],
        dataInput: {
            resource_id : "",
            resource_detail_id : ""
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        resourceDetailSettings: {
            placeholder: 'Please Select Resource Detail'
        },
    }

    var vm = new Vue({
        el : '#vue',
        data : data,
        computed: {
            resourceOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            destroyFullCalendar(){
                $('#calendar').fullCalendar('destroy');
            },
            buildFullCalendar(){
                $('#calendar').fullCalendar({
                    events : this.events,
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
                        right: 'month,agendaWeek,agendaDay'
                    },
                });
            }
        },
        watch: {
            'dataInput.resource_id' : function(newValue){
                if(newValue != ''){
                    this.selectedRD = [];
                    this.resourceDetail.forEach(RD => {
                        if(RD.resource_id == newValue){
                            this.selectedRD.push(RD);
                        }  
                    });
                }else{
                    this.dataInput.resource_detail_id = "";
                }
            },
            'dataInput.resource_detail_id' : function(newValue){
                if(newValue != ''){
                    $('div.overlay').show();
                    this.destroyFullCalendar();
                    this.events = [];
                    window.axios.get('/api/getSchedule/'+newValue).then(({ data }) => {
                        data.forEach(TR =>{
                            this.events.push({
                                title: TR.wbs.number+" - "+TR.wbs.description, 
                                start: TR.start_date,
                                end: TR.end_date,
                                clickable : false,
                                color : '#007bff',
                                textColor : 'black',
                            })
                        });
                        this.buildFullCalendar();
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
                }
            }
        },
    });
</script>
@endpush