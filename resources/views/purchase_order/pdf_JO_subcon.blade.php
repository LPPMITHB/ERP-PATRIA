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
                    bottom: 100px;
                    left: 10px;
                    right: 0cm;
                }
        </style>
    </head>
    <body>
        <script type="text/php">
            if (isset($pdf)) {
                if ( isset($pdf) ) { 
                    $x = 540;
                    $y = 5;
                    $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
                    $font = null;
                    $size = 9;
                    $color = array(0,0,0);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
                    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                } 
            }
        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            @if($route == '/purchase_order')
                            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">    
                            @else 
                            <img src="{{ asset('images/logo-PAMI.jpg') }}" alt="" srcset="">    
                            @endif                     
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Job Order</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                            <div style="font-size: 11px;">Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -80px;">
                                <b style="font-size: 12px;">{{$modelPO->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelPO->vendor->address}} <br>T.{{$modelPO->vendor->phone_number_1}}</p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -5px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">Vessel Name   </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 90px; margin-top:-20px">
                                : {{$projectName->project->name}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">Date   </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 90px; margin-top:-20px">
                                : {{date("D, d M Y", strtotime($modelPO->created_at))}}                   
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Class  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 90px; margin-top:-20px">
                                : {{$projectName->project->class_name}}                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Job  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 90px; margin-top:-20px">
                                : {{($modelPO->project) ? $modelPO->project->number : '-'}}                 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div style="line-height:11px;margin-left: -755px; margin-top: 220px; word-wrap:break-word;width: 720px;">
                        <i style="font-size: 9px;"><b>Sehubungan dengan proyek di PT. Patria Maritime Industry menunjuk subkontraktor di atas untuk melaksanakan pekerjaan dibawah ini :</b></i>
                    </div>
                </div>
            </div>
        </header>
        <main style="margin-top: -30px">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="job_order_pdf" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="3%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="25%" class="text-center">Service Description</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Detail</th>
                                    <th style="font-size: 11px" width="15%" class="text-center">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($discount = 0)
                                @php($tax = 0)
                                @php($freight = 0)
                                @foreach($modelPO->purchaseOrderDetails as $POD)
                                        <tr>
                                            <td style="font-size: 11px" class="text-center" width="3%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="25%" class="tdBreakWord p-l-5">{{ $POD->activityDetail->serviceDetail->service->name }} - {{ $POD->activityDetail->serviceDetail->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="15%" class="tdBreakWord text-center">{{ $POD->activityDetail->area }} {{ $POD->activityDetail->areaUom->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="15%" class="tdBreakWord p-l-5">{{ $POD->remark }}</td>
                                        </tr>
                                        @php($discount += $POD->total_price * (($POD->discount)/100))
                                        @php($tax += $POD->total_price * (($POD->tax)/100))
                                        @php($freight += $POD->estimated_freight)
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px;">
                            <div class="col-xs-12">
                                <div style="margin-left: -14px;margin-top:-10px;line-height:11px;word-wrap:break-word;width: 720px;">
                                    <i style="font-size: 9px;"><b>Subkontraktor secara resmi menyatakan kesediaan dan kesanggupan untuk memenuhi semua pekerjaan di atas sesuai dengan jadwal yang diberikan oleh PT. Patria Maritime Industry</b></i>
                                </div>
                            </div>
                            <hr style="height:1px;border:none;color:#333;background-color:#333;" />
                            <div style="font-size: 10px; margin-top:-20px;">
                            Catatan : <br>
                                1. Surat perintah kerja (asli) ini harus dilampirkan saat penagihan dilengkapi surat keterangan penyelesaian pekerjaan <br>
                                2. Subkontraktor harus mematuhi semua peraturan dalam docyard <br>
                                3. Material disediakan oleh subkontraktor <br>
                                4. Arus listrik dan alat berat disediakan oleh docyard <br>
                                5. Welding electrode dan consumable disiapkan oleh dockyard / subkontraktor <br>
                                6. Semua peralatan kerja pendukung disediakan oleh subkontraktor <br>
                                7. Semua kerugian akibat kelalaian/kesalahan pekerjaan menjadi tanggung jawab subkontraktor <br>
                                8. Pengembalian sisa material menjadi tanggung jawab subkontraktor dan dockyard <br>
                                9. Sebagian pekerjaan bisa dialihkan ke subkontraktor lain dalam dalam kondisi subkontraktor yang bersangkutan dirasa tidak mampu menyelesaikan pekerjaan dengan jadwal yang ditentukan <br>
                                10. Pembersihan alat kerja consumable dan hasil kerja menjadi tanggung jawab subkontraktor <br>
                                11. Pengecekan hasil pekerjaan dan pengetasan dilaksakan oleh subkontraktor dan dockyard <br>
                            </div>    
                            <hr style="height:1px;border:none;color:#333;background-color:#333;margin-top: 5px;" />
                            <div>
                                <div style="margin-top: -15px; font-size: 12px">Prepared by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 250px; margin-top:-150px">
                                <div style="margin-top: -15px; font-size: 12px">Aproved by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 500px; margin-top:-150px">
                                <div style="margin-top: -15px; font-size: 12px">Supplier Confirmation</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px;">Chop and Sign</div>
                                <div style=" font-size: 12px">Date</div>
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
