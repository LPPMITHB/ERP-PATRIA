<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Work;
use App\Models\Project;
use App\Models\Stock;
use Auth;
use DB;

class MaterialRequisitionController extends Controller
{

    public function index()
    {
        $modelMRs = MaterialRequisition::all();

        return view('material_requisition.index', compact('modelMRs'));
    }

    public function indexApprove()
    {
        $modelMRs = MaterialRequisition::where('status',1)->get();

        return view('material_requisition.indexApprove', compact('modelMRs'));
    }
    
    public function create()
    {
        $modelMaterial = Material::all()->jsonSerialize();
        $modelProject = Project::where('status',1)->get();

        return view('material_requisition.create', compact('modelMaterial','modelProject'));
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);

        $mr_number = $this->generateMRNumber();

        DB::beginTransaction();
        try {
            $MR = new MaterialRequisition;
            $MR->number = $mr_number;
            $MR->project_id = $datas->project_id;
            $MR->description = $datas->description;
            $MR->status = 1;
            $MR->type = 1;
            $MR->user_id = Auth::user()->id;
            $MR->branch_id = Auth::user()->branch->id;
            $MR->save();

            foreach($datas->materials as $data){
                $MRD = new MaterialRequisitionDetail;
                $MRD->material_requisition_id = $MR->id;
                $MRD->quantity = $data->quantityInt;
                $MRD->material_id = $data->material_id;
                $MRD->wbs_id = $data->wbs_id;
                $MRD->save();

                $this->reserveStock($data->material_id, $data->quantityInt);
            }
            DB::commit();
            return redirect()->route('material_requisition.show',$MR->id)->with('success', 'Material Requisition Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material_requisition.create')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $modelMR = MaterialRequisition::findOrFail($id);

        return view('material_requisition.show', compact('modelMR'));
    }

    public function showApprove($id)
    {
        $modelMR = MaterialRequisition::findOrFail($id);

        return view('material_requisition.showApprove', compact('modelMR'));
    }

    // function
    public function reserveStock($material_id,$quantity){
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $quantity;
            $modelStock->save();
        }
    }

    public function generateMRNumber(){
        $modelMR = MaterialRequisition::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelMR)){
            $number += intval(substr($modelMR->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$mr_number = $year+$number;
        $mr_number = 'MR-'.$mr_number;
		return $mr_number;
    }

    //API
    public function getWorkAPI($id){
        return response(Work::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }
}
