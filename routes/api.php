<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\IngredientCategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\CompletedOrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum','throttle:rate_limit,1')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/login', [AuthController::class , 'login']);

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getdashboarddata', [DashboardController::class , 'getdashboarddata']);

/*
|--------------------------------------------------------------------------
| Recent Order Check
|--------------------------------------------------------------------------
|
*/
Route::get('/recentOrder', [DashboardController::class , 'recentOrder']);


/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getcategorylist', [CategoryController::class , 'getcategorylist']);
Route::post('/addcategory', [CategoryController::class , 'addcategory']);
Route::post('/editcategory', [CategoryController::class , 'editcategory']);
Route::get('/getCategorySingleData/{id}', [CategoryController::class , 'getCategorySingleData']);
Route::post('/deleteCategoryData', [CategoryController::class , 'deleteCategoryData']);


/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getproductlist/{slug}', [ProductController::class , 'getproductlist']);
Route::get('/getallproductlist', [ProductController::class , 'getproductlist']);
Route::post('/addproduct', [ProductController::class , 'addproduct']);
Route::post('/editproduct', [ProductController::class , 'editproduct']);
Route::post('/removeProduct', [ProductController::class , 'removeProduct']);
Route::post('/searchIngredients', [ProductController::class , 'searchIngredients']);
// Route::get('/getProductSingleData/{id}', [ProductController::class , 'getProductSingleData']);

Route::get('/getaddproductpagedata', [ProductController::class , 'getaddproductpagedata']);
Route::get('/geteditproductpagedata/{slug}', [ProductController::class , 'geteditproductpagedata']);

/*
|--------------------------------------------------------------------------
| Pos Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getcategoryfeturedlist', [PosController::class , 'getcategoryfeturedlist']);
Route::get('/getavaliableTable', [PosController::class , 'getavaliableTable']);
Route::post('/getproductslist', [PosController::class , 'getproductslist']);
Route::get('/getProductPosData/{id}', [PosController::class , 'getProductPosData']);
Route::post('/addtocart', [PosController::class , 'addtocart']);
Route::get('/getCart', [PosController::class , 'getCart']);
Route::post('/removeCart', [PosController::class , 'removeCart']);
Route::post('/changeCartQuantity', [PosController::class , 'changeCartQuantity']);
Route::post('/saveOrder', [PosController::class , 'saveOrder']);
Route::post('/check-customer-for-ongoingorder', [PosController::class , 'checkCustomerOnGoingOrder']);
Route::post('/find-customer-through-number', [PosController::class , 'findCustomerThroughNumber']);

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getorders', [OrderController::class , 'getOrder']);
Route::get('/getordersforpopup/{table}', [OrderController::class , 'getOrderForPopup']);
Route::get('/getorderstime', [OrderController::class , 'getOrdersTime']);
Route::get('/prinorder/{id}', [OrderController::class , 'printOrder']);
Route::post('/order-save', [OrderController::class , 'orderSave']);
Route::post('/order-pay', [OrderController::class , 'orderPay']);





/*
|--------------------------------------------------------------------------
| Ingredient Category Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getingcategorylist', [IngredientCategoryController::class , 'getingcategorylist']);
Route::post('/addingcategory', [IngredientCategoryController::class , 'addingcategory']);
Route::post('/editingcategory', [IngredientCategoryController::class , 'editingcategory']);
Route::get('/getIngCategorySingleData/{id}', [IngredientCategoryController::class , 'getIngCategorySingleData']);
Route::post('/removeIngcategory', [IngredientCategoryController::class , 'removeIngcategory']);

/*
|--------------------------------------------------------------------------
| Ingredient Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getingredientlist/{slug}', [IngredientController::class , 'getingredientlist']);
Route::post('/addingredient', [IngredientController::class , 'addingredient']);
Route::post('/editingredient', [IngredientController::class , 'editingredient']);
Route::get('/getIngredientSingleData/{id}', [IngredientController::class , 'getIngredientSingleData']);
Route::post('/removeIngredint', [IngredientController::class , 'removeIngredint']);

/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getuserlist', [UserManagementController::class , 'getuserlist']);
Route::post('/adduser', [UserManagementController::class , 'adduser']);
Route::post('/edituser', [UserManagementController::class , 'edituser']);
Route::get('/getUserSingleData/{id}', [UserManagementController::class , 'getUserSingleData']);
Route::get('getuserdata', [UserManagementController::class , 'getUserData']);

/*
|--------------------------------------------------------------------------
| Lock Screen Routes
|--------------------------------------------------------------------------
|
*/
Route::get('getuserpasscode', [UserManagementController::class , 'userPasscode']);
Route::post('lockenabledisable', [UserManagementController::class , 'lockEnableDisable']);
Route::get('liveDateTime', [UserManagementController::class , 'liveDateTime']);

