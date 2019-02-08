<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0">
    
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" media="all">
        <style>
                /** 
                    Set the margins of the page to 0, so the footer and the header
                    can be of the full height and width !
                 **/
                 
                /** Define now the real margins of every page in the PDF **/
                @page{
                    margin-top:230px;
                    margin-bottom : 120px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -195px;
                    left: 0cm;
                    right: 0cm;
                }
                #footer{
                    position: fixed;
                    bottom: 10px;
                    left: 10px;
                    right: 0cm;
                }
                table,td,th{
                    border: 1px black solid;
                }
        </style>
    </head>
    <body>
        <script type="text/php">
            if (isset($pdf)) {
                }
        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">                    
                        </div>
                        <div class="row" style="margin-left: -5px;">
                            <div class="col-sm-12" style="font-size: 11px;line-height: 13px">
                                {{$branch->address}}
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 13px">
                                {{$branch->city}}
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 15px">
                                T.{{$branch->phone_number}} F.{{$branch->fax}}
                            </div>
                        </div>
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:10px;"><b>Purchase Requisition</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div style="margin-top:-120px; padding-top:5px">
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Request Date  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 100px; margin-top:-20px">
                                : {{date("d-m-Y", strtotime($modelPR->created_at))}}                   
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Request Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                                : {{$modelPR->number}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Department  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                                : {{$modelPR->user->role->name}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Project  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                                : {{($modelPR->project) ? $modelPR->project->number : '-'}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Status  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                                @if($modelPR->status == 0)
                                    @php($status = "CLOSED")
                                @elseif($modelPR->status == 1)
                                    @php($status = "OPEN")
                                @elseif($modelPR->status == 2)
                                    @php($status = "APPROVED")
                                @elseif($modelPR->status == 3)
                                    @php($status = "NEED REVISION")
                                @elseif($modelPR->status == 4)
                                    @php($status = "REVISED")
                                @elseif($modelPR->status == 5)
                                    @php($status = "REJECTED")
                                @elseif($modelPR->status == 6)
                                    @php($status = "CONSOLIDATED")
                                @endif
                                : {{$status}}                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main id="main">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="work_order_pdf" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="5%" class="text-center">No.</th>
                                    <th style="font-size: 11px" width="15%" class="text-center" >Material Code</th>
                                    <th style="font-size: 11px" width="25%" class="text-center">Material Name</th>
                                    <th style="font-size: 11px" width="8%" class="text-center">Qty</th>
                                    <th style="font-size: 11px" width="7%" class="text-center">Unit</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">Required Date</th>
                                    <th style="font-size: 11px" width="14%" class="text-center">Department</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">Project</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelPR->purchaseRequisitionDetails as $PRD)
                                    @if($PRD->quantity > 0)
                                        <tr>
                                            <td class="text-center" style="font-size: 11px" width="5%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $PRD->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="30%" class="tdBreakWord">{{ $PRD->material->name }}</td>
                                            <td style="font-size: 11px" width="8%" class="tdBreakWord text-center">{{ number_format($PRD->quantity) }}</td>
                                            <td style="font-size: 11px" width="7%" class="tdBreakWord text-center">{{$PRD->material->uom->unit}}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{($PRD->required_date != null) ? date("d-m-Y", strtotime($PRD->required_date)) : "-"}} </td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord">{{$PRD->user->role->name}}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord">{{($PRD->project_id != null) ? $PRD->project->number : ""}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <div class="col-xs-12" style="margin-top:3px; width:300px;padding-left:5px; border: black 1px solid; border-radius: 5px; height:80px;">
                                <div style="font-size: 11px"><b>Description</b></div>
                                <div style="font-size: 11px">{{$modelPR->description}}</div>
                            </div>
                            <div>
                                <div style="margin-left: 350px; margin-top: 3px; font-size: 11px">Prepared By</div>
                                <hr style="margin-left: 350px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 350px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 500px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Aproved By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 650px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Received By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
