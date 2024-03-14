<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as auth;
use App\Http\Controllers\DashboardController as dash;
use App\Http\Controllers\Settings\CompanyController as company;
use App\Http\Controllers\Settings\WerehouseController as werehouse;
use App\Http\Controllers\Settings\BillTermController as bill;
use App\Http\Controllers\Settings\UnitStyleController as unitstyle;
use App\Http\Controllers\Settings\UnitController as unit;
use App\Http\Controllers\Settings\SupplierController as supplier;
use App\Http\Controllers\Settings\CustomerController as customer;
use App\Http\Controllers\Settings\ShopController as shop;
use App\Http\Controllers\Settings\ShopBalanceController as shopbalance;
use App\Http\Controllers\Settings\UserController as user;
use App\Http\Controllers\Settings\AdminUserController as admin;
use App\Http\Controllers\Settings\Location\CountryController as country;
use App\Http\Controllers\Settings\Location\DivisionController as division;
use App\Http\Controllers\Settings\Location\DistrictController as district;
use App\Http\Controllers\Settings\Location\UpazilaController as upazila;
use App\Http\Controllers\Settings\Location\ThanaController as thana;
use App\Http\Controllers\Employee\DesignationController as designation;
use App\Http\Controllers\Employee\EmployeeController as employee;
use App\Http\Controllers\Employee\EmployeeLeaveController as emLeave;
use App\Http\Controllers\Currency\CurrencyController as currency;

use App\Http\Controllers\Product\CategoryController as category;
use App\Http\Controllers\Product\GroupController as group;
use App\Http\Controllers\Product\ProductController as product;
use App\Http\Controllers\Product\BatchController as batch;
use App\Http\Controllers\Product\ReturnProductController as returnproduct;
use App\Http\Controllers\Do\DOController as docon;
use App\Http\Controllers\Reports\ReportController as report;


use App\Http\Controllers\Sales\SalesController as sales;


use App\Http\Controllers\Accounts\MasterAccountController as master;
use App\Http\Controllers\Accounts\SubHeadController as sub_head;
use App\Http\Controllers\Accounts\ChildOneController as child_one;
use App\Http\Controllers\Accounts\ChildTwoController as child_two;
use App\Http\Controllers\Accounts\NavigationHeadViewController as navigate;
use App\Http\Controllers\Accounts\IncomeStatementController as statement;

use App\Http\Controllers\Vouchers\CreditVoucherController as credit;
use App\Http\Controllers\Vouchers\DebitVoucherController as debit;
use App\Http\Controllers\Vouchers\JournalVoucherController as journal;
/* Middleware */
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isOwner;
use App\Http\Middleware\isManager;
use App\Http\Middleware\isAccountant;
use App\Http\Middleware\isJso;
use App\Http\Middleware\isSalesrepresentative;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', [auth::class,'signUpForm'])->name('register');
Route::post('/register', [auth::class,'signUpStore'])->name('register.store');
Route::get('/', [auth::class,'signInForm'])->name('signIn');
Route::get('/login', [auth::class,'signInForm'])->name('login');
Route::post('/login', [auth::class,'signInCheck'])->name('login.check');
Route::get('/logout', [auth::class,'singOut'])->name('logOut');


Route::group(['middleware'=>isAdmin::class],function(){
    Route::prefix('admin')->group(function(){
        Route::get('/dashboard', [dash::class,'adminDashboard'])->name('admin.dashboard');
        /* settings */
        Route::get('/admincompany',[company::class,'admindex'])->name('admin.admincompany');


       // Route::resource('/profile/update',profile::class,['as'=>'admin']);

        Route::resource('users',user::class,['as'=>'admin']);
        Route::resource('admin',admin::class,['as'=>'admin']);
        Route::resource('country',country::class,['as'=>'admin']);
        Route::resource('division',division::class,['as'=>'admin']);
        Route::resource('district',district::class,['as'=>'admin']);
        Route::resource('upazila',upazila::class,['as'=>'admin']);
        Route::resource('thana',thana::class,['as'=>'admin']);
        Route::resource('unit',unit::class,['as'=>'admin']);
        Route::resource('currency',currency::class,['as'=>'admin']);

    });
});