/*
|--------------------------------------------------------------------------
| Permission Routes
|--------------------------------------------------------------------------
*/

Route::get('checknotlogin', [PermissionController::class , 'checknotlogin']);
Route::get('checklogin/{page}', [PermissionController::class , 'checklogin']);
Route::get('checkheaderpermission', [PermissionController::class , 'checkheaderpermission']);

// Route::get('checksubmin', [PermissionController::class , 'checksubmin']);
// Route::get('checklitchenmanager', [PermissionController::class , 'checklitchenmanager']);
// Route::get('checkwaiter', [PermissionController::class , 'checkwaiter']);


/*
|--------------------------------------------------------------------------
| Combo Routes
|--------------------------------------------------------------------------
|
*/

Route::get('getproductlist', [ComboController::class , 'getproductlist']);
Route::get('getcombolist', [ComboController::class , 'getcombolist']);
Route::get('getSingleCombo/{slug}', [ComboController::class , 'getSingleCombo']);
Route::post('/addcombo', [ComboController::class , 'addcombo']);
Route::post('/search-product', [ComboController::class , 'search_product']);
Route::post('/edit-combo', [ComboController::class , 'editCombo']);
Route::post('/removeCombo', [ComboController::class , 'removeCombo']);

/*
|--------------------------------------------------------------------------
| Tables Routes
|--------------------------------------------------------------------------
|
*/

Route::get('gettabledata', [TableController::class , 'gettablelist']);
Route::post('/addtable', [TableController::class , 'addtable']);
Route::get('gettabledatatime', [TableController::class , 'gettablesTime']);
Route::post('/changeTableStatus', [TableController::class , 'changeTableStatus']);


/*
|--------------------------------------------------------------------------
| Tax Routes
*/
Route::get('gettaxes', [HomeController::class , 'taxes']);
Route::post('/tax-add-update', [HomeController::class , 'taxAddUpdate']);
Route::post('/tax-status-change', [HomeController::class , 'taxStatusChange']);
Route::post('/tax-delete', [HomeController::class , 'taxDelete']);
Route::get('tax-single-data/{id}', [HomeController::class , 'getSingleData']);


/*
|--------------------------------------------------------------------------
| Tables Routes
|
*/
Route::get('getSettingData', [SettingController::class , 'getSettingData']);
Route::post('edit-setting', [SettingController::class , 'edit_setting']);

/*
|--------------------------------------------------------------------------
| Complete Order Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/getcompleteorderddata', [CompletedOrderController::class , 'getcompleteorderddata']);
Route::get('/getOrderProduct/{orderId}', [CompletedOrderController::class , 'getOrderProduct']);
Route::get('/printCompletedorder/{id}', [CompletedOrderController::class , 'printCompletedorder']);
Route::post('/emailInvoice', [CompletedOrderController::class , 'emailInvoice']);
Route::get('/emailInvoice/{id}', [CompletedOrderController::class , 'emailInvoice']);
Route::post('/filterCompleteOrder', [CompletedOrderController::class , 'filterCompleteOrder']);
