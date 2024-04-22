<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Shop;
use App\Models\Settings\ShopBalance;
use App\Models\Product\Group;
use App\Models\Settings\Supplier;
use App\Models\Product\Product;
use App\Models\Do\D_o;
use App\Models\Do\D_o_detail;
use App\Models\Do\DoReceiveHistory;
use App\Models\Sales\Sales;
use App\Models\Sales\SalesDetails;
use App\Models\Stock\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function stockreport(Request $request)
    {
        $groups = Group::where(company())->select('id','name')->get();
        $distributors = Supplier::where(company())->select('id','name')->get();
        $products = Product::where(company())->select('id','product_name')->get();

        $stockQuery = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->join('groups', 'groups.id', '=', 'products.group_id')
        ->join('suppliers', 'suppliers.id', '=', 'products.distributor_id')
        ->select(
            'products.product_name','products.dp_price as product_dp','groups.name as group_name','suppliers.name as supplier_name',
            'stocks.*',
            DB::raw('SUM(CASE WHEN stocks.status = 0 THEN stocks.totalquantity_pcs ELSE 0 END) as outs'),
            DB::raw('SUM(CASE WHEN stocks.status = 1 THEN stocks.totalquantity_pcs ELSE 0 END) as ins')
        );

        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $stockQuery->whereBetween(DB::raw('date(stocks.stock_date)'), [$request->fdate, $tdate]);
        }
        if ($request->group_id)
            $stockQuery->where('products.group_id',$request->group_id);
        if ($request->distributor_id)
            $stockQuery->where('products.distributor_id',$request->distributor_id);

        $stock = $stockQuery
            ->groupBy('products.group_id','products.distributor_id','products.product_name')
            ->get();
           // return $stock;
        return view('reports.stockReport', compact('stock','groups','products','distributors'));

        // $stock= DB::select("SELECT products.product_name,stocks.*,sum(stocks.totalquantity_pcs) as qty FROM `stocks` join products on products.id=stocks.product_id $where GROUP BY stocks.product_id");
        // return view('reports.stockReport',compact('stock'));
    }

    public function stockindividual($id)
    {
        // $company = company()['company_id'];
        // $where = '';
        // $salesItem = SalesDetails::where('product_id', $id)->where('company_id', $company)->get();
        $stock = Stock::where('product_id',$id)->get();
        $product = Product::where('id',$id)->first();

        return view('reports.stockReportIndividual', compact('stock','product'));
    }

    public function cashCollection(Request $request)
    {
        $sales = Sales::orderBy('id','DESC');
        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $sales->whereBetween(DB::raw('date(sales.sales_date)'), [$request->fdate, $tdate]);
        }
        $sales = $sales->get();
        //return $sales;
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('reports.cashCollection',compact('sales','userSr'));
    }

    public function damageProductList(Request $request)
    {
        $groups = Group::where(company())->select('id','name')->get();
        $distributors = Supplier::where(company())->select('id','name')->get();
        $sr = User::where(company())->where('role_id',5)->select('id','name')->get();
        $products = Product::where(company())->select('id','product_name')->get();

        $stockQuery = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->join('groups', 'groups.id', '=', 'products.group_id')
        ->join('sales', 'sales.id', '=', 'stocks.sales_id')
        ->join('suppliers', 'suppliers.id', '=', 'products.distributor_id')
        ->where('stocks.status_history', '=', 2)
        ->select(
            'products.product_name','products.dp_price as product_dp','groups.name as group_name','sales.sr_id as sr','suppliers.name as supplier_name',
            'stocks.*',DB::raw('SUM(stocks.totalquantity_pcs) as totalquantity_pcs'));

        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $stockQuery->whereBetween(DB::raw('date(stocks.stock_date)'), [$request->fdate, $tdate]);
        }
        if ($request->group_id)
            $stockQuery->where('products.group_id',$request->group_id);
        if ($request->distributor_id)
            $stockQuery->where('products.distributor_id',$request->distributor_id);
        if ($request->sr_id)
            $stockQuery->where('sales.sr_id',$request->sr_id);

        $stock = $stockQuery
            ->groupBy('stocks.product_id')
            ->get();
        return view('reports.damageProductList', compact('stock','groups','products','distributors','sr'));
    }
    public function SRreport(Request $request)
    {
        $sales = Sales::orderBy('id','DESC')->where(company())->where('sales.sr_id',$request->sr_id);
        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $sales->whereBetween(DB::raw('date(sales.sales_date)'), [$request->fdate, $tdate]);
        }
        $sales = $sales->get();
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('reports.srReport',compact('sales','userSr'));
    }

    public function srreportProduct(Request $request)
    {
        $products = Product::where(company())->select('id','product_name')->get();
        $userSr=User::where(company())->where('role_id',5)->get();
        $sales = Sales::with('sales_details')->where(company())->where('sales.sr_id',$request->sr_id);
        if ($request->fdate){
            $tdate = $request->tdate ?: $request->fdate;
            $sales->whereBetween(DB::raw('date(sales.sales_date)'), [$request->fdate, $tdate]);
        }
        if($request->product_id){
            $productId=$request->product_id;
            $sales=$sales->whereHas('sales_details',function($q) use ($productId){
                $q->where('product_id', $productId);
            });
        }

        $sales=$sales->orderBy('id', 'DESC')->get();
        // return $sales;
        return view('reports.srReportProduct',compact('sales','products','userSr'));
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

    public function undeliverdProduct(Request $request)
    {
        if ($request->supplier_id) {
            $do_reference = D_o::where('supplier_id',$request->supplier_id)->pluck('id');
            $dodetails= D_o_detail::whereIn('do_id',$do_reference)->groupBy('product_id')->get();
            // $histotry = DoReceiveHistory::whereIn('do_id',$do_reference)->groupBy('product_id')->get();
             //return $dodetails;
            // $commonProductIds = array_intersect($dodetails->pluck('product_id')->toArray(), $history->pluck('product_id')->toArray());

            // $do_reference = DoReceiveHistory::where(function($query) use ($histotry,$dodetails){
            //     if($dodetails){
            //         $query->orWhere(function($query) use ($dodetails){
            //             $query->whereIn('do_id',$dodetails);
            //         });
            //     }
            //     if($histotry){
            //         $query->orWhere(function($query) use ($histotry){
            //             $query->whereIn('do_id',$histotry);
            //         });
            //     }
            // })->get();
        }else {
            $dodetails = collect();
        }
        return view('do.undeliverd-list', compact('dodetails'));
    }
}