Route::group(['middleware'=>isOwner::class],function(){
    Route::prefix('owner')->group(function(){
        Route::get('/dashboard', [dash::class,'ownerDashboard'])->name('owner.dashboard');

        // settings
        Route::resource('company',company::class,['as'=>'owner']);
        Route::resource('unitstyle',unitstyle::class,['as'=>'owner']);
        Route::resource('unit',unit::class,['as'=>'owner']);
        Route::resource('werehouse',werehouse::class,['as'=>'owner']);
        Route::resource('bill',bill::class,['as'=>'owner']);
        Route::resource('users',user::class,['as'=>'owner']);
        Route::resource('supplier',supplier::class,['as'=>'owner']);
        Route::resource('customer',customer::class,['as'=>'owner']);
        Route::resource('shop',shop::class,['as'=>'owner']);
        Route::resource('shopbalance',shopbalance::class,['as'=>'owner']);
        Route::resource('checkCollection',shopbalance::class,['as'=>'owner']);
        Route::post('/customer/balance', [customer::class, 'customerBalance'])->name('owner.customer.balance');
        Route::post('/supplier/balance', [supplier::class, 'supplierBalance'])->name('owner.supplier.balance');

        //sales
        Route::resource('sales',sales::class,['as'=>'owner']);
        Route::get('selected-sales-get',[sales::class,'selectedCreate'])->name('owner.selectedCreate');
        Route::get('sales-primary-update/{id}',[sales::class,'PrimaryUpdate'])->name('owner.sales.primary_update');
        Route::post('sales-primary-store/{id}',[sales::class,'primaryStore'])->name('owner.sales.primaryStore');
        Route::get('sales-receive-screen/{id}',[sales::class,'salesReceiveScreen'])->name('owner.sales.receiveScreen');
        Route::get('sales-print-page/{id}',[sales::class,'printSalesClosing'])->name('owner.sales.printpage');
        Route::post('sales-receive',[sales::class,'salesReceive'])->name('owner.sales.receive');
        Route::get('shop-data-get',[sales::class,'ShopDataGet'])->name('owner.get_shop');
        Route::get('dsr-data-get',[sales::class,'DsrDataGet'])->name('owner.get_dsr');
        Route::get('supplier-product-data-get',[sales::class,'SupplierProduct'])->name('owner.get_supplier_product');
        Route::get('salesclosing-screen',[sales::class,'salesClosing'])->name('owner.salesClosing');
        Route::get('salesClosing-list',[sales::class,'salesClosingList'])->name('owner.salesClosingList');
        Route::post('salesclosing-data-get',[sales::class,'getSalesClosingData'])->name('owner.getSalesClosingData');

        // employee settings
        Route::resource('designation',designation::class,['as'=>'owner']);
        Route::resource('employee',employee::class,['as'=>'owner']);
        Route::resource('emLeave',emLeave::class,['as'=>'owner']);

        // Product
        Route::resource('category',category::class,['as'=>'owner']);
        Route::resource('group',group::class,['as'=>'owner']);
        Route::resource('product',product::class,['as'=>'owner']);
        Route::get('unit-pcs-get',[product::class,'UnitPcsGet'])->name('owner.unit_pcs_get');
        Route::resource('returnproduct',returnproduct::class,['as'=>'owner']);
        Route::resource('batch',batch::class,['as'=>'owner']);
        Route::resource('docontroll',docon::class,['as'=>'owner']);
        Route::get('doreceive',[docon::class,'DoRecive'])->name('owner.doreceive');
        Route::get('do-data-get',[docon::class,'doDataGet'])->name('owner.do_data_get');
        Route::get('unit-data-get',[docon::class,'UnitDataGet'])->name('owner.unit_data_get');
        Route::get('sales-unit-data-get',[sales::class,'UnitDataGet'])->name('owner.sales_unit_data_get');
        Route::post('doreceive', [docon::class,'DoRecive_edit'])->name('owner.do.accept_do_edit');
        Route::get('do-receive-list', [docon::class,'doReceiveList'])->name('owner.do.receivelist');
        Route::get('do-receive-list/{chalan_no}', [docon::class,'showDoReceive'])->name('owner.showDoReceive');
        // Route::post('product-up-for-do', [docon::class, 'productUp'])->name('doscreenProductUp');
        Route::get('doscreenProductUp',[docon::class,'productUpdate'])->name('owner.doscreenProductUp');
        Route::get('get-product-data-ajax',[docon::class,'getProductData'])->name('owner.get_ajax_productdata');

        //report
        Route::get('/stock-report',[report::class,'stockreport'])->name('owner.sreport');
        Route::get('/shop-due-report',[report::class,'ShopDue'])->name('owner.shopdue');
        Route::get('undeliverd-report', [report::class,'undeliverdProduct'])->name('owner.undeliverd');
        Route::get('/sr-report',[report::class,'SRreport'])->name('owner.srreport');
        Route::get('/sr-report-product',[report::class,'srreportProduct'])->name('owner.srreportProduct');
        Route::get('/cash-collection-report',[report::class,'cashCollection'])->name('owner.cashCollection');
        Route::get('/damage-product-list',[report::class,'damageProductList'])->name('owner.damageProductList');


        //Accounts
        Route::resource('master',master::class,['as'=>'owner']);
        Route::resource('sub_head',sub_head::class,['as'=>'owner']);
        Route::resource('child_one',child_one::class,['as'=>'owner']);
        Route::resource('child_two',child_two::class,['as'=>'owner']);
        Route::resource('navigate',navigate::class,['as'=>'owner']);

        Route::get('incomeStatement',[statement::class,'index'])->name('owner.incomeStatement');
        Route::get('incomeStatement_details',[statement::class,'details'])->name('owner.incomeStatement.details');

        //Voucher
        Route::resource('credit',credit::class,['as'=>'owner']);
        Route::resource('debit',debit::class,['as'=>'owner']);
        Route::get('get_head', [credit::class, 'get_head'])->name('owner.get_head');
        Route::resource('journal',journal::class,['as'=>'owner']);
        Route::get('journal_get_head', [journal::class, 'get_head'])->name('owner.journal_get_head');

    });
});

