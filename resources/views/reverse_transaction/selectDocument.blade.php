
@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Reverse Transaction » Select Document',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Document' => '',
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
                <div id="reverse_transaction">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <label for="" >Document Type</label>
                            <selectize v-model="documentType" :settings="documentTypeSettings">
                                <option value="1">Goods Receipt</option>
                                <option value="2">Goods Issue</option>
                            </selectize>  
                        </div>
                    </div>
                    <div class="row m-t-10" v-show="documentType != ''">
                        <div class="col-sm-6">
                            <div class="box-tools pull-left">
                                <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter datepicker" type="text" id="datepicker_from" />
                                <span id="date-label-to" class="date-label">To: </span><input class="date_range_filter datepicker" type="text" id="datepicker_to" />
                                <button type="button" id="btn-reset" class="btn btn-primary btn-sm">RESET</button>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <table id="document-table" class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Code</th>
                                        <th width="40%">Description</th>
                                        <th width="20%">Document Date</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(document,index) in documentData">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ document.number }}</td>
                                        <td class="tdEllipsis">{{ document.description }}</td>
                                        <td class="tdEllipsis">{{ document.created_at_date }}</td>
                                        <td class="tdEllipsis">
                                            <a :href="makeUrl(document.id)" class="btn btn-primary btn-xs">SELECT</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endverbatim
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        var document_table = $('#document-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
        $('div.overlay').hide();
    });

    var data = {
        documentType : "",
        documentData : [],
        submittedForm : {},
        documentTypeSettings : {
            placeholder: 'Please Document Type!'
        },
        menu : @json($menu),
    }

    var vm = new Vue({
        el : '#reverse_transaction',
        data : data,
        computed : {
            
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
            makeUrl(id){
                if(this.menu == "building"){
                    return "/reverse_transaction/create/"+this.documentType+"/"+id;
                }else{
                    
                }
            }
        },
        watch : {
            documentType: function(newValue){
                $('div.overlay').show();
                window.axios.get('/api/getDocuments/'+newValue+'/'+this.menu).then(({ data }) => {
                    this.documentData = [];
                    this.documentData = data;
                    $('#document-table').DataTable().destroy();
                    this.$nextTick(function() {
                        var document_table = $('#document-table').DataTable({
                            'paging'      : true,
                            'lengthChange': false,
                            'ordering'    : true,
                            'info'        : true,
                            'autoWidth'   : false,
                            'bFilter'     : true,
                            'initComplete': function(){
                                $('div.overlay').hide();
                            }
                        });

                        $("#datepicker_from").datepicker({
                            autoclose : true,
                            format : "dd-mm-yyyy"
                        }).keyup(function() {
                            var temp = this.value.split("-");
                            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            document_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            document_table.draw();
                        });

                        $("#datepicker_to").datepicker({
                            autoclose : true,
                            format : "dd-mm-yyyy"
                        }).keyup(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            document_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            document_table.draw();
                        });

                        document.getElementById("btn-reset").addEventListener("click", reset);

                        function reset() {
                            $("#datepicker_from").val('');
                            $("#datepicker_to").val('');
                            maxDateFilter = "";
                            minDateFilter = "";
                            document_table.draw();
                        }

                        // Date range filter
                        minDateFilter = "";
                        maxDateFilter = "";

                        $.fn.dataTableExt.afnFiltering.push(
                            function(oSettings, aData, iDataIndex) {
                                if (typeof aData._date == 'undefined') {
                                    var temp = aData[3].split("-");
                                    aData._date = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                                }

                                if (minDateFilter && !isNaN(minDateFilter)) {
                                    if (aData._date < minDateFilter) {
                                        return false;
                                    }
                                }

                                if (maxDateFilter && !isNaN(maxDateFilter)) {
                                    if (aData._date > maxDateFilter) {
                                        return false;
                                    }
                                }

                                return true;
                            }
                        );
                    })
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
        },
        created: function() {
        },
    });
</script>
@endpush
