<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Snapshot; 
use App\Models\SnapshotDetail; 
use App\Models\StorageLocationDetail; 
use App\Models\Stock; 
use App\Models\Material; 
use App\Models\Branch;
use App\Models\StorageLocation; 
use App\Models\GoodsIssue;
use App\Models\GoodsIssueDetail;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use Illuminate\Support\Collection;
use Auth;
use DB;

class PhysicalInventoryController extends Controller
{

    protected $gr;
    protected $gi;

    public function __construct(GoodsReceiptController $gr, GoodsIssueController $gi)
    {
        $this->middleware('auth');
        $this->gr = $gr;
        $this->gi = $gi;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSnapshot(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshots = Snapshot::whereIn('status',[1,2])->get();
        $materials = Material::all();
        $storage_locations = StorageLocation::all();

        return view('physical_inventory.indexSnapshot', compact('snapshots','materials','storage_locations','menu'));
    }

    public function indexCountStock(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshots = Snapshot::whereIn('status',[1,2])->get();

        return view('physical_inventory.indexCountStock', compact('snapshots','menu'));
    }

    public function indexAdjustStock(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshots = Snapshot::where('status',2)->get();

        return view('physical_inventory.indexAdjustStock', compact('snapshots','menu'));
    }

    public function viewAdjustmentHistory(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshots = Snapshot::where('status',0)->get();

        return view('physical_inventory.index', compact('snapshots','menu'));
    }


    public function displaySnapshot(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $sloc = $request->sloc;
        $material = $request->material;
        $stocks = StorageLocationDetail::whereIn('storage_location_id',$sloc)->
        whereIn('material_id', $material)->get();
        $piCode = self::generatePICode();


        return view('physical_inventory.displaySnapshot', compact('piCode','stocks','sloc','material','menu'));
    }

    public function storeSnapshot(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $stringSloc = "[".$request->sloc."]";
        $sloc = json_decode($stringSloc);

        $stringMaterial = "[".$request->material."]";
        $material = json_decode($stringMaterial);

        $stocks = StorageLocationDetail::whereIn('storage_location_id',$sloc)->
        whereIn('material_id', $material)->get();

        DB::beginTransaction();
        try {
            $snapshot = new Snapshot;
            $snapshot->code = self::generatePICode();
            $snapshot->user_id = Auth::user()->id;
            $snapshot->branch_id = Auth::user()->branch->id;
            $snapshot->save();

            foreach ($stocks as $stock) {
                $snapshotDetail = new SnapshotDetail;
                $snapshotDetail->snapshot_id = $snapshot->id;
                $snapshotDetail->material_id = $stock->material_id;
                $snapshotDetail->storage_location_id = $stock->storage_location_id;
                $snapshotDetail->quantity = $stock->quantity;
                $snapshotDetail->save();
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('physical_inventory.showSnapshot', ['id' => $snapshot->id])->with('success', 'Snapshot Created');
            }else{
                return redirect()->route('physical_inventory_repair.showSnapshot', ['id' => $snapshot->id])->with('success', 'Snapshot Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('physical_inventory.indexSnapshot')->with('error', $e->getMessage());
            }else{
                return redirect()->route('physical_inventory_repair.indexSnapshot')->with('error', $e->getMessage());
            }
        }
    }

    public function showSnapshot($id,Request $request)
    {
        $route = $request->route()->getPrefix();    
        $snapshot = Snapshot::where('id', $id)->whereIn('status',[1,2])->first();
        return view('physical_inventory.showSnapshot', compact('snapshot','route'));
    }

    public function printPdf($id, Request $request)
    {
        $modelSnapshot = Snapshot::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $branch = Branch::find(Auth::user()->branch_id);
        $route = $request->route()->getPrefix();
        $pdf->loadView('physical_inventory.pdf',['modelSnapshot' => $modelSnapshot, 'branch' => $branch, 'route' => $route]);
        $now = date("Y_m_d_H_i_s");
        
        return $pdf->download('Snapshot_'.$now.'.pdf');
    }

    public function countStock($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshot = Snapshot::whereIn('status',[1,2])->where('id', $id)->first();
        $snapshotDetails = SnapshotDetail::where('snapshot_id',$id)
        ->with(array('material'=>function($query){
                $query->select('id','code','description');
            }))
        ->with(array('material.uom'=>function($query){
            $query->select('id','unit','is_decimal');
        }))
        ->with(array('storageLocation'=>function($query){
            $query->select('id','name');
        }))->get();
        return view('physical_inventory.countStock', compact('snapshot','snapshotDetails','menu'));
    }

    public function showCountStock($id)
    {
        $snapshot = Snapshot::whereIn('status',[1,2,0])->where('id', $id)->first();
        $confirm = false;

        return view('physical_inventory.showCountStock', compact('snapshot','confirm'));
    }

    public function showConfirmCountStock($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $snapshot = Snapshot::where('status',2)->where('id', $id)->first();
        $confirm = true;

        return view('physical_inventory.showCountStock', compact('snapshot','confirm','menu'));
    }

    public function showPI($id)
    {
        $snapshot = Snapshot::where('id', $id)->first();

        return view('physical_inventory.showPI', compact('snapshot'));
    }

    public function storeCountStock(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $snapshot = Snapshot::findOrFail($id);
            $snapshot->status = 2;
            $snapshot->save();

            foreach ($data as $countStock) {
                $snapshotDetail = SnapshotDetail::findOrFail($countStock->id);
                $snapshotDetail->count = $countStock->count;
                $snapshotDetail->adjusted_stock = $countStock->count - $snapshotDetail->quantity;
                $snapshotDetail->save();
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('physical_inventory.showCountStock', ['id' => $id])->with('success', 'Stock Adjusted');
            }else{
                return redirect()->route('physical_inventory_repair.showCountStock', ['id' => $id])->with('success', 'Stock Adjusted');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('physical_inventory.indexCountStock')->with('error', $e->getMessage());
            }else{
                return redirect()->route('physical_inventory_repair.indexCountStock')->with('error', $e->getMessage());
            }
        }
    }

    public function storeAdjustStock(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/physical_inventory" ? "building" : "repair";    
        if($menu == "building"){
            $business_unit = 1;
        }elseif($menu =="repair"){
            $business_unit = 2;
        }
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $snapshot = Snapshot::findOrFail($id);
            $snapshot->status = 0;
            $snapshot->save();

            $goodsReceipt = array();
            $goodsIssue = array();

            foreach($snapshot->snapshotDetails as $details){
                if($details->adjusted_stock > 0){
                    array_push($goodsReceipt, $details);
                }elseif($details->adjusted_stock < 0){
                    array_push($goodsIssue, $details);
                }
                
            }
            if(count($goodsReceipt)>0){
                $gr = new GoodsReceipt;
                $gr->number = $this->gr->generateGRNumber();
                $gr->type = 5;
                $gr->business_unit_id = $business_unit;
                $gr->description = "Stock Adjustment ".$snapshot->code;
                $gr->user_id = Auth::user()->id;
                $gr->branch_id = Auth::user()->branch->id;
                $gr->save();
                foreach($goodsReceipt as $detail){
                    $grDetail = new GoodsReceiptDetail;
                    $grDetail->goods_receipt_id = $gr->id;
                    $grDetail->quantity = abs($detail->adjusted_stock);
                    $grDetail->material_id = $detail->material_id;
                    $grDetail->storage_location_id = $detail->storage_location_id;
                    $grDetail->save();


                    $slocDetail = StorageLocationDetail::where('material_id', $detail->material_id)->where('storage_location_id',$detail->storage_location_id)->first();
                    $slocDetail->quantity = $detail->count;
                    $slocDetail->save();

                    $stock = Stock::where('material_id', $detail->material_id)->first();
                    $stock->quantity = $stock->quantity + abs($detail->adjusted_stock);
                    $stock->save();
                }
            }

            if(count($goodsIssue)>0){
                $gi = new GoodsIssue;
                $gi->type = 3;
                $gi->business_unit_id = $business_unit;
                $gi->number = $this->gi->generateGINumber();
                $gi->description = "Stock Adjustment ".$snapshot->code;
                $gi->user_id = Auth::user()->id;
                $gi->branch_id = Auth::user()->branch->id;
                $gi->save();
                foreach($goodsIssue as $detail){
                    $giDetail = new GoodsIssueDetail;
                    $giDetail->goods_issue_id = $gi->id;
                    $giDetail->quantity = abs($detail->adjusted_stock);
                    $giDetail->material_id = $detail->material_id;
                    $giDetail->storage_location_id = $detail->storage_location_id;
                    $giDetail->save();

                    $slocDetail = StorageLocationDetail::where('material_id', $detail->material_id)->where('storage_location_id',$detail->storage_location_id)->first();
                    $slocDetail->quantity = $detail->count;
                    $slocDetail->save();
                    
                    $stock = Stock::where('material_id', $detail->material_id)->first();
                    $stock->quantity = $stock->quantity - abs($detail->adjusted_stock);
                    $stock->save();
                }
            }        
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('physical_inventory.indexSnapshot')->with('success', 'Stock Adjustment Approved');
            }else{
                return redirect()->route('physical_inventory_repair.indexSnapshot')->with('success', 'Stock Adjustment Approved');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('physical_inventory.indexAdjustStock')->with('error', $e->getMessage());
            }else{
                return redirect()->route('physical_inventory_repair.indexAdjustStock')->with('error', $e->getMessage());
            }
        }
    }

    public function generatePICode(){
        $code = 'PI';
        $modelPI = Snapshot::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelPI)){
            $number += intval(substr($modelPI->code, -4));
		}

        $pi_code = $code.''.sprintf('%04d', $number);
		return $pi_code;
	}
}
