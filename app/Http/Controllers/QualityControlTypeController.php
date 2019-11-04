<?php

namespace App\Http\Controllers;


use App\Models\QualityControlType;
use App\Models\QualityControlTypeDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;

class QualityControlTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qct_type = QualityControlType::get()->jsonSerialize();
        return view('qulity_control_type.index', compact('qct_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        return view('qulity_control_type.create');
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
            $qcType = new QualityControlType;
            $qcType->code = "DOCUMENT" . strtotime("now") . "QC" . Auth::user()->branch->id;
            $qcType->name = $data->name;
            $qcType->description = $data->description;
            $qcType->user_id = Auth::user()->id;
            $qcType->branch_id = Auth::user()->branch->id;

            if ($qcType->save()) {
                foreach ($data->task as $qctask) {
                    $qcTypeDetail = new QualityControlTypeDetail;
                    $qcTypeDetail->quality_control_type_id = $qcType->id;
                    $qcTypeDetail->name = $qctask->name;
                    $qcTypeDetail->description = $qctask->description;
                    $qcTypeDetail->save();
                }
            }
            DB::commit();
            return redirect()->route('qc_type.show', $qcType->id)->with('success', 'Success Created New Quality Control Type!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('qc_type.create')->with('error', $e->getMessage())->withInput();
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
        $qcType = QualityControlType::findOrFail($id);
        $qcTypeDetail = QualityControlTypeDetail::where(['quality_control_type_id' => $id])->get()->jsonSerialize();
        return view('qulity_control_type.show', compact('qcType', 'qcTypeDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $qcType = QualityControlType::findOrFail($id);
        $qcTypeDetail = QualityControlTypeDetail::where(['quality_control_type_id' => $id])->get()->jsonSerialize();
        return view('qulity_control_type.edit', compact('qcType', 'qcTypeDetail'));
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
    public function updateDetail(Request $request)
    {
        $data = $request->json()->all();
        $modelQcTypeDetail = null;
        DB::beginTransaction();
        try {
            if ($data['detailID'] == null) {
                $modelQcTypeDetail = new QualityControlTypeDetail;
                $modelQcTypeDetail->quality_control_type_id = $data['qc_typeID'];
                $modelQcTypeDetail->name = $data['name'];
                $modelQcTypeDetail->description = $data['description'];
                $modelQcTypeDetail->save();
            } else {
                $modelQcTypeDetail =  QualityControlTypeDetail::findOrFail($data['detailID']);
                $modelQcTypeDetail->quality_control_type_id = $data['qc_typeID'];
                $modelQcTypeDetail->name = $data['name'];
                $modelQcTypeDetail->description =  $data['description'];
                $modelQcTypeDetail->update();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo ($e);
            return response(json_encode($data), Response::HTTP_FORBIDDEN);
        }
        return response($modelQcTypeDetail->id, Response::HTTP_OK);
    }

    public function updateMaster(Request $request)
    {
        $data = json_decode($request->datas);
        $modelQcType = QualityControlType::findOrFail($data->id);
        DB::beginTransaction();
        try {
            $modelQcType->name = $data->name;
            $modelQcType->description = $data->description;
            $modelQcType->update();

            foreach ($data->task as $task) {
                if (!isset($task->id)) {
                    $qcTypeDetail = new QualityControlTypeDetail;
                    $qcTypeDetail->quality_control_type_id = $modelQcType->id;
                    $qcTypeDetail->name = $task->name;
                    $qcTypeDetail->description = $task->description;
                    $qcTypeDetail->save();
                } else {
                    $qcTypeDetail = QualityControlTypeDetail::find($task->id);
                    $qcTypeDetail->name = $task->name;
                    $qcTypeDetail->description = $task->description;
                    $qcTypeDetail->update();
                }
            }
            DB::commit();
            return redirect()->route('qc_type.show', $modelQcType->id)->with('success', "Success Updated Quality Control Type!");
        } catch (\Exception $e) {
            DB::rollback();
            echo ($e);
            return redirect()->route('qc_type.show', $modelQcType->id)->with('error', $e);
        }
        return response($modelQcType->id, Response::HTTP_OK);
    }

    public function deleteDetail(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $modelQcTypeDetail =  QualityControlTypeDetail::findOrFail($id);
            $modelQcTypeDetail->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo ($e);
            return response(json_encode($e), Response::HTTP_FORBIDDEN);
        }
        echo ($id);
        return response($id, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelQcType =  QualityControlType::findOrFail($id);
        $modelQcType->delete();
        // DB::beginTransaction();
        // try {
        //     $modelQcType =  QualityControlType::findOrFail($id);
        //     $modelQcType->delete();
        //     DB::commit();
        // } catch (Exception $e) {
        //     DB::rollback();
        //     return redirect()->route('qc_type.index')->with('error', $e.'Deleting Quality Control Error');
        // }
        return redirect()->route('qc_type.index')->with('success', 'Deleting Quality Control Succsess');
    }

    // /**
    //  * 
    //  */
    public function apiGetQcTypeMaster()
    {
        $dataQcType = QualityControlType::select(['name', 'description'])->get()->jsonSerialize();
        return response($dataQcType, Response::HTTP_OK);
    }
}
