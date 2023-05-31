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

        // employee settings
        Route::resource('designation',designation::class,['as'=>'owner']);
        Route::resource('employee',employee::class,['as'=>'owner']);
        Route::resource('emLeave',emLeave::class,['as'=>'owner']);

        // Product
        Route::resource('category',category::class,['as'=>'owner']);
        Route::resource('group',group::class,['as'=>'owner']);
        Route::resource('product',product::class,['as'=>'owner']);





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

    });
});

Route::group(['middleware'=>isJso::class],function(){
    Route::prefix('JSO')->group(function(){
        Route::get('/dashboard', [dash::class,'jsoDashboard'])->name('JSO.dashboard');

    });
});

Route::group(['middleware'=>isSalesrepresentative::class],function(){
    Route::prefix('SR')->group(function(){
        Route::get('/dashboard', [dash::class,'salesrepresentativeDashboard'])->name('SR.dashboard');

    });
});

Route::group(['middleware'=>isAccountant::class],function(){
    Route::prefix('accountant')->group(function(){
        Route::get('/dashboard', [dash::class,'accountantDashboard'])->name('accountant.dashboard');

    });
});


