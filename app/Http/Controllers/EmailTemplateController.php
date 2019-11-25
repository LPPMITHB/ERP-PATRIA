<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('email_template.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email_template.create');
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
            $email_template = new EmailTemplate;
            $email_template->name = $datas->name;
            $email_template->description = $datas->description;
            $email_template->template = $datas->template;
            $email_template->save();

            DB::commit();
            return redirect()->route('email_template.show', $email_template->id)->with('success', 'Success Created New Email Template!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('email_template.create')->with('error', $e->getMessage());
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
        $email_template = EmailTemplate::find($id);
        return view('email_template.show', compact('email_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('email_template.edit',compact('id'));
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
            $email_template = EmailTemplate::find($id);
            $email_template->name = $datas->name;
            $email_template->description = $datas->description;
            $email_template->template = $datas->template;
            $email_template->update();

            DB::commit();
            return redirect()->route('email_template.show', $email_template->id)->with('success', 'Success Updated Email Template!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('email_template.edit',$id)->with('error', $e->getMessage());
        }
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


    //API
    public function apiGetEmailTemplateMaster()
    {
        $dataEmailTemplate = EmailTemplate::all()->jsonSerialize();
        return response($dataEmailTemplate, Response::HTTP_OK);
    }

    public function apiGetEmailTemplateEdit($id)
    {
        $dataEmailTemplate = EmailTemplate::find($id)->jsonSerialize();
        return response($dataEmailTemplate, Response::HTTP_OK);
    }
}
