<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\Configuration;
use App\Models\Branch;
use App\Models\Bom;
use App\Models\Rap;
use App\Models\Stock;
use App\Models\RapDetail;
use App\Models\MaterialRequisition;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\Project;
use App\Models\Cost;
use App\Models\WBS;
use App\Models\Uom;
use Auth;
use App\Http\Controllers\PurchaseRequisitionController;
use Illuminate\Support\Collection;

class RAPController extends Controller
{
    protected $pr;

    public function __construct(PurchaseRequisitionController $pr)
    {
        $this->pr = $pr;
    }

    // view RAP
    public function indexSelectProject(Request $request)
    {
        $route = $request->route()->getPrefix();
        $menu = "view_rap";

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // create cost
    public function selectProjectCost(Request $request)
    {
        $menu = "create_cost";
        $route = $request->route()->getPrefix();

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // input actual other cost
    public function selectProjectActualOtherCost(Request $request)
    {
        $menu = "input_actual_other_cost";
        $route = $request->route()->getPrefix();

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // View Approval Actual Other Cost
    public function selectProjectPlanOtherCost(Request $request)
    {
        $menu = "view_project_with_have_actual_other_cost";
        $route = $request->route()->getPrefix();

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
            $ProjectWithActualOtherCost = [];
            foreach ($projects as $prj) {
                foreach ($prj->cost as $prjCost) {
                    if ($prjCost->id != null && $prjCost->actual_cost == null && $prjCost->status == 1) {
                        array_push($ProjectWithActualOtherCost, $prjCost->project_id);
                    }
                }
            }
            $projects = Project::whereIn('id', $ProjectWithActualOtherCost)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
            $ProjectWithActualOtherCost = [];
            foreach ($projects as $prj) {
                foreach ($prj->cost as $prjCost) {
                    if ($prjCost->id != null && $prjCost->actual_cost == null && $prjCost->status == 1) {
                        array_push($ProjectWithActualOtherCost, $prjCost->project_id);
                    }
                }
            }
            $projects = Project::whereIn('id', $ProjectWithActualOtherCost)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    //select 
    public function inputApprovalProjectPlanOtherCost(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $modelOtherCost = Cost::with('project', 'wbs')->where('status', 1)->get();
        $cost_types = Configuration::get('cost_type');

        return view('rap.inputApprovalProjectPlanOtherCost', compact('project', 'modelOtherCost', 'route', 'cost_types'));
        // return view('rap.inputActualOtherCost', compact('project', 'modelOtherCost', 'route', 'cost_types'));
    }
    // Input Approval Actual Other Cost
    public function updateApprovalProjectPlanOtherCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $cost = Cost::find($data['cost_id']);
            $cost->status = $data['status'];
            $cost->approval_date = Carbon::now();
            $cost->approved_by = Auth::user()->id;
            if (!$cost->update()) {
                return response(["error" => "Failed to save, please try again!"], Response::HTTP_OK);
            } else {
                DB::commit();
                return response(["response" => "Success to Update Cost"], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error" => $e->getMessage()], Response::HTTP_OK);
        }
    }

    // view planned cost
    public function selectProjectViewCost(Request $request)
    {
        $menu = "view_planned_cost";
        $route = $request->route()->getPrefix();

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // view planned cost
    public function selectProjectViewRM(Request $request)
    {
        $menu = "view_rm";
        $route = $request->route()->getPrefix();

        if ($route == '/rap') {
            $projects = Project::where('status', 1)->where('business_unit_id', 1)->get();
        } elseif ($route == '/rap_repair') {
            $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        }

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    public function selectWBS(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss;
        $dataWbs = Collection::make();

        $dataWbs->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        if ($route == '/rap') {
            foreach ($wbss as $wbs) {
                if ($wbs->wbs) {
                    $dataWbs->push([
                        "id" => $wbs->code,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap.showMaterialEvaluation', $wbs->id)],
                    ]);
                } else {
                    $dataWbs->push([
                        "id" => $wbs->code,
                        "parent" => $project->number,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap.showMaterialEvaluation', $wbs->id)],
                    ]);
                }
            }
        } elseif ($route == '/rap_repair') {
            foreach ($wbss as $wbs) {
                if ($wbs->wbs) {
                    $dataWbs->push([
                        "id" => $wbs->code,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap_repair.showMaterialEvaluation', $wbs->id)],
                    ]);
                } else {
                    $dataWbs->push([
                        "id" => $wbs->code,
                        "parent" => $project->number,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap_repair.showMaterialEvaluation', $wbs->id)],
                    ]);
                }
            }
        }

        return view('rap.selectWBS', compact('project', 'dataWbs', 'route'));
    }


    public function showMaterialEvaluation(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $wbs = WBS::findOrFail($id);
        $project = $wbs->project;
        $materialEvaluation = Collection::make();
        $modelBom = Bom::where('wbs_id', $id)->first();
        if ($modelBom != null) {
            foreach ($modelBom->bomDetails as $bomDetail) {
                if ($bomDetail->material) {
                    if (count($bomDetail->material->materialRequisitionDetails) > 0) {
                        foreach ($bomDetail->material->materialRequisitionDetails as $mrd) {
                            if ($mrd->wbs_id == $id) {
                                if ($mrd->material_requisition->status == 2 || $mrd->material_requisition->status == 7 || $mrd->material_requisition->status == 0) {
                                    $materialEvaluation->push([
                                        "material_code" => $bomDetail->material->code,
                                        "material_description" => $bomDetail->material->description,
                                        "unit" => $bomDetail->material->uom->unit,
                                        "budget" => $bomDetail->quantity,
                                        "requested" => $mrd->quantity,
                                        "issued" => $mrd->issued,
                                    ]);
                                } else {
                                    $materialEvaluation->push([
                                        "material_code" => $bomDetail->material->code,
                                        "material_description" => $bomDetail->material->description,
                                        "unit" => $bomDetail->material->uom->unit,
                                        "budget" => $bomDetail->quantity,
                                        "requested" => 0,
                                        "issued" => 0,
                                    ]);
                                }
                            }
                        }
                    } else {
                        $materialEvaluation->push([
                            "material_code" => $bomDetail->material->code,
                            "material_description" => $bomDetail->material->description,
                            "unit" => $bomDetail->material->uom->unit,
                            "budget" => $bomDetail->quantity,
                            "requested" => 0,
                            "issued" => 0,
                        ]);
                    }
                }
            }
            return view('rap.showMaterialEvaluation', compact('project', 'wbs', 'materialEvaluation', 'route'));
        } else {
            $route = $request->route()->getPrefix();
            if ($route == '/rap') {
                return redirect()->route('rap.selectWBS', $wbs->project_id)->with('error', "This WBS doesn't have BOM");
            } elseif ($route == '/rap_repair') {
                return redirect()->route('rap_repair.selectWBS', $wbs->project_id)->with('error', "This WBS doesn't have BOM");
            }
        }
    }

    public function showMaterialEvaluationRepair(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $materialEvaluation = Collection::make();
        $modelBom = Bom::where('project_id', $id)->first();
        $mr_ids = MaterialRequisition::where('project_id', $id)->get()->pluck('id')->toArray();

        if ($modelBom != null) {
            foreach ($modelBom->bomDetails as $bomDetail) {
                if ($bomDetail->material != null) {
                    if (count($bomDetail->material->materialRequisitionDetails) > 0) {
                        foreach ($bomDetail->material->materialRequisitionDetails->whereIn('material_requisition_id', $mr_ids) as $mrd) {
                            if (count($materialEvaluation) > 0) {
                                $material_not_found = true;
                                foreach ($materialEvaluation as $existing) {
                                    if ($mrd->material->code == $existing['material_code']) {
                                        $existing['used'] += $mrd->issued;
                                        $material_not_found = false;
                                    }
                                }

                                if ($material_not_found) {
                                    $materialEvaluation->push([
                                        "material_code" => $bomDetail->material->code,
                                        "material_description" => $bomDetail->material->description,
                                        "unit" => $bomDetail->material->uom->unit,
                                        "quantity" => $bomDetail->quantity,
                                        "used" => $mrd->issued,
                                    ]);
                                }
                            } else {
                                $materialEvaluation->push([
                                    "material_code" => $bomDetail->material->code,
                                    "material_description" => $bomDetail->material->description,
                                    "unit" => $bomDetail->material->uom->unit,
                                    "quantity" => $bomDetail->quantity,
                                    "used" => $mrd->issued,
                                ]);
                            }
                        }
                    } else {
                        $materialEvaluation->push([
                            "material_code" => $bomDetail->material->code,
                            "material_description" => $bomDetail->material->description,
                            "unit" => $bomDetail->material->uom->unit,
                            "quantity" => $bomDetail->quantity,
                            "used" => 0,
                        ]);
                    }
                }
            }

            return view('rap.showMaterialEvaluationRepair', compact('project', 'materialEvaluation', 'route'));
        } else {
            $route = $request->route()->getPrefix();
            if ($route == '/rap') {
                return redirect()->route('rap.selectWBS', $wbs->project_id)->with('error', "This WBS doesn't have BOM");
            } elseif ($route == '/rap_repair') {
                return redirect()->route('rap_repair.selectProjectViewRM')->with('error', "This WBS doesn't have BOM");
            }
        }
    }

    public function index(Request $request, $id)
    {
        $raps = Rap::where('project_id', $id)->get();
        $route = $request->route()->getPrefix();

        return view('rap.index', compact('raps', 'route'));
    }

    public function createCost(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $cost_types = Configuration::get('cost_type');

        return view('rap.createOtherCost', compact('project', 'route', 'cost_types'));
    }

    public function inputActualOtherCost(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $modelOtherCost = Cost::with('project', 'wbs')->get();
        $cost_types = Configuration::get('cost_type');

        return view('rap.inputActualOtherCost', compact('project', 'modelOtherCost', 'route', 'cost_types'));
    }

    public function viewPlannedCost(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $wbss = $project->wbss;
        $costs = Cost::where('project_id', $id)->get();
        $raps = Rap::where('project_id', $id)->get();
        $totalCost = 0;

        foreach ($raps as $rap) {
            $totalCost += $rap->total_price;
        }
        foreach ($costs as $cost) {
            $totalCost += $cost->plan_cost;
        }

        $data = Collection::make();

        $data->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name . ' <b>| Total Cost : Rp.' . number_format($totalCost) . '</b>',
            "icon" => "fa fa-ship"
        ]);

        foreach ($wbss as $wbs) {
            $RapCost = 0;
            foreach ($raps as $rap) {
                if ($rap->bom->wbs_id == $wbs->id) {
                    foreach ($rap->RapDetails as $RD) {
                        $RapCost += $RD->quantity * $RD->price;
                    }
                }
            }
            $otherCost = 0;
            foreach ($costs as $cost) {
                if ($cost->wbs_id == $wbs->id) {
                    $otherCost += $cost->plan_cost;
                }
            }
            $TempwbsCost = 0;
            $wbsCost = Collection::make();
            self::getWbsCost($wbs, $TempwbsCost, $raps, $costs, $wbsCost);
            $totalCost = 0;
            foreach ($wbsCost as $cost) {
                $totalCost += $cost;
            }

            if ($wbs->wbs) {
                $data->push([
                    "id" => $wbs->code,
                    "parent" => $wbs->wbs->code,
                    "text" => $wbs->number . ' - ' . $wbs->description . ' <b>| Sub Total Cost : Rp.' . number_format($totalCost) . '</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            } else {
                $data->push([
                    "id" => $wbs->code,
                    "parent" => $project->number,
                    "text" => $wbs->number . ' - ' . $wbs->description . ' <b>| Sub Total Cost : Rp.' . number_format($totalCost) . '</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }
        }

        foreach ($raps as $rap) {
            $wbss = [];
            array_push($wbss, $rap->bom->wbs_id);
            $wbss = array_unique($wbss);
            foreach ($wbss as $wbs) {
                $RapCost = 0;
                if ($rap->bom->wbs_id == $wbs) {
                    $wbs_code = $rap->bom->wbs->code;
                    foreach ($rap->RapDetails as $RD) {
                        $RapCost += $RD->price;
                    }
                }
                $data->push([
                    "id" => 'WBS' . $wbs . 'COST' . $RapCost . 'RAP' . $rap->id,
                    "parent" => $wbs_code,
                    "text" => $rap->number . ' - <b>Rp.' . number_format($RapCost) . '</b>',
                    "icon" => "fa fa-money"
                ]);
            }
        }

        foreach ($costs as $cost) {
            if ($cost->wbs_id == null) {
                $data->push([
                    "id" => 'COST' . $cost->id,
                    "parent" => $project->number,
                    "text" => 'Other Cost - <b>Rp.' . number_format($cost->plan_cost) . '</b>',
                    "icon" => "fa fa-money"
                ]);
            } else {
                $data->push([
                    "id" => 'COST' . $cost->id,
                    "parent" => $cost->wbs->code,
                    "text" => 'Other Cost - <b>Rp.' . number_format($cost->plan_cost) . '</b>',
                    "icon" => "fa fa-money"
                ]);
            }
        }
        return view('rap.viewPlannedCost', compact('project', 'costs', 'data', 'route'));
    }


    public function viewPlannedCostRepair(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::findOrFail($id);
        $wbss = $project->wbss;
        $costs = Cost::where('project_id', $id)->get();
        $raps = Rap::where('project_id', $id)->get();
        $total_cost_project = 0;

        $material_cost_project = 0;
        $service_cost_project = 0;
        $resource_cost_project = 0;
        $other_cost_project = 0;

        foreach ($costs as $cost) {
            $total_cost_project += $cost->plan_cost;
        }

        $data = Collection::make();

        foreach ($wbss as $wbs) {
            $TempwbsCost = 0;
            $wbsCost = Collection::make();
            self::getWbsCostRepair($wbs, $TempwbsCost, $costs, $wbsCost);
            $total_cost = 0;
            $material_cost = 0;
            $service_cost = 0;
            $resource_cost = 0;
            $other_cost = 0;
            foreach ($wbsCost as $cost) {
                $total_cost += $cost['wbs_cost'];
                $material_cost += $cost['material_cost'];
                $service_cost += $cost['service_cost'];
                $resource_cost += $cost['resource_cost'];
                $other_cost += $cost['other_cost'];
            }

            if ($wbs->wbs) {
                $data->push([
                    "id" => $wbs->code,
                    "parent" => $wbs->wbs->code,
                    "text" => $wbs->number . ' - ' . $wbs->description . ' <b>| Sub Total Cost : Rp.' . number_format($total_cost, 2) . '</b>'
                    . ' <b>| Material Cost : Rp.' . number_format($material_cost, 2) . '</b>'
                    . ' <b>| Service Cost : Rp.' . number_format($service_cost, 2) . '</b>'
                    . ' <b>| Resource Cost : Rp.' . number_format($resource_cost, 2) . '</b>'
                    . ' <b>| Other Cost : Rp.' . number_format($other_cost, 2) . '</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            } else {
                $total_cost_project += $total_cost;
                $material_cost_project += $material_cost;
                $service_cost_project += $service_cost;
                $resource_cost_project += $resource_cost;
                $other_cost_project += $other_cost;

                $data->push([
                    "id" => $wbs->code,
                    "parent" => $project->number,
                    "text" => $wbs->number . ' - ' . $wbs->description . ' <b>| Sub Total Cost : Rp.' . number_format($total_cost, 2) . '</b>'
                    . ' <b>| Material Cost : Rp.' . number_format($material_cost, 2) . '</b>'
                    . ' <b>| Service Cost : Rp.' . number_format($service_cost, 2) . '</b>'
                    . ' <b>| Resource Cost : Rp.' . number_format($resource_cost, 2) . '</b>'
                    . ' <b>| Other Cost : Rp.' . number_format($other_cost, 2) . '</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }
        }

        foreach ($costs as $cost) {
            if ($cost->wbs_id == null) {
                $data->push([
                    "id" => 'COST' . $cost->id,
                    "parent" => $project->number,
                    "text" => 'Other Cost - <b>Rp.' . number_format($cost->plan_cost, 2) . '</b>',
                    "icon" => "fa fa-money"
                ]);
            } else {
                $data->push([
                    "id" => 'COST' . $cost->id,
                    "parent" => $cost->wbs->code,
                    "text" => 'Other Cost - <b>Rp.' . number_format($cost->plan_cost, 2) . '</b>',
                    "icon" => "fa fa-money"
                ]);
            }
        }

        $data->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name . ' <b>| Total Cost : Rp.' . number_format($total_cost_project, 2) . '</b>',
            "icon" => "fa fa-ship"
        ]);
        return view('rap.viewPlannedCost', compact('project', 'costs', 'data', 'route'));
    }

    public function getWbsCost($wbs, $wbsCost, $raps, $costs, $finalCost)
    {
        if (count($wbs->wbss) > 0) {
            $RapCost = 0;
            foreach ($raps as $rap) {
                if ($rap->bom->wbs_id == $wbs->id) {
                    $RapCost += $rap->total_price;
                }
            }
            $otherCost = 0;
            foreach ($costs as $cost) {
                if ($cost->wbs_id == $wbs->id) {
                    $otherCost += $cost->plan_cost;
                }
            }
            $wbsCost = $RapCost + $otherCost;
            $finalCost->push($wbsCost);
            foreach ($wbs->wbss as $wbs) {
                self::getWbsCost($wbs, $wbsCost, $raps, $costs, $finalCost);
            }
        } else {
            $RapCost = 0;
            foreach ($raps as $rap) {
                if ($rap->bom->wbs_id == $wbs->id) {
                    $RapCost += $rap->total_price;
                }
            }

            $otherCost = 0;
            foreach ($costs as $cost) {
                if ($cost->wbs_id == $wbs->id) {
                    $otherCost += $cost->plan_cost;
                }
            }
            $wbsCost = $RapCost + $otherCost;
            $finalCost->push($wbsCost);
        }
    }

    public function getWbsCostRepair($wbs, $wbsCost, $costs, $finalCost)
    {
        if (count($wbs->wbss) > 0) {
            $materialCost = 0;
            if (count($wbs->wbsMaterials) > 0) {
                foreach ($wbs->wbsMaterials as $wbsMaterial) {
                    if ($wbsMaterial->weight != null) {
                        $price_per_kg = $wbsMaterial->material->cost_standard_price_per_kg;
                        $materialCost += $price_per_kg * $wbsMaterial->weight;
                    } else {
                        $price = $wbsMaterial->material->cost_standard_price;
                        $materialCost += $price * $wbsMaterial->quantity;
                    }
                }
            }

            $otherCost = 0;
            foreach ($costs as $cost) {
                if ($cost->wbs_id == $wbs->id) {
                    $otherCost += $cost->plan_cost;
                }
            }

            $serviceCost = 0;
            if($wbs->service_detail_id != null){
                $serviceCost = $wbs->serviceDetail->cost_standard_price * $wbs->area;
            }

            $resourceCost = 0;
            if(count($wbs->resourceTrxs) > 0){
                foreach ($wbs->resourceTrxs as $resourceTrx) {
                    $resourceCost += $resourceTrx->quantity * $resourceTrx->resource->cost_standard_price;
                }
            }

            $wbsCost = $materialCost + $otherCost + $serviceCost + $resourceCost;
            $temp_cost = [];
            $temp_cost['wbs_cost'] = $wbsCost;
            $temp_cost['material_cost'] = $materialCost;
            $temp_cost['service_cost'] = $serviceCost;
            $temp_cost['resource_cost'] = $resourceCost;
            $temp_cost['other_cost'] = $otherCost;

            $finalCost->push($temp_cost);
            foreach ($wbs->wbss as $wbs) {
                self::getWbsCostRepair($wbs, $wbsCost, $costs, $finalCost);
            }
        } else {
            $materialCost = 0;
            if (count($wbs->wbsMaterials) > 0) {
                foreach ($wbs->wbsMaterials as $wbsMaterial) {
                    if ($wbsMaterial->weight != null) {
                        $price_per_kg = $wbsMaterial->material->cost_standard_price_per_kg;
                        $materialCost += $price_per_kg * $wbsMaterial->weight;
                    } else {
                        $price = $wbsMaterial->material->cost_standard_price;
                        $materialCost += $price * $wbsMaterial->quantity;
                    }
                }
            }

            $otherCost = 0;
            foreach ($costs as $cost) {
                if ($cost->wbs_id == $wbs->id) {
                    $otherCost += $cost->plan_cost;
                }
            }

            $serviceCost = 0;
            if($wbs->service_detail_id != null){
                $serviceCost = $wbs->serviceDetail->cost_standard_price * $wbs->area;
            }

            $resourceCost = 0;
            if(count($wbs->resourceTrxs) > 0){
                foreach ($wbs->resourceTrxs as $resourceTrx) {
                    $resourceCost += $resourceTrx->quantity * $resourceTrx->resource->cost_standard_price;
                }
            }
            $wbsCost = $materialCost + $otherCost + $serviceCost + $resourceCost;
            $temp_cost = [];
            $temp_cost['wbs_cost'] = $wbsCost;
            $temp_cost['material_cost'] = $materialCost;
            $temp_cost['service_cost'] = $serviceCost;
            $temp_cost['resource_cost'] = $resourceCost;
            $temp_cost['other_cost'] = $otherCost;

            $finalCost->push($temp_cost);
        }
    }

    public function storeCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $cost = new Cost;
            $cost->description = $data['description'];
            $cost->plan_cost = $data['cost'];
            if ($data['wbs_id'] != "") {
                $cost->wbs_id = $data['wbs_id'];
            }
            $cost->project_id = $data['project_id'];

            $cost->user_id = Auth::user()->id;
            $cost->branch_id = Auth::user()->branch->id;
            $cost->cost_type = $data['cost_type'];

            if (!$cost->save()) {
                return response(["error" => "Failed to save, please try again!"], Response::HTTP_OK);
            } else {
                DB::commit();
                return response(["response" => "Success to create new cost"], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error" => $e->getMessage()], Response::HTTP_OK);
        }
    }

    public function storeActualCost(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $cost = Cost::find($data['cost_id']);
            $cost->actual_cost = $data['actual_cost'];
            if (!$cost->update()) {
                return response(["error" => "Failed to save, please try again!"], Response::HTTP_OK);
            } else {
                DB::commit();
                return response(["response" => "Success to Update Cost"], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error" => $e->getMessage()], Response::HTTP_OK);
        }
    }

    public function storeAssignCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $modelCost = Cost::findOrFail($data['cost_id']);
            if ($data['wbs_id'] == "") {
                $modelCost->wbs_id = null;
            } else {
                $modelCost->wbs_id = $data['wbs_id'];
            }
            if (!$modelCost->save()) {
                return redirect()->route('rap.assignCost')->with('error', 'Failed to save, please try again !');
            } else {
                DB::commit();
                return response(json_encode($modelCost), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rap.assignCost')->with('error', $e->getMessage());
        }
    }

    public function updateCost(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $cost = Cost::find($id);
            $cost->description = $data['description'];
            $cost->plan_cost = $data['cost'];
            if ($data['wbs_id'] == "") {
                $cost->wbs_id = null;
            } else {
                $cost->wbs_id = $data['wbs_id'];
            }
            $cost->project_id = $data['project_id'];
            $cost->cost_type = $data['cost_type'];

            if (!$cost->update()) {
                return response(["error" => "Failed to save, please try again!"], Response::HTTP_OK);
            } else {
                DB::commit();
                return response(["response" => "Success to Update Cost"], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error" => $e->getMessage()], Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $rap_number = self::generateRapNumber();

        DB::beginTransaction();
        try {
            $rap = new Rap;
            $rap->number = $rap_number;
            $rap->project_id = $datas->project->id;
            $rap->user_id = Auth::user()->id;
            $rap->branch_id = Auth::user()->branch->id;
            $rap->save();

            self::saveRapDetail($rap->id, $datas->checkedBoms);
            $total_price = self::calculateTotalPrice($rap->id);

            $modelRap = Rap::findOrFail($rap->id);
            $modelRap->total_price = $total_price;
            $modelRap->save();

            self::updateStatusBom($datas->checkedBoms);
            self::checkstock($datas->checkedBoms);
            DB::commit();
            return redirect()->route('rap.show', ['id' => $rap->id])->with('success', 'RAP Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rap.selectProject')->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelRap = Rap::find($id);
        if ($route == "/rap") {
            if ($modelRap) {
                if ($modelRap->project->business_unit_id == 1) {
                    return view('rap.show', compact('modelRap', 'route'));
                } else {
                    return redirect()->route('rap.indexSelectProject')->with('error', 'RAP isn\'t exist, Please try again !');
                }
            } else {
                return redirect()->route('rap.indexSelectProject')->with('error', 'RAP isn\'t exist, Please try again !');
            }
        } elseif ($route == "/rap_repair") {
            $modelRapDetails = $modelRap->rapDetails;
            $wbss = $modelRap->project->wbss->where('service_detail_id', '!=', null);
            foreach ($modelRapDetails as $rapDetail) {
                $dimensions_obj = json_decode($rapDetail->dimensions_value);
                $dimensions_string = "-";
                if($dimensions_obj != null){
                    foreach ($dimensions_obj as $dimension) {
                        $uom = Uom::find($dimension->uom_id);
                        if($dimensions_string == "-"){
                            $dimensions_string = $dimension->value_input." ".$uom->unit; 
                        }else{
                            $dimensions_string .= " x ".$dimension->value_input." ".$uom->unit; 
                        }
                    }
                }
                $rapDetail->dimensions_string = $dimensions_string;
            }
            if ($modelRap) {
                if ($modelRap->project->business_unit_id == 2) {
                    return view('rap.show', compact('modelRap', 'modelRapDetails', 'route', 'wbss'));
                } else {
                    return redirect()->route('rap_repair.indexSelectProject')->with('error', 'RAP isn\'t exist, Please try again !');
                }
            } else {
                return redirect()->route('rap_repair.indexSelectProject')->with('error', 'RAP isn\'t exist, Please try again !');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $modelRap = Rap::findOrFail($id);
        $modelRAPD = RapDetail::where('rap_id', $modelRap->id)->with('bom', 'material', 'service', 'material.uom')->get();
        $modelBOM = Bom::where('id', $modelRap->bom_id)->first();
        $project = Project::where('id', $modelRap->project_id)->first();
        $route = $request->route()->getPrefix();

        if ($route == "/rap") {
            return view('rap.edit', compact('modelRap', 'project', 'modelRAPD', 'modelBOM'));
        } elseif ($route == "/rap_repair") {
            return view('rap.editRepair', compact('modelRap', 'project', 'modelRAPD', 'modelBOM'));
        }
    }

    public function update(Request $request, $id)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                $modelRAPD = RapDetail::findOrFail($data->id);
                $modelRAPD->price = str_replace(',', '', $data->priceTotal);
                $modelRAPD->update();
            }
            $total_price = self::calculateTotalPrice($datas[0]->rap_id);

            $modelRap = Rap::findOrFail($datas[0]->rap_id);
            $modelRap->total_price = $total_price;
            $modelRap->update();

            DB::commit();
            if ($route == "/rap") {
                return redirect()->route('rap.show', ['id' => $datas[0]->rap_id])->with('success', 'RAP Updated !');
            } elseif ($route == "/rap_repair") {
                return redirect()->route('rap_repair.show', ['id' => $datas[0]->rap_id])->with('success', 'RAP Updated !');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($route == "/rap") {
                return redirect()->route('rap.indexSelectProject')->with('error', $e->getMessage());
            } elseif ($route == "/rap_repair") {
                return redirect()->route('rap_repair.indexSelectProject')->with('error', $e->getMessage());
            }
        }
    }



    public function destroy($id)
    {
        //
    }

    public function deleteOtherCost(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $otherCost = Cost::find($id);
            $otherCost->delete();
            DB::commit();
            if ($route == "/rap") {
                return response(["response" => "Successfully deleted other cost."], Response::HTTP_OK);
            } elseif ($route == "/rap_repair") {
                return response(["response" => "Successfully deleted other cost."], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error" => $e->getMessage()], Response::HTTP_OK);
        }
    }

    // Function
    public function getCostsApproved($project_id)
    {
        $costs = Cost::where('project_id', $project_id)->with('wbs')->where('status', 2)->get()->jsonSerialize();
        return response($costs, Response::HTTP_OK);
    }
    public function getCostsPlanned($project_id)
    {
        $costs = Cost::where('project_id', $project_id)->with('wbs')->where('status', 1)->get()->jsonSerialize();
        return response($costs, Response::HTTP_OK);
    }

    public function getCosts($project_id)
    {
        $costs = Cost::where('project_id', $project_id)->with('wbs')->get()->jsonSerialize();
        return response($costs, Response::HTTP_OK);
    }

    public function checkStock($bom_ids)
    {
        $datas = [];

        foreach ($bom_ids as $bom_id) {
            $modelBom = Bom::findOrFail($bom_id);
            foreach ($modelBom->bomDetails as $bomDetail) {
                $data = new \stdClass();
                $data->bomDetail = $bomDetail;
                array_push($datas, $data);
            }
        }
        // create PR (optional)
        foreach ($datas as $data) {
            $modelStock = Stock::where('material_id', $data->bomDetail->material_id)->first();
            $status = 0;
            $project_id = $data->bomDetail->bom->project_id;
            if (!isset($modelStock)) {
                $status = 1;
            } else {
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if ($remaining < $data->bomDetail->quantity) {
                    $status = 1;
                }
            }
        }
        if ($status == 1) {
            $pr_number = $this->pr->generatePRNumber();
            $current_date = today();
            $valid_to = $current_date->addDays(7);
            $valid_to = $valid_to->toDateString();
            $modelProject = Project::findOrFail($project_id);

            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->valid_date = $valid_to;
            $PR->project_id = $project_id;
            $PR->description = 'AUTO PR FOR ' . $modelProject->code;
            $PR->status = 1;
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();
        }

        // reservasi & PR Detail
        foreach ($datas as $data) {
            $modelStock = Stock::where('material_id', $data->bomDetail->material_id)->first();

            if (isset($modelStock)) {
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if ($remaining < $data->bomDetail->quantity) {
                    $PRD = new PurchaseRequisitionDetail;
                    $PRD->purchase_requisition_id = $PR->id;
                    $PRD->material_id = $data->bomDetail->material_id;
                    $PRD->wbs_id = $data->bomDetail->bom->wbs_id;
                    $PRD->quantity = $data->bomDetail->quantity;
                    $PRD->save();
                }
                $modelStock->reserved += $data->bomDetail->quantity;
                $modelStock->updated_at = Carbon::now();
                $modelStock->save();
            } else {
                $PRD = new PurchaseRequisitionDetail;
                $PRD->purchase_requisition_id = $PR->id;
                $PRD->material_id = $data->bomDetail->material_id;
                $PRD->wbs_id = $data->bomDetail->bom->wbs_id;
                $PRD->quantity = $data->bomDetail->quantity;
                $PRD->save();

                $modelStock = new Stock;
                $modelStock->material_id = $data->bomDetail->material_id;
                $modelStock->quantity = 0;
                $modelStock->reserved = $data->bomDetail->quantity;
                $modelStock->branch_id = Auth::user()->branch->id;
                $modelStock->save();
            }
        }
    }

    public function saveRapDetail($rap_id, $boms)
    {
        foreach ($boms as $bom) {
            $modelBom = Bom::findOrFail($bom);
            foreach ($modelBom->bomDetails as $bomDetail) {
                $rap_detail = new RapDetail;
                $rap_detail->rap_id = $rap_id;
                $rap_detail->bom_id = $bomDetail->bom_id;
                $rap_detail->material_id = $bomDetail->material_id;
                $rap_detail->quantity = $bomDetail->quantity;
                $rap_detail->price = $bomDetail->quantity * $bomDetail->material->cost_standard_price;
                $rap_detail->save();
            }
        }
    }

    public function calculateTotalPrice($id)
    {
        $modelRap = Rap::findOrFail($id);
        $total_price = 0;
        foreach ($modelRap->RapDetails as $RapDetail) {
            $total_price += $RapDetail->price;
        }
        return $total_price;
    }

    public function updateStatusBom($bom_ids)
    {
        foreach ($bom_ids as $bom_id) {
            $modelBom = Bom::findOrFail($bom_id);
            $modelBom->status = 2;
            $modelBom->save();
        }
    }

    private function generateRapNumber()
    {
        $modelRap = Rap::orderBy('created_at', 'desc')->where('branch_id', Auth::user()->branch_id)->first();

        $number = 1;
        if (isset($modelRap)) {
            $number += intval(substr($modelRap->number, -6));
        }
        $year = date('y00000');
        $year = intval($year);

        $rap_number = $year + $number;
        print_r($rap_number);
        exit();
        $rap_number = 'RAP-' . $rap_number;
        return $rap_number;
    }

    public function getNewCostAPI($id)
    {
        return response(Cost::where('project_id', $id)->with('wbs')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllWbssCostAPI($project_id)
    {
        $works = WBS::orderBy('planned_end_date', 'asc')->where('project_id', $project_id)->get()->jsonSerialize();
        return response($works, Response::HTTP_OK);
    }





    // view RAP repair
    public function indexSelectProjectRepair(Request $request)
    {
        $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        $menu = "view_rap";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // create cost repair
    public function selectProjectCostRepair(Request $request)
    {
        $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        $menu = "create_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // input actual other cost repair
    public function selectProjectActualOtherCostRepair(Request $request)
    {
        $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        $menu = "input_actual_other_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // view planned cost repair
    public function selectProjectViewCostRepair(Request $request)
    {
        $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        $menu = "view_planned_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }

    // view planned cost repair
    public function selectProjectViewRMRepair(Request $request)
    {
        $projects = Project::where('status', 1)->where('business_unit_id', 2)->get();
        $menu = "view_rm";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects', 'menu', 'route'));
    }
}
