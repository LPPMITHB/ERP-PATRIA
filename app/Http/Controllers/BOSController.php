<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Project;
use App\Models\Bos;
use App\Models\BosDetail;
use App\Models\Material;
use App\Models\Branch;
use App\Models\WBS;
use App\Models\User;
use App\Models\Rap;
use App\Models\RapDetail;
use App\Models\Stock;
use App\Models\Service;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Auth;

class BOSController extends Controller
{
    protected $pr;

    public function __construct(PurchaseRequisitionController $pr)
    {
        $this->pr = $pr;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProject()
    {
        $projects = Project::where('status',1)->get();

        return view('bos.indexProject', compact('projects'));
    }

    public function selectProject()
    {
        $projects = Project::where('status',1)->get();

        return view('bos.selectProject', compact('projects'));
    }

    public function selectWBS($id)
    {
        $project = Project::find($id);
        $wbss = $project->wbss;
        $data = Collection::make();

        $data->push([
                "id" => $project->number , 
                "parent" => "#",
                "text" => $project->name,
                "icon" => "fa fa-ship"
            ]);
    
        foreach($wbss as $wbs){
            $bos_code = "";
            $bos = Bos::where('wbs_id',$wbs->id)->first();
            if($bos){
                $bos_code = " - ".$bos->code;
                if($wbs->wbs){
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.edit',$bos->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.edit',$bos->id)],
                    ]);
                } 
            }else{
                if($wbs->wbs){
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.create',$wbs->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.create',$wbs->id)],
                    ]);
                } 
            } 
        }
        return view('bos.selectWBS', compact('project','data'));
    }

    public function indexBos($id)
    {
        $project = Project::find($id);
        $wbs = $project->wbss;
        $data = Collection::make();

        $data->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        foreach($wbs as $work){
            $bos_code = "";
            $bos = Bos::where('wbs_id',$work->id)->first();
            if($bos){
                $bos_code = " - ".$bos->code;
                if($work->wbs){
                    $data->push([
                        "id" => $work->code , 
                        "parent" => $work->wbs->code,
                        "text" => $work->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.show',$bos->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bos.show',$bos->id)],
                    ]);
                } 
            }else{
                if($work->wbs){
                    $data->push([
                        "id" => $work->code , 
                        "parent" => $work->wbs->code,
                        "text" => $work->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                    ]);
                }else{
                    $data->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name. ''.$bos_code,
                        "icon" => "fa fa-suitcase",
                    ]);
                } 
            }
             
        }
        return view('bos.indexBos', compact('project','data'));
    }

    public function assignBos($id)
    {
        $modelBOS = Bos::where('project_id',$id)->with('work')->get();
        $project = Project::findOrFail($id);
        $wbs = WBS::where('project_id',$id)->get();

        return view('bos.assignBos', compact('modelBOs','project','wbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $wbs = WBS::findOrFail($id);
        $project = Project::where('id',$wbs->project_id)->with('ship','customer')->first();
        $services = Service::orderBy('name')->get()->jsonSerialize();

        return view('bos.create', compact('project','services','bos_code','wbs'));
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
        $bos_code = self::generateBosCode();

        DB::beginTransaction();
        try {
            $bos = new Bos;
            $bos->code = $bos_code;
            $bos->description = $datas->description;
            $bos->project_id = $datas->project_id;
            $bos->wbs_id = $datas->wbs_id;
            $bos->branch_id = Auth::user()->branch->id;
            $bos->user_id = Auth::user()->id;
            if(!$bos->save()){
                return redirect()->route('bos.create',$bos->id)->with('error', 'Failed Save BOS !');
            }else{
                self::saveBosDetail($bos,$datas->services);
                // self::createRap($datas,$bos);
                DB::commit();
                return redirect()->route('bos.show', ['id' => $bos->id])->with('success', 'Bill Of Service Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bos.indexProject')->with('error', $e->getMessage());
        }
    }

    public function storeBos(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $bos_detail = new BosDetail;
            $bos_detail->bos_id = $data['bos_id'];
            $bos_detail->service_id = $data['service_id'];
            $bos_detail->cost_standard_price = $data['cost_standard_priceInt'];
            if(!$bos_detail->save()){
                return back()->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($bos_detail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bos.indexProject')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BOS  $BOS
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $pr_number = '-';
        // $rap_number = '-';
        $modelBOS = Bos::where('id',$id)->with('project','bosDetails','user','branch')->first();
        $modelBOSDetail = BosDetail::where('bos_id',$modelBOS->id)->with('service')->get();

        // $modelPR = PurchaseRequisition::where('bos_id',$modelBOS->id)->first();
        // if(isset($modelPR)){
        //     $pr_number = $modelPR->number;
        // }

        // $modelRAP = Rap::where('bos_id',$modelBOS->id)->first();
        // if(isset($modelRAP)){
        //     $rap_number = $modelRAP->number;
        // }
        return view('bos.show', compact('modelBOS','modelBOSDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BOS  $BOS
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $pr_number = '-';
        // $rap_number = '-';
        $modelBOS = Bos::where('id',$id)->with('project')->first();
        $modelBOSDetail = BosDetail::where('bos_id',$modelBOS->id)->with('service')->get();
        $services = Service::orderBy('name')->get()->jsonSerialize();
        $project = $modelBOS->project;
        $project = Project::find($project->id)->with('ship','customer')->first();

        // $modelPR = PurchaseRequisition::where('bos_id',$modelBOS->id)->first();
        // if(isset($modelPR)){
        //     $pr_number = $modelPR->number;
        // }

        // $modelRAP = Rap::where('bos_id',$modelBOS->id)->first();
        // if(isset($modelRAP)){
        //     $rap_number = $modelRAP->number;
        // }

        return view('bos.edit', compact('modelBOS','services','modelBOSDetail','project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BOS  $BOS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOSDetail = BosDetail::findOrFail($data['bos_detail_id']);
            $diff = $data['cost_standard_priceInt'] - $modelBOSDetail->cost_standard_price;
            // $modelBOSDetail->material_id = $data['material_id'];
            $modelBOSDetail->cost_standard_price = $data['cost_standard_priceInt'];

            if(!$modelBOSDetail->save()){
                return redirect()->route('bos.edit',$modelBOSDetail->bos_id)->with('error','Failed to save, please try again !');
            }else{
                // update RAP
                // $modelRAP = Rap::where('bos_id',$modelBOSDetail->bos_id)->first();
                // foreach($modelRAP->rapDetails as $rapDetail){
                //     if($rapDetail->material_id == $modelBOSDetail->material_id){
                //         $rapDetail->cost_standard_price = $data['cost_standard_priceInt'];
                //         $rapDetail->save();
                //     }
                // }
                // update reserve mst_stock
                // $modelStock = Stock::where('material_id',$modelBOSDetail->material_id)->first();
                // $modelStock->reserved += $diff;
                // $modelStock->save();
                DB::commit();
                return response(json_encode($modelBOSDetail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bos.edit',$modelBOSDetail->bos_id)->with('error', $e->getMessage());
        }
    }

    public function updateDesc(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOS = Bos::findOrFail($data['bos_id']);
            $modelBOS->description = $data['desc'];

            if(!$modelBOS->save()){
                return redirect()->route('bos.edit',$bos->id)->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($modelBOS),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bos.edit',$bos->id)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BOS  $bOS
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->json()->all();

        $modelBOSDetail = BosDetail::findOrFail($data[0]);
        DB::beginTransaction();
        try {
            $modelBOSDetail->delete();
            DB::commit();
            return response(json_encode($modelBOSDetail),Response::HTTP_OK);
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('bos.edit',$bos->id)->with('status', 'Can\'t Delete The Material Because It Is Still Being Used');
        } 
    }

    private function generateBosCode(){
        $code = 'BOS';
        $modelBOS = BOS::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelBOS)){
            $number += intval(substr($modelBOS->code, -4));
		}

        $bos_code = $code.''.sprintf('%04d', $number);
		return $bos_code;
    }

    private function generateRapNumber(){
        $modelRap = Rap::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelRap)){
            $number += intval(substr($modelRap->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$rap_number = $year+$number;
        $rap_number = 'RAP-'.$rap_number;
		return $rap_number;
    }
    
    private function saveBosDetail($bos, $services){
        foreach($services as $service){
            $bos_detail = new BosDetail;
            $bos_detail->bos_id = $bos->id;
            $bos_detail->service_id = $service->service_id;
            $bos_detail->cost_standard_price = $service->cost_standard_priceInt;
            if(!$bos_detail->save()){
                return redirect()->route('bos.create')->with('error', 'Failed Save Bos Detail !');
            }
        }
    }

    // public function createRap($data,$bos){
    //     $rap_number = self::generateRapNumber();
    //     $rap = new Rap;
    //     $rap->number = $rap_number;
    //     $rap->project_id = $data->project_id;
    //     $rap->bos_id = $bos->id;
    //     $rap->user_id = Auth::user()->id;
    //     $rap->branch_id = Auth::user()->branch->id;
    //     if(!$rap->save()){
    //         return redirect()->route('bos.create')->with('error', 'Failed Save RAP !');
    //     }else{
    //         self::saveRapDetail($rap->id,$bos->bosDetails);
    //         $total_price = self::calculateTotalPrice($rap->id);

    //         $modelRap = Rap::findOrFail($rap->id);
    //         $modelRap->total_price = $total_price;
    //         $modelRap->save();
    //     }
    // }

    // public function saveRapDetail($rap_id,$bosDetails){
    //     foreach($bosDetails as $bosDetail){
    //         $rap_detail = new RapDetail;
    //         $rap_detail->rap_id = $rap_id;
    //         $rap_detail->service_id = $bosDetail->service_id;
    //         $rap_detail->quantity = $bosDetail->quantity;
    //         $rap_detail->price = $bosDetail->quantity * $bosDetail->material->cost_standard_price;
    //         $rap_detail->save();
    //     }
    // }

    // public function calculateTotalPrice($id){
    //     $modelRap = Rap::findOrFail($id);
    //     $total_price = 0;
    //     foreach($modelRap->RapDetails as $RapDetail){
    //         $total_price += $RapDetail->price;
    //     }
    //     return $total_price;
    // }

    public function getServiceAPI($id){

        return response(Service::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBosAPI($id){

        return response(BosDetail::where('bos_id',$id)->with('service')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getNewBosAPI($id){

        return response($modelBOS = Bos::where('project_id',$id)->with('wbs')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBosDetailAPI($id){

        return response($modelBD = BosDetail::where('id',$id)->with('service')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServicesAPI($ids){
        $ids = json_decode($ids);

        return response(Service::orderBy('name')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
