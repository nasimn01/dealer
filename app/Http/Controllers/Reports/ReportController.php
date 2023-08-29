<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Shop;
use App\Models\Settings\ShopBalance;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function stockreport(Request $request)
    {
        $stockQuery = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->select(
            'products.product_name',
            'stocks.*',
            DB::raw('SUM(CASE WHEN stocks.status = 0 THEN stocks.totalquantity_pcs ELSE 0 END) as outs'),
            DB::raw('SUM(CASE WHEN stocks.status = 1 THEN stocks.totalquantity_pcs ELSE 0 END) as ins')
        );

        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $stockQuery->whereBetween(DB::raw('date(stocks.created_at)'), [$request->fdate, $tdate]);
        }

        $stock = $stockQuery
            ->groupBy('stocks.product_id', 'products.product_name')
            ->get();

        return view('reports.stockReport', compact('stock'));


        // $stock= DB::select("SELECT products.product_name,stocks.*,sum(stocks.totalquantity_pcs) as qty FROM `stocks` join products on products.id=stocks.product_id $where GROUP BY stocks.product_id");
        // return view('reports.stockReport',compact('stock'));
    }

    public function ShopDue(Request $request)
    {
        $shop = Shop::where(company())->get();

        $query = ShopBalance::join('shops', 'shops.id', '=', 'shop_balances.shop_id')
        ->groupBy('shop_balances.shop_id')
        ->select('shops.*', 'shop_balances.*',
            DB::raw('SUM(CASE WHEN shop_balances.status = 0 THEN shop_balances.balance_amount ELSE 0 END) as balance_out'),
            DB::raw('SUM(CASE WHEN shop_balances.status = 1 THEN shop_balances.balance_amount ELSE 0 END) as balance_in')
    );

    if ($request->shop_name) {
        $query->where('shop_balances.shop_id', $request->shop_name);
    }
    $data = $query->get();
        return view('reports.shopdue', compact('shop','data'));
    }
}
