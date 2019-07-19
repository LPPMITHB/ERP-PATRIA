<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use App\Models\GoodsIssue;

class ReverseTransactionController extends Controller
{
    public function selectDocument(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        
        return view('reverse_transaction.selectDocument', compact('menu'));
    }

    //API
    public function getDocuments($type, $menu)
    {
        $modelData = "";
        $business_unit_id = $menu == "building" ? 1 : 2;
        if($type == 1){
            $modelData = GoodsReceipt::where('business_unit_id', $business_unit_id)->get();
        }else if($type == 2){
            $modelData = GoodsIssue::where('business_unit_id', $business_unit_id)->get();
        }

        return response($modelData, Response::HTTP_OK);
    }
}
