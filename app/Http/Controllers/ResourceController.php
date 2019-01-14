<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Uom;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\PurchaseOrderDetail;
use App\Models\Configuration;
use DateTime;
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
        $resource_category = Configuration::get('resource_category');

        foreach($resources as $resource){
            $resource['categoryName'] ="";
            foreach($resource_category as $category){
                if($resource->category_id == $category->id){
                    $resource->categoryName = $category->name;
                    // print_r($categoryName);exit();
                }
            }
        }
        

        return view('resource.index', compact('resources','resource_category'));
    }

    public function assignResource()
    {
        $resources = Resource::all();
        $projects = Project::where('status',1)->get();
        $assignresource = ResourceDetail::with('project','resource','wbs')->get();
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

        return view('resource.create', compact('resource', 'resource_code','uoms','vendors','resource_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $resource = new Resource;
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
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
            $wbs = WBS::find($wbs_id);
            $resourceDetailWbs = $wbs->resourceDetails;
            if(count($resourceDetailWbs)>0){
                foreach ($resourceDetailWbs as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }

            $categoryFromResource = [];
            foreach($data['dataResources'] as $detail){
                
                $resource = Resource::find($detail['resource_id']);
                array_push($categoryFromResource, $resource->category->id);

                $resourceDetail = new ResourceDetail;
                $resourceDetail->resource_id = $detail['resource_id'];
                $resourceDetail->project_id = $wbs->project->id;
                $resourceDetail->wbs_id = $wbs->id;
                $resourceDetail->category_id = $resource->category->id;
                $resourceDetail->quantity = $detail['quantityInt'];
                $resourceDetail->save();
            }

            array_unique($categoryFromResource);

            foreach($data['selected_resource_category'] as $category){
                if(in_array($category, $categoryFromResource) != true){
                    $resourceDetail = new ResourceDetail;
                    $resourceDetail->project_id = $wbs->project->id;
                    $resourceDetail->wbs_id = $wbs->id;
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
            $wbs = WBS::find($wbs_id);
            $resourceDetailWbs = $wbs->resourceDetails;
            if(count($resourceDetailWbs)>0){
                foreach ($resourceDetailWbs as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }
            foreach($data as $category_id){
                $resourceDetail = new ResourceDetail;
                $resourceDetail->project_id = $wbs->project->id;
                $resourceDetail->wbs_id = $wbs->id;
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
        $resource_category = Configuration::get('resource_category');
        $vendor = Vendor::all();
        // print_r($resource);exit();      
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

        return view('resource.edit', compact('resource','uoms','resource_code','vendors','resource_category'));
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
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $resource = Resource::find($id);
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
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
    
    
    public function getWbsAssignResourceApi($id){
        $wbs = WBS::where('project_id',$id)->get()->jsonSerialize();

        return response($wbs, Response::HTTP_OK);
    }

    public function getWbsNameAssignResourceApi($id){

        return response(WBS::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

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
        $resourcedetail = ResourceDetail::with('project','resource','wbs')->get()->jsonSerialize();
        return response($resourcedetail, Response::HTTP_OK);
    }


    
    
    


    
}