Route::group(['middleware'=>isManager::class],function(){
    Route::prefix('manager')->group(function(){
        Route::get('/dashboard', [dash::class,'managerDashboard'])->name('manager.dashboard');

        Route::resource('product',product::class,['as'=>'manager']);
        Route::get('unit-pcs-get',[product::class,'UnitPcsGet'])->name('manager.unit_pcs_get');
        Route::resource('docontroll',docon::class,['as'=>'manager']);
        Route::get('doreceive',[docon::class,'DoRecive'])->name('manager.doreceive');
        Route::get('do-data-get',[docon::class,'doDataGet'])->name('manager.do_data_get');
        Route::get('unit-data-get',[docon::class,'UnitDataGet'])->name('manager.unit_data_get');
        Route::get('sales-unit-data-get',[sales::class,'UnitDataGet'])->name('manager.sales_unit_data_get');
        Route::post('doreceive', [docon::class,'DoRecive_edit'])->name('manager.do.accept_do_edit');
        // Route::post('product-up-for-do', [docon::class, 'productUp'])->name('doscreenProductUp');
        Route::get('doscreenProductUp',[docon::class,'productUpdate'])->name('manager.doscreenProductUp');
        Route::get('get-product-data-ajax',[docon::class,'getProductData'])->name('manager.get_ajax_productdata');

    });
});

Route::group(['middleware'=>isJso::class],function(){
    Route::prefix('SR')->group(function(){
        Route::get('/dashboard', [dash::class,'jsoDashboard'])->name('SR.dashboard');

    });
});

Route::group(['middleware'=>isSalesrepresentative::class],function(){
    Route::prefix('DSR')->group(function(){
        Route::get('/dashboard', [dash::class,'salesrepresentativeDashboard'])->name('DSR.dashboard');

    });
});

Route::group(['middleware'=>isAccountant::class],function(){
    Route::prefix('accountant')->group(function(){
        Route::get('/dashboard', [dash::class,'accountantDashboard'])->name('accountant.dashboard');

    });
});


