<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\Project;
use App\Models\Work;
use App\Models\Uom;
use App\Models\Category;
use App\Models\PurchaseOrderDetail;
use Auth;
use DB;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::all();
        
        return view('resource.index', compact('resources'));
    }

    public function assignResource()
    {
        $resources = Resource::where('status',1)->get();
        $projects = Project::where('status',1)->get();
        $assignresource = ResourceDetail::with('project','resource','work')->get();
        return view('resource.assignResource', compact('resources','projects','assignresource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = new Resource;
        $resource_code = self::generateResourceCode();
        $categories = Category::all();
        $uoms = Uom::all();
        
        return view('resource.create', compact('resource', 'resource_code','uoms','categories'));

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
        DB::beginTransaction();
        try {
            $resource = new Resource;
            $resource->code = strtoupper($datas->dataInput->code);
            $resource->name = ucwords($datas->dataInput->name);
            $resource->description = $datas->dataInput->description;
            $resource->type = $datas->dataInput->type;
            $resource->quantity = $datas->dataInput->quantity;
            $resource->uom_id = $datas->dataInput->uom;
            $resource->category_id = $datas->dataInput->category;
            $resource->status = $datas->dataInput->status;
            $resource->user_id = Auth::user()->id;
            $resource->branch_id = Auth::user()->branch->id;
            $resource->save();

            DB::commit();
            return redirect()->route('resource.show',$resource->id)->with('success', 'Success Created New Resource!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('resource.create')->with('error', $e->getMessage());
        }
    }

    public function storeResourceDetail(Request $request, $wbs_id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $work = Work::find($wbs_id);
            $resourceDetailWork = $work->resourceDetails;
            if(count($resourceDetailWork)>0){
                foreach ($resourceDetailWork as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }

            $categoryFromResource = [];
            foreach($data['dataResources'] as $detail){
                
                $resource = Resource::find($detail['resource_id']);
                array_push($categoryFromResource, $resource->category->id);

                $resourceDetail = new ResourceDetail;
                $resourceDetail->resource_id = $detail['resource_id'];
                $resourceDetail->project_id = $work->project->id;
                $resourceDetail->wbs_id = $work->id;
                $resourceDetail->category_id = $resource->category->id;
                $resourceDetail->quantity = $detail['quantityInt'];
                $resourceDetail->save();
            }

            array_unique($categoryFromResource);

            foreach($data['selected_resource_category'] as $category){
                if(in_array($category, $categoryFromResource) != true){
                    $resourceDetail = new ResourceDetail;
                    $resourceDetail->project_id = $work->project->id;
                    $resourceDetail->wbs_id = $work->id;
                    $resourceDetail->category_id = $category;
                    $resourceDetail->save();
                }
            }


            DB::commit();
            return response(["response"=>"Success to assign resource "],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeResourceCategory(Request $request, $wbs_id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $work = Work::find($wbs_id);
            $resourceDetailWork = $work->resourceDetails;
            if(count($resourceDetailWork)>0){
                foreach ($resourceDetailWork as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }
            foreach($data as $category_id){
                $resourceDetail = new ResourceDetail;
                $resourceDetail->project_id = $work->project->id;
                $resourceDetail->wbs_id = $work->id;
                $resourceDetail->category_id = $category_id;
                $resourceDetail->save();
            }

            DB::commit();
            return response(["response"=>"Success to assign resource "],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
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
        $resource = Resource::findOrFail($id);
        $modelPOD = PurchaseOrderDetail::where('resource_id',$id)->get();
        
        return view('resource.show', compact('resource','modelPOD'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        $resource_code = $resource->code;
        $categories = Category::all();
        $uoms = Uom::all();
        
        return view('resource.create', compact('resource','uoms','resource_code','categories'));
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
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $resource = Resource::find($id);
            $resource->code = strtoupper($datas->dataInput->code);
            $resource->name = ucwords($datas->dataInput->name);
            $resource->description = $datas->dataInput->description;
            $resource->type = $datas->dataInput->type;
            $resource->quantity = $datas->dataInput->quantity;
            $resource->uom_id = $datas->dataInput->uom;
            $resource->category_id = $datas->dataInput->category;
            $resource->status = $datas->dataInput->status;
            $resource->user_id = Auth::user()->id;
            $resource->branch_id = Auth::user()->branch->id;
            $resource->update();

            DB::commit();
            return redirect()->route('resource.show',$resource->id)->with('success', 'Resource Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('resource.update',$resource->id)->with('error', $e->getMessage());
        }
    }

    public function updateAssignResource (Request $request, $id)
    {
        $data = $request->json()->all();
        $resource_ref = ResourceDetail::find($id);

        DB::beginTransaction();
        try {
            $resource_ref->resource_id = $data['resource_id'];
            $resource_ref->project_id = $data['project_id'];
            $resource_ref->wbs_id = $data['wbs_id'];
            $resource_ref->category_id = $data['category_id'];
            $resource_ref->quantity = $data['quantity'];

            if(!$resource_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$resource_ref->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeAssignResource(Request $request)
    {
        $data = $request->json()->all();
   
        DB::beginTransaction();
        try {
            $resource = new ResourceDetail;
            $resource->resource_id = $data['resource_id'];
            $resource->project_id = $data['project_id'];
            $resource->wbs_id = $data['wbs_id'];
            $resource->category_id = $data['category_id'];
            $resource->quantity = $data['quantity'];
            

            if(!$resource->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to assign resource"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }


    public function generateResourceCode(){
        $code = 'RSC';
        $modelResource = Resource::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelResource)){
            $number += intval(substr($modelResource->code, -4));
		}

        $resource_code = $code.''.sprintf('%04d', $number);
		return $resource_code;
    }

    public function getResourceAssignApi($id){
        $resource = Resource::where('id',$id)->with('uom')->first()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }
    
    public function getWorkAssignResourceApi($id){
        $work = Work::where('project_id',$id)->get()->jsonSerialize();

        return response($work, Response::HTTP_OK);
    }

    public function getWorkNameAssignResourceApi($id){

        return response(Work::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getResourceNameAssignResourceApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getProjectNameAssignResourceApi($id){

        return response(Project::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }
    
    public function getCategoryARApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }
    
    

    public function getResourceDetailApi(){
        $resourcedetail = ResourceDetail::with('project','resource','work')->get()->jsonSerialize();
        return response($resourcedetail, Response::HTTP_OK);
    }


    
    
    


    
}
