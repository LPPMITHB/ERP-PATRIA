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
                    margin-top:310px;
                    margin-bottom : 240px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -268px;
                    left: 0cm;
                    right: 0cm;
                }
                #footer{
                    position: fixed;
                    bottom: 0px;
                    left: 10px;
                    right: 0cm;
                }
        </style>
    </head>
    <body>
        <script type="text/php">
            if ( isset($pdf) ) {
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
                                T. {{$branch->phone_number}} F.{{$branch->fax}}
                            </div>
                        </div>
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Material Requisition</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -10px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">MR Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelMR->number}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">MR Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelMR->created_at))}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Rebill To  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -            
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Page  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main style="margin-top: -15px">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="work_order_pdf" style="width: 100%; margin-left: -10px; margin-top :-55px;">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >Material Name</th>
                                    <th style="font-size: 11px" width="30%" class="text-center">Material Description</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">Unit</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Qty</th>
                                    <th style="font-size: 11px" width="15%" class="text-center">Work Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelMR->MaterialRequisitionDetails as $MRD)
                                    @if($MRD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $MRD->material->code }} - {{ $MRD->material->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="30%" class="tdBreakWord">{{ $MRD->material->description }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{ $MRD->material->uom->unit }}</td>
                                            <td style="font-size: 11px" width="13%" class="tdBreakWord text-right">{{ number_format($MRD->quantity) }}</td>
                                            <td style="font-size: 11px" width="15%" class="tdBreakWord text-right">{{ $MRD->wbs->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px;">
                            <div>
                                <div style="margin-top: 10px; font-size: 12px">Requested by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:130px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 200px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Authorised by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:130px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 400px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Issued by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:130px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 590px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Received by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:130px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
