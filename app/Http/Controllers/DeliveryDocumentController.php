<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\DeliveryDocument;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;

class DeliveryDocumentController extends Controller
{
    public function selectProject(){
        $modelProject = Project::where('status',1)->get();

        return view('delivery_document.selectProject', compact('modelProject'));
    }

    public function selectProjectIndex(){
        $modelProject = Project::where('status',1)->get();

        return view('delivery_document.selectProjectIndex', compact('modelProject'));
    }

    public function manage(Request $request,$id){
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $deliveryDocuments = $project->deliveryDocuments;

        return view('delivery_document.manage', compact('deliveryDocuments','route','project'));
    }

    public function show(Request $request,$id){
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $deliveryDocuments = $project->deliveryDocuments;

        return view('delivery_document.show', compact('deliveryDocuments','route','project'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $delivery_document = new DeliveryDocument;
            $delivery_document->project_id = $request->project_id;
            $delivery_document->document_name = $request->document_name;
            $delivery_document->user_id = Auth::user()->id;
            $delivery_document->branch_id = Auth::user()->branch->id;

            if($request->hasFile('file')){
                // Get filename with the extension
                $fileNameWithExt = $request->file('file')->getClientOriginalName();
                // Get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('file')->getClientOriginalExtension();
                $delivery_document->extension = $extension;
                // File name to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                // Upload document
                $path = $request->file('file')->storeAs('documents/delivery_documents',$fileNameToStore);
                $delivery_document->status = 0;
            }else{
                $fileNameToStore =  null;
            }
            $delivery_document->file_name = $fileNameToStore;

            if(!$delivery_document->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to add Delivery Document"],Response::HTTP_OK);
            }
        }catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {
            $delivery_document = DeliveryDocument::find($id);
            $delivery_document->document_name = $request->document_name;
            $delivery_document->user_id = Auth::user()->id;
            $delivery_document->branch_id = Auth::user()->branch->id;
            if($delivery_document->file_name == null){
                $image_path = public_path("app/documents/delivery_documents/".$delivery_document->file_name); 
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            if($request->hasFile('file')){
                // Get filename with the extension
                $fileNameWithExt = $request->file('file')->getClientOriginalName();
                // Get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('file')->getClientOriginalExtension();
                $delivery_document->extension = $extension;
                // File name to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                // Upload document
                $path = $request->file('file')->storeAs('documents/delivery_documents',$fileNameToStore);
                $delivery_document->status = 0;
                $delivery_document->file_name = $fileNameToStore;
            }

            if(!$delivery_document->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update Delivery Document"],Response::HTTP_OK);
            }
        }catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $delivery_document = DeliveryDocument::findOrFail($id);

            $image_path = public_path("app/documents/delivery_documents/".$delivery_document->file_name); 
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $delivery_document->delete();
            DB::commit();
            return response(["response"=>"Success to delete delivery document"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //API
    public function getDeliveryDocumentsAPI($project_id){
        $deliveryDocuments = DeliveryDocument::where('project_id', $project_id)->get()->jsonSerialize();
        return response($deliveryDocuments, Response::HTTP_OK);
    }
}