<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Project;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Material;
use App\Models\Branch;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Auth;

class BOMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProject()
    {
        $projects = Project::where('status',1)->get();

        return view('bom.indexProject', compact('projects'));
    }

    public function selectProject()
    {
        $projects = Project::where('status',1)->get();

        return view('bom.selectProject', compact('projects'));
    }

    public function selectWBS($id)
    {
        $project = Project::find($id);
        $works = $project->works;
        $wbs = Collection::make();

        $wbs->push([
                "id" => $project->code , 
                "parent" => "#",
                "text" => $project->name,
                "icon" => "fa fa-ship"
            ]);
    
        foreach($works as $work){
            if($work->work){
                $wbs->push([
                    "id" => $work->code , 
                    "parent" => $work->work->code,
                    "text" => $work->name,
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => route('bom.create',$work->id)],
                ]);
            }else{
                $wbs->push([
                    "id" => $work->code , 
                    "parent" => $project->code,
                    "text" => $work->name,
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => route('bom.create',$work->id)],
                ]);
            }  
        }

        return view('bom.selectWBS', compact('project','wbs'));
    }

    public function indexBom($id)
    {
        $project = Project::find($id);
        $works = $project->works;
        $wbs = Collection::make();

        $wbs->push([
            "id" => $project->code , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);
    
        foreach($works as $work){
            $bom_code = "";
            $bom = Bom::where('work_id',$work->id)->first();
            if($bom){
                $bom_code = " - ".$bom->code;
                if($work->work){
                    $wbs->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name. ''.$bom_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                    ]);
                }else{
                    $wbs->push([
                        "id" => $work->code , 
                        "parent" => $project->code,
                        "text" => $work->name. ''.$bom_code,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                    ]);
                } 
            }else{
                if($work->work){
                    $wbs->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name. ''.$bom_code,
                        "icon" => "fa fa-suitcase",
                    ]);
                }else{
                    $wbs->push([
                        "id" => $work->code , 
                        "parent" => $project->code,
                        "text" => $work->name. ''.$bom_code,
                        "icon" => "fa fa-suitcase",
                    ]);
                } 
            }
             
        }
        return view('bom.indexBom', compact('project','wbs'));
    }

    public function assignBom($id)
    {
        $modelBOM = Bom::where('project_id',$id)->with('work')->get();
        $project = Project::findOrFail($id);
        $works = Work::where('project_id',$id)->get();

        return view('bom.assignBom', compact('modelBOM','project','works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $work = Work::findOrFail($id);
        $project = Project::where('id',$work->project_id)->with('ship','customer')->first();
        $materials = Material::orderBy('name')->get()->jsonSerialize();

        return view('bom.create', compact('project','materials','bom_code','work'));
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
        $bom_code = self::generateBomCode();

        DB::beginTransaction();
        try {
            $bom = new Bom;
            $bom->code = $bom_code;
            $bom->description = $datas->description;
            $bom->project_id = $datas->project_id;
            $bom->work_id = $datas->work_id;
            $bom->branch_id = Auth::user()->branch->id;
            $bom->user_id = Auth::user()->id;
            if(!$bom->save()){
                return redirect()->route('bom.create',$bom->id)->with('error', 'Failed Save Bom !');
            }else{
                self::saveBomDetail($bom,$datas->materials);
                DB::commit();
                return redirect()->route('bom.show', ['id' => $bom->id])->with('success', 'Bill Of Material Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.indexProject')->with('error', $e->getMessage());
        }
    }

    public function storeBom(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $bom_detail = new BomDetail;
            $bom_detail->bom_id = $data['bom_id'];
            $bom_detail->material_id = $data['material_id'];
            $bom_detail->quantity = $data['quantityInt'];
            if(!$bom_detail->save()){
                return back()->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($bom_detail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.indexProject')->with('error', $e->getMessage());
        }
    }

    // public function storeAssignBom(Request $request)
    // {
    //     $data = $request->json()->all();

    //     DB::beginTransaction();
    //     try {
    //         $modelBOM = Bom::findOrFail($data['bom_id']);
    //         if($data['work_id'] == ""){
    //             $modelBOM->work_id = null;
    //         }else{
    //             $modelBOM->work_id = $data['work_id'];
    //         }
    //         if(!$modelBOM->save()){
    //             return redirect()->route('bom.assignBom')->with('error','Failed to save, please try again !');
    //         }else{
    //             DB::commit();
    //             return response(json_encode($modelBOM),Response::HTTP_OK);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->route('bom.assignBom')->with('error', $e->getMessage());
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelBOM = Bom::where('id',$id)->with('project','bomDetails','user','branch')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material')->get();

        return view('bom.show', compact('modelBOM','modelBOMDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelBOM = Bom::where('id',$id)->with('project')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material')->get();
        $materials = Material::orderBy('name')->get()->jsonSerialize();
        $project = $modelBOM->project;
        $project = Project::find($project->id)->with('ship','customer')->first();

        return view('bom.edit', compact('modelBOM','materials','modelBOMDetail','project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOMDetail = BomDetail::findOrFail($data['bom_detail_id']);
            $modelBOMDetail->material_id = $data['material_id'];
            $modelBOMDetail->quantity = $data['quantityInt'];

            if(!$modelBOMDetail->save()){
                return redirect()->route('bom.edit',$bom->id)->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($modelBOMDetail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('error', $e->getMessage());
        }
    }

    public function updateDesc(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOM = Bom::findOrFail($data['bom_id']);
            $modelBOM->description = $data['desc'];

            if(!$modelBOM->save()){
                return redirect()->route('bom.edit',$bom->id)->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($modelBOM),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->json()->all();

        $modelBOMDetail = BomDetail::findOrFail($data[0]);
        DB::beginTransaction();
        try {
            $modelBOMDetail->delete();
            DB::commit();
            return response(json_encode($modelBOMDetail),Response::HTTP_OK);
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('status', 'Can\'t Delete The Material Because It Is Still Being Used');
        }  
    }

    private function generateBomCode(){
        $code = 'BOM';
        $modelBOM = BOM::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelBOM)){
            $number += intval(substr($modelBOM->code, -4));
		}

        $bom_code = $code.''.sprintf('%04d', $number);
		return $bom_code;
    }
    
    private function saveBomDetail($bom, $materials){
        foreach($materials as $material){
            $bom_detail = new BomDetail;
            $bom_detail->bom_id = $bom->id;
            $bom_detail->material_id = $material->material_id;
            $bom_detail->quantity = $material->quantityInt;
            if(!$bom_detail->save()){
                return redirect()->route('bom.create')->with('error', 'Failed Save Bom Detail !');
            }
        }
        return true;
    }

    public function getMaterialAPI($id){

        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomAPI($id){

        return response(BomDetail::where('bom_id',$id)->with('material')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getNewBomAPI($id){

        return response($modelBOM = Bom::where('project_id',$id)->with('work')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomDetailAPI($id){

        return response($modelBD = BomDetail::where('id',$id)->with('material')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::orderBy('name')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
