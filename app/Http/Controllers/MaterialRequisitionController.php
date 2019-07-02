<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\WBS;
use App\Models\Bom;
use App\Models\Project;
use App\Models\Stock;
use Illuminate\Support\Collection;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use App\Providers\numberConverter;

class MaterialRequisitionController extends Controller
{

    public function index(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('business_unit_id',2)->pluck('id')->toArray();
        }elseif($menu == "building"){
            $modelProject = Project::where('business_unit_id',1)->pluck('id')->toArray();
        }

        $modelMRs = MaterialRequisition::whereIn('project_id',$modelProject)->get();

        return view('material_requisition.index', compact('modelMRs','menu'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }
        $modelMRs = MaterialRequisition::whereIn('status',[1,4])->whereIn('project_id',$modelProject)->get();

        return view('material_requisition.indexApprove', compact('modelMRs','menu'));
    }
    
    public function create(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }    

        $stocks = Stock::all();
        foreach($stocks as $stock){
            $stock['available'] = $stock->quantity - $stock->reserved;
        }
        return view('material_requisition.create', compact('modelProject','menu','stocks'));
    }

    public function createRepair(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }    

        $stocks = Stock::all();
        foreach($stocks as $stock){
            $stock['available'] = $stock->quantity - $stock->reserved;
        }
        return view('material_requisition.createRepair', compact('modelProject','menu','stocks'));
    }

    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $mr_number = $this->generateMRNumber();

        DB::beginTransaction();
        try {
            $MR = new MaterialRequisition;
            $MR->number = $mr_number;
            $MR->project_id = $datas->project_id;
            $MR->description = $datas->description;
            $MR->status = 1;
            $MR->type = 0;
            $MR->user_id = Auth::user()->id;
            $MR->branch_id = Auth::user()->branch->id;
            $MR->save();

            foreach($datas->materials as $data){
                $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$MR->id)->get();
                if(count($modelMRDs)>0){
                    $status = 0;
                    foreach($modelMRDs as $MRD){
                        if($MRD->material_id == $data->material_id && $MRD->wbs_id == $data->wbs_id){
                            $updatedQty = $MRD->quantity + $data->quantityFloat;
                            $this->updateReserveStock($data->material_id, $MRD->quantity ,$updatedQty);
                            $MRD->quantity = $updatedQty;
                            $MRD->update();

                            $status = 1;
                        }
                    }
                    if($status == 0){
                        $MRD = new MaterialRequisitionDetail;
                        $MRD->material_requisition_id = $MR->id;
                        $MRD->quantity = $data->quantityFloat;
                        $MRD->material_id = $data->material_id;
                        $MRD->wbs_id = $data->wbs_id;
                        $MRD->save();

                        $this->reserveStock($data->material_id, $data->quantityFloat);
                    }
                }else{
                    $MRD = new MaterialRequisitionDetail;
                    $MRD->material_requisition_id = $MR->id;
                    $MRD->quantity = $data->quantityFloat;
                    $MRD->material_id = $data->material_id;
                    $MRD->wbs_id = $data->wbs_id;
                    $MRD->save();

                    $this->reserveStock($data->material_id, $data->quantityFloat);
                }
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_requisition.show',$MR->id)->with('success', 'Material Requisition Created');
            }elseif($menu == "repair"){
                return redirect()->route('material_requisition_repair.show',$MR->id)->with('success', 'Material Requisition Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_requisition.create')->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('material_requisition_repair.create')->with('error', $e->getMessage());
            }
        }
    }

    public function show($id,Request $request)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    

        return view('material_requisition.show', compact('modelMR','menu'));
    }

    public function showApprove($id, Request $request)
    {
        $route = $request->route()->getPrefix();

        $modelMR = MaterialRequisition::findOrFail($id);
        if($modelMR->status == 1){
            $status = 'OPEN';
        }
        elseif($modelMR->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelMR->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelMR->status == 4){
            $status = 'REVISED';
        }
        elseif($modelMR->status == 5){
            $status = 'REJECTED';
        }
        elseif($modelMR->status == 0 || $modelMR->status == 7){
            $status = 'ORDERED';
        }
        elseif($modelMR->status == 6){
            $status = 'CONSOLIDATED';
        }
        $modelMRD = $modelMR->materialRequisitionDetails;
        foreach($modelMRD as $MRD){
            $issued = MaterialRequisitionDetail::where('material_id',$MRD->material_id)->where('wbs_id',$MRD->wbs_id)->get()->sum('issued');
            if($route == "/material_requisition"){
                $MRD['planned_quantity'] = $MRD->wbs != null ? $MRD->wbs->bom->bomDetails->where('material_id',$MRD->material_id)->first()->quantity : "-";
            }else{
                $MRD['planned_quantity'] = "-";
            }
            $MRD['issued'] = $issued;
        }

        return view('material_requisition.showApprove', compact('status','modelMR','route','modelMRD'));
    }

    public function edit($id, Request $request)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
        $modelMaterial = Material::all()->jsonSerialize();
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = $modelMR->project->with('ship','customer','wbss')->where('business_unit_id',2)->first()->jsonSerialize();
        }elseif($menu == "building"){
            $modelProject = $modelMR->project->with('ship','customer','wbss')->where('business_unit_id',1)->first()->jsonSerialize();
        }
        $modelWBS = $modelMR->project->wbss; 
        $modelMRD = Collection::make();
        foreach($modelMR->MaterialRequisitionDetails as $mrd){
            if($mrd->material->uom->is_decimal == 1){
                $modelMRD->push([
                    "mrd_id" => $mrd->id,
                    "material_id" => $mrd->material_id,
                    "material_code" => $mrd->material->code,
                    "material_description" => $mrd->material->description,
                    "planned_quantity" => number_format($mrd->wbs->bom->bomDetails->where('material_id', $mrd->material_id)->first()->quantity,2),
                    "quantity" => number_format($mrd->quantity,2),
                    "quantityFloat" => $mrd->quantity,
                    "wbs_id" => $mrd->wbs_id,
                    "wbs_number" => $mrd->wbs->number,
                    "wbs_description" => $mrd->wbs->description,
                    "availableStr" => "-",
                    "is_decimal" => true,
                    "unit" => $mrd->material->uom->unit,
                ]);
            }else{
                $modelMRD->push([
                    "mrd_id" => $mrd->id,
                    "material_id" => $mrd->material_id,
                    "material_code" => $mrd->material->code,
                    "material_description" => $mrd->material->description,
                    "planned_quantity" => number_format($mrd->wbs->bom->bomDetails->where('material_id', $mrd->material_id)->first()->quantity),
                    "quantity" => number_format($mrd->quantity),
                    "quantityFloat" => $mrd->quantity,
                    "wbs_id" => $mrd->wbs_id,
                    "wbs_number" => $mrd->wbs->number,
                    "wbs_description" => $mrd->wbs->description,
                    "availableStr" => "-",
                    "is_decimal" => false,
                    "unit" => $mrd->material->uom->unit,
                ]);
            }
        }

        $stocks = Stock::all();
        foreach($stocks as $stock){
            $stock['available'] = $stock->quantity - $stock->reserved;
        }
        return view('material_requisition.edit', compact('menu','modelMR','modelMRD','modelMaterial','modelProject','modelWBS','stocks'));
    }

    public function editRepair($id, Request $request)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
        $modelMaterial = Material::all()->jsonSerialize();
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $modelProject = $modelMR->project->with('ship','customer','wbss')->where('id',$modelMR->project_id)->first()->jsonSerialize();
        $modelWBS = $modelMR->project->wbss; 
        $modelMRD = Collection::make();
        foreach($modelMR->MaterialRequisitionDetails as $mrd){
            if($mrd->material->uom->is_decimal == 1){
                $modelMRD->push([
                    "mrd_id" => $mrd->id,
                    "material_id" => $mrd->material_id,
                    "material_code" => $mrd->material->code,
                    "material_description" => $mrd->material->description,
                    "planned_quantity" => number_format($mrd->wbs->project->boms[0]->bomDetails->where('material_id', $mrd->material_id)->first()->quantity,2),
                    "quantity" => number_format($mrd->quantity,2),
                    "quantityFloat" => $mrd->quantity,
                    "wbs_id" => $mrd->wbs_id,
                    "wbs_number" => $mrd->wbs->number,
                    "wbs_description" => $mrd->wbs->description,
                    "availableStr" => "-",
                    "is_decimal" => true,
                    "unit" => $mrd->material->uom->unit,
                ]);
            }else{
                $modelMRD->push([
                    "mrd_id" => $mrd->id,
                    "material_id" => $mrd->material_id,
                    "material_code" => $mrd->material->code,
                    "material_description" => $mrd->material->description,
                    "planned_quantity" => number_format($mrd->wbs->project->boms[0]->bomDetails->where('material_id', $mrd->material_id)->first()->quantity),
                    "quantity" => number_format($mrd->quantity),
                    "quantityFloat" => $mrd->quantity,
                    "wbs_id" => $mrd->wbs_id,
                    "wbs_number" => $mrd->wbs->number,
                    "wbs_description" => $mrd->wbs->description,
                    "availableStr" => "-",
                    "is_decimal" => false,
                    "unit" => $mrd->material->uom->unit,
                ]);
            }
        }

        $stocks = Stock::all();
        foreach($stocks as $stock){
            $stock['available'] = $stock->quantity - $stock->reserved;
        }
        return view('material_requisition.editRepair', compact('menu','modelMR','modelMRD','modelMaterial','modelProject','modelWBS','stocks'));
    }


    public function update(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $MR = MaterialRequisition::find($id);
            foreach($datas->deleted_mrd as $id){
                $modelPRD = MaterialRequisitionDetail::findOrFail($id);
                $this->deleteReserveStock($modelPRD);
                $modelPRD->delete();
            }
            $MR->description = $datas->description;
            if($MR->status == 3){
                $MR->status = 4;
            }
            $MR->update();

            foreach($datas->materials as $data){
                if($data->mrd_id != null){
                    $MRD = MaterialRequisitionDetail::find($data->mrd_id);
                    $this->updateReserveStock($data->material_id, $MRD->quantity ,$data->quantityFloat);
                    
                    $MRD->quantity = $data->quantityFloat;
                    $MRD->wbs_id = $data->wbs_id;
                    $MRD->update();
                }else{
                    $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$MR->id)->get();
                    if(count($modelMRDs)>0){
                        $status = 0;
                        foreach($modelMRDs as $MRD){
                            if($MRD->material_id == $data->material_id && $MRD->wbs_id == $data->wbs_id){
                                $updatedQty = $MRD->quantity + $data->quantityFloat;
                                $this->updateReserveStock($data->material_id, $MRD->quantity ,$updatedQty);
                                $MRD->quantity = $updatedQty;
                                $MRD->update();
    
                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $MRD = new MaterialRequisitionDetail;
                            $MRD->material_requisition_id = $MR->id;
                            $MRD->quantity = $data->quantityFloat;
                            $MRD->material_id = $data->material_id;
                            $MRD->wbs_id = $data->wbs_id;
                            $MRD->save();
    
                            $this->reserveStock($data->material_id, $data->quantityFloat);
                        }
                    }else{
                        $MRD = new MaterialRequisitionDetail;
                        $MRD->material_requisition_id = $MR->id;
                        $MRD->quantity = $data->quantityFloat;
                        $MRD->material_id = $data->material_id;
                        $MRD->wbs_id = $data->wbs_id;
                        $MRD->save();
    
                        $this->reserveStock($data->material_id, $data->quantityFloat);
                    }
                }


            }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_requisition.show',$MR->id)->with('success', 'Material Requisition Updated');
            }elseif($menu == "repair"){
                return redirect()->route('material_requisition_repair.show',$MR->id)->with('success', 'Material Requisition Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_requisition.edit',$MR->id)->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('material_requisition_repair.edit',$MR->id)->with('error', $e->getMessage());
            }
        }
    }

    public function approval(Request $request){
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelMR = MaterialRequisition::findOrFail($datas->mr_id);
            if($datas->status == "approve"){
                $modelMR->status = 2;
                $modelMR->revision_description = $datas->desc;
                $modelMR->approved_by = Auth::user()->id;
                $modelMR->approval_date = Carbon::now();
                $modelMR->update();
                DB::commit();
                if($route == "/material_requisition"){
                    return redirect()->route('material_requisition.show',$datas->mr_id)->with('success', 'Material Requisition Approved');
                }elseif($route == "/material_requisition_repair"){
                    return redirect()->route('material_requisition_repair.show',$datas->mr_id)->with('success', 'Material Requisition Approved');
                }
            }elseif($datas->status == "need-revision"){
                $modelMR->status = 3;
                $modelMR->revision_description = $datas->desc;
                $modelMR->approved_by = Auth::user()->id;
                $modelMR->update();
                DB::commit();
                if($route == "/material_requisition"){
                    return redirect()->route('material_requisition.show',$datas->mr_id)->with('success', 'Material Requisition Need Revision');
                }elseif($route == "/material_requisition_repair"){
                    return redirect()->route('material_requisition_repair.show',$datas->mr_id)->with('success', 'Material Requisition Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelMR->status = 5;
                $modelMR->revision_description = $datas->desc;
                $modelMR->approved_by = Auth::user()->id;
                $modelMR->approval_date = Carbon::now();
                $mrds = $modelMR->materialRequisitionDetails;
                foreach ($mrds as $mrd) {
                    $stock = Stock::where('material_id',$mrd->material_id)->first();
                    $stock->reserved -= $mrd->quantity;
                    $stock->update();
                }
                $modelMR->update();
                DB::commit();
                if($route == "/material_requisition"){
                    return redirect()->route('material_requisition.show',$datas->mr_id)->with('success', 'Material Requisition Rejected');
                }elseif($route == "/material_requisition_repair"){
                    return redirect()->route('material_requisition_repair.show',$datas->mr_id)->with('success', 'Material Requisition Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('material_requisition.show',$datas->mr_id)->with('error', $e->getMessage());
        }
    }

    // function
    public function reserveStock($material_id,$quantity){
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $quantity;
            $modelStock->save();
        }
    }

    public function updateReserveStock($material_id,$oldQty, $newQty){
        $difference = $newQty - $oldQty;
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $difference;
            $modelStock->save();
        }
    }

    public function deleteReserveStock($modelPRD){
        $modelStock = Stock::where('material_id',$modelPRD->material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved - $modelPRD->quantity;
            $modelStock->update();
        }
    }

    public function printPdf($id, Request $request)
    {
        $modelMR = MaterialRequisition::find($id);
        $branch = Auth::user()->branch;
        $route = $request->route()->getPrefix();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('material_requisition.pdf',['modelMR' => $modelMR, 'branch' => $branch,'route'=> $route]);
        $now = date("Y_m_d_H_i_s");
        return $pdf->stream('Material_Requisition_'.$now.'.pdf');
    }

    public function generateMRNumber(){
        $modelMR = MaterialRequisition::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelMR)){
            $yearDoc = substr($modelMR->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelMR->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$mr_number = $year+$number;
        $mr_number = 'MR-'.$mr_number;
        
        return $mr_number;
    }

    //API
    public function getWbsAPI($id){
        $data = array();

        $wbs = WBS::findOrFail($id);
        if($wbs->bom != null){
            $material_ids = $wbs->bom->bomDetails->pluck('material_id')->toArray();
            $data['materials'] = Material::whereIn('id',$material_ids)->get();
        }else{
            $data['materials'] = [];
        }

        $data['wbs'] = $wbs->jsonSerialize();

        return response($data, Response::HTTP_OK);
    }

    public function getWbsEditAPI($id, $mr_id){
        $data = array();
        $mrds = MaterialRequisition::find($mr_id)->MaterialRequisitionDetails;
        $exisiting_material = $mrds->where('wbs_id',$id)->pluck('material_id')->toArray();

        $wbs = WBS::findOrFail($id);
        if($wbs->bom != null){
            $material_ids = $wbs->bom->bomDetails->pluck('material_id')->toArray();
            $data['materials'] = Material::whereIn('id',$material_ids)->whereNotIn('id', $exisiting_material)->get();
        }else{
            $data['materials'] = [];
        }

        $data['wbs'] = $wbs->jsonSerialize();

        return response($data, Response::HTTP_OK);
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','wbss','boms.bomDetails.material')->first()->jsonSerialize();
        return response($project, Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getStockAPI($id){
        $stock = Stock::where('material_id',$id)->first()->jsonSerialize();
        
        return response($stock, Response::HTTP_OK);
    }

    public function getMaterialInfoAPI($id, $wbs_id)
    {
        $data = [];

        $bom = Bom::where('wbs_id',$wbs_id)->first();
        $planned_quantity = $bom->bomDetails->where('material_id', $id)->first()->quantity;

        // $stock = Stock::where('material_id',$id)->first();
        // $available = $stock->quantity - $stock->reserved;
        // if($available < 0){
        //     $available = 0;
        // }
        // $data['available'] = $available;
        $material = Material::where('id',$id)->first();
        $data['is_decimal'] = $material->uom->is_decimal == 1 ? true:false;
        $data['unit'] = $material->uom->unit;
        $data['planned_quantity'] = $planned_quantity;

        return response($data, Response::HTTP_OK);

        
    }

    public function getMaterialInfoRepairAPI($id, $project_id)
    {
        $data = [];

        $bom = Bom::where('project_id',$project_id)->first();
        $planned_quantity = $bom->bomDetails->where('material_id', $id)->first()->quantity;

        // $stock = Stock::where('material_id',$id)->first();
        // $available = $stock->quantity - $stock->reserved;
        // if($available < 0){
        //     $available = 0;
        // }
        // $data['available'] = $available;
        $material = Material::where('id',$id)->first();
        $data['is_decimal'] = $material->uom->is_decimal == 1 ? true:false;
        $data['unit'] = $material->uom->unit;
        $data['planned_quantity'] = $planned_quantity;

        return response($data, Response::HTTP_OK);

        
    }
}
