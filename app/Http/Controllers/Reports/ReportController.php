<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Shop;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function stockreport(Request $request)
    {
        $where=false;
        if($request->fdate){
            $tdate=$request->tdate?$request->tdate:$request->fdate;
            $where=" where (date(stocks.`created_at`) BETWEEN '".$request->fdate."' and '".$tdate."') ";
        }

        $stock= DB::select("SELECT products.product_name,stocks.*,sum(stocks.totalquantity_pcs) as qty FROM `stocks` join products on products.id=stocks.product_id $where GROUP BY stocks.product_id");
        return view('reports.stockReport',compact('stock'));
    }

    public function ShopDue(Request $request)
    {
        // dd($request->all());
        $shop = Shop::where(company())->get();

        return view('reports.shopdue', compact('shop'));
    }
}
