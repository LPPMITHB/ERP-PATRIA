<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Work;
use App\Models\ProductionOrder;
use App\Models\ProductionOrderDetail;
use App\Models\Bom;
use App\Models\Material;
use App\Models\Resource;
use App\Models\Stock;
use App\Models\ResourceDetail;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use Auth;
use DB;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectProject(){
        $modelProject = Project::where('status',1)->get();
        $menu = "create_po";

        return view('production_order.selectProject', compact('modelProject','menu'));
    }

    public function selectProjectRelease (){
        $modelProject = Project::where('status',1)->get();
        $menu = "release_po";

        return view('production_order.selectProject', compact('modelProject','menu'));
    }

    public function selectProjectConfirm (){
        $modelProject = Project::where('status',1)->get();
        $menu = "confirm_po";

        return view('production_order.selectProject', compact('modelProject','menu'));
    }

    public function selectProjectReport (){
        $modelProject = Project::where('status',1)->get();
        $menu = "report_po";

        return view('production_order.selectProject', compact('modelProject','menu'));
    }
    
    public function selectWBS($id){
        $modelProject = Project::findOrFail($id);
        $modelWBS = Work::where('project_id',$id)->get();

        return view('production_order.selectWBS', compact('modelWBS','modelProject'));
    }

    public function selectWO($id){
        $modelProject = Project::findOrFail($id);
        $modelPO = ProductionOrder::where('project_id',$id)->where('status',1)->get();

        return view('production_order.selectWO', compact('modelPO','modelProject'));
    }

    public function confirmWO($id){
        $modelProject = Project::findOrFail($id);
        $modelPO = ProductionOrder::where('project_id',$id)->where('status',1)->get();

        return view('production_order.confirmWO', compact('modelPO','modelProject'));
    }

    public function index()
    {
        //
    }

    public function selectWOReport($id){
        $modelProject = Project::findOrFail($id);
        $modelPO = ProductionOrder::where('project_id',$id)->where('status',1)->get();

        return view('production_order.selectWOReport', compact('modelPO','modelProject'));
    }

    public function report($id){
        $modelPO = ProductionOrder::findOrFail($id);
        $modelProject = Project::findOrFail($modelPO->project_id);
        $totalPrice = 0;
        foreach($modelPO->ProductionOrderDetails as $PO){
            if($PO->material_id != ""){
                $totalPrice += $PO->actual * $PO->material->cost_standard_price;
            }
        }
        return view('production_order.report', compact('modelPO','modelProject','totalPrice'));
    }

    public function release($id){
        $modelPO = ProductionOrder::where('id',$id)->with('project')->first();
        $modelPOD = ProductionOrderDetail::where('production_order_id',$modelPO->id)->with('material','resource','productionOrder')->get()->jsonSerialize();
        $project = Project::where('id',$modelPO->project_id)->with('customer','ship')->first();

        // tambahan material dari BOM
        $modelBOM = Bom::where('wbs_id',$modelPO->wbs_id)->get();

        $boms = Collection::make();
        foreach($modelBOM as $bom){
            foreach($bom->bomDetails as $bomDetail){
                $boms->push([
                    "id" => $bomDetail->id , 
                    "material" => [
                        "code" => $bomDetail->material->code,
                        "name" => $bomDetail->material->name,
                    ],
                    "quantity" => $bomDetail->quantity,
                    "material_id" => $bomDetail->material_id,
                    "wbs_id" => $bomDetail->bom->wbs_id
                ]);
            }
        }

        // tambahan resource dari assign resource
        $modelRD = ResourceDetail::where('wbs_id',$modelPO->wbs_id)->get();

        $resources = Collection::make();
        foreach($modelRD as $RD){
            $resources->push([
                "id" => $RD->id , 
                "resource" => [
                    "code" => $RD->resource->code,
                    "name" => $RD->resource->name,
                    "status" => $RD->resource->status,
                ],
                "resource_id" => $RD->resource_id
            ]);
        }
        return view('production_order.release', compact('modelPO','project','modelPOD','boms','resources'));
    }

    public function confirm($id){
        $modelPO = ProductionOrder::where('id',$id)->with('project')->first();
        $modelPOD = ProductionOrderDetail::where('production_order_id',$modelPO->id)->with('material','resource','productionOrder')->get()->jsonSerialize();
        $project = Project::where('id',$modelPO->project_id)->with('customer','ship')->first();

        // tambahan material dari BOM
        $modelBOM = Bom::where('wbs_id',$modelPO->wbs_id)->get();

        $boms = Collection::make();
        foreach($modelBOM as $bom){
            foreach($bom->bomDetails as $bomDetail){
                $boms->push([
                    "id" => $bomDetail->id , 
                    "material" => [
                        "code" => $bomDetail->material->code,
                        "name" => $bomDetail->material->name,
                    ],
                    "quantity" => $bomDetail->quantity,
                    "material_id" => $bomDetail->material_id,
                    "wbs_id" => $bomDetail->bom->wbs_id
                ]);
            }
        }
        $modelRD = ResourceDetail::where('wbs_id',$modelPO->wbs_id)->get();

        $resources = Collection::make();
        foreach($modelRD as $RD){
            $resources->push([
                "id" => $RD->id , 
                "resource" => [
                    "code" => $RD->resource->code,
                    "name" => $RD->resource->name,
                    "status" => $RD->resource->status,
                ],
                "resource_id" => $RD->resource_id
            ]);
        }
        return view('production_order.confirm', compact('modelPO','project','modelPOD','boms','resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $work = Work::findOrFail($id);
        $project = Project::findOrFail($work->project_id);
        $materials = Material::all()->jsonSerialize();
        $resources = Resource::all()->jsonSerialize();

        $modelBOM = Bom::where('wbs_id',$work->id)->get();
        $modelRD = ResourceDetail::where('wbs_id',$work->id)->get();

        return view('production_order.create', compact('work','project','materials','resources','modelBOM','modelRD'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $arrData = $datas->datas;

        $po_number = $this->generateWONumber();

        DB::beginTransaction();
        try {
            $PO = new ProductionOrder;
            $PO->number = $po_number;
            $PO->project_id = $datas->project_id;
            $PO->wbs_id = $datas->wbs_id;
            $PO->status = 1;
            $PO->user_id = Auth::user()->id;
            $PO->branch_id = Auth::user()->branch->id;
            $PO->save();

            $status = 0;

            foreach($arrData as $data){
                $POD = new ProductionOrderDetail;
                $POD->production_order_id = $PO->id;
                if($data->type == "Material"){
                    $POD->material_id = $data->id;
                }
                else{
                    $POD->resource_id = $data->id;
                }
            
                $POD->quantity = $data->quantity;
                $POD->save();
            }
            DB::commit();
            return redirect()->route('production_order.show',$PO->id)->with('success', 'Work Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('production_order.create',$datas->project_id)->with('error', $e->getMessage());
        }
    }

    public function storeRelease(Request $request){
        $datas = json_decode($request->datas);
        $po_id = $datas->modelPOD[0]->production_order_id;
        $modelPO = ProductionOrder::findOrFail($po_id);

        DB::beginTransaction();
        try {
            $modelPO->status = 2;
            $modelPO->save();

            $this->createMR($datas->modelPOD);
            $this->updatePOD($datas->boms, $datas->resourceDetails,$po_id);
            DB::commit();
            return redirect()->route('production_order.show',$modelPO->id)->with('success', 'Work Order Created');
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('production_order.selectProjectRelease')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelPO = ProductionOrder::findOrFail($id);    
        
        return view('production_order.show', compact('modelPO'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createMR($modelPOD){
        $mr_number = $this->generateMRNumber();

        $MR = new MaterialRequisition;
        $MR->number = $mr_number;
        $MR->project_id = $modelPOD[0]->production_order->project_id;
        $MR->description = "AUTO CREATE MR FROM WORK ORDER";
        $MR->type = 1;
        $MR->user_id = Auth::user()->id;
        $MR->branch_id = Auth::user()->branch->id;
        $MR->save();

        foreach($modelPOD as $POD){
            if($POD->material_id != "" || $POD->material_id != null){
                $MRD = new MaterialRequisitionDetail;
                $MRD->material_requisition_id = $MR->id;
                $MRD->quantity = $POD->quantity;
                $MRD->issued = 0;
                $MRD->material_id = $POD->material_id;
                $MRD->save();
            }
        }
    }

    public function updatePOD($modelMaterial, $modelResource, $po_id){
        foreach($modelMaterial as $material){
            $modelPOD = new ProductionOrderDetail;
            $modelPOD->production_order_id = $po_id;
            $modelPOD->material_id = $material->material_id;
            $modelPOD->wbs_id = $material->wbs_id;
            $modelPOD->quantity = $material->sugQuantity;
            $modelPOD->save();
        }

        foreach($modelResource as $resource){
            $modelPOD = new ProductionOrderDetail;
            $modelPOD->production_order_id = $po_id;
            $modelPOD->resource_id = $resource->resource_id;
            $modelPOD->save();
        }
    }

    public function generateWONumber(){
        $modelPO = ProductionOrder::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelPO)){
            $number += intval(substr($modelPO->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

        $po_number = $year+$number;
        $po_number = 'PrO-'.$po_number;
        return $po_number;
    }

    public function getMaterialAPI($id){

        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getStockAPI($id){
        $stock = Stock::where('material_id',$id)->first();
        if($stock){
            $stock = json_encode($stock);
        }else{
            $stock = [];
            $stock = json_encode($stock);
        }

        return response($stock, Response::HTTP_OK);
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
}
