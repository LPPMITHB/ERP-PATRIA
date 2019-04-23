@extends('layouts.main')

@section('content-header')
  <h1>Project Dashboard</h1>
@endsection

@section('content')
  <div class="row">
      <div class="col-lg-12">
          <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#individual" data-toggle="tab">Individual Project</a></li>
                  <li><div class="col-sm-12"></div></li>
              </ul>
              <div class="tab-content">
                  <div class="tab-pane active" id="individual">
                      <div class="box-body p-t-0">
                        
                          <div class="row p-b-10">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <a href="#" data-container="body" data-toggle="tooltip" title="Project dengan background berwarna biru menandakan bahwa project masih dalam schedule & tidak terdapat WBS yang terlambat dari jadwal yang telah dibuat.">
                                <div class="info-box" style="min-height:30px">
                                  <span class="info-box-icon bg-aqua m-t-0" style="height:20px"></span>
                                  <div class="info-box-content p-t-0 m-t-0">
                                    <span class="info-box-text"><b>Project Ok</b></span>
                                    <span class="info-box-number"></span>
                                  </div>
                                </div>
                              </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" data-container="body" data-toggle="tooltip" title="Project dengan background berwarna kuning menandakan bahwa terdapat activity / wbs yang terlambat namun ekspetasi tanggal selesai seluruh WBS belum melebihi tanggal rencana berakhirnya project.">
                                <div class="info-box" style="min-height:30px">
                                  <span class="info-box-icon m-t-0" style="height:20px; background-color: #E9E92F"> </span>
                                  <div class="info-box-content p-t-0 m-t-0">
                                    <span class="info-box-text"><b>WBS Late</b></span>
                                    <span class="info-box-number"></span>
                                  </div>
                                </div>
                              </a>
                            </div>
                            <div class="clearfix visible-sm-block"></div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" data-container="body" data-toggle="tooltip" title="Project dengan background berwarna orange menandakan bahwa terdapat activity / wbs yang terlambat dan ekspetasi tanggal selesai seluruh WBS telah melebihi tanggal rencana berakhirnya project.">
                                <div class="info-box" style="min-height:30px">
                                  <span class="info-box-icon bg-orange m-t-0" style="height:20px"></span>
                                  <div class="info-box-content p-t-0 m-t-0">
                                    <span class="info-box-text"><b>Project Warning</b></span>
                                    <span class="info-box-number"></span>
                                  </div>
                                </div>
                              </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" data-container="body" data-toggle="tooltip" title="Project dengan background berwarna merah menandakan bahwa project saat ini telah melewati tanggal rencana berakhirnya project.">
                                <div class="info-box" style="min-height:30px">
                                  <span class="info-box-icon bg-red m-t-0" style="height:20px"></span>
                                  <div class="info-box-content p-t-0 m-t-0">
                                    <span class="info-box-text"><b>Project Late</b></span>
                                    <span class="info-box-number"></span>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </div>

                          @foreach ($modelProject as $project)
                            @foreach($datas as $data)
                              @if($data['id'] == $project->id)
                                <div class="row">   
                                    <div class="col-lg-12 col-xs-12">
                                        <!-- small box -->
                                        @if($data['status'] == 0)
                                          <div style="display: inline-block; margin-bottom: -2px" class="small-box bg-aqua p-r-5 p-l-5">
                                            <label>Project Code : {{$project->number}} - {{$project->person_in_charge}}</label>
                                          </div>
                                          <div class="small-box bg-aqua">
                                        @elseif($data['status'] == 1)
                                          <div style="display: inline-block; margin-bottom: -2px; color: white; background-color: #E9E92F" class="small-box p-r-5 p-l-5">
                                              <label>Project Code : {{$project->number}} - {{$project->person_in_charge}}</label>
                                          </div>
                                          <div class="small-box bg-darken-4" style="color: white; background-color: #E9E92F">
                                        @elseif($data['status'] == 2)
                                          <div style="display: inline-block; margin-bottom: -2px" class="small-box bg-orange p-r-5 p-l-5">
                                              <label>Project Code : {{$project->number}} - {{$project->person_in_charge}}</label>
                                          </div>
                                          <div class="small-box bg-orange">
                                        @elseif($data['status'] == 3)
                                          <div style="display: inline-block; margin-bottom: -2px" class="small-box bg-red p-r-5 p-l-5">
                                              <label>Project Code : {{$project->number}} - {{$project->person_in_charge}}</label>
                                          </div>
                                          <div class="small-box bg-red">
                                        @endif
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-md-2 col-xs-5 col-sm-4">
                                                        <h4>Ship</h4>
                                                    </div>
                                                    <div class="col-md-4 col-xs-7 col-sm-8">
                                                        <h4> : {{$project->ship->type}}</h4>                
                                                    </div>
                                                    <div class="col-md-2 col-xs-5 col-sm-4">
                                                        <h4>Progress </h4>
                                                    </div>
                                                    <div class="col-md-4 col-xs-7 col-sm-8">
                                                        <h4> : {{$project->progress}} %</h4>  
                                                    </div>
                                                    @if($project->actual_start_date != null)
                                                      <div class="col-md-2 col-xs-5 col-sm-4">
                                                          <h4>Actual Start Date</h4>
                                                      </div>
                                                      <div class="col-md-4 col-xs-7 col-sm-8">
                                                          <h4> : {{date("d-m-Y", strtotime($project->actual_start_date))}}</h4>                
                                                      </div>
                                                    @else
                                                      <div class="col-md-2 col-xs-5 col-sm-4">
                                                          <h4>Planned Start Date</h4>
                                                      </div>
                                                      <div class="col-md-4 col-xs-7 col-sm-8">
                                                          <h4> : {{date("d-m-Y", strtotime($project->planned_start_date))}}</h4>                
                                                      </div>
                                                    @endif
                                                    <div class="col-md-2 col-xs-5 col-sm-4">
                                                        <h4>Days Left </h4>
                                                    </div>
                                                    <div class="col-md-4 col-xs-7 col-sm-8">
                                                        @php
                                                            $earlier = new DateTime(date("Y-m-d"));
                                                            $later = new DateTime($project->planned_end_date);
                                          
                                                            $datediff = $later->diff($earlier)->format("%a");
                                                            if($later<$earlier){
                                                              $datediff = "- ".$datediff;
                                                            }
                                                        @endphp
                                                        <h4> : {{$datediff}} Days</h4>                
                                                    </div>
                                                    <div class="col-md-2 col-xs-5 col-sm-4">
                                                        <h4>Customer</h4>
                                                    </div>
                                                    <div class="col-md-4  col-xs-7 col-sm-8 tdEllipsis" data-container="body" data-toggle="tooltip" data-placement="bottom" title="{{$project->customer->name}}">
                                                        <h4> : {{$project->customer->name}}</h4>                
                                                    </div>
                                                    <div class="col-md-2 col-xs-5 col-sm-4">
                                                        <h4>Cost Absorption </h4>
                                                    </div>
                                                    @php
                                                        $costAbsorbed = 0;
                                                        $mrs = $project->materialRequisitions;
                                                        if($mrs){
                                                          foreach ($mrs as $mr) {
                                                            $gis = $mr->goodsIssues;
                                                            foreach ($gis as $gi) {
                                                              $gids = $gi->goodsIssueDetails;
                                                              foreach ($gids as $gid) {
                                                                $costAbsorbed += $gid->material->cost_standard_price * $gid->quantity;
                                                              }
                                                            }
                                                          }
                                                        }
                                                        $totalCost = count($project->raps)>0 ? $project->raps->sum('total_price') : 0;
                                                        if($totalCost > 0){
                                                          $percentageCost = number_format(($costAbsorbed / $totalCost)*100,2);
                                                        }else{
                                                          $percentageCost = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-md-4 col-xs-7 col-sm-8 tdEllipsis" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Rp {{number_format($costAbsorbed)}} / Rp {{count($project->raps)>0 ? number_format($project->raps->sum('total_price')) : 0}}">
                                                        <h4> : {{$percentageCost}} %</h4>                
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            
                                            <div class="icon">
                                              @if($project->drawing != null)
                                                <img style="width : 73px; height: 65px;" src="{{ URL::to('/') }}/app/documents/project/{{$project->drawing}}">
                                              @else
                                                <i class="fa fa-ship"></i>
                                              @endif
                                            </div>
                                            @if($project->business_unit_id == 1)
                                              <a href="{{ route('project.show',['id'=>$project->id]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                              @elseif($project->business_unit_id == 2)
                                              <a href="{{ route('project_repair.show',['id'=>$project->id]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </div>
                              @endif
                            @endforeach
                          @endforeach
                      </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="overall">
                      <div class="box-body">
                      </div>
                  </div>  
              </div>
              <!-- /.tab-content -->
          </div>
      </div>
  </div>
@endsection

@push('script')
<script>
     $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush